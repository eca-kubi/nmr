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
                    <h5 class="box-title text-bold"><span class="fa fa-wpforms text-warning"></span> Reports</h5>
                    <div class="box-tools pull-right d-none">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="card p-2 col-md-6 m-auto">
                        <span class="h3 card-header text-center">Select Report to View</span>
                        <div class="card-body">
                            <?php if (count($reports) > 0): ?>
                                <form id="viewReportForm" class="demo-section k-content"
                                      action="<?php echo URL_ROOT . '/pages/view-report/' ?>">
                                    <h4><label for="reportYear">Report Year</label></h4>
                                    <input id="reportYear" placeholder="Select Report Year" style="width: 100%;" name="report_year"/>
                                    <h4 style="margin-top: 2em;"><label for="reportMonth">Report Month</label></h4>
                                    <input id="reportMonth" placeholder="Select Report Month" style="width: 100%;" name="report_month"/>
<!--                                    <input type="hidden" id="reportID" name="report_id">
-->                                    <button class="k-button k-primary" style="margin-top: 2em; float: right;">
                                        Submit
                                    </button>
                                </form>
                            <?php else: ?>
                                <h5>No Report Available</h5>
                            <?php endif; ?>
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
    let reports = <?php echo json_encode($reports); ?>;
    let monthNames = kendo.cultures.current.calendars.standard.months.names;
    $(function () {
        let viewReportForm = $("#viewReportForm");
        if (viewReportForm.length > 0) {
            let reportMonth = $('#reportMonth').kendoComboBox({
                change(e) {
                    //$("#reportID").val(reports.filter(r => (r.year === parseInt(reportYear.value())) && monthNames[r.month] === reportMonth.value()).map(r => r.report_id)[0])
                }
            }).data('kendoComboBox');
            let reportYear = $('#reportYear').kendoComboBox({
                change(e) {
                    reportMonth.value(null);
                    let year = parseInt(this.value());
                    let distinctMonths = reports.filter(r => r.year === year).map(r => r.month).sort().map(m => monthNames[m]);
                    reportMonth.setDataSource(new kendo.data.DataSource({data: distinctMonths}));
                }
            }).data('kendoComboBox');
            let distinctYears = [...new Set(reports.map(r => r.year).sort((a, b) => b - a))];
            reportYear.setDataSource(new kendo.data.DataSource({data: distinctYears}));

            /*viewReportForm.on('submit', function (e) {
                e.preventDefault();
                jQuery.post({
                    url: "<?php echo URL_ROOT . '/pages/view-reports'?>",
                    data: viewReportForm.serialize()
                }).done((e) => {
                    window.location.href = URL_ROOT + "/pages/view-reports/" + $("#reportID").val();
                })
            });*/
        }
    });

</script>
</body>
</html>