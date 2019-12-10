<?php

/*
 * Base Controller
 * Loads the models and views
 */

class Controller
{
    public function __construct(){}

    // Load model
    public function model($model)
    {
        // Require model file
        require_once '../app/models/' . ucwords($model) . '.php';

        // Instantiate model
        return new $model();
    }

    // Load view
    public function view(string $view, array $payload): void
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
}