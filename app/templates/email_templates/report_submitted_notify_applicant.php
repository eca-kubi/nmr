<?php
$current_user = getUserSession();
$body = "<h3>Congratulations!</h3><br>You have successfully submitted your " . $target_month . ' ' . $target_year . ' ' . $flash_or_full . " report.";
echo $body;