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
}