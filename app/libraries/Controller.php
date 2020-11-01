<?php

class Controller
{
    public function __construct(){}

    // Load model
    public function model($model)
    {
        // Require model file
        require_once sprintf("../app/models/%s.php", ucwords($model));

        // Instantiate model
        return new $model();
    }

    // Load view
    public function view(string $view, array $payload = []): void
    {
        // Check for view file
        extract($payload, EXTR_OVERWRITE);
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else if (file_exists('../app/views/' . $view . '.html')) {
            require_once "../app/views/$view.html";
        } else {
            redirect('errors/index/404');
        }
    }
    // Load view
    public function renderView(string $view, string $controller, array $payload = [])
    {
        // Check for view file
        $viewFilePath = '../app/views/' . $controller . '/' .$view;
        extract($payload, EXTR_OVERWRITE);
        if (file_exists("$viewFilePath.php" )) {
            require_once "$viewFilePath.php";
        } else if (file_exists("$viewFilePath.html")) {
            require_once "$viewFilePath.html";
        } else {
            redirect('errors/index/1000');
        }
    }
}
