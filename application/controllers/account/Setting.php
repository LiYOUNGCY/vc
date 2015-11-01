<?php

class Setting extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('user_service');
        $this->load->service('auth_service');
    }

    public function index($type = 'user')
    {
        $data['css'] = array(
            'font-awesome/css/font-awesome.min.css',
            'base.css',
            'alert.css',
            'radiocheck.min.css',
        );

        $data['javascript'] = array(
            'jquery.js',
            'alert.min.js',
            'error.js',
            'geo.js',
            'ajaxfileupload.js',
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', true);
        $body = array();

        $body['top'] = $this->load->view('common/top', $user, true);
        $body['footer'] = $this->load->view('common/footer', '', true);


        $body['user'] = $this->user_service->get_user_by_id($this->user['id']);
//        $body['user']         = $this->user;


        if ($type == 'safe') {
            //修改密码
            $data['title'] = '安全设置';
            $this->load->view('common/head', $data);
            $this->load->view('safe', $body);
        }
        //修改个人信息的页面
        elseif ($type == 'user') {
            $data['title'] = '账户设置';
            $body['address'] = $this->user_service->get_address($this->user['id']);
            $this->load->view('common/head', $data);
            $this->load->view('setting', $body);
//            echo json_encode($body);
        }

    }

    /**
     * [change_password 修改密码].
     *
     * @return [type] [description]
     */
    public function change_password()
    {
        $old_pwd = $this->sc->input('old_pwd');
        $pwd = $this->sc->input('pwd');

        $result = $this->user_service->change_password($this->user['id'], $old_pwd, $pwd);

        if ($result) {
            echo "<script>alert('".lang('OPERATE_SUCCESS')."');window.location.href='".base_url()."setting/pwd';</script>";
        } else {
            $this->error->output('INVALID_REQUEST');
        }
    }

    public function change_phone()
    {
        $phone = $this->sc->input('phone');
        $id = $this->user['id'];

        $result = $this->user_service->change_phone($id, $phone);

        if ($result) {
            $this->sc->output_success();
        } else {
            $this->sc->output_error();
        }
    }

    public function change_name()
    {
        $name = $this->sc->input('name');
        $user_id = $this->user['id'];

        $result = $this->user_service->change_name($user_id, $name);

        if($result) {
            $this->message->success();
        }

        $this->message->error($name. $user_id);
    }

    public function change_headpic()
    {
        $this->load->service('image_service');

        $user_id = $this->user['id'];
        $result = $this->image_service->upload_headpic('upfile', $user_id);

        //save by database
        $this->user_service->change_headpic($user_id, base_url().$result['filepath']);

        header('Content-Type:application/json');
        echo json_encode($result);
    }
}
