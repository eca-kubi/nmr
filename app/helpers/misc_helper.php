<?php

use Moment\CustomFormats\MomentJs;
use Moment\Moment;
use Moment\MomentException;


function formatDate($date, $from, $to)
{
    if (empty($date)) {
        return '';
    }
    $d = DateTime::createFromFormat($from, $date);
    if ($d) {
        $ret = $d->format($to);
        if ($ret) {
            return $ret;
        }
    }

    return '';
}

function today()
{
    try {
        echo (new DateTime())->format(DFF);
    } catch (Exception $e) {
    }
}

function isCurrentGM(string $user_id)
{
    return $user_id === getCurrentGM();
}

if (!function_exists('array_key_last')) {
    /**
     * Polyfill for array_key_last() function added in PHP 7.3.
     *
     * Get the last key of the given array without affecting
     * the internal array pointer.
     *
     * @param array $array An array
     *
     * @return mixed the last key of array if the array is not empty; NULL otherwise
     */
    function array_key_last($array)
    {
        $key = null;

        if (is_array($array)) {
            end($array);
            $key = key($array);
        }

        return $key;
    }
}

function echoDate($date, $return = false)
{
    try {
        $d = (new Moment($date))->calendar(false);
        $t = (new Moment($date))->format('hh:mma', new MomentJs());
        if ($return) {
            return $d . ' at ' . $t;
        }
        echo $d . ' at ' . $t;
    } catch (MomentException $e) {
    }
    return '';
}

function echoDateOfficial($date, $official = false)
{
    try {
        if (!$official) {
            $d = (new Moment($date))->calendar(false);
            $t = (new Moment($date))->format('hh:mm a', new MomentJs());
            return $d . ' at ' . $t;
        }

        return (new Moment($date))->format('ddd, MMM D YYYY', new MomentJs());
    } catch (MomentException $e) {
    }
    return '';
}


/**
 * @param $department_id
 * @return mixed
 */
function getDepartmentHod($department_id)
{
    $db = Database::getDbh();
    $ret = $db->where('department_id', $department_id)
        ->where('role', ROLE_MANAGER)
        ->objectBuilder()
        ->getOne('users');
    return $ret;
}

function insertEmail($subject, $body, $recipient_address, $recipient_name = '')
{
    $db = Database::getDbh();
    return $db->insert('email', [
        'subject' => $subject,
        'body' => $body,
        'recipient_address' => $recipient_address,
        'recipient_name' => $recipient_name,
    ]);
}

/**
 * @return string $id
 */
function getCurrentGM()
{
    return Database::getDbh()->where('prop', 'current_gm')->getValue('settings', 'value');
}

function getFinanceOfficer()
{
    return Database::getDbh()->where('prop', 'finance_officer')->getValue('settings', 'value');
}

function its_logged_in_user($user_id)
{
    return getUserSession()->user_id === $user_id;
}


/**
 * @param $department_id
 * @return string
 */
function getDepartment($department_id)
{
    $department = (new Department($department_id))->department;
    if (!empty($department)) {
        return $department;
    }
    return 'N/A';
}

function isCurrentHR(string $user_id)
{
    return getCurrentHR() === $user_id;
}

function isCurrentFmgr(string $user_id)
{
    return getCurrentFmgr() === $user_id;
}

function getCurrentHR()
{
    return
        Database::getDbh()
            ->where('prop', 'current_hr')
            ->getValue('settings', 'value');
}

function getCurrentFmgr()
{
    return Database::getDbh()
        ->where('prop', 'current_fmgr')
        ->getValue('settings', 'value');
}

function getNameJobTitleAndDepartment($user_id)
{
    $user = new User($user_id);
    return concatNameWithUserId($user_id) .
        ' from ' .
        getDepartment($user->department_id);
}

function concatNameWithUserId($user_id)
{
    $user = new User($user_id);
    return $user->first_name . ' ' . $user->last_name;
}


/**Return current date & time
 * @return string
 */
function now()
{
    $date_time = '';
    try {
        $date_time = (new DateTime())->format(DFB_DT);
    } catch (Exception $e) {
    } finally {
        return $date_time;
    }
}

function site_url($url = '')
{
    return URL_ROOT . '/' . $url;
}

function goBack()
{

    if (!empty($_SERVER['HTTP_REFERER'])) {
        $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
        // echo '<p><a href="'. $referer .'" title="Return to the previous page">&laquo; Go back</a></p>';
        header("Location: $referer");

    } else {

        //echo '<p><a href="javascript:history.go(-1)" title="Return to the previous page">&laquo; Go back</a></p>';
        echo '<script>history.go(-1)</script>';
        exit;
    }
}

function the_method($url = ''): string
{
    $method = '';
    if (!$url) {
        $url = the_url();
    }
    $parts = explode('/', $url);
    if (!empty($parts[5])) {
        $method = str_replace('-', '_', $parts[5]);
    }
    return $method;
}

/**
 * @return string | bool
 */
function the_url()
{
    $referer = '';
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
    }
    return $referer;
}

function getDepartmentMembers($department_id)
{
    $db = Database::getDbh();
    return $db->where('department_id', $department_id)
        ->objectBuilder()
        ->get('users');
}

function get_include_contents($filename, $variablesToMakeLocal): string
{
    extract($variablesToMakeLocal, EXTR_OVERWRITE);
    $file = APP_ROOT . "/templates/$filename.php";
    if (is_file($file)) {
        ob_start();
        require($file);
        return ob_get_clean();
    }
    return '';
}

function isCurrentManagerForDepartment(string $department_id, string $user_id)
{
    return getCurrentManager($department_id) === $user_id;
}

function getCurrentManager($department_id)
{
    $db = Database::getDbh();
    return $db->where('department_id', $department_id)->getValue('departments', 'current_manager');
}

function isCurrentManager(string $user_id)
{
    $db = Database::getDbh();
    return $db->where('current_manager', $user_id)->has('departments');
}

function isSecretary($user_id)
{
    $user_role = (new User($user_id))->role;
    return $user_role === ROLE_SECRETARY;
}

function isAssignedAsSecretary($user_id)
{
    $db = Database::getDbh();
    return $db->where('user_id', $user_id)->has('assigned_as_secretary');
}


function isSuperintendent($user_id)
{
    $user_role = (new User($user_id))->role;
    return in_array($user_role, ADMIN, true);
}

function getMembersAssignedToSecretary($user_id): array
{
    $db = Database::getDbh();
    $department_members = [];
    $department_id = $db->where('user_id', $user_id)->getValue('assigned_as_secretary', 'department_id');
    try {
        $department_members = $db->where('department_id', $department_id)->orderBy('first_name', 'ASC')->get('users');
    } catch (Exception $e) {
    }
    return $department_members;
}

function isFinanceOfficer($user_id)
{
    return Database::getDbh()->where('value', $user_id)->where('prop', 'finance_officer')->has('settings');
}

/* Get the HTTP(S) URL of the current page.
 *
 * @param $server The $_SERVER superglobals array.
 * @return string The URL.
 */
function currentUrl($server)
{
    //Figure out whether we are using http or https.
    $http = 'http';
    //If HTTPS is present in our $_SERVER array, the URL should
    //start with https:// instead of http://
    if (isset($server['HTTPS'])) {
        $http = 'https';
    }
    //Get the HTTP_HOST.
    $host = $server['HTTP_HOST'];
    //Get the REQUEST_URI. i.e. The Uniform Resource Identifier.
    $requestUri = $server['REQUEST_URI'];
    //Finally, construct the full URL.
    //Use the function htmlentities to prevent XSS attacks.
    return $http . '://' . htmlentities($host) . htmlentities($requestUri);
}

function nullableStringConverter($nullableString, $nullOutput, $trueOutput, $falseOutput)
{
    if ($nullableString === null) {
        return $nullOutput;
    }
    if ($nullableString) {
        return $trueOutput;
    }

    return $falseOutput;
}

