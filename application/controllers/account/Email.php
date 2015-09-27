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
    }
}
