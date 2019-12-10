<?php
session_start();

function isLoggedIn()
{
    if (isset($_SESSION['logged_in_user'])) {
        return true;
    }
    return false;
}

function getUserSession()
{
    return $_SESSION['logged_in_user'] ?? [];
}

function createUserSession($u)
{
    $_SESSION['logged_in_user'] = $u;
}

function logout()
{
    unset($_SESSION['logged_in_user']);
    session_destroy();
    redirectToStart();
}



