<?php
function redirect(string $page = ''): void
{
    header('location: ' . HOST . '/' . $page);
    exit;
}