<?php

class Publish extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('production_service');
    }


    public function index($type = 'publish', $pid = NULL)
    {
        $head['css'] = array(
            'base.css',
            'font-awesome/css/font-awesome.min.css',
            'alert.css',
            'jquery.Jcrop.css'
        );

        $head['javascript'] = array(
            'jquery.js',
            'error.js',
            'timeago.js',
            'alert.min.js',
            'autosize.js',
            'ajaxfileupload.js'
        );

        $user['user'] = $this->user;
        $data['top'] = $this->load->view('common/top', $user, TRUE);

        if ($type == 'publish') {
            $head['title'] = '发布专题';
            $this->load->view('common/head', $head);
            $this->load->view('publish_topic', $data);
        }
    }
}