<?php


class Sheets extends Controller
{

    public function saveSpreadsheetTemplate()
    {
        $db = Database::getDbh();
        $template = file_get_contents('php://input');
        $description = $_GET['description'];
        /*if ($db->where('description', $description)->has(TABLE_NMR_SPREADSHEET_TEMPLATES)) {
            $db->onDuplicate(['template']);
            $db->insert(TABLE_NMR_SPREADSHEET_TEMPLATES, ['description' => $description, 'template' => $template]);
        }*/
        $db->onDuplicate(['template']);
        $success = $db->insert(TABLE_NMR_SPREADSHEET_TEMPLATES, ['description' => $description, 'template' => $template]);
        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

}