<?php
function redirect(string $page = ''): void
{
    if (strpos($page, '?') === false) {
        header('location: ' . URL_ROOT . '/' . $page . '?' . fetchGetParams());
    }
    else {
        header('location: ' . URL_ROOT . '/' . $page);
    }
    exit;
}