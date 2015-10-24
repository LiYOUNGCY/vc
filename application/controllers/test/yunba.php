<?php

class yunba extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $this->load->view('test/yunba');
    }

    public function push()
    {
        $this->load->library('Push');
        $json = array('a' => '222','b' => '123');
        $json = json_encode($json);
        $this->push->push_to_topic('12345', $json);
    }
}
