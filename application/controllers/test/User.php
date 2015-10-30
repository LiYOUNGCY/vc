<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('transport_model');
    }

    public function index()
    {
        $query = $this->transport_model->get_transport_list_by_range(NOT_IN_GUANGZHUO);

        echo json_encode($query);
    }

    public function check_email()
    {
        $data['title'] = 'check_email';
        $this->load->view('test/user/check_email_view', $data);
    }

    public function check_phone()
    {
        $data['title'] = 'check_phone';
        $this->load->view('test/user/check_phone_view', $data);
    }

    public function check_email_action()
    {
        $email = $this->sc->input('email');
        $query = $this->user_model->check_email($email);
        echo $query;
    }

    public function check_phone_action()
    {
        $phone = $this->sc->input('phone');
        $query = $this->user_model->check_phone($phone);
        echo $query;
    }

    public function register()
    {
        $data['title'] = 'register';
        $this->load->view('test/user/register_view', $data);
    }

    public function login()
    {
        $data['title'] = 'Login';
        $this->load->view('test/user/login_view', $data);
    }

}
