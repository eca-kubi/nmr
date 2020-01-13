<?php

class Pages extends Controller
{
    public function index(): void
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        redirect('pages/dashboard');
    }

    public function dashboard(): void
    {
        if (!isLoggedIn()) {
            redirect('users/login/pages/dashboard');
        }
        $payload['page_title'] = 'Dashboard';
        $payload['current_draft'] = Database::getDbh()->where('month(time_modified) = month(current_date)')->where('user_id', getUserSession()->user_id)->getOne('nmr_editor_draft');
        $this->view('pages/dashboard', $payload);
    }

    public function powerUserDashboard()
    {
        if (!isLoggedIn()) {
            redirect('users/login/pages/power-user-dashboard');
        }
        $payload = ['page_title' => 'Power User Dashboard'];
        if ($payload['is_power_user'] = isPowerUser(getUserSession()->user_id)){
            $this->view('pages/power-user-dashboard', $payload);
        } else {
            redirect('pages/dashboard');
        }
    }

    public function reports(): void
    {
        $payload['page_title'] = 'Reports';
        $db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/reports');
        }
        $payload['reports'] = $db->get('nmr_flash_report');
        $this->view('pages/reports', $payload);
    }

    public function newReport(): void
    {
        if (!isLoggedIn()) {
            redirect('users/login/pages/new-report');
        }
        $payload['page_title'] = 'New Report';
        $db = Database::getDbh();
        $current_user = getUserSession();
        if ($draft = $db->where('user_id', $current_user->user_id)->where("month(time_modified) = month(current_date())")->getOne('nmr_editor_draft')) {
            redirect('/pages/editReport' . $draft['draft_id']);
        }
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $this->view('pages/report', $payload);
    }

    public function editReport($draft_id): void
    {
        //if (!$draft_id) redirect('errors/index/404');
        if (!isLoggedIn()) {
            redirect('users/login/pages/edit-report/' . $draft_id);
        }
        $payload['page_title'] = 'Edit Report';
        $payload['draft_id'] = $draft_id;
        $payload['content'] = Database::getDbh()->where('draft_id', $draft_id)->getValue('nmr_editor_draft', 'content');
        $db = Database::getDbh();
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $this->view('pages/report', $payload);
    }

    public function viewReport(): void
    {
        //if (!$report_id) redirect('errors/index/404');
        $db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/view-report/');
        }
        $payload['page_title'] = 'View Report';
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['report_month_input']) && isset($_GET['report_year_input'])) {
            $payload['report'] = $db->where('month', monthNumber($_GET['report_month_input'] . '-' . $_GET['report_year_input']))->where('year', $_GET['report_year_input'])->getOne('nmr_flash_report');
            $this->view('pages/view-report', $payload);
        } else {
            redirect('pages/reports');
        }
    }

    public function saveDraft()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getDbh();
            $current_user = getUserSession();
            $draft_id = $_POST['draft_id'];
            if ($db->where('draft_id', $draft_id)->where('user_id', $current_user->user_id)->has('nmr_editor_draft')) {
                $ret = $db->where('draft_id', $draft_id)->update('nmr_editor_draft',
                    ['content' => $_POST['content'], 'time_modified' => now()]
                );
                if ($ret)
                    echo json_encode(['success' => true]);
                else
                    echo json_encode(['success' => false]);
            } else {
                $ret = $db->insert('nmr_editor_draft', [
                    'content' => $_POST['content'],
                    'time_modified' => now(),
                    'user_id' => $current_user->user_id
                ]);
                if ($ret)
                    echo json_encode(['draft_id' => $db->getInsertId(), 'success' => true]);
                else
                    echo json_encode(['success' => false]);
            }

        }
    }

    public function openSubmission()
    {
        $currentYear = date('Y');
        $currentMonth = date('F');
        if (currentSubmissionYear() !== $currentYear && (currentSubmissionMonth()) !== $currentMonth ) {
            $ret = Database::getDbh()->where('prop', 'nmr_submission_opened')->update('settings', ['value' => 1]);
            $ret = $ret && Database::getDbh()->where('prop', 'nmr_current_submission_month')->update('settings', ['value' => $currentMonth]);
            $ret = $ret && Database::getDbh()->where('prop', 'nmr_current_submission_year')->update('settings', ['value' => $currentYear]);
            $ret = $ret && Database::getDbh()->where('prop', 'nmr_submission_closed_by_power_user')->update('settings', ['value' => 0]);
            if ($ret) {
                echo json_encode(['currentSubmissionYear' => $currentYear, 'currentSubmissionMonth' => $currentMonth, 'isSubmissionClosedByPowerUser' => false]);
            }
        }
    }

    public function closeSubmission()
    {
        $ret = Database::getDbh()->where('prop', 'nmr_submission_opened')->update('settings', ['value' => 0]);
        $ret = $ret && Database::getDbh()->where('prop', 'nmr_submission_closed_by_power_user')->update('settings', ['value' => 1]);
        echo json_encode(['isSubmissionClosedByPowerUser' => true]);
    }

    public function viewSubmissions()
    {
        $db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/view-report/');
        }
        $payload['submissions'] = getSubmissions();
        $payload['page_title'] = 'Report Submission';
        $this->view('pages/view-submissions', $payload);
    }

    public function fetchSubmissions()
    {
        try {
            $submissions = Database::getDbh()->where('submitted', 1)->join('users u', 'u.user_id=n.user_id')
                ->join('departments d', 'u.department_id=d.department_id')
                ->get('nmr_editor_draft n');
            echo print_r($submissions);
        } catch (Exception $e) {
        }
    }

    public function draftReports()
    {
        $db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/view-report/');
        }
        $payload['page_title'] = 'Draft Reports';
        $payload['drafts'] = Database::getDbh()->where('user_id', getUserSession()->user_id)->get('nmr_editor_draft');
        $this->view('pages/draft-reports', $payload);
    }

    public function phpinfo(): void
    {
        echo phpinfo();
    }

    public function editor(): void
    {

    }

    public function fetchDraft($draft_id)
    {
        echo Database::getDbh()->where('draft_id', $draft_id)->getValue('nmr_editor_draft', 'content');
    }
}
