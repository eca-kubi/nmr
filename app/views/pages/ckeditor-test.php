<?php include_once(APP_ROOT . '/views/includes/styles.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/navbar.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/sidebar.php'); ?>
<!-- .content-wrapper -->
<style>
    .cke_reset_all {
        z-index: 9999999 !important;
    }
</style>
<div class="content-wrapper animated fadeInRight" style="margin-top: <?php //echo NAVBAR_MT; ?>">
    <!-- content -->
    <section class="content blockable d-none">
        <div class="box-group pt-1" id="box_group">
            <div class="box collapsed">
                <div class="box-header">
                    <h5 class="box-title text-bold"><span
                                class="fa fa-wpforms text-warning"></span> <?php echo 'CKEditor Test' ?></h5>
                    <div class="box-tools pull-right d-none">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <textarea name="content" id="" cols="30" rows="10"><?php echo $content ?? ''; ?></textarea>
                </div>
                <!-- /.box-body -->
                <div class="box-footer d-none"></div>
                <!-- /.box-footer-->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once(APP_ROOT . '/views/includes/footer.php'); ?>
</div>
<!-- /.wrapper -->
<?php include_once(APP_ROOT . '/views/includes/scripts.php'); ?>
<?php include_once(APP_ROOT . '/templates/kendo-templates.html'); ?>
<script>
    $(function () {
        CKEDITOR.replace('content', {
            filebrowserBrowseUrl: URL_ROOT + '/ckfinder/browse',
            filebrowserUploadUrl: URL_ROOT + '/ckfinder/?command=QuickUpload&type=Files'
        });
        CKEDITOR.config.extraPlugins = 'image2, toc, tabletoolstoolbar, tableresize, tableresizerowandcolumn';
    });

</script>
</body>
</html>