<?php

class Message extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('message_service');
    }

    public function index()
    {
        $query = $this->message_service->system_message(2, 'TEST');

        var_dump($query);
    }
}
