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
        if ($payload['is_power_user'] = isPowerUser(getUserSession()->user_id)) {
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

    public function newDraft(): void
    {
        if (!isLoggedIn()) {
            // redirect('users/login/pages/new-draft' . (isset($_GET['preloaded'])? '?preloaded=true' : ''));
            redirect('users/login/pages/new-draft' . fetchGetParams());
        }
        $payload['page_title'] = 'New Draft';
        $payload['is_new_draft'] = true;
        $db = Database::getDbh();
        if (isset($_GET['preloaded'])) {
            $preloaded = $db->where('department_id', getUserSession()->department_id)->getOne('nmr_preloaded_draft');
            if (is_array($preloaded) && count($preloaded) > 0) {
                $payload['content'] = $preloaded['editor_content'];
                $payload['spreadsheet_content'] = $preloaded['spreadsheet_content'];
                $payload['title'] = $preloaded['title'];
                $payload['edit_draft'] = true;
            }
        }
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $this->view('pages/report', $payload);
    }

    public function editDraft($draft_id): void
    {
        //if (!$draft_id) redirect('errors/index/404');
        if (!isLoggedIn()) {
            redirect('users/login/pages/edit-draft/' . $draft_id);
        }
        $db = Database::getDbh();
        if (!$db->where('draft_id', $draft_id)->where('user_id', getUserSession()->user_id)->has('nmr_editor_draft'))
            redirect('errors/index/404');
        $payload['page_title'] = 'Edit Draft';
        $payload['draft_id'] = $draft_id;
        $draft = $db->where('draft_id', $draft_id)->where('user_id', getUserSession()->user_id)->getOne('nmr_editor_draft', ['content', 'title', 'spreadsheet_content']);
        $payload['content'] = $draft['content'];
        $payload['spreadsheet_content'] = $draft['spreadsheet_content'];
        $payload['title'] = $draft['title'];
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $payload['edit_draft'] = true;
        $this->view('pages/report', $payload);
    }

    public function editPreloadedDraft($draft_id): void
    {
        if (!isLoggedIn()) {
            redirect('users/login/pages/edit-preloaded-draft/' . $draft_id);
        }
        if (!isITAdmin(getUserSession()->user_id))
            redirect('pages/draft-reports');
        $db = Database::getDbh();
        if (!$db->where('draft_id', $draft_id)->has('nmr_preloaded_draft'))
            redirect('errors/index/404');
        $payload['page_title'] = 'Edit Preloaded Draft';
        $payload['draft_id'] = $draft_id;
        $draft = $db->where('draft_id', $draft_id)->getOne('nmr_preloaded_draft', ['editor_content', 'title', 'spreadsheet_content']);
        $payload['content'] = $draft['editor_content'];
        $payload['spreadsheet_content'] = $draft['spreadsheet_content'];
        $payload['title'] = $draft['title'];
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $payload['edit_draft'] = true;
        $payload['edit_preloaded_draft'] = true;
        $this->view('pages/report', $payload);
    }

    public function deleteDraft($draft_id)
    {
        $db = Database::getDbh();
        $success = $db->where('draft_id', $draft_id)->update('nmr_editor_draft', ['deleted' => 1]);
        if ($success)
            echo json_encode(['success' => true]);
    }

    public function deletePreloadedDraft($draft_id)
    {
        $db = Database::getDbh();
        $success = $db->where('draft_id', $draft_id)->update('nmr_preloaded_draft', ['deleted' => 1]);
        if ($success)
            echo json_encode(['success' => true]);
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
            $draft_id = isset($_POST['draft_id']) ? $_POST['draft_id'] : '';
            if ($draft_id && $db->where('draft_id', $draft_id)->where('user_id', $current_user->user_id)->has('nmr_editor_draft')) {
                $ret = $db->where('draft_id', $draft_id)->update('nmr_editor_draft',
                    ['title' => $_POST['title'], 'content' => $_POST['content'], 'time_modified' => now(), 'spreadsheet_content' => $_POST['spreadsheet_content']]
                );
                if ($ret)
                    echo json_encode(['success' => true]);
                else
                    echo json_encode(['success' => false]);
            } else {
                $ret = $db->insert('nmr_editor_draft', [
                    'title' => $_POST['title'],
                    'content' => $_POST['content'],
                    'spreadsheet_content' => $_POST['spreadsheet_content'],
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

    public function savePreloadedDraft()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getDbh();
            $current_user = getUserSession();
            $draft_id = isset($_POST['draft_id']) ? $_POST['draft_id'] : '';
            if ($draft_id && $db->where('draft_id', $draft_id)->has('nmr_preloaded_draft')) {
                $ret = $db->where('draft_id', $draft_id)->update('nmr_preloaded_draft',
                    ['title' => $_POST['title'], 'editor_content' => $_POST['content'], 'time_modified' => now(), 'spreadsheet_content' => $_POST['spreadsheet_content']]
                );
                if ($ret)
                    echo json_encode(['success' => true]);
                else
                    echo json_encode(['success' => false]);
            } else {
                $ret = $db->insert('nmr_preloaded_draft', [
                    'title' => $_POST['title'],
                    'editor_content' => $_POST['content'],
                    'spreadsheet_content' => $_POST['spreadsheet_content'],
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

    function saveDraftAsPreloaded()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getDbh();
            $current_user = getUserSession();
            $department_id = $db->where('department', $_POST['department_name'])->getValue('departments', 'department_id');
            if ($db->where('department_id', $department_id)->has('nmr_preloaded_draft')) {
                $success = $db->where('department_id', $department_id)->update('nmr_preloaded_draft', [
                    'title' => $_POST['title'],
                    'editor_content' => $_POST['content'],
                    'spreadsheet_content' => $_POST['spreadsheet_content'],
                    'time_modified' => now(),
                    'modified_by' => $current_user->user_id
                ]);
                if ($success) echo json_encode(['success' => true]);
                else echo json_encode(['success' => false]);
            } else {
                $success = $db->insert('nmr_preloaded_draft', [
                    'title' => $_POST['title'],
                    'editor_content' => $_POST['content'],
                    'spreadsheet_content' => $_POST['spreadsheet_content'],
                    'time_modified' => now(),
                    'modified_by' => $current_user->user_id,
                    'department_id' => $department_id
                ]);
                if ($success) echo json_encode(['success' => true]);
                else echo json_encode(['success' => false]);
            }
        }
    }

    public function openSubmission()
    {
        $currentYear = date('Y');
        $currentMonth = date('F');
        if (currentSubmissionYear() !== $currentYear && (currentSubmissionMonth()) !== $currentMonth) {
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

    public function reportSubmissions(string $target_month = "", $target_year = "", $department_id = "")
    {
        if (!isLoggedIn())
            redirect('users/login/pages/report-submissions/');
        if (!isPowerUser(getUserSession()->user_id))
            redirect('errors/index/404');
        $payload['page_title'] = 'Report Submissions';
        $payload['report_submissions'] = groupedReportSubmissions(getReportSubmissions($target_month, $target_year, $department_id));

        $this->view('pages/report-submissions', $payload);
    }

    public function draftReports()
    {
        $db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/draft-reports/');
        }
        $payload['page_title'] = 'Draft Reports';
        $payload['drafts'] = Database::getDbh()->where('user_id', getUserSession()->user_id)->where('deleted', 0)->get('nmr_editor_draft');
        $this->view('pages/draft-reports', $payload);
    }


    public function preloadedDraftReports()
    {
        $db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/preloaded-draft-reports/');
        }
        if (!isITAdmin(getUserSession()->user_id))
            redirect('pages/draft-reports');
        $payload['page_title'] = 'Preloaded Draft Reports';
        $payload['preloaded_drafts'] = Database::getDbh()->where('deleted', 0)->get('nmr_preloaded_draft');
        $this->view('pages/preloaded-draft-reports', $payload);
    }

    public function saveSpreadsheetTemplate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            $db = Database::getDbh();
            $department_id = $db->where('department', $data->department)->getValue('departments', 'department_id');
            $db->onDuplicate(['template', 'department_id']);
            $success = $db->insert(TABLE_NMR_SPREADSHEET_TEMPLATES,
                ['description' => $data->description, 'template' => $data->template, 'department_id' => $department_id]);
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }

    public function submitReport()
    {
        $db = Database::getDbh();
        $current_user = getUserSession();
        $db->onDuplicate(['content', 'spreadsheet_content', 'date_modified']);
        $draft_id = '';
        if (isset($_POST['draft_id'])) $draft_id = $_POST['draft_id'];
        $success = $db->insert('nmr_report_submissions', [
            'department_id' => $current_user->department_id,
            'user_id' => $current_user->user_id,
            'content' => $_POST['content'],
            'spreadsheet_content' => $_POST['spreadsheet_content'],
            'date_submitted' => now(),
            'date_modified' => now(),
            'target_month' => $db->func('MonthName(?)', [now()]),
            'target_year' => $db->func('Year(?)', [now()])
        ]);
        if ($success) {
            if ($db->where('draft_id', $draft_id)->has('nmr_editor_draft')) {
                $success = $db->where('draft_id', $draft_id)->update('nmr_editor_draft', [
                    'title' => $_POST['title'],
                    'user_id' => $current_user->user_id,
                    'content' => $_POST['content'],
                    'spreadsheet_content' => $_POST['spreadsheet_content'],
                    'time_modified' => now()
                ]);
                if($success) echo json_encode(['success' => true, 'draftId' => $draft_id]);;
            } else {
                $success = $db->insert('nmr_editor_draft', [
                    'title' => $_POST['title'],
                    'user_id' => $current_user->user_id,
                    'content' => $_POST['content'],
                    'spreadsheet_content' => $_POST['spreadsheet_content'],
                    'time_modified' => now()
                ]);
                if ($success) echo json_encode(['success' => true, 'draftId' => $success]);
            }
        }
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

    public function fetchPreloadedDraft($draft_id)
    {
        echo Database::getDbh()->where('draft_id', $draft_id)->getValue('nmr_preloaded_draft', 'editor_content');
    }

    public function getArrayData()
    {
        echo json_encode(htmlentities('<span></span>'));
    }
}
