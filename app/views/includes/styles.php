<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?php /** @var string $page_title */
        echo $page_title; ?>
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo URL_ROOT; ?>/public/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/css/animate.css/animate.min.css"/>
    <link href="<?php echo URL_ROOT; ?>/public/assets/fonts/my-fonts/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/fonts/font-awesome-pro/css/all.min.css"/>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/fonts/font-awesome-pro/css/v4-shims.min.css"/>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/css/w3/w3.css"/>
<!--    <link rel="stylesheet" href="<?php /*echo URL_ROOT; */?>/public/assets/css/subjx/subjx.min.css"/>
-->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/css/bootstrap/bootstrap.css"/>
    <!--<link rel="stylesheet" href="<?php /*echo URL_ROOT;  */?>/public/assets/css/adminlte/adminlte.css"/>-->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/css/adminlte/adminlte-alpha.css"/>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/css/adminlte/box-widget.css"/>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/css/adminlte/adminlte-miscellaneous.css"/>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/fonts/font-face/css/fonts.css"/>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/css/kendo-ui/kendo.bootstrap-v4.min.css"/>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/bootnavbar/css/bootnavbar.css"/>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/assets/css/shards/shards.min.css"/>

    <!--    <link rel="stylesheet" href="<?php /*echo URL_ROOT; */?>/public/assets/css/toc/tocbot.css"/>
-->
<!--    <link rel="stylesheet" href="<?php /*echo URL_ROOT; */?>/public/assets/ckeditor/contents.css"/>
-->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/custom-assets/css/custom.css"/>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/custom-assets/css/debug.css"/>
<!--    <script>
        var events = {};
        var original = window.addEventListener;

        window.addEventListener = function(type, listener, useCapture) {
            events[type] = true;
            return original(type, listener, useCapture);
        };

        function hasEventBeenAdded(type) {
            return type in events;
        }
    </script>-->
    <!-- <link rel="stylesheet" href="<?php /*echo URL_ROOT; */ ?>/public/assets/css/kendo-ui/kendo.common.min.css"/>
    <link rel="stylesheet" href="<?php /*echo URL_ROOT; */ ?>/public/assets/css/kendo-ui/kendo.rtl.min.css"/>
    <link rel="stylesheet" href="<?php /*echo URL_ROOT; */ ?>/public/assets/css/kendo-ui/kendo.default.min.css"/>
    <link rel="stylesheet" href="<?php /*echo URL_ROOT; */ ?>/public/assets/css/kendo-ui/kendo.mobile.all.min.css"/>-->
    <link rel="stylesheet" href="<?php echo URL_ROOT;  ?>/public/assets/css/overlay-scrollbar/OverlayScrollbars.min.css"/>
    <script type="text/javascript" src="<?php echo URL_ROOT; ?>/public/assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo URL_ROOT; ?>/public/assets/js/block-ui/block-ui.js"></script>
    <script>
        $.blockUI({
            message: '<i class="fa fa-spinner w3-spin" style="font-size:32px"></i>',
            css: {
                padding: 0,
                margin: 0,
                width: '0%',
                top: '40%',
                left: '50%',
                textAlign: 'center',
                color: '#000',
                border: '0',
                backgroundColor: 'rgba(0,0,0,0.5)',
                cursor: 'default'
            },
            overlayCSS: {
                backgroundColor: '#000',
                opacity: 0.0,
                cursor: 'default'
            },
            onUnblock: function () {
                $(".blockable").removeClass(".d-none");
            }
        });
        $('.blockable').block({
            message: null,
            overlayCSS: {
                backgroundColor: '#000',
                opacity: 0.0,
                cursor: 'default'
            },
        });
    </script>
    <script type="text/javascript" src="<?php echo URL_ROOT; ?>/public/assets/js/overlay-scrollbar/jquery.overlayScrollbars.min.js"></script>
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
