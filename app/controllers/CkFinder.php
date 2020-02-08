<?php


class CkFinder extends Controller
{

    public function index() : void
    {
        require_once APP_ROOT . '../ckfinder/core/connector/php/connector.php';
    }

    public function browse()
    {
       require_once APP_ROOT . '../ckfinder/ckfinder.html';
    }

    public function get($type, $folder, $file_name)
    {
        //$file_name = isset($_GET['f']) ? $_GET['f'] : '';
        $file_name = FILE_UPLOAD_PATH . "/" . uniqueId() . "/" . $file_name;
        sendFile($file_name);
    }

    public function upload()
    {
        $command = $_GET['command'];
        $type = $_GET['type'];
    }

    public function samples()
    {
        require_once APP_ROOT . '../ckfinder/samples/index.html';
    }
}