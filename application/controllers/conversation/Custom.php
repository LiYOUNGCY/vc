<?php

class Custom extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('conversation_service');
    }

    public function index($type = 'list')
    {
        //客服列表
        if ($type == 'list') {
        }
        //最近客服消息
        elseif ($type == 'latest') {
        }
    }

    /**
     * [get_custom_service_list 获取客服列表].
     *
     * @return [type] [description]
     */
    public function get_custom_service_list()
    {
        $custom = $this->conversation_service->get_custom_service_list();
        echo json_encode($custom);
    }

    /**
     * [get_latest_conversation 获取最近客服消息].
     *
     * @return [type] [description]
     */
    public function get_latest_conversation()
    {
        $page = $this->sc->input('page');
        $latest = $this->conversation_service->get_latest_list($page, $this->user['id']);
        echo json_encode($latest);
    }

    /**
     * 保存对话信息.
     */
    public function send_message_by_user()
    {
        $data = array(
            'sender',
            'cid',
            'uid',
            'msg',
            'time',
        );

        $data = $this->sc->input($data);

        $query = $this->conversation_service->insert_message($data);
        if (isset($query)) {
            $result = array('success' => 0);
            echo json_encode($result);
        }
    }

    /**
     * 获取历史消息.
     */
    public function get_history_by_user()
    {
        $uid = $this->sc->input('uid');

        $message = $this->conversation_service->get_histroy_by_user($uid);

        echo json_encode($message);
    }
}
