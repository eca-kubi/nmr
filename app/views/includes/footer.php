<footer class="font-raleway w3-tiny d-none main-footer" style="z-index: 1100">
    <div class="col-8 float-left text-left">
        <strong>
            &copy; <?php echo year(now()) ?> -
            <a href="<?php echo site_url('about'); ?>">Developed By Adamus IT</a>.
        </strong>
    </div>
    <div class="float-right col-4 text-right">
        <b>Version 2.0</b>
    </div>
</footer>
<input type="hidden" id="url_root" value="<?php echo URL_ROOT; ?>">

<!--Change Password Modal-->
<div class="modal fade" style="z-index: 9995 !important;" id="change_password_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content fa font-weight-normal">
            <div class="modal-header">
                <h6 class="modal-title" id="modelTitleId">Password Reset</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php //flash('flash'); ?>
                <div>
                    <form action="<?php echo site_url('users/change-password'); ?>" data-toggle="validator"
                          id="change_password_form" method="post"
                          role="form">
                        <div class="form-group">
                            <input type="password" class="form-control mb-1" id="current_password"
                                   name="current_password"
                                   placeholder="Current Password" required>
                            <small class="with-errors help-block"></small>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control mb-1" id="password" name="password"
                                   placeholder="New Password" required>
                            <small class="with-errors help-block "></small>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control mb-1" name="confirm_password"
                                   placeholder="Confirm New Password" data-match-error="The passwords must match"
                                   data-match="#password" required>
                            <small class="with-errors help-block text-muted"></small>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col">
                    <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Cancel
                    </button>
                    <button type="submit" form="change_password_form" class="btn btn-success float-right">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="kendoAlert"></div>
<script>
    const DEFAULT_DRAFT_MONTH = `<?php echo DEFAULT_DRAFT_MONTH ?>`;
    const DEFAULT_DRAFT_YEAR = `<?php echo DEFAULT_DRAFT_YEAR ?>`;
    let isPowerUser = Boolean(<?php echo isPowerUser($current_user->user_id) ?>);
    let submissionClosedStatus = {
        nmr: JSON.parse('<?php echo json_encode(getTargetMonthYearClosedStatus('nmr')) ?>'),
        nmr_fr: JSON.parse('<?php echo json_encode(getTargetMonthYearClosedStatus('nmr_fr')) ?>')
    };

    let isSubmissionOpened = function (targetMonth = DEFAULT_DRAFT_MONTH, targetYear = DEFAULT_DRAFT_YEAR, tablePrefix = 'nmr') {
        return !submissionClosedStatus[tablePrefix][`${targetMonth} ${targetYear}`];
    };

    let isSubmissionClosed = function (targetMonth = DEFAULT_DRAFT_MONTH, targetYear = DEFAULT_DRAFT_YEAR, tablePrefix = 'nmr') {
        return submissionClosedStatus[tablePrefix][`${targetMonth} ${targetYear}`];
    };

    //let isSubmissionClosedByPowerUser = Boolean(<?php echo isSubmissionClosedByPowerUser(monthName(monthNumber(now())), year(now())); ?>);
    let currentSubmissionMonth = "<?php echo currentSubmissionMonth() ?>";
    let currentSubmissionYear = "<?php echo currentSubmissionYear() ?>";
    let isITAdmin = Boolean(<?php echo isITAdmin($current_user->user_id); ?>);
    let departments = JSON.parse('<?php echo json_encode(Database::getDbh()->getValue('departments', 'department', null)) ?>')
</script>