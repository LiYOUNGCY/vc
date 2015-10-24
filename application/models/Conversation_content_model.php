<?php

class Conversation_content_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * [get_conversation_content 获取对话内容].
     *
     * @param int    $page  [页数]
     * @param [type] $cid   [对话id]
     * @param int    $limit [页面个数限制]
     * @param string $order [排序]
     *
     * @return [type] [description]
     */
    public function get_conversation_content($page = 0, $cid, $limit = 20, $order = 'id DESC')
    {
        $query = $this->db->where('cid', $cid)
                          ->order_by($order)
                          ->limit($limit, $page * $limit)
                          ->get('conversation_content')
                          ->result_array();

        return $query;
    }

    /**
     * [insert_conversation_content 添加对话内容].
     *
     * @param [type] $cid        [对话id]
     * @param [type] $sender_id  [发送者id]
     * @param [type] $reciver_id [接收者id]
     * @param [type] $content    [对话内容]
     *
     * @return [type] [description]
     */
    public function insert_conversation_content($cid, $sender_id, $reciver_id, $content)
    {
        $arr = array(
            'cid' => $cid,
            'sender_id' => $sender_id,
            'reciver_id' => $reciver_id,
            'content' => $content,
            'publish_time' => date('Y-m-d H:i:s', time()),
        );
        $this->db->insert('conversation_content', $arr);

        return $this->db->affected_rows() === 1;
    }
}
