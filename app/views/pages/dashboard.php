<?php include_once(APP_ROOT . '/views/includes/styles.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/navbar.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/sidebar.php'); ?>
<!-- .content-wrapper -->
<div class="content-wrapper animated fadeInRight" style="margin-top: <?php //echo NAVBAR_MT; ?>">
    <!-- content -->
    <section class="content blockable d-none">
        <div class="box-group pt-1" id="box_group">
            <div class="box collapsed">
                <div class="box-header">
                    <h5 class="box-title text-bold"><span class="fa fa-dashboard text-primary"></span> Dashboard</h5>
                    <div class="box-tools pull-right d-none">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <?php if (is_array($current_draft) && count($current_draft) > 0): ?>
                        <div class="col-6 col-md-6">
                            <h5 class="mb-2 text-nowrap">
                                <i class="fa fa-plus-square-o text-success"></i> Edit Draft
                            </h5>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer"
                                 data-url="<?php echo URL_ROOT .'/pages/edit-report/' . $current_draft['draft_id'] ?>">
                                <div class="inner">
                                    <h3 class="w3-hide-small ">Edit Draft</h3>
                                    <h5 class="w3-hide-large w3-hide-medium text-bold">Edit Draft</h5>
                                    <p>Edit current draft.</p>
                                </div>
                                <div class="icon text-success">
                                    <i class="fa fa-edit"></i>
                                </div>
                                <a href="#" class="small-box-footer bg-success">
                                    <span class="fa fa-chevron-circle-right"></span>
                                </a>
                            </div>
                        </div>
                        <?php else:  ?>
                        <div class="col-6 col-md-6">
                            <h5 class="mb-2 text-nowrap">
                                <i class="fa fa-plus-square-o text-success"></i> New Report
                            </h5>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer"
                                 data-url="<?php echo URL_ROOT ?>/pages/new-report">
                                <div class="inner">
                                    <h3 class="w3-hide-small ">New Report</h3>
                                    <h5 class="w3-hide-large w3-hide-medium text-bold">New Report</h5>
                                    <p>Create a new report.</p>
                                </div>
                                <div class="icon text-success">
                                    <i class="fa fa-plus-square-o"></i>
                                </div>
                                <a href="#" class="small-box-footer bg-success">
                                    <span class="fa fa-chevron-circle-right"></span>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-6 col-md-6">
                            <h5 class="mb-2 text-nowrap">
                                <i class="fa fa-eye text-aqua"></i> View Report
                            </h5>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer"
                                 data-url="<?php echo URL_ROOT ?>/pages/view-submissions/">
                                <div class="inner">
                                    <h3 class="w3-hide-small ">View Report</h3>
                                    <h5 class="w3-hide-large w3-hide-medium text-bold">View Report</h5>
                                    <p>View reports.</p>
                                </div>
                                <div class="icon text-aqua">
                                    <i class="fa fa-eye"></i>
                                </div>
                                <a href="#" class="small-box-footer bg-aqua">
                                    <span class="fa fa-chevron-circle-right"></span>
                                </a>
                            </div>
                        </div>
                    </div>
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
        $('.small-box').on('click', (e) => window.location.href = $(e.currentTarget).attr('data-url'))
    });

</script>
</body>
</html>