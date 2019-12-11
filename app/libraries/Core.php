<?php

/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */

class Core
{
    protected string $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected array $params = [];

    public function __construct()
    {
        $url = $this->getUrl();
        // Look in controllers for first value
        if (isset($url['0'])) {
            $url['0'] = str_replace(['-', '_'], '', $url['0']);
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
                require_once '../app/controllers/' . $this->currentController . '.php';
                $this->currentController = new $this->currentController;
                if (isset($url[1])) {
                    $url[1] = str_replace(['-', '_'], '', $url[1]);
                    if (method_exists($this->currentController, $url[1])) {
                        $this->currentMethod = $url[1];
                        unset($url[1]);
                        $this->params = $url ? array_values($url) : [];
                        if ($this->currentMethod === 'login') {
                            $this->params = [implode('/', $this->params)];
                        }
                        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
                        return;
                    }

                    $this->currentController = 'Errors';
                    require_once '../app/controllers/' . $this->currentController . '.php';
                    $this->currentController = new $this->currentController;
                    call_user_func([$this->currentController, $this->currentMethod], 404);
                    return;
                }
                call_user_func_array([$this->currentController, $this->currentMethod], []);
                return;
            }

            $this->currentController = 'Errors';
            require_once '../app/controllers/' . $this->currentController . '.php';
            $this->currentController = new $this->currentController;
            call_user_func([$this->currentController, $this->currentMethod], 404);
            return;
        }

        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
