<?php
function init () {
    // Perform checks here and there
    try {
        $db = Database::getDbh();
        if (!$db->where("(target_month =? and target_year = ?)", [DEFAULT_DRAFT_MONTH, DEFAULT_DRAFT_YEAR])->has('nmr_target_month_year')) {
            $db->insert('nmr_target_month_year', ['target_month' => DEFAULT_DRAFT_MONTH, 'target_year' => DEFAULT_DRAFT_YEAR]);
        }

        if (!$db->where("(target_month =? and target_year = ?)", [DEFAULT_DRAFT_MONTH, DEFAULT_DRAFT_YEAR])->has('nmr_fr_target_month_year')) {
            $db->insert('nmr_fr_target_month_year', ['target_month' => DEFAULT_DRAFT_MONTH, 'target_year' => DEFAULT_DRAFT_YEAR]);
        }
        $db->where('prop', 'nmr_current_submission_month')->update('settings', ['value' => DEFAULT_DRAFT_MONTH]);
        $db->where('prop', 'nmr_current_submission_year')->update('settings', ['value' => DEFAULT_DRAFT_YEAR]);

    } catch (Exception $e) {
    }
}

init();

