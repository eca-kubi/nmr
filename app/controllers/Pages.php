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

    public function dashboard(): void {
        $payload['page_title'] = 'Dashboard';
        if (!isLoggedIn()) {
            redirect('users/login/pages/dashboard');
        }
        $this->view('pages/dashboard', $payload);
    }

    public function phpinfo(): void
    {
        echo phpinfo();
    }
}
