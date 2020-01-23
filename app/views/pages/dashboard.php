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
                                                xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span>
                                Draft Report
                            </h5>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer"
                                 data-url="<?php echo URL_ROOT . '/pages/draft-reports/' ?>">
                                <div class="inner">
                                    <h3 class="w3-hide-small ">Draft Report</h3>
                                    <h5 class="w3-hide-large w3-hide-medium text-bold">Draft Report</h5>
                                    <p>View and edit draft report</p>
                                </div>
                                <div class="icon text-success">
                                    <span><svg class="fontastic-draft"
                                               style="fill: var(--danger); width: 78px; height: 90px"><use
                                                    xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span>
                                </div>
                                <a href="#" class="small-box-footer" style="background-color: var(--danger)">
                                    <span class="fa fa-chevron-circle-right"></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-2 text-nowrap">
                                <i class="fa fa-file-user text-success"></i> My Reports
                            </h5>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer"
                                 data-url="<?php echo URL_ROOT ?>/pages/my-reports/">
                                <div class="inner">
                                    <h3 class="w3-hide-small ">My Reports</h3>
                                    <h5 class="w3-hide-large w3-hide-medium text-bold"> My Reports</h5>
                                    <p>View and submit your reports.</p>
                                </div>
                                <div class="icon text-success">
                                    <i class="fa fa-file-user"></i>
                                </div>
                                <a href="#" class="small-box-footer bg-success">
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
                                 data-url="<?php echo URL_ROOT ?>/pages/submitted-reports/">
                                <div class="inner">
                                    <h3 class="w3-hide-small ">Submitted Reports</h3>
                                    <h5 class="w3-hide-large w3-hide-medium text-bold">Submitted Reports</h5>
                                    <p>View submitted reports.</p>
                                </div>
                                <div class="icon" style="color: goldenrod">
                                    <i class="fa fa-check-double"></i>
                                </div>
                                <a href="#" class="small-box-footer" style="background-color: goldenrod">
                                    <span class="fa fa-chevron-circle-right"></span>
                                </a>
                            </div>
                        </div>
                        <?php if (isPowerUser($current_user->user_id)): ?>
                            <div class="col-md-6">
                                <h5 class="mb-2 text-nowrap">
                                    <i class="fa fa-door-open text-aqua"></i> Open Submission
                                </h5>
                                <!-- small box -->
                                <div class="small-box show border" style="cursor:pointer"
                                     id="openSubmission">
                                    <div class="inner">
                                        <h3 class="w3-hide-small ">Open Submission</h3>
                                        <h5 class="w3-hide-large w3-hide-medium text-bold">Open Submission</h5>
                                        <p>Open report submission.</p>
                                    </div>
                                    <div class="icon text-aqua">
                                        <i class="fa fa-door-open"></i>
                                    </div>
                                    <a href="#" class="small-box-footer bg-aqua">
                                        <span class="fa fa-chevron-circle-right"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 <?php echo isSubmissionOpened() ? '' : 'd-none' ?>">
                                <h5 class="mb-2 text-nowrap">
                                    <i class="fa fa-door-closed text-orange"></i> Close Submission
                                </h5>
                                <!-- small box -->
                                <div class="small-box show border" id="closeSubmission" style="cursor:pointer">
                                    <div class="inner">
                                        <h3 class="w3-hide-small ">Close Submission</h3>
                                        <h5 class="w3-hide-large w3-hide-medium text-bold">Close Submission</h5>
                                        <p>Close report submission.</p>
                                    </div>
                                    <div class="icon text-orange">
                                        <i class="fa fa-door-closed"></i>
                                    </div>
                                    <a href="#" class="small-box-footer bg-orange">
                                        <span class="fa fa-chevron-circle-right"></span>
                                    </a>
                                </div>
                            </div>
                        <?php endif ?>
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
            if (isSubmissionOpened) {
                kendoAlert("Submission Already Opened!", `Report submission is already opened for ${currentSubmissionMonth + " " + currentSubmissionYear}.`)
            } else if (isSubmissionClosedByPowerUser) {
                kendoAlert('Submission Currently Closed', 'Power user has closed submission of reports for ' + currentSubmissionMonth + ' ' + currentSubmissionYear +
                    '.<br/> Try again next month!');
            } else {
                let openSubmission = $("<div/>").appendTo("body").kendoDialog({
                    width: "450px",
                    title: 'Open Submission of Reports',
                    content: $("#openSubmissionContent").html(),
                    actions: [
                        {
                            text: 'Confirm',
                            primary: true,
                            action: function () {
                                $.get({
                                    url: URL_ROOT + '/pages/open-submission',
                                    dataType: "json"
                                }).done(function (data, successTextStatus, jQueryXHR) {
                                    openSubmission.close();
                                    isSubmissionOpened = true;
                                    currentSubmissionMonth = data.currentSubmissionMonth;
                                    currentSubmissionYear = data.currentSubmissionYear;
                                    $("#closeSubmission").parent().removeClass('d-none');
                                    kendoAlert("Submission Opened", "Report submission opened for " + data.currentSubmissionMonth + " " + data.currentSubmissionYear);
                                });
                            }
                        },
                        {
                            text: 'Cancel',
                            action: function () {
                                openSubmission.close();
                            }
                        }
                    ],
                    close(e) {
                        openSubmission.destroy();
                    },
                    initOpen(e) {
                        /*$("#targetMonth").kendoComboBox({
                            dataSource: new kendo.data.DataSource({data: monthNames})
                        });*/
                    }
                }).data('kendoDialog');
            }
        });

        $("#closeSubmission").on('click', function () {
            if (isSubmissionOpened) {
                let dfd = showWindow("Are you sure you want to close submission? <br/>Users will not be able to submit anymore reports for this month!", 'Close Submission!', undefined);
                $.when(dfd).then(function (confirmed) {
                    if (confirmed) {
                        $.get({
                            url: URL_ROOT + '/pages/close-submission',
                            dataType: "json"
                        }).done(function (data, successTextStatus, jQueryXHR) {
                            isSubmissionOpened = false;
                            isSubmissionClosedByPowerUser = data.isSubmissionClosedByPowerUser;
                            kendoAlert('Submission Closed', 'Submission of reports closed for this month!');
                            $("#closeSubmission").parent().addClass('d-none');
                        });
                    }
                })
            } else if (isSubmissionClosedByPowerUser) {
                kendoAlert('Submission Closed', 'Submission of reports is already closed for this month!');
            }
        });
    });

</script>
</body>
</html>