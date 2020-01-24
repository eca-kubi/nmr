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
            <div class="box collapsed">
                <div class="box-header border-bottom">
                    <div class="row p-1">
                        <h5 class="box-title text-bold"><span><svg class="fontastic-draft" style="fill: currentColor"><use
                                            xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span>
                            <?php echo $page_title ?? ''; ?>
                        </h5>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if (isset($report_submissions) && is_array($report_submissions) && count($report_submissions) > 0): ?>
                        <div class="accordion" id="accordionReportSubmissions">
                            <?php $i = 0;
                            foreach ($report_submissions as $key => $group) { ?>
                                <div class="cardd mb-1">
                                    <div class="card-header with-plus-icon" id="heading_<?php echo $key; ?>">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                    data-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne"><i class="collapse-icon fa fa-plus"></i>
                                                <?php echo $key; ?>
                                            </button>
                                            <a
                                                    href="#"
                                                    class="fa fa-ellipsis-v font-weight-lighter float-right w3-text-dark-grey"
                                                    data-toggle="dropdown"
                                                    role="button"></a>
                                            <span class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                <a
                                                        class="dropdown-item preview-final-report-btn"
                                                        href="#" data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                        data-target-year="<?php echo explode(" ", $key)[1] ?>"><i
                                                            class="fa fa-play-circle-o"></i> Preview</a>
                                                <?php if (isPowerUser($current_user->user_id) && isset($is_power_user)): ?>
                                                    <a
                                                            class="dropdown-item generate-report-btn"
                                                            href="<?php echo "#" ?>"
                                                            data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                            data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                    ><i class="fas fa-cogs"></i> Generate Report
                                                    </a>
                                                    <a id="<?php echo 'editFinalReportBtn_' . $key ?>"
                                                       class="dropdown-item edit-final-report-btn <?php echo isPowerUser($current_user->user_id) ? '' : 'd-none' ?> d-none"
                                                       href="#"
                                                       data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                       data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                    ><i class="fa fa-file-edit"></i> Edit
                                                    </a> <?php endif; ?>
                                                <a
                                                        class="dropdown-item download-final-report-btn"
                                                        href="<?php echo "#" ?>"
                                                        data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                        data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                ><i class="fa fa-file-download"></i> Download</a><a
                                                        class="dropdown-item d-none"
                                                        href="<?php echo "#" ?>"
                                                        data-target-month="<?php echo explode(" ", $key)[0] ?>"
                                                        data-target-year="<?php echo explode(" ", $key)[1] ?>"
                                                ><i class="fa fa-megaphone"></i> Notify HoDs</a>
                                            </span>
                                        </h5>
                                    </div>

                                    <div id="collapseOne" class="with-plus-icon collapse <?php echo $i === 0 ? 'show' : '';
                                    $i++ ?>"
                                         aria-labelledby="heading_<?php echo $key; ?>"
                                         data-parent="#accordionReportSubmissions">
                                        <div class="card-body border rounded-bottom">
                                            <?php if (isPowerUser($current_user->user_id)) { ?>
                                                <a href="#submissionCollapse" class="btn btn-primary mb-3"
                                                   data-toggle="collapse" role="button"><i
                                                            class="fa fa-info-circle"></i> <?php echo $key ?> Report
                                                    Submission Summary</a>
                                                <div class="collapse" id="submissionCollapse">
                                                    <div class="card card-body">
                                                        <table id="submissionStatusGrid"
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
                                                                <th colspan="2"><?php echo $key ?> Report Submission
                                                                    Summary
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th data-field="department">Department</th>
                                                                <th data-field="status">Status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach (getSubmittedDepartments(explode(" ", $key)[0], explode(" ", $key)[1]) as $department) { ?>
                                                                <tr>
                                                                    <td><?php echo $department ?></td>
                                                                    <td class="text-bold text-success"> Submitted</td>
                                                                </tr>
                                                            <?php } ?>
                                                            <?php foreach (getNotSubmittedDepartments(explode(" ", $key)[0], explode(" ", $key)[1]) as $department) { ?>
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
                                                     class="dropdown-item "
                                                     href="<?php echo URL_ROOT . '/pages/edit-submitted-report/' . $report['report_submissions_id']; ?>"
                                             ><i class="fa fa-file-edit"></i> Edit</a>
                                             <a class="dropdown-item preview-btn" href="#"><i
                                                         class="fa fa-play-circle-o"></i> Preview</a>
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
                                                                   data-target-month="<?php echo $report['target_month'] ?>"
                                                                   data-target-year="<?php echo $report['target_year'] ?>"><i
                                                                            class="fa fa-play-circle-o mr-0"></i>
                                                                    Preview</a>
                                                                <a class="float-right text-sm font-poppins w3-text-dark-grey mr-4 <?php echo isPowerUser($current_user->user_id) ? '' : 'd-none' ?>"
                                                                   href="<?php echo URL_ROOT . '/pages/edit-submitted-report/' . $report['report_submissions_id']; ?>"
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
                        <h5>No Reports have been Submitted!</h5>
                    <?php endif; ?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer d-none"></div>
                <!-- /.box-footer-->
            </div>
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
<script>
    let previewEditor;
    let draftWindow;
    let previewTargetMonth;
    let previewTargetYear;
    let reportSubmissionsId;
    /**
     * @type {kendo.ui.PDFViewer}*/
    let pdfViewer;


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

        jQSelectors.draftViewerWindow = $("<div id='draftViewerWindow'/>").appendTo("body");
        jQSelectors.draftPreviewViewer = $("<div id='draftPreviewViewer'/>").appendTo(jQSelectors.draftViewerWindow);
        jQSelectors.draftPreviewEditor = $("<textarea id='draftPreviewEditor' style='width: 100%;'/>").appendTo("body");

        draftWindow = jQSelectors.draftViewerWindow.kendoWindow({
            modal: true,
            visible: false,
            width: "80%",
            scrollable: false
            //height: "80%",
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
            height: 550,
            scale: 1,
            toolbar: {
                items: [
                    "pager", "zoom", "toggleSelection", "search", "download", "print",
                    {
                        id: "generateReport",
                        template: `<a role='button' class='<?php echo isPowerUser($current_user->user_id) ? 'k-button k-flat generate-report-btn' : 'd-none' ?>' title='Generate Report'><span class='fa fa-cogs'></span>&nbsp;Generate Report</a>`
                    },
                    {
                        id: "editSubmittedReport",
                        template: `<a role="button" class="k-button k-flat" onclick="onEditSubmittedReport()" title="Edit"> <i class="fa fa-file-edit"></i>&nbsp; Edit</a>`,
                    },
                    {
                        id: "editFinalReport",
                        template: `<a role="button" class="k-button k-flat" onclick="onEditFinalReport()" title="Edit"> <i class="fa fa-file-edit"></i>&nbsp; Edit</a>`,
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
            let currentTarget = $(e.currentTarget);
            reportSubmissionsId = currentTarget.data('reportSubmissionsId');
            let title = currentTarget.data('title');
            let departmentId = currentTarget.data('departmentId');
            let currentMonth = previewTargetMonth = currentTarget.data('targetMonth');
            let currentYear = previewTargetYear = currentTarget.data('targetYear');
            pdfViewer.toolbar.hide('#generateReport');
            pdfViewer.toolbar.hide("#editFinalReport");
            previewContent(`${URL_ROOT}/pages/get-submitted-report/${reportSubmissionsId}`, data => JSON.parse(data).content);
        });

        $(".preview-final-report-btn").on("click", e => {
            let target = $(e.currentTarget);
            let targetMonth = previewTargetMonth = target.data('targetMonth');
            let targetYear = previewTargetYear = target.data('targetYear');
            $.ajax({
                url: `${URL_ROOT}/pages/download-final-report-client-side/${targetMonth}/${targetYear}`,
                dataType: "html",
                success: data => {
                    previewEditor.value(data);
                    kendo.drawing.drawDOM($(previewEditor.body), {
                        paperSize: 'a3',
                        margin: "2cm",
                        multipage: true,
                        forcePageBreak: ".page-break"
                    }).then(function (group) {
                        // Render the result as a PDF file
                        return kendo.drawing.exportPDF(group, {});
                    }).done(data => {
                        draftWindow.center().open().maximize();
                        pdfViewer.fromFile({data: data.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                        setTimeout(() => pdfViewer.activatePage(1), 500);
                    });
                }
            });
            pdfViewer.toolbar.show('#generateReport');
            pdfViewer.toolbar.hide("#editSubmittedReport");
            //previewContent(`${URL_ROOT}/pages/final-report/${targetMonth}/${targetYear}`, data => JSON.parse(data).map(value => value.content).join("<br/>"))
        });

        $(".download-final-report-btn").on("click", e => {
            let target = $(e.currentTarget);
            let targetMonth = target.data('targetMonth');
            let targetYear = target.data('targetYear');
            downloadContent(`${URL_ROOT}/pages/download-final-report-client-side/${targetMonth}/${targetYear}`, data => data, (targetMonth + " " + targetYear + " Nzema Report").toUpperCase());
        });


        $(".generate-report-btn").on('click', e => {
            let target = $(e.currentTarget);
            let targetMonth = previewTargetMonth = target.data('targetMonth');
            let targetYear = previewTargetYear = target.data('targetYear');
            let html_content = "";
            // todo issue warning to user.
            $.ajax({
                url: `${URL_ROOT}/pages/generate-report/${targetMonth}/${targetYear}`,
                dataType: "html",
                dataFilter(data, type) {
                    return JSON.parse(data).map(value => value.content).join("<br/>");
                },
                success: data => {
                    previewEditor.value(data);
                    html_content = data;
                    kendo.drawing.drawDOM($(previewEditor.body), {
                        paperSize: 'a3',
                        margin: "2cm",
                        multipage: true,
                        forcePageBreak: ".page-break"
                    }).then(function (group) {
                        // Render the result as a PDF file
                        return kendo.drawing.exportPDF(group, {});
                    }).done(data => {
                        $.ajax({
                            url: `${URL_ROOT}/pages/final-report/${targetMonth}/${targetYear}`,
                            data: JSON.stringify({data_uri: data, html_content: html_content}, null, 2),
                            type: "POST",
                            processData: false,
                            dataType: "json",
                            contentType: "application/json",
                            success: data1 => kendoAlert('Report Generated Successfully', `${targetMonth} ${targetYear} Nzema Report generated successfully! <p><u>Download Link:</u> <a class="m-2" href="${URL_ROOT}/pages/download-report/${targetMonth}/${targetYear}" target="_blank">${URL_ROOT}/pages/download-report/${targetMonth}/${targetYear}</a> <a id="copyDownloadLink" class="d-none" href="#" role="button" title="Copy download link"><i class="fa fa-copy"></i> </a></p>`)
                        })
                    });
                }
            });
        });

        $(".edit-final-report-btn").on('click', e => {
            let target = $(e.currentTarget);
            let targetMonth = previewTargetMonth = target.data('targetMonth');
            let targetYear = previewTargetYear = target.data('targetYear');
            let html_content = "";

            $.ajax({
                url: `${URL_ROOT}/pages/is-submission-closed/${targetMonth}/${targetYear}`,
                dataType: "json",
                success: data => {
                    if (data.submission_closed) {
                        window.location.href = `${URL_ROOT}/pages/edit-final-report/${targetMonth}/${targetYear}`;
                    } else {
                        showWindow('You must first close submission of reports for this month! This will ensure that no one can undo the changes you are about to make.<br>Do you wish to close submission?',
                            'Close Submission First').done(() => {
                            $.get({
                                url: `${URL_ROOT}/pages/close-submission/${targetMonth}/${targetYear}`,
                                dataType: "json"
                            }).done(data => {
                                if (data.success) window.location.href = `${URL_ROOT}/pages/edit-final-report/${targetMonth}/${targetYear}`;
                            })
                        })
                    }
                }
            });
        });
    });

    function onEditSubmittedReport(e) {
        window.location.href=`${URL_ROOT}/pages/edit-submitted-report/${reportSubmissionsId}`;
    }

    function onEditFinalReport(e) {
        $("[id='editFinalReportBtn_" +  previewTargetMonth + " " + previewTargetYear + "']").trigger('click');
    }

    function previewContent(previewURL, dataFilter) {
        $.ajax({
            url: previewURL,
            dataType: "html",
            dataFilter(data, type) {
                return dataFilter ? dataFilter(data, type) : data;
            },
            success: function (data) {
                previewEditor.value(data);
                kendo.drawing.drawDOM($(previewEditor.body), {
                    paperSize: 'a3',
                    margin: "2cm",
                    multipage: true,
                    forcePageBreak: ".page-break"
                }).then(function (group) {
                    // Render the result as a PDF file
                    return kendo.drawing.exportPDF(group, {});
                }).done(data => {
                    draftWindow.center().open().maximize();
                    pdfViewer.fromFile({data: data.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                    setTimeout(() => pdfViewer.activatePage(1), 500)
                });
            }
        })
    }

    function downloadContent(contentUrl, dataFilter, fileName = "Report") {
        $.ajax({
            url: contentUrl,
            dataType: "html",
            dataFilter(data, type) {
                return dataFilter ? dataFilter(data, type) : data;
            },
            success: function (data) {
                previewEditor.value(data);
                kendo.drawing.drawDOM($(previewEditor.body), {
                    paperSize: 'a3',
                    margin: "2cm",
                    multipage: true,
                    forcePageBreak: ".page-break"
                }).then(function (group) {
                    // Render the result as a PDF file
                    return kendo.drawing.exportPDF(group, {});
                }).done(data => {
                    kendo.saveAs({
                        dataURI: data,
                        fileName: fileName + ".pdf"
                    });
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