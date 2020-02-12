<?php include_once(APP_ROOT . '/views/includes/styles.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/navbar.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/sidebar.php'); ?>
<!-- .content-wrapper -->
<style>
    .cke_reset_all {
        z-index: 9999999 !important;
    }

    .cke_maximized {
        z-index: 99999995 !important;
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
    let editor;
    $(function () {
        CKEDITOR.editor.prototype.value = function () {
            this.getData();
        };
        CKEDITOR.editor.prototype.body = function () {
            this.document.$.body;
        };
        CKEDITOR.editor.prototype.update = function () {
            this.updateElement();
        };
        CKEDITOR.editor.prototype.exec = function (command, content) {
            if (command  === 'insertHtml')
                editor.insertHtml(content);
        };
        CKEDITOR.editor.prototype.paste = function (content) {
            editor.insertHtml(content);
        }

        CKEDITOR.replace('content', {
            title: "Nzema Monthly Report",
            filebrowserBrowseUrl: URL_ROOT + '/ckfinder/browse/?type=Files',
            filebrowserImageBrowseUrl : URL_ROOT + '/ckfinder/browse?type=Images',
            filebrowserUploadUrl: URL_ROOT + '/ckfinder/?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl : URL_ROOT + '/ckfinder/?command=QuickUpload&type=Images'
        });
        CKEDITOR.config.extraPlugins = 'image2, toc, tabletoolstoolbar, tableresize, tableresizerowandcolumn, autogrow, preview';
        //CKEDITOR.config.removePlugins = 'save, forms, preview, sourcearea, language, styles, iframe, specialchar, flash, about, bidi, newpage, stylescombo,div';
       editor = CKEDITOR.instances.content;

        editor.addCommand('save', {
            exec: (editor) => {

            }
        });

        editor.ui.addButton('Save', {
            label: 'Save',
            command: 'save',
            icon: this.path + "images/save.png"
        })
    });

</script>
</body>
</html>