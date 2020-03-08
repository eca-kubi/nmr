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
                                <span><svg class="fontastic-draft" style="fill: var(--orange)"><use
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
                                               style="fill: var(--orange); width: 78px; height: 90px"><use
                                                    xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span>
                                </div>
                                <a href="#" class="small-box-footer" style="background-color: var(--orange)">
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
                                    <h5 class="w3-hide-large w3-hide-medium text-bold">View My Reports</h5>
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
                                (Departments)
                            </h5>
                            <!-- small box -->
                            <div class="small-box show border" style="cursor:pointer"
                                 data-url="<?php echo URL_ROOT ?>/pages/submitted-reports/">
                                <div class="inner">
                                    <h3 class="w3-hide-small text-wrap">Submitted Reports (Departments)</h3>
                                    <h5 class="w3-hide-large w3-hide-medium text-bold">Submitted Reports
                                        (Departments)</h5>
                                    <!--<p>View reports submitted by departments</p>-->
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
                                <div class="small-box show border dropdown exclude-hover" style="cursor:pointer"
                                     id="openSubmission">
                                    <div class="inner" data-toggle="dropdown">
                                        <h3 class="w3-hide-small ">Open Submission</h3>
                                        <h5 class="w3-hide-large w3-hide-medium text-bold">Open Submission</h5>
                                        <p>Open report submission.</p>
                                    </div>
                                    <div class="icon text-aqua" data-toggle="dropdown">
                                        <i class="fa fa-door-open"></i>
                                    </div>
                                    <a href="#" class="small-box-footer bg-aqua" data-toggle="dropdown">
                                        <span class="fa fa-chevron-circle-right"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item" type="button" data-id="openSubmission"
                                                data-table-prefix="nmr">Flash</button>
                                        <button class="dropdown-item" type="button" data-id="openSubmission"
                                                data-table-prefix="nmr_fr">Full</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-2 text-nowrap">
                                    <i class="fa fa-door-closed text-danger"></i> Close Submission
                                </h5>
                                <!-- small box -->
                                <div class="small-box show border dropdown exclude-hover"  id="closeSubmission"  style="cursor:pointer">
                                    <div class="inner" data-toggle="dropdown">
                                        <h3 class="w3-hide-small ">Close Submission</h3>
                                        <h5 class="w3-hide-large w3-hide-medium text-bold">Close Submission</h5>
                                        <p>Close report submission.</p>
                                    </div>
                                    <div class="icon text-danger" data-toggle="dropdown">
                                        <i class="fa fa-door-closed"></i>
                                    </div>
                                    <a href="#" class="small-box-footer bg-danger" data-toggle="dropdown">
                                        <span class="fa fa-chevron-circle-right"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-id="closeSubmission"
                                           data-table-prefix="nmr">Flash</a>
                                        <a class="dropdown-item" href="#" data-id="closeSubmission"
                                           data-table-prefix="nmr_fr">Full</a>
                                    </div>
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

    //let tablePrefix = "<?php echo $table_prefix ?? 'nmr'; ?>";
    $(function () {
        $('.small-box[data-url]').on('click', (e) => window.location.href = $(e.currentTarget).attr('data-url'));
        $("#openSubmission .dropdown-item, #closeSubmission .dropdown-item").on('click', (e) => {
            let targetMonth = '';
            let targetYear = '';
            let currentTarget = $(e.currentTarget);
            let id = currentTarget.attr('data-id');
            let title = id === 'openSubmission' ? 'Open Submission' : 'Close Submission';
            let tablePrefix = currentTarget.attr('data-table-prefix');

            showWindow('Select a month and year.', title, '#openCloseSubmissionContent', () => {

                targetMonth = $("#targetMonthCB").kendoComboBox({
                    dataSource: new kendo.data.DataSource({data: monthNames}),
                    change(e) {
                        targetMonth = this.value();
                    }
                }).data('kendoComboBox').value();

                targetYear = $("#targetYearCB").kendoComboBox({
                    dataSource: new kendo.data.DataSource({data: getYearsBetween("December 2019", "December 2030")}),
                    change(e) {
                        targetYear = this.value();
                    }
                }).data('kendoComboBox').value();

            }).done(() => {
                $.get({
                    url: URL_ROOT + `/pages/${id === 'openSubmission' ? 'open' : 'close'}-submission` + '/' + targetMonth + '/' + targetYear + '/' + tablePrefix,
                    dataType: "json"
                }).done(function (data) {
                    //$("#closeSubmission").parent().removeClass('d-none');
                    let alert = kendoAlert("Submission " + `${id === 'openSubmission' ? 'Opened!' : 'Closed!'}`, "Report submission " + `${id === 'openSubmission' ? 'opened' : 'closed'}` + " for " + data.targetMonth + " " + data.targetYear);
                    setTimeout(() => alert.close(), 1500);
                    if (currentSubmissionYear === targetYear && currentSubmissionMonth === targetMonth)
                        if (id === 'openSubmission')
                            $("#submissionNotice p").removeClass('text-danger').addClass('text-success').html("<i class=\"fa fa-info-circle\"></i> Report Submission Opened for the Current Month");
                        else
                            $("#submissionNotice p").removeClass('text-success').addClass('text-danger').html("<i class=\"fa fa-info-circle\"></i> Report Submission Closed for the Current Month");
                });
            });
            /*  if (isSubmissionOpened) {
                  kendoAlert("Submission Already Opened!", `Report submission is already opened for ${currentSubmissionMonth + " " + currentSubmissionYear}.`)
              }
              else {
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
                                      let alert = kendoAlert("Submission Opened", "Report submission opened for " + data.currentSubmissionMonth + " " + data.currentSubmissionYear);
                                      setTimeout(() => alert.close(), 3000);
                                      $("#submissionNotice p").removeClass('text-danger').addClass('text-success').html("<i class=\"fa fa-info-circle\"></i> Report Submission Opened");
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
                          /!*$("#targetMonth").kendoComboBox({
                              dataSource: new kendo.data.DataSource({data: monthNames})
                          });*!/
                      }
                  }).data('kendoDialog');
              }*/
        });
        /*$("#closeSubmission").on('click', function () {
            let dfd = showWindow("", 'Close Submission!', '#close');

            showWindow('Select a month and year.', 'Close Submission', '#openCloseSubmissionContent', () => {
                $("#targetMonthCB").kendoComboBox({
                    dataSource: new kendo.data.DataSource({data: monthNames})
                });

                $("#targetYearCB").kendoComboBox({
                    dataSource: new kendo.data.DataSource({data: getYearsBetween("December 2019", "December 2030")})
                });
            }).done(() => {
                let targetMonth = $("#targetMonthCB").val();
                let targetYear = $("#targetYearCB").val();
                $.get({
                    url: URL_ROOT + '/pages/close-submission' + '/' + targetMonth + '/' + targetYear + '/' + tablePrefix,
                    dataType: "json"
                }).done(function (data) {
                    //$("#closeSubmission").parent().removeClass('d-none');
                    let alert = kendoAlert("Submission Opened", "Report submission opened for " + data.currentSubmissionMonth + " " + data.currentSubmissionYear);
                    setTimeout(() => alert.close(), 3000);
                    if (currentSubmissionYear === targetYear && currentSubmissionMonth === targetMonth)
                        $("#submissionNotice p").removeClass('text-danger').addClass('text-success').html("<i class=\"fa fa-info-circle\"></i> Report Submission Opened for the Current Month");
                });
            });
            $.when(dfd).then(function (confirmed) {
                if (confirmed) {
                    $.get({
                        url: URL_ROOT + '/pages/close-submission',
                        dataType: "json"
                    }).done(function (data, successTextStatus, jQueryXHR) {
                        isSubmissionOpened = false;
                        isSubmissionClosedByPowerUser = data.isSubmissionClosedByPowerUser;
                        let alert = kendoAlert('Submission Closed', 'Submission of reports closed for this month!');
                        setTimeout(() => alert.close(), 3000);
                        $("#closeSubmission").parent().addClass('d-none');
                        $("#submissionNotice p").removeClass('text-success').addClass('text-danger').html("<i class=\"fa fa-info-circle\"></i> Report Submission Closed");
                    });
                }
            })
            /!* if (isSubmissionOpened) {
                 let dfd = showWindow("Are you sure you want to close submission? <br/>Users will not be able to submit anymore reports for this month!", 'Close Submission!', undefined);
                 $.when(dfd).then(function (confirmed) {
                     if (confirmed) {
                         $.get({
                             url: URL_ROOT + '/pages/close-submission',
                             dataType: "json"
                         }).done(function (data, successTextStatus, jQueryXHR) {
                             isSubmissionOpened = false;
                             isSubmissionClosedByPowerUser = data.isSubmissionClosedByPowerUser;
                            let alert =  kendoAlert('Submission Closed', 'Submission of reports closed for this month!');
                            setTimeout(() => alert.close(), 3000);
                             $("#closeSubmission").parent().addClass('d-none');
                             $("#submissionNotice p").removeClass('text-success').addClass('text-danger').html("<i class=\"fa fa-info-circle\"></i> Report Submission Closed");
                         });
                     }
                 })
             } else if (isSubmissionClosedByPowerUser) {
                let alert =  kendoAlert('Submission Closed', 'Submission of reports is already closed for this month!');
                 setTimeout(() => alert.close(), 3000);
             }*!/
        });*/
    });

</script>
</body>
</html>