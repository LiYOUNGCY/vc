<?php

class Message_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private function _insert_message($sender_id, $message_text, $message_level, $reply_to_message_id = 0)
    {
        $data = array(
            'send_datetime' => date('Y-m-d H:i:s'),
            'message_text' => $message_text,
            'sender_user_id' => $sender_id,
            'reply_to_message_id' => $reply_to_message_id,
            'message_level' => $message_level
        );

        $this->db->insert('message', $data);

        return $this->db->insert_id();
    }

    public function send_message_to_all_users($sender_id, $message_text, $message_level)
    {
        $message_id = $this->_insert_message($sender_id, $message_text, $message_level);

        if (empty($message_id)) {
            return false;
        }

        $message_tabel = $this->db->protect_identifiers('message_recipient', true);
        $user_tabel = $this->db->protect_identifiers('user', true);

        $this->db->query("INSERT INTO {$message_tabel} SELECT {$message_id}, {$user_tabel}.id, 0, 0 FROM {$user_tabel}");

        return $this->db->affected_rows() > 0;
    }

    public function send_message_to_user($sender_id, $receiver_id, $message_text, $message_level)
    {
        $message_id = $this->_insert_message($sender_id, $message_text, $message_level);

        if (empty($message_id)) {
            return false;
        }

        $data = array(
            'message_id' => $message_id,
            'user_id' => $receiver_id
        );

        $this->db->insert('message_recipient', $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_message_by_user($user_id, $message_level, $page)
    {
        //每页10条消息
        $limit = 10;

        $query = $this->db
            ->select('message.message_text as content, message.send_datetime as publish_time, message_recipient.message_id')
            ->from('message, message_recipient')
            ->where('message.id = message_recipient.message_id')
            ->where('message_recipient.recipient_keep', 0)
            ->where('message_recipient.user_id', $user_id)
            ->where('message.message_level', $message_level)
            ->order_by('message_recipient.message_id DESC');

        if (!empty($page) && is_numeric($page)) {
            $query = $query->limit($limit, $page * $limit);
        }

        $query = $query->get()
            ->result_array();

        return $query;
    }
}
