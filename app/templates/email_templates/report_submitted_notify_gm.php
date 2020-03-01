<?php
/** @var string $link */
$current_user = getUserSession();
$body = $department. ' has submitted their ' . $flash_or_full . ' Report for ' . $target_month . ' ' . $target_year . '.'
    ." <br/>Click the following link for more information. </br><b>Link: </b> <a href='$link'>$link</a> ";
echo $body;

