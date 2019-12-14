<?php

use Intervention\Image\Facades\Image;

class FileService extends Controller
{
    public function read(): void
    {
        $path = isset($_POST['path']) ? $_POST['path'] : '';
        echo readFileMetaData(FILE_UPLOAD_PATH . "/" . getUserSession()->staff_id . "/" . $path);
    }

    public function upload(): void
    {
        $current_user_file_upload_path = FILE_UPLOAD_PATH . '/' . getUserSession()->staff_id;
        $path = $_POST['path'] ? $current_user_file_upload_path . '/' .  $_POST['path'] : $current_user_file_upload_path;
        $file = uploadFile($path);
        if ($file->completed) {
            $file_meta_data = ['name' => $file->getClientFileName(), 'type' => 'f', 'size' => $file->getSize(), 'path' => $_POST['path']];
            echo json_encode($file_meta_data);
        }
    }

    public function files()
    {
        $current_user = getUserSession();
        $file_name = isset($_GET['f']) ? $_GET['f'] : '';
        $file_name = FILE_UPLOAD_PATH . "/$current_user->staff_id/" . $file_name;
        sendFile($file_name);
    }

    public function createDirectory()
    {
        $current_user = getUserSession();
        $path = $_POST['path'] ? '/' . $_POST['path'] . $_POST['name'] : '/' . $_POST['name'];
        $upload_path = FILE_UPLOAD_PATH . "/" . $current_user->staff_id . $path;
        if (mkdir($upload_path, 0777, true)) {
            echo json_encode(['name' => $_POST['name'], 'type' => 'd', 'path' => $_POST['path']]);
        } else {
            echo json_encode(['success' => mkdir($upload_path)]);
        }
    }
}
