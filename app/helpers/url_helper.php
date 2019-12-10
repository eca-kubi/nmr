<?php
function redirect($page)
{
    header('location: ' . URL_ROOT . '/' . $page);
    exit;
}

  // Redirect to start page
  function redirectToStart(){
      header('location: ' . HOST);
      exit;
  }