<?php

class Notification extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('message_service');
    }

    public function SystemMessage()
    {
        //获取文章列表
        $user['user'] = $this->user;
        $navbar = $this->load->view('admin/common/navbar', $user, true);

        $foot = $this->load->view('admin/common/foot', '', true);

        $history = $this->message_service->get_system_message_by_user($this->user['id'], null);

        //页面数据
        $body = array(
            'navbar' => $navbar,
            'foot' => $foot,
            'history' => $history
        );
        $this->load->view('admin/common/head');
        $this->load->view('admin/notification/system_message', $body);
    }

    public function send_system_message()
    {
        $user_id = $this->user['id'];
        $message_text = $this->sc->input('message');

        $query = $this->message_service->system_message($user_id, $message_text);

        if ($query) {
            redirect(base_url() . ADMINROUTE . 'notification/SystemMessage');
        } else {
            echo '发送失败';
        }
    }
}