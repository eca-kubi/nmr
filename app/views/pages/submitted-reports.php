<?php include_once(APP_ROOT . '/views/includes/styles.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/navbar.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/sidebar.php'); ?>
<style>
    .accordion .fa {
        margin-right: 0.5rem;
    }
</style>
<!-- .content-wrapper -->
<div class="content-wrapper animated fadeInRight" style="margin-top: <?php //echo NAVBAR_MT; ?>">
    <!-- content -->
    <section class="content blockable d-none">
        <div class="box-group pt-1" id="box_group">
            <div class="mt-3"></div>
            <?php /** @var array $report_submissions */
            foreach ($report_submissions as $table_prefix => $report_submission) { ?>
                <div class="box collapsed <?php echo $table_prefix === 'nmr' ? 'border-primary' : 'border-warning' ?>">
                    <div class="box-header border-bottom">
                        <div class="row p-1">
                            <h5 class="box-title text-bold"><span><svg class="fontastic-draft"
                                                                       style="fill: currentColor"><use
                                                xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span>
                                <?php echo 'Submitted Reports ' ?> <span
                                        class="<?php echo $table_prefix === 'nmr' ? 'text-primary' : 'text-warning' ?>">(<?php echo flashOrFull($table_prefix) ?> Report)</span>
                            </h5>
                        </div>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php if (count($report_submission) > 0): ?>
                            <div class="accordion"
                                 id="accordionReportSubmissions<?php echo flashOrFull($table_prefix) ?>">
                                <?php $i = 0;
                                foreach ($report_submission as $key => $g) {
                                    $group = array_values($g);
                                    $i++ ?>
                                    <div class="cardd mb-1">
                                        <div class="card-header with-plus-icon" id="heading_<?php echo $key; ?>">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link <?php echo $table_prefix === 'nmr' ? 'text-primary' : 'text-warning' ?>"
                                                        type="button"
                                                        data-toggle="collapse"
                                                        data-target="#collapseOne<?php echo flashOrFull($table_prefix) . $i; ?>"
                                                        aria-expanded="true"
                                                        aria-controls="collapseOne<?php echo flashOrFull($table_prefix) . $i ?>">
                                                    <i
                                                            class="collapse-icon fa fa-plus"></i>
                                                    <?php echo $key; ?>
                                                </button>
                                                <span class="toolbar float-right">
                                                    <span class="row">
                                                        <a
                                                                class="dropdown-item preview-final-report-btn col"
                                                                href="#"
                                                                data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                                data-table-prefix="<?php echo $table_prefix ?>"
                                                                data-target-year="<?php echo explode(" ", $key)[1] ?>"><i
                                                                    class="fa fa-play-circle-o"></i> View Report</a>
                                                    <?php if (isPowerUser($current_user->user_id) && isset($is_power_user)): ?>
                                                        <a
                                                                class="dropdown-item generate-report-btn col"
                                                                href="<?php echo "#" ?>"
                                                                data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                                data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                                data-table-prefix="<?php echo $table_prefix ?>"
                                                        ><i class="fas fa-cogs"></i> Generate Report
                                                    </a>
                                                        <a id="<?php echo 'editFinalReportBtn_' . $key ?>"
                                                           class="dropdown-item edit-final-report-btn col <?php echo isPowerUser($current_user->user_id) ? '' : 'd-none' ?> <?php /** @var array $target_month_years */
                                                           echo in_array($key, $target_month_years[$table_prefix]) ? '' : 'd-none' ?>"
                                                           href="#"
                                                           data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                           data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                           data-table-prefix="<?php echo $table_prefix ?>"
                                                        ><i class="fa fa-file-edit"></i> Edit
                                                    </a> <?php endif; ?>
                                                <a
                                                        class="dropdown-item download-final-report-btn col <?php echo !empty($group[0]['download_url']) ? '' : 'd-none' ?>"
                                                        href="<?php echo $group[0]['download_url'] ?? "#" ?>"
                                                        data-download-url="<?php echo $group[0]['download_url'] ?? ''; ?>"
                                                        target="_blank"
                                                        data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                        data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                        data-table-prefix="<?php echo $table_prefix ?>"
                                                ><i class="fa fa-file-download"></i> Download</a><a
                                                                class="dropdown-item d-none col"
                                                                href="<?php echo "#" ?>"
                                                                data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                                data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                                data-table-prefix="<?php echo $table_prefix ?>"
                                                        ><i class="fa fa-megaphone"></i> Notify HoDs</a>
                                                </span>
                                                <a
                                                        href="#"
                                                        class="fa fa-ellipsis-v font-weight-lighter float-right w3-text-dark-grey d-none"
                                                        data-toggle="dropdown"
                                                        role="button"></a>
                                                <span class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                <a
                                                        class="dropdown-item preview-final-report-btn"
                                                        href="#" data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                        data-table-prefix="<?php echo $table_prefix ?>"
                                                        data-target-year="<?php echo explode(" ", $key)[1] ?>"><i
                                                            class="fa fa-play-circle-o"></i> View Report</a>
                                                <?php if (isPowerUser($current_user->user_id) && isset($is_power_user)): ?>
                                                    <a
                                                            class="dropdown-item generate-report-btn"
                                                            href="<?php echo "#" ?>"
                                                            data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                            data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                            data-table-prefix="<?php echo $table_prefix ?>"
                                                    ><i class="fas fa-cogs"></i> Generate Report
                                                    </a>
                                                    <a id="<?php echo 'editFinalReportBtn_' . $key ?>"
                                                       class="dropdown-item edit-final-report-btn <?php echo isPowerUser($current_user->user_id) ? '' : 'd-none' ?> <?php /** @var array $target_month_years */
                                                       echo in_array($key, $target_month_years[$table_prefix]) ? '' : 'd-none' ?>"
                                                       href="#"
                                                       data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                       data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                       data-table-prefix="<?php echo $table_prefix ?>"
                                                    ><i class="fa fa-file-edit"></i> Edit
                                                    </a> <?php endif; ?>
                                                <a
                                                        class="dropdown-item download-final-report-btn <?php echo !empty($group[0]['download_url']) ? '' : 'd-none' ?>"
                                                        href="<?php echo $group[0]['download_url'] ?? "#" ?>"
                                                        data-download-url="<?php echo $group[0]['download_url'] ?? ''; ?>"
                                                        target="_blank"
                                                        data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                        data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                        data-table-prefix="<?php echo $table_prefix ?>"
                                                ><i class="fa fa-file-download"></i> Download</a><a
                                                            class="dropdown-item d-none"
                                                            href="<?php echo "#" ?>"
                                                            data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                            data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                            data-table-prefix="<?php echo $table_prefix ?>"
                                                    ><i class="fa fa-megaphone"></i> Notify HoDs</a>
                                                    </span>

                                            </span>
                                            </h5>
                                        </div>

                                        <div id="collapseOne<?php echo flashOrFull($table_prefix) . $i ?>"
                                             class="with-plus-icon collapse <?php //echo $i === 0 ? 'show' : '';
                                             //$i++ ?>"
                                             aria-labelledby="heading_<?php echo $key; ?>"
                                             data-parent="#accordionReportSubmissions<?php echo flashOrFull($table_prefix) ?>">
                                            <div class="card-body border rounded-bottom">
                                                <?php if (isPowerUser($current_user->user_id)) { ?>
                                                    <a href="#submissionCollapse<?php echo flashOrFull($table_prefix) ?>"
                                                       class="btn btn-<?php echo $table_prefix === 'nmr' ? 'primary' : 'warning'; ?> mb-3"
                                                       data-toggle="collapse" role="button"><i
                                                                class="fa fa-info-circle"></i> <?php echo $key ?> <?php echo flashOrFull($table_prefix) ?>
                                                        Report
                                                        Submission Summary</a>
                                                    <div class="collapse"
                                                         id="submissionCollapse<?php echo flashOrFull($table_prefix) ?>">
                                                        <div class="card card-body">
                                                            <table id="submissionStatusGrid<?php echo flashOrFull($table_prefix) ?>"
                                                                   class="table table-bordered mb-2">
                                                                <colgroup>
                                                                    <col/>
                                                                    <col/>
                                                                    <!-- <col style="width:110px" />
                                                                     <col style="width:120px" />
                                                                     <col style="width:130px" />-->
                                                                </colgroup>
                                                                <thead>
                                                                <tr class="text-center">
                                                                    <th colspan="2"><?php echo $key ?> <?php echo flashOrFull($table_prefix) ?>
                                                                        Report
                                                                        Submission
                                                                        Summary
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th data-field="department">Department</th>
                                                                    <th data-field="status">Status</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php foreach (getSubmittedDepartments(explode(" ", $key)[0], explode(" ", $key)[1], $table_prefix) as $department) { ?>
                                                                    <tr>
                                                                        <td><?php echo $department ?></td>
                                                                        <td class="text-bold text-success"> Submitted
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <?php foreach (getNotSubmittedDepartments(explode(" ", $key)[0], explode(" ", $key)[1], $table_prefix) as $department) { ?>
                                                                    <tr>
                                                                        <td><?php echo $department ?></td>
                                                                        <td class="text-bold text-danger"> Pending</td>
                                                                    </tr>
                                                                <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                <?php } ?>
                                                <div class="row"><?php foreach ($group as $report) { ?>
                                                        <div class="col-md-4 col-sm-6 col-xs-12"
                                                             id="<?php echo $report['report_submissions_id']; ?>">
                                                            <div class="info-box p-0"><span
                                                                        class="info-box-icon bg-gray-light border rounded-0 rounded-left"><svg
                                                                            class="fontastic-draft"
                                                                            style="fill: currentColor"><use
                                                                                xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span>
                                                                <div class="info-box-content">
                                                                <span class="info-box-text text-bold"><?php echo $report['department'] ?>
                                                                    <a href="#"
                                                                       class="fa fa-ellipsis-v font-weight-lighter float-right draft-menu w3-text-dark-grey d-none"
                                                                       data-toggle="dropdown"
                                                                       role="button"></a>
                                         <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"><a
                                                     class="dropdown-item edit-submitted-report"
                                                     data-submissions-id="<?php echo $report['report_submissions_id']; ?>"
                                                     data-target-month="<?php echo $report['target_month'] ?>"
                                                     data-target-year="<?php echo $report['target_year'] ?>"
                                                     data-table-prefix="<?php echo $table_prefix ?>"
                                                     href="#"
                                             ><i class="fa fa-file-edit"></i> Edit</a>
                                             <a class="dropdown-item preview-btn" href="#"><i
                                                         class="fa fa-play-circle-o"></i> View Report</a>
                                        </div>
                                    </span>
                                                                    <span class="text-sm"><i
                                                                                class="fa fa-calendar"></i> <?php echo echoDateOfficial($report['date_submitted'], true); ?></span>
                                                                    <span style="font-size: 0.7rem;display: block"><i
                                                                                class="fa fa-clock-o"></i> <?php echo getTime($report['date_submitted']); ?></span>

                                                                    <a href="#"
                                                                       class="float-right text-sm font-poppins w3-text-dark-grey preview-btn"
                                                                       data-report-submissions-id="<?php echo $report['report_submissions_id']; ?>"
                                                                       data-title="<?php echo $report['department']; ?>"
                                                                       data-table-prefix="<?php echo $table_prefix ?>"
                                                                       data-target-month="<?php echo $report['target_month'] ?>"
                                                                       data-target-year="<?php echo $report['target_year'] ?>"><i
                                                                                class="fa fa-play-circle-o mr-0"></i>
                                                                        View Report</a>
                                                                    <a class="float-right text-sm font-poppins w3-text-dark-grey mr-4 edit-submitted-report <?php echo isPowerUser($current_user->user_id) ? '' : 'd-none' ?>"
                                                                       href="#"
                                                                       data-table-prefix="<?php echo $table_prefix ?>"
                                                                       data-submissions-id="<?php echo $report['report_submissions_id']; ?>"
                                                                       data-target-month="<?php echo $report['target_month'] ?>"
                                                                       data-target-year="<?php echo $report['target_year'] ?>"
                                                                    ><i class="fa fa-file-edit mr-0"></i> Edit</a>
                                                                </div>
                                                                <!-- /.info-box-content -->
                                                            </div>
                                                            <!-- /.info-box -->
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php else: ?>
                            <br>
                            <h5>No <?php echo flashOrFull($table_prefix) ?> Reports have been Submitted!</h5>
                        <?php endif; ?>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer d-none"></div>
                    <!-- /.box-footer-->
                </div>
            <?php } ?>

        </div>
    </section>
    <!-- /.content -->
</div>
<style>
    .k-editor {
        z-index: -1 !important;
    }
</style>
<!-- /.content-wrapper -->
<?php include_once(APP_ROOT . '/views/includes/footer.php'); ?>
</div>
<!-- /.wrapper -->
<?php include_once(APP_ROOT . '/views/includes/scripts.php'); ?>
<?php include_once(APP_ROOT . '/templates/kendo-templates.html'); ?>
<?php
$table_prefixes = ['nmr', 'nmr_fr'];
$cover_pages = [];
foreach ($table_prefixes as $tb_p) {
    $cover_pages[$tb_p] = Database::getDbh()->where('name', 'cover_page')->getValue($tb_p .'_report_parts', 'content');
}
$distribution_list = Database::getDbh()->where('name', 'distribution_list')->getValue('nmr_report_parts', 'content');
$blank_page = Database::getDbh()->where('name', 'blank_page')->getValue('nmr_report_parts', 'content');
?>
<script>
    let previewEditor;
    let draftWindow;
    let previewTargetMonth;
    let previewTargetYear;
    let reportSubmissionsId;
    let tablePrefix;
    /**
     * @type {kendo.ui.PDFViewer}*/
    let pdfViewer;

    const COVER_PAGES = {
        nmr: '<?php echo $cover_pages['nmr']; ?>',
        nmr_fr: `<?php echo $cover_pages['nmr_fr']; ?>`
    };


    const BLANK_PAGE = `<?php echo $blank_page; ?>`;

    const DISTRIBUTION_LIST = `<?php echo $distribution_list ?>`;

    $(function () {
            // Add minus icon for collapse element which is open by default
            /* $("#submissionStatusGrid").kendoGrid({
                 height: 300,
                 sortable: true
             });*/
            $(".collapse.show").each(function () {
                $(this).prev(".card-header").find(".collapse-icon").addClass("fa-minus").removeClass("fa-plus");
            });

            // Toggle plus minus icon on show hide of collapse element
            $(".collapse").on('show.bs.collapse', function () {
                $(this).prev(".card-header").find(".collapse-icon").removeClass("fa-plus").addClass("fa-minus");
            }).on('hide.bs.collapse', function () {
                $(this).prev(".card-header").find(".collapse-icon").removeClass("fa-minus").addClass("fa-plus");
            });

            $("[id^='submissionCollapse']").on('hide.bs.collapse show.bs.collapse', e => e.stopPropagation());

            jQSelectors.draftViewerWindow = $("<div id='draftViewerWindow'/>").appendTo("body");
            jQSelectors.draftPreviewViewer = $("<div id='draftPreviewViewer'/>").appendTo(jQSelectors.draftViewerWindow);
            jQSelectors.draftPreviewEditor = $("<textarea id='draftPreviewEditor' style='width: 100%;'/>").appendTo("body");

            draftWindow = jQSelectors.draftViewerWindow.kendoWindow({
                modal: true,
                visible: false,
                width: "80%",
                scrollable: true,
                // (Optional) Will limit the percentage dimensions as well:
                // maxWidth: 1200,
                // maxHeight: 800,
                //open: adjustSize
            }).data("kendoWindow");

            pdfViewer = jQSelectors.draftPreviewViewer.kendoPDFViewer({
                pdfjsProcessing: {
                    file: ""
                },
                width: "100%",
                height: 800,
                scale: 1.27,
                toolbar: {
                    items: [
                        "pager", "zoom", "toggleSelection", "search", "download", "print",
                        /*   {
                               id: "generateReport",
                               template: `<a role='button' class='d-none' title='Generate Report'><span class='fa fa-cogs'></span>&nbsp;Generate Report</a>`,
                           },

                           */
                        {
                            id: "editFinalReport",
                            overflow: "auto",
                            type: "button",
                            text: " <i class=\"fa fa-edit mt-1\"></i>&nbsp;Edit",
                            click: onEditFinalReport
                            //template: `<a role="button" class="k-button k-flat" onclick="onEditFinalReport()" title="Edit"> <i class="fa fa-file-edit"></i>&nbsp; Edit</a>`
                        },
                        {
                            id: "editSubmittedReport",
                            overflow: "auto",
                            type: "button",
                            text: "<i class='fa fa-edit mt-1'></i> Edit",
                            click: onEditSubmittedReport
                            //template: `<a role="button" class="k-button k-flat d-none" onclick="onEditSubmittedReport()" title="Edit"> <i class="fa fa-file-edit"></i>&nbsp; Edit</a>`,
                        },
                        {
                            id: "cancel",
                            overflow: "auto",
                            template: `<a role="button" class="k-button k-flat" onclick="draftWindow.close();" title="Cancel"> <i class="k-i-cancel k-icon"></i>&nbsp; Cancel</a>`
                        }
                    ]
                }
            }).getKendoPDFViewer();

            setTimeout(function () {
                previewEditor = jQSelectors.draftPreviewEditor.kendoEditor({
                    tools: [],
                    stylesheets: [
                        "<?php echo URL_ROOT; ?>/public/assets/css/bootstrap/bootstrap.css",
                        "<?php echo URL_ROOT; ?>/public/custom-assets/css/editor.css"
                    ]
                }).data("kendoEditor");
            }, 1000);

            $("a.preview-btn").on("click", function (e) {
                let target = $(e.target);
                let tablePrefix = window.tablePrefix = target.data('tablePrefix');
                let targetMonth = window.targetMonth = target.data('targetMonth');
                let targetYear = window.targetYear = target.data('targetYear');
                let reportSubmissionsId = window.reportSubmissionsId = target.data('reportSubmissionsId');
                pdfViewer.toolbar.hide("#editFinalReport");
                if (!isPowerUser)
                    pdfViewer.toolbar.hide("#editSubmittedReport");
                progress('.content-wrapper', true);
                $.ajax({
                    url: `${URL_ROOT}/pages/get-submitted-report/${reportSubmissionsId}/${tablePrefix}`,
                    dataType: "html",
                    success: (data) => {
                        previewEditor.value(data);
                        kendo.drawing.drawDOM($(previewEditor.body), {
                            allPages: true,
                            paperSize: 'A4',
                            margin: tablePrefix === 'nmr_fr'? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
                            multipage: true,
                            scale: 0.7,
                            forcePageBreak: ".page-break",
                            template: $(`#page-template-body_${tablePrefix}`).html()
                        }).done(function (group) {
                            kendo.drawing.exportPDF(group, {
                                allPages: true,
                                paperSize: 'A4',
                                margin: "1cm",
                                multipage: true,
                                scale: 0.7,
                                forcePageBreak: ".page-break"
                            }).done(data => {
                                progress('.content-wrapper');
                                draftWindow.center().open().maximize();
                                pdfViewer.fromFile({data: data.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                                setTimeout(() => pdfViewer.activatePage(1), 500)
                            });
                        })
                    }
                });
                //previewContent(`${URL_ROOT}/pages/get-submitted-report/${reportSubmissionsId}/${tablePrefix}`, data => JSON.parse(data).content);
            });

            $(".preview-final-report-btn").on("click", e => {
                let target = $(e.currentTarget);
                let tablePrefix = window.tablePrefix = target.data('tablePrefix');
                let targetMonth = window.targetMonth = target.data('targetMonth');
                let targetYear = window.targetYear = target.data('targetYear');
                pdfViewer.toolbar.hide("#editSubmittedReport");
                if (!target.siblings('.edit-final-report-btn').hasClass('d-none') && isPowerUser)
                    pdfViewer.toolbar.show("#editFinalReport");
                else
                    pdfViewer.toolbar.hide("#editFinalReport");
                progress('.content-wrapper', true);
                $.ajax({
                    url: `${URL_ROOT}/pages/preview-final-report/${targetMonth}/${targetYear}/${tablePrefix}`,
                    dataType: "html",
                    success: (data) => {
                        const COVER_PAGE = COVER_PAGES[tablePrefix].replace("#: monthYear #", targetMonth.toUpperCase() + ' ' + targetYear);
                        let content = COVER_PAGE + getPageBreak() + DISTRIBUTION_LIST + getPageBreak() + BLANK_PAGE;
                        previewEditor.value(content);
                        kendo.drawing.drawDOM($(previewEditor.body), {
                            allPages: true,
                            paperSize: 'A4',
                            margin: tablePrefix === 'nmr_fr'? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
                            multipage: true,
                            scale: 0.7,
                            forcePageBreak: ".page-break",
                            template: $(`#page-template-cover-toc_${tablePrefix}`).html()
                        }).done(function (group) {
                            // Remove  Cover and Distribution List
                            let content = data;
                            content = removeTagAndContent('coverpage', content);
                            content = removeTagAndContent('distributionlist', content);

                            previewEditor.value(content);

                            kendo.drawing.drawDOM($(previewEditor.body), {
                                allPages: true,
                                paperSize: 'A4',
                                margin: tablePrefix === 'nmr_fr'? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
                                multipage: true,
                                scale: 0.7,
                                forcePageBreak: ".page-break",
                                template: $(`#page-template-body_${tablePrefix}`).html()
                            }).done((group2) => {
                                group.append(...group2.children);
                                kendo.drawing.exportPDF(group, {
                                    allPages: true,
                                    paperSize: 'A4',
                                    margin: tablePrefix === 'nmr_fr'? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
                                    multipage: true,
                                    scale: 0.7,
                                    forcePageBreak: ".page-break"
                                }).done(data2 => {
                                    progress('.content-wrapper');
                                    draftWindow.center().open().maximize();
                                    pdfViewer.fromFile({data: data2.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                                    setTimeout(() => pdfViewer.activatePage(1), 500)
                                })
                            })
                        })
                    }
                });
                //previewContent(`${URL_ROOT}/pages/preview-final-report/${targetMonth}/${targetYear}/${tablePrefix}`, data => data);
            });

            $(".generate-report-btn").on('click', e => {
                let target = $(e.currentTarget);
                let tablePrefix = target.data('tablePrefix');
                let targetMonth = window.targetMonth = target.data('targetMonth');
                let targetYear = window.targetYear = target.data('targetYear');
                let html_content = "";
                // todo issue warning to user.
                progress('.content-wrapper', true);
                $.ajax({
                    url: `${URL_ROOT}/pages/final-report/${targetMonth}/${targetYear}/${tablePrefix}`,
                    dataType: "html",
                    /*dataFilter(data, type) {
                        return JSON.parse(data).content;
                    },*/
                    success: data => {
                        const COVER_PAGE = COVER_PAGES[tablePrefix].replace("#: monthYear #", targetMonth.toUpperCase() + ' ' + targetYear);
                        let content = COVER_PAGE + getPageBreak() + DISTRIBUTION_LIST + getPageBreak() + BLANK_PAGE;
                        previewEditor.value(content);
                        kendo.drawing.drawDOM($(previewEditor.body), {
                            allPages: true,
                            paperSize: 'A4',
                            margin: tablePrefix === 'nmr_fr'? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
                            multipage: true,
                            scale: 0.7,
                            forcePageBreak: ".page-break",
                            template: $(`#page-template-cover-toc_${tablePrefix}`).html()
                        }).done(function (group) {
                            // Remove  Cover and Distribution List
                            let content = data;
                            content = removeTagAndContent('coverpage', content);
                            content = removeTagAndContent('distributionlist', content);

                            previewEditor.value(content);

                            kendo.drawing.drawDOM($(previewEditor.body), {
                                allPages: true,
                                paperSize: 'A4',
                                margin: tablePrefix === 'nmr_fr'? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
                                multipage: true,
                                scale: 0.7,
                                forcePageBreak: ".page-break",
                                template: $(`#page-template-body_${tablePrefix}`).html()
                            }).done((group2) => {
                                group.append(...group2.children);
                                kendo.drawing.exportPDF(group, {
                                    allPages: true,
                                    paperSize: 'A4',
                                    margin: tablePrefix === 'nmr_fr'? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
                                    multipage: true,
                                    scale: 0.7,
                                    forcePageBreak: ".page-break"
                                }).done(data2 => {
                                    progress('.content-wrapper');
                                    $.post(`${URL_ROOT}/pages/final-report/${targetMonth}/${targetYear}/${tablePrefix}`, {
                                        data_uri: data2,
                                        html_content: data
                                    }, (data1) => {
                                        progress('.content-wrapper');
                                        kendoAlert('Report Generated Successfully', `${targetMonth} ${targetYear} Nzema Report generated successfully! <p><u>Download Link:</u> <a class="" href="${data1.downloadUrl}" target="_blank">${data1.downloadUrl}</a> <a id="copyDownloadLink" class="d-none" href="#" role="button" title="Copy download link"><i class="fa fa-copy"></i> </a></p>`);
                                        target.siblings('.download-final-report-btn').attr('href', data1.downloadUrl).attr('data-download-url', data1.downloadUrl).removeClass('d-none');
                                        target.siblings('.edit-final-report-btn').removeClass('d-none')
                                    }, "json");
                                })
                            })
                        })
                    }
                    /*success: data => {
                        previewEditor.value(data);
                        html_content = data;
                        kendo.drawing.drawDOM($(previewEditor.body), {
                            paperSize: 'A4',
                            margin: tablePrefix === 'nmr_fr'? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
                            multipage: true,
                            forcePageBreak: ".page-break",
                            scale: 0.7,
                            template: $(`#page-template-body_${tablePrefix}`).html()
                        }).then(function (group) {
                            return kendo.drawing.exportPDF(group, {});
                        }).done(dataUri => {
                            $.post(`${URL_ROOT}/pages/final-report/${targetMonth}/${targetYear}/${tablePrefix}`, {
                                data_uri: dataUri,
                                html_content: html_content
                            }, (data1) => {
                                progress('.content-wrapper');
                                kendoAlert('Report Generated Successfully', `${targetMonth} ${targetYear} Nzema Report generated successfully! <p><u>Download Link:</u> <a class="" href="${data1.downloadUrl}" target="_blank">${data1.downloadUrl}</a> <a id="copyDownloadLink" class="d-none" href="#" role="button" title="Copy download link"><i class="fa fa-copy"></i> </a></p>`);
                                target.siblings('.download-final-report-btn').attr('href', data1.downloadUrl).attr('data-download-url', data1.downloadUrl).removeClass('d-none');
                                target.siblings('.edit-final-report-btn').removeClass('d-none')
                            }, "json")
                        });
                    }*/
                });
            });

            $(".edit-final-report-btn").on('click', e => {
                let target = $(e.currentTarget);
                let tablePrefix = window.tablePrefix = target.data('tablePrefix');
                let targetMonth = window.targetMonth = target.data('targetMonth');
                let targetYear = window.targetYear = target.data('targetYear');
                onEditFinalReport();
            });

            $(".edit-submitted-report").on('click', e => {
                let target = $(e.currentTarget);
                let tablePrefix = window.tablePrefix = target.data('tablePrefix');
                let targetMonth = window.targetMonth = target.data('targetMonth');
                let targetYear = window.targetYear = target.data('targetYear');
                let submissionsId = window.reportSubmissionsId = target.data('submissionsId');
                onEditSubmittedReport();
            });
        }
    )
    ;

    function onEditSubmittedReport() {
        $.ajax({
            url: `${URL_ROOT}/pages/is-submission-closed/${window.targetMonth}/${window.targetYear}`,
            dataType: "json",
            success: data => {
                if (data.submission_closed) {
                    window.location.href = `${URL_ROOT}/pages/edit-submitted-report/${window.reportSubmissionsId}/${window.tablePrefix}`;
                } else {
                    showWindow('You must first close submission of reports for this month! This will ensure that no one can undo the changes you are about to make.<br>Do you wish to close submission?',
                        'Close Submission First').done(() => {
                        $.get({
                            url: `${URL_ROOT}/pages/close-submission/${window.targetMonth}/${window.targetYear}`,
                            dataType: "json"
                        }).done(data => {
                            if (data.success) window.location.href = `${URL_ROOT}/pages/edit-submitted-report/${window.reportSubmissionsId}/${window.tablePrefix}`;
                        })
                    })
                }
            }
        });
    }

    function onEditFinalReport() {
        $.ajax({
            url: `${URL_ROOT}/pages/is-submission-closed/${window.targetMonth}/${window.targetYear}`,
            dataType: "json",
            success: data => {
                if (data.submission_closed) {
                    window.location.href = `${URL_ROOT}/pages/edit-final-report/${window.targetMonth}/${window.targetYear}/${window.tablePrefix}`;
                } else {
                    showWindow('You must first close submission of reports for this month! This will ensure that no one can undo the changes you are about to make.<br>Do you wish to close submission?',
                        'Close Submission First').done(() => {
                        $.get({
                            url: `${URL_ROOT}/pages/close-submission/${window.targetMonth}/${window.targetYear}`,
                            dataType: "json"
                        }).done(data => {
                            if (data.success) window.location.href = `${URL_ROOT}/pages/edit-final-report/${window.targetMonth}/${window.targetYear}/${window.tablePrefix}`;
                        })
                    })
                }
            }
        });
    }

    function previewContent(previewURL, dataFilter) {
        progress('.content-wrapper', true);
        $.ajax({
            url: previewURL,
            dataType: "html",
            dataFilter(data, type) {
                return dataFilter ? dataFilter(data, type) : data;
            },
            success: function (data) {
                previewEditor.value(data);
                kendo.drawing.drawDOM($(previewEditor.body), {
                    allPages: true,
                    paperSize: 'A4',
                    margin: tablePrefix === 'nmr_fr' ? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : "1cm",
                    multipage: true,
                    scale: 0.7,
                    forcePageBreak: ".page-break"
                }).then(function (group) {
                    // Render the result as a PDF file
                    return kendo.drawing.exportPDF(group, {});
                }).done(data => {
                    progress('.content-wrapper');
                    draftWindow.center().open().maximize();
                    pdfViewer.fromFile({data: data.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                    setTimeout(() => pdfViewer.activatePage(1), 500)
                });
            }
        })
    }

    function adjustSize() {
        // For small screens, maximize the window when it is shown.
        // You can also make the check again in $(window).resize if you want to
        // but you will have to change the way to reference the widget and then
        // to use $("#theWindow").data("kendoWindow").
        // Alternatively, you may want to .center() the window.

        if ($(window).width() < 800 || $(window).height() < 600) {
            this.maximize();
        }
    }


</script>
</body>
</html>