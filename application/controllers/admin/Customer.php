<?php

class Customer extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $head['javascript'] = array(
            'perfect-scrollbar.jquery.min.js',
        );
        $head['css'] = array(
            'style.css',
            'perfect-scrollbar.min.css',
        );

        $body['user'] = $this->user;

        $this->load->view('admin/common/head', $head);
        $this->load->view('admin/conversation/customer', $body);
    }
}
