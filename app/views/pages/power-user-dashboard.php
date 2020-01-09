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
                    <h5 class="box-title text-bold"><span class="fa fa-dashboard text-warning"></span> Power User Dashboard</h5>
                    <div class="box-tools pull-right d-none">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-4 col-md-4">
                            <h6 class="mb-2 text-nowrap">
                                <i class="fa fa-door-open text-success"></i> Open Submission
                            </h6>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer" onclick="openSubmission" id="openSubmission">
                                <div class="inner">
                                    <h4 class="w3-hide-small ">Open Submission</h4>
                                    <h6 class="w3-hide-large w3-hide-medium text-bold">Open Submission</h6>
                                    <p>Open report submission.</p>
                                </div>
                                <div class="icon text-success">
                                    <i class="fa fa-door-open"></i>
                                </div>
                                <a href="#" class="small-box-footer bg-success">
                                    <span class="fa fa-chevron-circle-right"></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <h6 class="mb-2 text-nowrap">
                                <i class="fa fa-door-closed text-danger"></i> Close Submission
                            </h6>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer">
                                <div class="inner">
                                    <h4 class="w3-hide-small ">Close Submission</h4>
                                    <h6 class="w3-hide-large w3-hide-medium text-bold">Close Submission</h6>
                                    <p>Close report submission.</p>
                                </div>
                                <div class="icon text-danger">
                                    <i class="fa fa-door-closed"></i>
                                </div>
                                <a href="#" class="small-box-footer bg-danger">
                                    <span class="fa fa-chevron-circle-right"></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <h6 class="mb-2 text-nowrap">
                                <i class="fa fa-eye text-primary"></i> View Submissions
                            </h6>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer"
                                 data-url="<?php echo URL_ROOT ?>/pages/reports/">
                                <div class="inner">
                                    <h4 class="w3-hide-small ">View Submissions</h4>
                                    <h6 class="w3-hide-large w3-hide-medium text-bold">View Submissions</h6>
                                    <p>View submitted reports.</p>
                                </div>
                                <div class="icon text-primary">
                                    <i class="fa fa-eye"></i>
                                </div>
                                <a href="#" class="small-box-footer bg-primary">
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
        $('.small-box[data-url]').on('click', (e) => window.location.href = $(e.currentTarget).attr('data-url'));
        $("#openSubmission").on('click', () => {
            $("<div/>").appendTo("body").kendoDialog({
                title: 'Open Submissions'
            });
        });
    });

</script>
</body>
</html>