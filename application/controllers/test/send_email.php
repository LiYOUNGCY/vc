<?php

class send_email extends CI_Controller
{
    public function index()
    {
        $this->load->library('email');

        $this->email->from('rachechenmu@163.com', 'Rache');
        $this->email->to('544439533@qq.com');
        // $this->email->cc('981533089@qq.com');
        // $this->email->bcc('981533089@qq.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send();

        var_dump($this->email->print_debugger());
    }
}
