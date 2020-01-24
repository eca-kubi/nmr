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
        //$payload['current_draft'] = Database::getDbh()->where('month(time_modified) = month(current_date)')->where('user_id', getUserSession()->user_id)->getOne('nmr_editor_draft');
        $payload['is_power_user'] = isPowerUser(getUserSession()->user_id);
        $this->view('pages/dashboard', $payload);
    }

    public function powerUserDashboard()
    {
        redirect('pages/dashboard');
        /*if (!isLoggedIn()) {
            redirect('users/login/pages/power-user-dashboard');
        }
        $payload = ['page_title' => 'Power User Dashboard'];
        if ($payload['is_power_user'] = isPowerUser(getUserSession()->user_id)) {
            $this->view('pages/power-user-dashboard', $payload);
        } else {
            redirect('pages/dashboard');
        }*/
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
        if (!isLoggedIn()) {
            redirect('users/login/pages/edit-draft/' . $draft_id);
        }
        $db = Database::getDbh();
        if (!$db->where('draft_id', $draft_id)->where('user_id', getUserSession()->user_id)->has('nmr_editor_draft'))
            redirect('errors/index/404');
        $payload['page_title'] = 'Edit Draft (Flash Report)';
        $payload['draft_id'] = $draft_id;
        $draft = $db->where('draft_id', $draft_id)->where('user_id', getUserSession()->user_id)->getOne('nmr_editor_draft', ['content', 'title', 'spreadsheet_content', 'target_year', 'target_month']);
        $payload['content'] = $draft['content'];
        $target_month = $draft['target_month'];
        $target_year = $draft['target_year'];
        $payload['is_submission_closed'] = isSubmissionClosedByPowerUser($target_month, $target_year);
        //$payload['is_submission_opened'] = isSubmissionOpened();
        $payload['spreadsheet_content'] = $draft['spreadsheet_content'];
        $payload['title'] = 'Edit Draft (Flash Report)';
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $payload['edit_draft'] = true;
        $this->view('pages/report', $payload);
    }

    public function editReport($draft_id): void
    {
        $db = Database::getDbh();
        $current_user = getUserSession();
        if (!isLoggedIn()) {
            redirect('users/login/pages/edit-report/' . $draft_id);
        }
        if (!$db->where('draft_id', $draft_id)->where('user_id', $current_user->user_id)->has('nmr_editor_draft'))
            redirect('errors/index/404');
        $payload['page_title'] = 'My Reports (Flash Report)';
        $payload['draft_id'] = $draft_id;
        $payload['edit_report'] = true;
        $draft = $db->where('draft_id', $draft_id)->where('user_id', $current_user->user_id)->getOne('nmr_editor_draft', ['content', 'title', 'spreadsheet_content', 'target_month', 'target_year']);
        $payload['content'] = $draft['content'];
        $payload['spreadsheet_content'] = $draft['spreadsheet_content'];
        $payload['title'] = 'My Reports (Flash Report)';
        $target_month = $draft['target_month'];
        $target_year = $draft['target_year'];
        $payload['is_submission_closed'] = isSubmissionClosedByPowerUser($target_month, $target_year);
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $this->view('pages/report', $payload);
    }

    public function editSubmittedReport($report_submissions_id): void
    {
        $db = Database::getDbh();
        $current_user = getUserSession();
        if (!isLoggedIn()) {
            redirect('users/login/pages/edit-submitted-report/' . $report_submissions_id);
        }
        if (!isPowerUser($current_user->user_id) || isITAdmin($current_user->user_id)) {
            redirect('errors/index/404');
        }

        if (!$db->where('report_submissions_id', $report_submissions_id)->has('nmr_report_submissions')) {
            redirect('errors/index/404');
        }
        $payload['report_submissions_id'] = $report_submissions_id;
        $payload['edit_submitted_report'] = true;
        try {
            $submitted_report = $db->where('report_submissions_id', $report_submissions_id)
                ->join('departments d', 'r.department_id=d.department_id')
                ->getOne('nmr_report_submissions r', ['content', 'spreadsheet_content', 'target_month', 'target_year', 'department']);
            $payload['content'] = $submitted_report['content'];
            $payload['spreadsheet_content'] = $submitted_report['spreadsheet_content'];
            $payload['title'] = "Flash Report (" . $submitted_report['department'] . ")";
            $payload['page_title'] = 'Flash Report (' . $submitted_report['department'] . ')';
            $target_month = $submitted_report['target_month'];
            $target_year = $submitted_report['target_year'];
            //$payload['is_submission_closed'] = isSubmissionClosedByPowerUser($target_month, $target_year);
            $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
            $this->view('pages/report', $payload);
        } catch (Exception $e) {
        }
    }

    public function updateSubmittedReport($report_submissions_id)
    {
        $db = Database::getDbh();
        $success = $db->where('report_submissions_id', $report_submissions_id)->update('nmr_report_submissions', [
            'content' => $_POST['content'],
            'spreadsheet_content' => $_POST['spreadsheet_content'],
            'date_modified' => now(),
        ]);
        if ($success) {
            echo json_encode(['success' => true]);
        }
    }

    public function notSubmittedDepartments($target_month, $target_year)
    {
       echo json_encode(getNotSubmittedDepartments($target_month, $target_year));
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
        $db = Database::getDbh();
        $ret = $db->where('prop', 'nmr_submission_opened')->update('settings', ['value' => 1]);
        $ret = $ret && $db->where('prop', 'nmr_current_submission_month')->update('settings', ['value' => $currentMonth]);
        $ret = $ret && $db->where('prop', 'nmr_current_submission_year')->update('settings', ['value' => $currentYear]);
        $ret = $ret && $db->where('prop', 'nmr_submission_closed_by_power_user')->update('settings', ['value' => 0]);
        $db->onDuplicate(['target_year', 'target_month']);
        $ret = $ret && $db->insert('nmr_target_month_year', ['target_year' => $currentYear, 'target_month' => $currentMonth, 'closed_status' => 0]);
        if ($ret) {
            echo json_encode(['currentSubmissionYear' => $currentYear, 'currentSubmissionMonth' => $currentMonth, 'isSubmissionClosedByPowerUser' => false]);
        }
    }

    public function closeSubmission($target_month = "", $target_year = "")
    {
        $db = Database::getDbh();
        $target_month = $target_month? : date('Y');
        $target_year = $target_year ? : date('F');
        if (currentSubmissionYear() === $target_year && (currentSubmissionMonth()) === $target_month) {
            $ret = Database::getDbh()->where('prop', 'nmr_submission_opened')->update('settings', ['value' => 0]);
            $ret = $ret && Database::getDbh()->where('prop', 'nmr_submission_closed_by_power_user')->update('settings', ['value' => 1]);
            $ret = $ret && Database::getDbh()->where('prop', 'nmr_current_submission_month')->update('settings', ['value' => '']);
            $ret = $ret && Database::getDbh()->where('prop', 'nmr_current_submission_year')->update('settings', ['value' => '']);
        }
        if ($db->where('target_month', $target_month)->where('target_year', $target_year)
            ->update('nmr_target_month_year', ['closed_status' => 1])) {
            echo json_encode(['isSubmissionClosedByPowerUser' => true, 'success' => true]);
        }
    }

    public function submittedReports(string $target_month = "", $target_year = "", $department_id = "")
    {
        if (!isLoggedIn())
            redirect('users/login/pages/submitted-reports/');
        $payload['page_title'] = 'Submitted Reports (Flash Report)';
        $payload['report_submissions'] = groupedReportSubmissions(getReportSubmissions($target_month, $target_year, $department_id));
        $payload['is_power_user'] = isPowerUser(getUserSession()->user_id);
        $this->view('pages/submitted-reports', $payload);
    }

    public function generateReport(string $target_month, $target_year)
    {
        $db = Database::getDbh();
        try {
            $ret = $db->where('s.target_month="' . $target_month . '"')
                ->where('s.target_year="' . $target_year . '"')
                ->join('departments d', 'd.department_id=s.department_id')
                ->join('nmr_report_order r', 'r.department_id=d.department_id')
                ->orderBy('r.order_no', 'ASC')
                ->get('nmr_report_submissions s', null, 's.content');
            echo json_encode($ret, JSON_UNESCAPED_SLASHES);
        } catch (Exception $e) {
        }
    }

    public function finalReport(string $target_month, $target_year)
    {
        $db = Database::getDbh();
        $db->onDuplicate(['data_uri', 'html_content']);
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $data_uri = $data->data_uri;
        $html_content = $data->html_content;
        if ($db->insert('nmr_final_report', ['data_uri' => $data_uri, 'html_content' => $html_content, 'target_month' => $target_month, 'target_year' => $target_year])) {
            echo json_encode(['success' => true, 'targetMonth' => $target_month, 'targetYear' => $target_year]);
        }
    }

    public function fetchFinalReportAsHtml(string $target_month, $target_year)
    {
        $db = Database::getDbh();
        $cover_page = $db->where('name', 'cover_page')->getValue('nmr_report_parts', 'content');
        if ($db->where('target_year', $target_year)->where('target_month', $target_month)->has('nmr_final_report')) {
            $content = $db->where('target_year', $target_year)->where('target_month', $target_month)
                ->getValue('nmr_final_report', 'html_content');
            if (strpos($content, "<coverpage>") === false) $content = "<coverpage>$cover_page</coverpage>" . "<p class='page-break'></p>" . $content;
            return $content;
        } else {
            $callback = function ($array) {
                return $array['content'];
            };

            $join = function ($content, $separator) {
                $content .= $separator;
                return $content;
            };
            return "<coverpage>$cover_page</coverpage>" . "<p class='page-break'></p>" . array_reduce(array_map($callback, getSubmittedReports($target_month, $target_year)), $join, "<br/>");
        }
    }


    public function editFinalReport(string $target_month, $target_year)
    {
        $db = Database::getDbh();
        $payload['page_title'] = 'Edit Final Report (Flash Report)';
        $payload['edit_final_report'] = true;
        // $payload['is_submission_closed'] = isSubmissionClosedByPowerUser($target_month, $target_year);
        $payload['content'] = $this->fetchFinalReportAsHtml($target_month, $target_year);
        $payload['title'] = "$target_month $target_year Flash Report";
        $payload['target_year'] = $target_year;
        $payload['target_month'] = $target_month;
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $this->view('pages/report', $payload);
    }

    public function saveFinalReport(string $target_month, $target_year)
    {
        $db = Database::getDbh();
        $db->onDuplicate(['html_content']);
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        if ($db->insert('nmr_final_report', [
            'html_content' => $data->html_content,
            'target_year' => $target_year,
            'target_month' => $target_month
        ])) {
            echo json_encode(['success' => true]);
        }
    }


    public function isSubmissionClosed(string $target_month, $target_year)
    {
        echo json_encode(['submission_closed' => isSubmissionClosedByPowerUser($target_month, $target_year)]);
    }

    public function draftReports()
    {
        redirect('pages/draft-report');
        /*$db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/draft-reports/');
        }
        $payload['page_title'] = 'Draft Reports';
        try {
            $payload['drafts'] = Database::getDbh()->where('user_id', getUserSession()->user_id)
                ->where('deleted', 0)
                ->orderBy('time_modified')
                ->get('nmr_editor_draft');
        } catch (Exception $e) {
        }
        $this->view('pages/draft-reports', $payload);*/
    }

    public function draftReport()
    {
        $db = Database::getDbh();
        $current_user = getUserSession();
        if (!isLoggedIn()) {
            redirect('users/login/pages/draft-report/');
        }
        $payload['page_title'] = 'Draft Report (Start Monthly Report Here)';
        $current_sub_month = currentSubmissionMonth() ?: monthName(monthNumber(now()));
        $current_sub_year = currentSubmissionYear() ?: year(now());
        $previous_month = explode(" ", getPreviousMonthYear($current_sub_month))[0];
        $previous_year = explode(" ", getPreviousMonthYear($current_sub_month))[1];
        // If user has a draft for the target month and year load it
        if (hasDraftForTargetMonthYear($current_sub_month, $current_sub_year, $current_user->user_id)) {
            $payload['draft'] = getDraftForTargetMonthYear($current_sub_month, $current_sub_year, $current_user->user_id);
        } else if (hasDraftForTargetMonthYear($previous_month, $previous_year, $current_user->user_id)) {
            // if a draft exists for the previous month create a new one based on it
            $previous_draft = getDraftForTargetMonthYear($previous_month, $previous_year, $current_user->user_id);
            if ($draft_id = $db->insert('nmr_editor_draft', [
                'content' => $previous_draft['content'],
                'spreadsheet_content' => $previous_draft['spreadsheet_content'],
                'target_month' => $current_sub_month,
                'target_year' => $current_sub_year,
                'user_id' => $current_user->user_id,
                'time_modified' => now(),
                'target_month_no' => monthNumber(now())
            ])) {
                $payload['draft'] = $db->where('draft_id', $draft_id)->getOne('nmr_editor_draft');
                // Create an entry into my reports
                $db->insert('nmr_my_reports', ['draft_id' => $draft_id]);
            }
        } else if ($db->where('department_id', $current_user->department_id)->has('nmr_preloaded_draft')) {
            // Create a new draft based on preloaded draft
            $preloaded_draft = $db->where('department_id', $current_user->department_id)->getOne('nmr_preloaded_draft');
            if ($draft_id = $db->insert('nmr_editor_draft', [
                'content' => $preloaded_draft['editor_content'],
                'spreadsheet_content' => $preloaded_draft['spreadsheet_content'],
                'target_month' => $current_sub_month,
                'target_year' => $current_sub_year,
                'user_id' => $current_user->user_id,
                'time_modified' => now(),
                'target_month_no' => monthNumber(now())
            ])) {
                $payload['draft'] = $db->where('draft_id', $draft_id)->getOne('nmr_editor_draft');
                $db->insert('nmr_my_reports', ['draft_id' => $draft_id]);
            }
        } else {
            // Create a new draft
            if ($draft_id = $db->insert('nmr_editor_draft', [
                'target_month' => $current_sub_month,
                'target_year' => $current_sub_year,
                'user_id' => $current_user->user_id,
                'time_modified' => now(),
                'target_month_no' => monthNumber(now())
            ])) {
                $payload['draft'] = $db->where('draft_id', $draft_id)->getOne('nmr_editor_draft');
                $db->insert('nmr_my_reports', ['draft_id' => $draft_id]);
            }
        }
        $this->view('pages/draft-report', $payload);
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

    public function myReports()
    {
        $db = Database::getDbh();
        $payload['my_reports'] = [];
        $payload['page_title'] = 'My Reports';
        $current_user = getUserSession();
        if (!isLoggedIn()) {
            redirect('users/login/pages/my-reports/');
        }

        try {
            $my_reports = $db->where('d.user_id', $current_user->user_id)->join('nmr_editor_draft d', 'd.draft_id=m.draft_id')
                ->join('nmr_target_month_year t', 't.target_month=d.target_month and t.target_year=d.target_year')
                ->orderBy('month_no_year', 'DESC')
                ->get('nmr_my_reports m', null, 'd.draft_id, d.time_modified, d.target_year, d.target_month, concat(d.target_year, d.target_month_no) as month_no_year, t.closed_status');
            if (is_array($my_reports)) {
                $my_reports = groupedMyReports($my_reports);
                $payload['my_reports'] = $my_reports;
            }
        } catch (Exception $e) {
        }
        $this->view('pages/my-reports', $payload);
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

    public function getSubmittedReport($report_id)
    {
        $report = Database::getDbh()->where('report_submissions_id', $report_id)->getOne('nmr_report_submissions');
        echo json_encode($report, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
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
                    //'user_id' => $current_user->user_id,
                    'content' => $_POST['content'],
                    'spreadsheet_content' => $_POST['spreadsheet_content'],
                    'time_modified' => now()
                ]);
                if ($success) echo json_encode(['success' => true, 'draftId' => $draft_id]);;
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


    public function downloadReport(string $target_month, $target_year)
    {
        $db = Database::getDbh();
        $data_uri = $db->where('target_month', $target_month)->where('target_year', $target_year)
            ->getValue('nmr_final_report', 'data_uri');
        $data_uri = str_replace('data:application/pdf;base64,', '', $data_uri);
        $data = base64_decode($data_uri);

        file_put_contents('file.pdf', $data);
        header('Content-Type: application/pdf');
        echo $data;
    }

    public function downloadFinalReportClientSide($target_month, $target_year)
    {
        echo $this->fetchFinalReportAsHtml($target_month, $target_year);
    }

    public function phpinfo(): void
    {
        echo phpinfo();
    }

    public function fetchDraft($draft_id)
    {
        echo Database::getDbh()->where('draft_id', $draft_id)->getValue('nmr_editor_draft', 'content');
    }

    public function fetchPreloadedDraft($draft_id)
    {
        echo Database::getDbh()->where('draft_id', $draft_id)->getValue('nmr_preloaded_draft', 'editor_content');
    }
}
