<?php
class Pages extends Controller
{
    public function index(): void
    {
        if (!isLoggedIn()) {
            redirect(HOST .'/fms/users/login');
        }
        redirect('pages/dashboard');
    }

    public function dashboard(): void {

    }

    public function phpinfo(): void
    {
        echo phpinfo();
    }
}
