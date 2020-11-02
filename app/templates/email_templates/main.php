<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 2/25/2019
 * Time: 9:32 AM
 */
$current_user = getUserSession();
/** @var string $link */
$fof = strtoupper($flash_or_full);
echo <<<html
<html lang="en">
<head>
    <title>NZEMA MONTHLY $fof REPORTS - ($target_month_year)</title>
</head>
<body style="margin: 0; padding: 0;">
<table align="center" cellpadding="10" cellspacing="0" width="600" style="border-collapse: collapse;">
    <tr bgcolor="#70bbd9" style="padding: 30px 30px 30px 30px;">
        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold; border-bottom: #f8f8f8 2px solid;">
            <b>NZEMA MONTHLY $fof REPORTS ($target_month_year)</b>
        </td>
    </tr>
    <tr bgcolor="#70bbd9" style="padding: 30px 30px 30px 30px;">
        <td>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="color: #153643;font-family: Arial, sans-serif; font-size: 14px;">
                        $body
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
        <td>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold"> 
                        (c) 2020- Developed by Adamus IT<br/>
                        Email: ithelpdesk@adamusgh.com <br/>
                        Ext: 1000/1011
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
html;
