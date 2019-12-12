<?php
class Pages extends Controller
{
    public function index(): void
    {
        if (!isLoggedIn()) {
            redirect('fms/users/login/nmr/');
        }
        redirect('nmr/pages/dashboard');
    }

    public function dashboard(): void {
        $payload['page_title'] = 'Dashboard';
        $this->view('pages/dashboard', $payload);
    }

    public function phpinfo(): void
    {
        echo phpinfo();
    }
}
