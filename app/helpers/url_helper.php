<?php
function redirect(string $page = ''): void
{
    header('location: ' . URL_ROOT . '/' . $page);
    exit;
}