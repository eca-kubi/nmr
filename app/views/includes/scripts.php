<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery/jquery.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/block-ui/block-ui.js"></script>
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
<script src="<?php echo URL_ROOT; ?>/public/assets/js/bootstrap/bootstrap.bundle.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/adminlte/adminlte.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/kendo-ui/kendo.all.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/letter-avatar/letter-avatar.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/custom-assets/js/custom.js"></script>