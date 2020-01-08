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

    public function dashboard() : void {
        if (!isLoggedIn()) {
            redirect('users/login/pages/dashboard');
        }
        $payload['page_title'] = 'Dashboard';
        $this->view('pages/dashboard', $payload);
    }

    public function reports(): void {
        $payload['page_title'] = 'Reports';
        $db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/reports');
        }
        $payload['reports'] = $db->get('nmr_flash_report');
        $this->view('pages/reports', $payload);
    }

    public function newReport() : void {
        if (!isLoggedIn()) {
            redirect('users/login/pages/new-report');
        }
        $payload['page_title'] = 'New Report';
        $db = Database::getDbh();
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $this->view('pages/new-report', $payload);
    }

    public function editReport(?string $report_id = null) : void {
        if (!$report_id) redirect('errors/index/404');
        if (!isLoggedIn()) {
            redirect('users/login/pages/edit-report/' . $report_id);
        }
        $payload['page_title'] = 'Edit Report';
        $db = Database::getDbh();
        $payload['spreadsheet_templates'] = json_encode($db->get(TABLE_NMR_SPREADSHEET_TEMPLATES));
        $this->view('pages/edit-report', $payload);
    }

    public function viewReport() : void {
        //if (!$report_id) redirect('errors/index/404');
        $db = Database::getDbh();
        if (!isLoggedIn()) {
            redirect('users/login/pages/view-report/');
        }
        $payload['page_title'] = 'View Report';
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['report_month_input']) && isset($_GET['report_year_input'])) {
            $payload['report'] = $db->where('month', $_GET['report_month_input'])->where('year', $_GET['report_year_input'])->getOne('nmr_flash_report');
            $this->view('pages/view-report', $payload);
        } else {
            redirect('pages/reports');
        }
    }


    public function phpinfo(): void
    {
        echo phpinfo();
    }

    public function editor() : void
    {

    }
}
