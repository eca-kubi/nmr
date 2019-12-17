<?php

class ImageService extends Controller
{
    public function read(): void
    {
        echo readFileMetaData(IMAGE_UPLOAD_PATH . "/" . uniqueId(). '/' .$_POST['path']);
    }

    public function upload(): void
    {
        $path = $_POST['path'] ?  IMAGE_UPLOAD_PATH . "/" . uniqueId() . '/'. $_POST['path'] : IMAGE_UPLOAD_PATH . "/" . uniqueId();
        if ($file = uploadFile($path)) {
            if ($file->completed) {
                createThumbnail($path . '/' . $file->getClientFileName());
                echo json_encode(['name' => $file->getClientFileName(), 'type' => 'f', 'size' => $file->getSize(), 'path' => $_POST['path']]);
            }
        }
    }

    public function thumbnailService()
    {
        $image_file_name = isset($_GET['i']) ? $_GET['i'] : '';
        $image_file_name = THUMBNAIL_PATH . "/" . uniqueId() . "/" . $image_file_name;
        sendFile($image_file_name);
    }

    public function images()
    {
        $current_user = getUserSession();
        $file_name = isset($_GET['i']) ? $_GET['i'] : '';
        $file_name = IMAGE_UPLOAD_PATH . "/" . uniqueId() . "/" . $file_name;
        sendFile($file_name);
    }
}
