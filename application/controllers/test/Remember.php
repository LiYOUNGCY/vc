<?php


class Remember extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo 'Remember ME TEST', '<br/>';
        var_dump($_SESSION);
    }
}
