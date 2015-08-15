<?php

class Email extends MY_Controller 
{
    function __construct()
    {
        parent::__construct();  
        $this->load->service('user_service');
    }

    function active()
    {
        $token = $this->sc->input('token', 'get');

        $result = $this->user_service->active_email($token);

        if($result != FALSE)
        {
            echo 'success';
        }
        else
        {
            echo 'fail';
        }
    }

    function test()
    {
        $this->user_service->validate_email(1, '981533089@qq.com');
        echo 'send email';
    }
}