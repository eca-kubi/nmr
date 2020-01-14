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
                        <div class="col-md-6">
                            <h5 class="mb-2 text-nowrap">
                                <span><svg class="fontastic-draft" style="fill: var(--danger)"><use
                                                xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span> Draft Reports
                            </h5>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer"
                                 data-url="<?php echo URL_ROOT .'/pages/draft-reports/' ?>">
                                <div class="inner">
                                    <h3 class="w3-hide-small ">Draft Reports</h3>
                                    <h5 class="w3-hide-large w3-hide-medium text-bold">Draft Reports</h5>
                                    <p>View and create draft reports</p>
                                </div>
                                <div class="icon text-success">
                                    <span><svg class="fontastic-draft" style="fill: var(--danger); width: 78px; height: 90px"><use
                                                    xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span>
                                </div>
                                <a href="#" class="small-box-footer" style="background-color: var(--danger)">
                                    <span class="fa fa-chevron-circle-right"></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-2 text-nowrap">
                                <i class="fa fa-check-double" style="color: goldenrod"></i> Submitted Reports
                            </h5>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer"
                                 data-url="<?php echo URL_ROOT ?>/pages/view-submissions/">
                                <div class="inner">
                                    <h3 class="w3-hide-small ">Submitted Reports</h3>
                                    <h5 class="w3-hide-large w3-hide-medium text-bold">Submitted Reports</h5>
                                    <p>View and edit submitted reports.</p>
                                </div>
                                <div class="icon" style="color: goldenrod">
                                    <i class="fa fa-check-double"></i>
                                </div>
                                <a href="#" class="small-box-footer" style="background-color: goldenrod">
                                    <span class="fa fa-chevron-circle-right"></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-2 text-nowrap">
                                <i class="fa fa-stamp text-success"></i> Approved Reports
                            </h5>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer"
                                 data-url="<?php echo URL_ROOT ?>/pages/view-submissions/">
                                <div class="inner">
                                    <h3 class="w3-hide-small ">Approved Reports</h3>
                                    <h5 class="w3-hide-large w3-hide-medium text-bold"> Approved Reports</h5>
                                    <p>View and download reports approved by Power User.</p>
                                </div>
                                <div class="icon text-success">
                                    <i class="fa fa-stamp"></i>
                                </div>
                                <a href="#" class="small-box-footer bg-success">
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