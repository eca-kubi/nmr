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
<div id="kendoAlert"></div>
<script>
    let isPowerUser = Boolean(<?php echo isPowerUser($current_user->user_id) ?>);
    let isSubmissionOpened = Boolean(<?php echo isSubmissionOpened(); ?>);
    let isSubmissionClosedByPowerUser = Boolean(<?php echo isSubmissionClosedByPowerUser(monthName(monthNumber(now())), year(now())); ?>);
    let currentSubmissionMonth = "<?php echo currentSubmissionMonth() ?>";
    let currentSubmissionYear = "<?php echo currentSubmissionYear() ?>";
    let isITAdmin = Boolean(<?php echo isITAdmin($current_user->user_id); ?>);
    let departments = JSON.parse('<?php echo json_encode(Database::getDbh()->getValue('departments', 'department', null)) ?>')
</script>