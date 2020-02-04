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

    public function reportParts(): void
    {
        $payload['page_title'] = 'Report Parts';
        $db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/report-parts');
        }
        $payload['report_parts'] = $db->get('nmr_report_parts');
        $payload['report_parts_fr'] = $db->get('nmr_fr_report_parts');
        $this->view('pages/report-parts', $payload);
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

    public function editDraft($draft_id, $table_prefix = 'nmr'): void
    {
        $db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/edit-draft/' . $draft_id . '/' . $table_prefix);
        }
        if (!$db->where('draft_id', $draft_id)->where('user_id', getUserSession()->user_id)->has($table_prefix . '_editor_draft'))
            redirect('errors/index/404');
        $payload['page_title'] = 'Edit Draft ' . flashOrFull($table_prefix) . '( Report)';
        $payload['draft_id'] = $draft_id;
        $draft = $db->where('draft_id', $draft_id)->where('user_id', getUserSession()->user_id)->getOne($table_prefix . '_editor_draft', ['content', 'title', 'spreadsheet_content', 'target_year', 'target_month']);
        $payload['content'] = $draft['content'];
        $target_month = $draft['target_month'];
        $target_year = $draft['target_year'];
        $payload['target_month'] = $target_month;
        $payload['target_year'] = $target_year;
        $payload['is_submission_closed'] = isSubmissionClosedByPowerUser($target_month, $target_year);
        $payload['spreadsheet_content'] = $draft['spreadsheet_content'];
        $payload['title'] = $payload['page_title'];
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $payload['edit_draft'] = true;
        $payload['table_prefix'] = $table_prefix;
        $this->view('pages/report', $payload);
    }

    public function editReport($draft_id, $table_prefix='nmr'): void
    {
        $db = Database::getDbh();
        $current_user = getUserSession();
        if (!isLoggedIn()) {
            redirect('users/login/pages/edit-report/' . $draft_id);
        }
        if (!$db->where('draft_id', $draft_id)->where('user_id', $current_user->user_id)->has($table_prefix. '_editor_draft'))
            redirect('errors/index/404');
        $payload['page_title'] = 'My Reports (' . flashOrFull($table_prefix) . ') Report)';
        $payload['draft_id'] = $draft_id;
        $payload['edit_report'] = true;
        $draft = $db->where('draft_id', $draft_id)->where('user_id', $current_user->user_id)->getOne($table_prefix. '_editor_draft', ['content', 'title', 'spreadsheet_content', 'target_month', 'target_year']);
        $payload['content'] = $draft['content'];
        $payload['spreadsheet_content'] = $draft['spreadsheet_content'];
        $payload['title'] = $payload['page_title'];
        $target_month = $draft['target_month'];
        $target_year = $draft['target_year'];
        $payload['is_submission_closed'] = isSubmissionClosedByPowerUser($target_month, $target_year, $table_prefix);
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $this->view('pages/report', $payload);
    }

    public function editSubmittedReport($report_submissions_id, $table_prefix = 'nmr'): void
    {
        $db = Database::getDbh();
        $current_user = getUserSession();
        if (!isLoggedIn()) {
            redirect('users/login/pages/edit-submitted-report/' . $report_submissions_id . '/' . $table_prefix);
        }
        if (!isPowerUser($current_user->user_id) || isITAdmin($current_user->user_id)) {
            redirect('errors/index/404');
        }

        if (!$db->where('report_submissions_id', $report_submissions_id)->has($table_prefix . '_report_submissions')) {
            redirect('errors/index/404');
        }
        $payload['report_submissions_id'] = $report_submissions_id;
        $payload['edit_submitted_report'] = true;
        $payload['table_prefix'] = $table_prefix;
        try {
            $submitted_report = $db->where('report_submissions_id', $report_submissions_id)
                ->join('departments d', 'r.department_id=d.department_id')
                ->getOne($table_prefix . '_report_submissions r', ['content', 'spreadsheet_content', 'target_month', 'target_year', 'department']);
            $payload['content'] = $submitted_report['content'];
            $payload['spreadsheet_content'] = $submitted_report['spreadsheet_content'];
            $payload['title'] = "Flash Report (" . $submitted_report['department'] . ")";
            $payload['page_title'] = 'Flash Report (' . $submitted_report['department'] . ')';
            $payload['target_month'] = $submitted_report['target_month'];
            $payload['target_year'] = $submitted_report['target_year'];
            $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
            $this->view('pages/report', $payload);
        } catch (Exception $e) {
        }
    }

    public function updateSubmittedReport($report_submissions_id, $table_prefix = 'nmr')
    {
        $db = Database::getDbh();
        $data = [];
        if (isset($_POST['spreadsheet_content'])) {
            $data['spreadsheet_content'] = $_POST['spreadsheet_content'];
        }
        $data['content'] = $_POST['content'];
        $data['date_modified'] = now();
        $success = $db->where('report_submissions_id', $report_submissions_id)
            ->update($table_prefix . '_report_submissions', $data);

        if ($success) {
            // At the client end do a get request followed by a post request to 'pages/final-report' in order to update pdf file and html of final report at the backend
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
        $payload['spreadsheet_templates'] = json_encode(getSpreadsheetTemplate());
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

    public function saveReportPart($report_part_id = "", $table_prefix = 'nmr')
    {
        $db = Database::getDbh();
        if ($report_part_id) {
            if ($db->where('report_part_id', $report_part_id)->update($table_prefix . '_report_parts', [
                'content' => $_POST['content']
            ])) {
                echo json_encode(['success' => true]);
            }
        } else {
            if ($db->insert($table_prefix . '_report_parts', [
                'content' => $_POST['content'],
                'description' => $_POST['description'],
                'name' => strtolower(preg_replace('/\s+/', '_', $_POST['description']))
            ])) {
                echo json_encode(['success' => true]);
            }
        }
    }

    public function saveReportPartTemp($report_part_id = "", $table_prefix = 'nmr')
    {
        $db = Database::getDbh();
        if ($report_part_id) {
            if ($db->where('report_part_id', $report_part_id)->update($table_prefix . '_report_parts_temp', [
                'content' => $_POST['content']
            ])) {
                echo json_encode(['success' => true, 'report_part_id_temp' => $report_part_id]);
            }
        } else {
            if ($db->insert($table_prefix . '_report_parts_temp', [
                'content' => $_POST['content'],
            ])) {
                echo json_encode(['success' => true, 'report_part_id_temp' => $db->getInsertId()]);
            }
        }
    }

    public function fetchReportPart($report_part_id, $table_prefix = 'nmr')
    {
        echo Database::getDbh()->where('report_part_id', $report_part_id)->getValue($table_prefix . '_report_parts', 'content');
    }

    public function fetchReportPartTemp($report_part_id, $table_prefix = 'nmr')
    {
        echo Database::getDbh()->where('report_part_id', $report_part_id)->getValue($table_prefix . '_report_parts_temp', 'content');
    }

    public function saveDraft($table_prefix = 'nmr')
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getDbh();
            $current_user = getUserSession();
            $draft_id = isset($_POST['draft_id']) ? $_POST['draft_id'] : '';
            if ($draft_id && $db->where('draft_id', $draft_id)->where('user_id', $current_user->user_id)->has($table_prefix . '_editor_draft')) {
                $ret = $db->where('draft_id', $draft_id)->update($table_prefix . '_editor_draft',
                    ['title' => $_POST['title'], 'content' => $_POST['content'], 'time_modified' => now(), 'spreadsheet_content' => $_POST['spreadsheet_content']]
                );
                if ($ret)
                    echo json_encode(['success' => true]);
                else
                    echo json_encode(['success' => false]);
            } else {
                $ret = $db->insert($table_prefix . '_editor_draft', [
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

    public function savePreloadedDraft($table_prefix = 'nmr')
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getDbh();
            $draft_id = isset($_POST['draft_id']) ? $_POST['draft_id'] : '';
            if ($draft_id && $db->where('draft_id', $draft_id)->has($table_prefix . '_preloaded_draft')) {
                $ret = $db->where('draft_id', $draft_id)->update($table_prefix . '_preloaded_draft',
                    ['title' => $_POST['title'], 'editor_content' => $_POST['content'], 'time_modified' => now(), 'spreadsheet_content' => $_POST['spreadsheet_content']]
                );
                if ($ret)
                    echo json_encode(['success' => true]);
                else
                    echo json_encode(['success' => false]);
            } else {
                $ret = $db->insert($table_prefix . '_preloaded_draft', [
                    'title' => $_POST['title'],
                    'editor_content' => $_POST['content'],
                    'spreadsheet_content' => $_POST['spreadsheet_content'],
                    'time_modified' => now()
                ]);
                if ($ret)
                    echo json_encode(['draft_id' => $db->getInsertId(), 'success' => true]);
                else
                    echo json_encode(['success' => false]);
            }
        }
    }

    function saveDraftAsPreloaded($table_prefix = 'nmr')
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getDbh();
            $current_user = getUserSession();
            $department_id = $db->where('department', $_POST['department_name'])->getValue('departments', 'department_id');
            if ($db->where('department_id', $department_id)->has($table_prefix . '_preloaded_draft')) {
                $success = $db->where('department_id', $department_id)->update($table_prefix . '_preloaded_draft', [
                    'title' => $_POST['title'],
                    'editor_content' => $_POST['content'],
                    'spreadsheet_content' => $_POST['spreadsheet_content'],
                    'time_modified' => now(),
                    'modified_by' => $current_user->user_id
                ]);
                if ($success) echo json_encode(['success' => true]);
                else echo json_encode(['success' => false]);
            } else {
                $success = $db->insert($table_prefix . '_preloaded_draft', [
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

    public function openSubmission($target_month = "", $target_year = "", $table_prefix = 'nmr')
    {
        $db = Database::getDbh();
        $target_month = $target_month ?: date('F');
        $target_year = $target_year ?: date('Y');
        $ret = $db->where('prop', $table_prefix . '_submission_opened')->update('settings', ['value' => 1]);
        //$ret = $ret && $db->where('prop', $table_prefix . '_current_submission_month')->update('settings', ['value' => $target_month]);
        //$ret = $ret && $db->where('prop', $table_prefix . '_current_submission_year')->update('settings', ['value' => $target_year]);
        $ret = $ret && $db->where('prop', $table_prefix . '_submission_closed_by_power_user')->update('settings', ['value' => 0]);
        $db->onDuplicate(['closed_status']);
        $ret = $ret && $db->insert($table_prefix . '_target_month_year', ['target_year' => $target_year, 'target_month' => $target_month, 'closed_status' => 0]);
        if ($ret) {
            echo json_encode(['targetYear' => $target_year, 'targetMonth' => $target_month, 'isSubmissionClosedByPowerUser' => false]);
        }
    }

    public function closeSubmission($target_month = "", $target_year = "", $table_prefix = 'nmr')
    {
        $db = Database::getDbh();
        $target_month = $target_month ?: date('F');
        $target_year = $target_year ?: date('Y');
        /* if (currentSubmissionYear() === $target_year && (currentSubmissionMonth()) === $target_month) {
             $ret = Database::getDbh()->where('prop', $table_prefix . '_submission_opened')->update('settings', ['value' => 0]);
             $ret = $ret && Database::getDbh()->where('prop', $table_prefix . '_submission_closed_by_power_user')->update('settings', ['value' => 1]);
             $ret = $ret && Database::getDbh()->where('prop', $table_prefix . '_current_submission_month')->update('settings', ['value' => '']);
             $ret = $ret && Database::getDbh()->where('prop', $table_prefix . '_current_submission_year')->update('settings', ['value' => '']);
         }*/
        if ($db->where('target_month', $target_month)->where('target_year', $target_year)->update($table_prefix . '_target_month_year', ['closed_status' => 1])) {
            if (currentSubmissionYear() === $target_year && currentSubmissionMonth() === $target_month) {
                $db->where('prop', $table_prefix . '_submission_opened')->update('settings', ['value' => 0]);
                $db->where('prop', $table_prefix . '_submission_closed_by_power_user')->update('settings', ['value' => 1]);
               // $db->where('prop', $table_prefix . '_current_submission_month')->update('settings', ['value' => '']);
               // $db->where('prop', $table_prefix . '_current_submission_year')->update('settings', ['value' => '']);
            }
            echo json_encode(['isSubmissionClosedByPowerUser' => true, 'targetYear' => $target_year, 'targetMonth' => $target_month, 'success' => true]);
        }
    }

    public function submittedReports(string $target_month = "", $target_year = "", $department_id = "")
    {
        if (!isLoggedIn())
            redirect('users/login/pages/submitted-reports/');
        $payload['page_title'] = 'Submitted Reports';
        $payload['is_power_user'] = isPowerUser(getUserSession()->user_id);
        $table_prefixes = ['nmr', 'nmr_fr'];
        foreach ($table_prefixes as $table_prefix) {
            $payload['report_submissions'][$table_prefix] = array_reverse(groupedReportSubmissions(getReportSubmissions($target_month, $target_year, $department_id, $table_prefix))) ;
            $payload['target_month_years'][$table_prefix] = Database::getDbh()->getValue($table_prefix . '_final_report', 'concat_ws(" ", target_month, target_year)', null) ?: [];
        }
        $this->view('pages/submitted-reports', $payload);
    }


    public function finalReport(string $target_month, $target_year, $table_prefix = 'nmr')
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $db = Database::getDbh();
            $db->onDuplicate(['html_content', 'download_url']);
            // $json = file_get_contents('php://input');
            // $data = json_decode($json);
            $data_uri = $_POST['data_uri'];
            $base_to_php = explode(',', $data_uri);
            $base64_decoded = base64_decode($base_to_php[1]);
            $reports_directory = APP_ROOT . "/../public/reports/" . strtolower(flashOrFull($table_prefix));
            $file_name = strtoupper("$target_month" . "-" . $target_year . "-NZEMA-REPORT(" . strtoupper(flashOrFull($table_prefix)) . ").pdf");
            $download_url = URL_ROOT . "/public/reports/" . strtolower(flashOrFull($table_prefix)) . "/$file_name";
            //chdir(APP_ROOT . "");
            if (!is_dir($reports_directory)) {
                mkdir($reports_directory, 0777, true);
            }
            file_put_contents($reports_directory . '/' . $file_name, $base64_decoded);

            $html_content = $_POST['html_content'];

            if ($db->insert($table_prefix . '_final_report', ['download_url' => $download_url, 'html_content' => $html_content, 'target_month' => $target_month, 'target_year' => $target_year])) {
                echo json_encode(['success' => true, 'targetMonth' => $target_month, 'targetYear' => $target_year, "downloadUrl" => $download_url]);
            }
        } else {
            echo generateFinalReport($target_month, $target_year, $table_prefix);
            //echo json_encode(['content' => generateFinalReport($target_month, $target_year, $table_prefix)], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS);
        }
    }

    public function editReportPart($report_part_id)
    {
        $db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/edit-report-part/' . $report_part_id);
        }
        $payload['edit_report_part'] = true;
        $report_part = $db->where('report_part_id', $report_part_id)->getOne('nmr_report_parts');
        $payload['content'] = $report_part['content'];
        $payload['report_part_id'] = $report_part_id;
        $payload['report_part_description'] = $report_part['description'];
        $payload['page_title'] = 'Edit ' . $report_part['description'];
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $this->view('pages/report', $payload);
    }

    public function addReportPart()
    {
        $payload['page_title'] = 'New Report Part';
        $payload['add_report_part'] = true;
        $payload['spreadsheet_templates'] = json_encode(Database::getDbh()->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $this->view('pages/report', $payload);
    }

    /*
        public function finalReport(string $target_month, $target_year, $table_prefix = 'nmr')
        {
            $db = Database::getDbh();
            $db->onDuplicate(['html_content', 'download_url']);
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            $data_uri = $data->data_uri;
            $base_to_php = explode(',', $data_uri);
            $base64_decoded = base64_decode($base_to_php[1]);
            $reports_directory = APP_ROOT . "/../public/reports/" . strtolower(flashOrFull($table_prefix));
            $file_name = strtoupper("$target_month $target_year NZEMA REPORT.pdf");
            $download_url = URL_ROOT . "/public/reports/" . strtolower(flashOrFull($table_prefix)) . "/$file_name";
            //chdir(APP_ROOT . "");
            if (!is_dir($reports_directory)) {
                mkdir($reports_directory, 0777, true);
            }
            file_put_contents($reports_directory . '/' . $file_name, $base64_decoded);

            $html_content = $data->html_content;

            if ($db->insert($table_prefix . '_final_report', ['download_url' => $download_url, 'html_content' => $html_content, 'target_month' => $target_month, 'target_year' => $target_year])) {
                echo json_encode(['success' => true, 'targetMonth' => $target_month, 'targetYear' => $target_year, "downloadUrl" => $download_url]);
            }
        }*/

    public function editFinalReport(string $target_month, $target_year, $table_prefix = 'nmr')
    {
        if (!isLoggedIn()) redirect('users/login/pages/edit-final-report/'. $target_month . '/'. $target_year . '/' . $table_prefix);
        $db = Database::getDbh();
        $current_user = getUserSession();
        $payload['page_title'] = 'Edit Final Report ' . $table_prefix === 'nmr' ? '(Flash Report)' : 'Full Report';
        $payload['edit_final_report'] = true;
        $payload['table_prefix'] = $table_prefix;
        if (!(isPowerUser($current_user->user_id) || isITAdmin($current_user->user_id))) redirect('errors/index/404');
        if ($db->where('target_month', $target_month)->where('target_year', $target_year)->has($table_prefix . '_final_report')) {
            $final_report = $db->where('target_month', $target_month)->where('target_year', $target_year)->getOne($table_prefix . '_final_report');
            $payload['final_report_id'] = $final_report['final_report_id'];
            $payload['content'] = $final_report['html_content'];
            $payload['title'] = "$target_month $target_year " . flashOrFull($table_prefix) . " Report";
            $payload['target_year'] = $target_year;
            $payload['target_month'] = $target_month;
            $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
            $this->view('pages/report', $payload);
        } else {
            redirect('errors/index/404');
        }
    }

    public function isSubmissionClosed(string $target_month, $target_year)
    {
        echo json_encode(['submission_closed' => isSubmissionClosedByPowerUser($target_month, $target_year)]);
    }

    public function draftReports()
    {
        redirect('pages/draft-report');
    }

    public function draftReport($target_month='', $target_year='', $table_prefix='nmr')
    {
        $db = Database::getDbh();
        $current_user = getUserSession();
        if (!isLoggedIn()) {
            redirect('users/login/pages/draft-report/');
        }
        $table_prefixes = ['nmr', 'nmr_fr'];
        $payload['page_title'] = 'Draft Report (Start Monthly Report Here)';
        $current_sub_month = $target_month? : currentSubmissionMonth();
        $current_sub_year = $target_year? : currentSubmissionYear();
        $previous_month = explode(" ", getPreviousMonthYear($current_sub_month))[0];
        $previous_year = explode(" ", getPreviousMonthYear($current_sub_month))[1];
        foreach ($table_prefixes as $table_prefix) {
            // If user has a draft for the target month and year load it
            if (hasDraftForTargetMonthYear($current_sub_month, $current_sub_year, $current_user->user_id, $table_prefix)) {
                $payload['drafts'][$table_prefix] = getDraftForTargetMonthYear($current_sub_month, $current_sub_year, $current_user->user_id, $table_prefix);
            } else if (hasDraftForTargetMonthYear($previous_month, $previous_year, $current_user->user_id, $table_prefix)) {
                // if a draft exists for the previous month create a new one based on it
                $previous_draft = getDraftForTargetMonthYear($previous_month, $previous_year, $current_user->user_id, $table_prefix);
                if ($draft_id = $db->insert($table_prefix . '_editor_draft', [
                    'content' => $previous_draft['content'],
                    'spreadsheet_content' => $previous_draft['spreadsheet_content'],
                    'target_month' => $current_sub_month,
                    'target_year' => $current_sub_year,
                    'user_id' => $current_user->user_id,
                    'time_modified' => now(),
                    'target_month_no' => monthNumber(now())
                ])) {
                    $payload['drafts'][$table_prefix] = $db->where('draft_id', $draft_id)->getOne($table_prefix . '_editor_draft');
                    // Create an entry into my reports
                    $db->insert($table_prefix . '_my_reports', ['draft_id' => $draft_id]);
                }
            } else if ($db->where('department_id', $current_user->department_id)->has($table_prefix . '_preloaded_draft')) {
                // Create a new draft based on preloaded draft
                $preloaded_draft = $db->where('department_id', $current_user->department_id)->getOne($table_prefix . '_preloaded_draft');
                if ($draft_id = $db->insert($table_prefix . '_editor_draft', [
                    'content' => $preloaded_draft['editor_content'],
                    'spreadsheet_content' => $preloaded_draft['spreadsheet_content'],
                    'target_month' => $current_sub_month,
                    'target_year' => $current_sub_year,
                    'user_id' => $current_user->user_id,
                    'time_modified' => now(),
                    'target_month_no' => monthNumber(now())
                ])) {
                    $payload['drafts'][$table_prefix] = $db->where('draft_id', $draft_id)->getOne($table_prefix . '_editor_draft');
                    $db->insert($table_prefix . '_my_reports', ['draft_id' => $draft_id]);
                }
            } else {
                // Create a new draft
                if ($draft_id = $db->insert($table_prefix . '_editor_draft', [
                    'target_month' => $current_sub_month,
                    'target_year' => $current_sub_year,
                    'user_id' => $current_user->user_id,
                    'time_modified' => now(),
                    'target_month_no' => monthNumber(now())
                ])) {
                    $payload['drafts'][$table_prefix] = $db->where('draft_id', $draft_id)->getOne($table_prefix . '_editor_draft');
                    $db->insert($table_prefix . '_my_reports', ['draft_id' => $draft_id]);
                }
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
        $payload['preloaded_drafts'] = $db->where('deleted', 0)->get('nmr_preloaded_draft');
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

            $my_reports_fr = $db->where('d.user_id', $current_user->user_id)->join('nmr_fr_editor_draft d', 'd.draft_id=m.draft_id')
                ->join('nmr_target_month_year t', 't.target_month=d.target_month and t.target_year=d.target_year')
                ->orderBy('month_no_year', 'DESC')
                ->get('nmr_fr_my_reports m', null, 'd.draft_id, d.time_modified, d.target_year, d.target_month, concat(d.target_year, d.target_month_no) as month_no_year, t.closed_status');
            if (is_array($my_reports_fr)) {
                $my_reports_fr = groupedMyReports($my_reports_fr);
                $payload['my_reports_fr'] = $my_reports_fr;
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

    public function getSubmittedReport($report_id, $table_prefix = 'nmr')
    {
        $report = Database::getDbh()->where('report_submissions_id', $report_id)->getOne($table_prefix . '_report_submissions');
        echo json_encode($report, JSON_UNESCAPED_SLASHES);
    }

    public function submitReport($table_prefix = 'nmr')
    {
        $db = Database::getDbh();
        $current_user = getUserSession();
        $db->onDuplicate(['content']);
        $draft_id = '';
        if (isset($_POST['draft_id'])) $draft_id = $_POST['draft_id'];
        $success = $db->insert($table_prefix . '_report_submissions', [
            'department_id' => $current_user->department_id,
            'user_id' => $current_user->user_id,
            'content' => $_POST['content'],
            //'spreadsheet_content' => $_POST['spreadsheet_content'],
            'date_submitted' => now(),
            //'date_modified' => now(),
            'target_month' => $db->func('MonthName(?)', [now()]),
            'target_year' => $db->func('Year(?)', [now()])
        ]);
        if ($success) {
            if ($db->where('draft_id', $draft_id)->has($table_prefix . '_editor_draft')) {
                $success = $db->where('draft_id', $draft_id)->update($table_prefix . '_editor_draft', [
                    //'title' => $_POST['title'],
                    'content' => $_POST['content'],
                    //'spreadsheet_content' => $_POST['spreadsheet_content'],
                    //'time_modified' => now()
                ]);
                if ($success) echo json_encode(['success' => true, 'draftId' => $draft_id]);
            } else {
                $success = $db->insert($table_prefix . '_editor_draft', [
                    //'title' => $_POST['title'],
                    'user_id' => $current_user->user_id,
                    'content' => $_POST['content'],
                    //'spreadsheet_content' => $_POST['spreadsheet_content'],
                    //'time_modified' => now()
                ]);
                if ($success) echo json_encode(['success' => true, 'draftId' => $success]);
            }
        }
    }


    public function downloadReport(string $target_month, $target_year, $table_prefix = 'nmr')
    {
        $db = Database::getDbh();
        $data_uri = $db->where('target_month', $target_month)->where('target_year', $target_year)
            ->getValue($table_prefix . '_final_report', 'data_uri');
        $data_uri = str_replace('data:application/pdf;base64,', '', $data_uri);
        $data = base64_decode($data_uri);
        //file_put_contents('file.pdf', $data);
        header('Content-Type: application/pdf');
        echo $data;
    }

    public function fetchFinalReport($target_month, $target_year, $table_prefix = 'nmr')
    {
        echo fetchFinalReportAsHtml($target_month, $target_year, $table_prefix);
    }

    public function previewContent()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            echo $_POST['content'];
        }
    }

    public function previewFinalReport($target_month, $target_year, $table_prefix = 'nmr')
    {
        echo fetchFinalReportAsHtml($target_month, $target_year, $table_prefix) ?: generateFinalReport($target_month, $target_year, $table_prefix);
    }

    public function getFinalReport($final_report_id, $table_prefix = 'nmr')
    {
        echo Database::getDbh()->where('final_report_id', $final_report_id)->getValue($table_prefix . '_final_report', 'html_content');
    }

    public function phpinfo(): void
    {
        echo phpinfo();
    }

    public function fetchDraft($draft_id, $table_prefix = 'nmr')
    {
        echo Database::getDbh()->where('draft_id', $draft_id)->getValue($table_prefix . '_editor_draft', 'content');
    }

    public function fetchPreloadedDraft($draft_id, $table_prefix = 'nmr')
    {
        echo Database::getDbh()->where('draft_id', $draft_id)->getValue($table_prefix . '_preloaded_draft', 'editor_content');
    }
}
