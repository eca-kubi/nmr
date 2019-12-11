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

    }

    public function phpinfo(): void
    {
        echo phpinfo();
    }
}
