<?php
class Users extends Controller
{
    private array $payload;
    private $_db;
    
    public function __construct()
    {
        $this->_db = Database::getDbh();
    }

    public function login(string $redirect_url=''): void
    {
        $payload['title'] = 'NMR Login';
        $payload['redirect_url'] = $redirect_url;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payload['post'] = validatePost('login_form');
            $post = $payload['post'];
            if(!empty($post->staff_id_err) || !empty($post->password_err))   {
                flash('flash_login', 'Invalid Username/Password', 'alert text-danger text-center');
                $this->view('users/login', $payload);
            }
            else {
                $loggedInUser = User::login($post->staff_id, $post->password);
                if ($loggedInUser)
                {
                    $u = new User($loggedInUser->user_id);
                    createUserSession($u);
                    if (!empty($redirect_url)) {
                        redirect($redirect_url);
                    }
                    redirect('pages/dashboard');
                }
            }
        } else {
            $this->view('users/login', $payload);
        }
    }

    public function forgotPassword(): void
    {
        $db = Database::getDbh();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $email = $_POST['email'] ?? null;
            if ($email) {
                $ret = $db->where('email', $email)->getOne('users');
                if ($ret) {
                    $ret = $db->where('email', $email)->getOne('users');
                    $salt = 'archangel';
                    $md5_email = md5($ret['email'] . $salt);
                    $pass = md5($ret['password'] . $salt);
                    $reset_link = site_url("users/reset-password/$md5_email/$pass");
                    $link = "<a href='$reset_link'>Click To Reset password</a>";
                    $data['title'] = 'Password Reset';
                    $recipient = concatNameWithUserId($ret['user_id']);
                    $subject = 'Change Management System [Password Reset]';
                    $body = 'Hello ' . $recipient . ', ' . HTML_NEW_LINE .
                        'If you have requested to change your password kindly use this link below to do so; else ignore this message.' . HTML_NEW_LINE .
                        $link;
                    if (insertEmail($subject, $body, $email, $recipient)) {
                        flash('flash', 'We have sent a link to your email for you to reset your password.', 'text-success alert text-sm');
                    }
                    $db->onDuplicate(['secret_token' => $pass, 'email_hashed' => $md5_email])
                        ->insert('password_reset', [
                            'email' => $email,
                            'secret_token' => $pass,
                            'email_hashed' => $md5_email
                        ]);
                    /*if (sendMail('Reset Password', 'Click On This Link to Reset Password. ' . $link. '<p style="color: red"><b>Please note that due to security reasons we will set this link to expire in one (1) day.</b></p>', $email, ucwords($ret['first_name']. ' '. $ret['last_name'], ' -.'))) {

                        $this->db->onDuplicate(['secret_token' => $pass, 'email_hashed'=>$md5_email])
                            ->insert('password_reset', [
                                'email' => $email,
                                'secret_token' => $pass,
                                'email_hashed' => $md5_email
                            ]);

                        flash('flash', 'We have sent a link to your email for you to reset your password.', 'text-success alert');
                        redirect('users/login');
                    } else {
                        flash('flash', "Mail Error", 'alert text-danger');
                        redirect('users/login');
                    }*/
                } else {
                    flash('flash', 'The email does not exist on our system', 'text-danger alert');
                }
            }
        }
        redirect('users/login');
    }

    public function resetPassword($email_hashed = '', $secret_token = ''): void
    {
        $db = Database::getDbh();
        if (($_SERVER['REQUEST_METHOD'] === 'GET') && !empty($email_hashed) && !empty($secret_token) && $db->where('email_hashed', $email_hashed)
                ->where('secret_token', $secret_token)
                ->has('password_reset')) {
                $ret = $db->getOne('password_reset', 'expiry, email');
                if ($ret['expiry'] > date('Y-m-d')) {
                    redirect('users/new-password/' . $email_hashed . '/' . $secret_token);
                } else {
                    flash('flash', 'The link has expired!', 'alert text-danger');
                    redirect('users/login');
                }
            }
        redirect('users/login');
    }

    public function newPassword($email_hashed = '', $secret_token = ''): void
    {
        $salt = 'archangel';
        $db = Database::getDbh();
        if (!empty($email_hashed) && !empty($secret_token)) {
            if ($db->where('email_hashed', $email_hashed)
                ->where('secret_token', $secret_token)
                ->has('password_reset')) {
                $ret = $db->getOne('password_reset', 'expiry, email, secret_token, email_hashed');
                $payload = [
                    'post' => $ret,
                    'title' => 'Change Management System - New Password'
                ];
                if ($ret['expiry'] > date('Y-m-d')) {
                    $this->view('users/new_password', $payload);
                    //return;
                } else {
                    flash('flash', 'The link has expired!', 'alert text-danger');
                    redirect('users/login');
                }
            } else {
                flash('flash', 'The link has expired or does not exist!', 'alert text-danger text-sm');
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['email'])) {
                $email = $_POST['email'];
                $md5_email = md5($_POST['email'] . $salt);
                if ($db->where('email', $_POST['email'])->where('email_hashed', $md5_email)->get('password_reset')) {
                    $password = $_POST['password'];
                    $confirm_password = $_POST['confirm_password'];
                    if (!empty($password) && !empty($confirm_password) && $password === $confirm_password) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        if ($db->where('email', $email)->update('users', ['password' => $hashed_password])) {
                            $db->where('email', $email)
                                ->delete('password_reset');
                            flash('flash', 'Password changed successfully. Please login with your new password!', 'alert text-success text-sm');
                            redirect('users/login');
                        }
                    } else {
                        flash('flash', 'An error occurred!', 'alert text-danger');
                        redirect('users/login');
                    }
                }
            }
            redirect('users/login');
        }
        redirect('users/login');
    }

    public function changePassword(): void
    {
        $user = new User (getUserSession()->user_id);
        $db = Database::getDbh();
        $data = array();
        $method = the_method();
        $flash = "flash_$method";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['password'];
            $confirm = $_POST['confirm_password'];
            // verify current password
            if (password_verify($current_password, $user->password)) {
                if ($new_password === $confirm) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    if ($hashed_password) {
                        $data['password'] = $hashed_password;
                        if ($user->default_password) {
                            // this will disable notification to set new password
                            $data['default_password'] = false;
                        }
                        $ret = $db->where('user_id', $user->user_id)
                            ->update('users', $data);
                        if ($ret) {
                            flash($flash, 'Password changed successfully!', 'text-success text-sm alert text-center');
                        } else {
                            flash($flash, 'An error occurred!', 'text-danger text-sm alert text-center');
                        }
                    }
                } else {
                    // Password mismatch
                    flash($flash, 'Password mismatch!', 'text-danger text-sm alert text-center');
                }
            } else {
                // Incorrect password
                flash($flash, 'Incorrect password!', 'text-danger alert text-sm text-center');
            }
        }
        goBack();
    }

    public function profile($user_id = null): void
    {
        $post = array();
        $user = getUserSession();
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        if (empty($user_id) || !userExists($user_id)) {
            $user_id = $user->user_id;
        }

        $this->payload['page_title'] = 'Profile';

        try {
            $post = Database::getDbh()
                ->ObjectBuilder()
                ->where('u.user_id', $user_id)
                ->join('departments d', 'd.department_id=u.department_id', 'LEFT')
                ->getOne('users u');
        } catch (Exception $e) {
        }

        $this->payload['mgrs'] = getCurrentManager($user->department_id);
        //getDepartmentHods($user->department_id);
        $this->payload['post'] = $post;
        $this->payload['user'] = getUserSession();
        $this->view('users/profile', $this->payload);
    }

    public function logout(): void
    {
        logout();
    }

    public function chooseSession(): void
    {
        $payload = [
            'title' => 'Choose Session',
            'current_user' => getUserSession()
        ];

        $this->view('choose_session/index', $payload);
    }

    public function index() {
        if (!isLoggedIn()) {
            redirect('users/login/users');
        }
        $db = Database::getDbh();
        //$payload['users'] = $db->objectBuilder()->get('users');
        $payload['page_title'] = 'Users';
        $this->view('users/index', $payload);
    }

    public function create()
    {
        if (!isLoggedIn()) {
            // throw Session timed out error
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $_POST = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
                
            } catch (JsonException $e) {
            }
            $ret = [];
            $insert_data = [];
            $record_added_id = $this->_db->insert('users', $insert_data);
            if ($record_added_id) {

            } else {
                $ret['errors'] = [['message' => 'Failed to add record.', 'code' => ERROR_UNSPECIFIED_ERROR]];
                try {
                    echo json_encode($ret, JSON_THROW_ON_ERROR, 512);
                } catch (JsonException $e) {
                }
            }
        }
    }

    public function read()
    {
        if (!isLoggedIn()) {
            // throw Session timed out error
        }
        $db = Database::getDbh();
        $users = $db->join('departments', 'departments.department_id = users.department_id')->objectBuilder()->get('users', null, 'user_id, concat_ws(" ", first_name, last_name) as name, staff_id as username, users.department_id as department, job_title as position, email');
        echo json_encode($users);
    }

    public function departments()
    {
        $db = Database::getDbh();
        $departments  = $db->get('departments', null, 'department as text, department_id as value');
        echo json_encode($departments);
    }

    /* A sanitization check for the account password */
    public function isPasswdValid(string $passwd): bool
    {
        /* Initialize the return variable */
        $valid = TRUE;

        /* Example check: the length must be between 8 and 16 chars */
        $len = mb_strlen($passwd);

        if (($len < 8) || ($len > 16))
        {
            $valid = FALSE;
        }

        /* You can add more checks here */

        return $valid;
    }

    /* A sanitization check for the account username */
    public function isNameValid(string $name): bool
    {
        /* Initialize the return variable */
        $valid = TRUE;

        /* Example check: the length must be between 8 and 16 chars */
        $len = mb_strlen($name);

        if (($len < 8) || ($len > 16) || $this->_db->where('username', $name)->has('users'))
        {
            $valid = FALSE;
        }

        /* You can add more checks here */

        return $valid;
    }
    
    public function isPostValid(array $post)
    {
        $valid = true;


        return $valid;
    }

    public function isRequiredSet(array $post)
    {
        $required_fields = ['username', 'password', 'email', 'first_name', 'last_name', 'role', 'job_title'];
        foreach ($required_fields as $required_field) {
            $field_name = ucwords(str_replace("_", " ", $required_field));
            if (!key_exists($required_field, $post)) {
                throw new Exception("$field_name is required!");
            }
        }
    }
}
