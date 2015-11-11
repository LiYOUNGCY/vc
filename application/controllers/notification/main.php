<?php

class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('notification_service');
    }

    /**
     * [index 显示消息列表].
     *
     * @return [type] [description]
     */
    public function index($type = 'systemmsg')
    {
        if (!is_string($type)) {
            show_404();
        }

        $data['css'] = array(
            'swiper.min.css',
            'font-awesome/css/font-awesome.min.css',
            'base.css',
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'error.js',
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', true);

        $data['title'] = '我的消息 - 用户中心';
        $body['top'] = $this->load->view('common/top', $user, true);
        $body['footer'] = $this->load->view('common/footer', '', true);
        $body['user'] = $this->user;

        $this->load->view('common/head', $data);
        if (strcmp($type, 'systemmsg') == 0) {
            $this->load->view('systemmsg', $body);
        } elseif (strcmp($type, 'goodsmsg') == 0) {
            $this->load->view('goodsmsg', $body);
        }
    }

    public function get_system_message()
    {
        $user_id = $this->user['id'];
        $page = $this->sc->input('page');

        $query = $this->message_service->get_system_message_by_user($user_id, $page);

        if(empty($query)) {
            $this->message->error();
        }

        echo json_encode($query);
    }

    public function get_goods_message()
    {
        $user_id = $this->user['id'];
        $page = $this->sc->input('page');

        $query = $this->message_service->get_goods_message_by_user($user_id, $page);

        if(empty($query)) {
            $this->message->error();
        }

        echo json_encode($query);
    }
}
