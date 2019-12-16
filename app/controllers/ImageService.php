<?php

class ImageService extends Controller
{
    public function read(): void
    {
        echo readFileMetaData(IMAGE_UPLOAD_PATH . "/" . getUserSession()->staff_id . '/' .$_POST['path']);
    }

    public function upload(): void
    {
        $staff_id = getUserSession()->staff_id;
        $path = $_POST['path'] ?  IMAGE_UPLOAD_PATH . "/$staff_id" . '/'. $_POST['path'] : IMAGE_UPLOAD_PATH . "/$staff_id";
        if ($file = uploadFile($path)) {
            if ($file->completed) {
                createThumbnail($path . '/' . $file->getClientFileName());
                echo json_encode(['name' => $file->getClientFileName(), 'type' => 'f', 'size' => $file->getSize(), 'path' => $_POST['path']]);
            }
        }
    }

    public function thumbnailService()
    {
        $current_user = getUserSession();
        $image_file_name = isset($_GET['i']) ? $_GET['i'] : '';
        $image_file_name = THUMBNAIL_PATH . "/$current_user->staff_id/" . $image_file_name;
        sendFile($image_file_name);
    }

    public function images()
    {
        $current_user = getUserSession();
        $file_name = isset($_GET['i']) ? $_GET['i'] : '';
        $file_name = IMAGE_UPLOAD_PATH . "/$current_user->staff_id/" . $file_name;
        sendFile($file_name);
    }
}
