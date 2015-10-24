<?php

class Message_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private function _insert_message($sender_id, $message_text, $reply_to_message_id = 0)
    {
        $data = array(
            'send_datetime' => date('Y-m-d H:i:s'),
            'message_text' => $message_text,
            'sender_user_id' => $sender_id,
            'reply_to_message_id' => $reply_to_message_id,
        );

        $this->db->insert('message', $data);

        return $this->db->insert_id();
    }

    public function send_message_to_all_users($sender_id, $message_text)
    {
        $message_id = $this->_insert_message($sender_id, $message_text);

        if (empty($message_id)) {
            return false;
        }

        $message_tabel = $this->db->protect_identifiers('message_recipient', true);
        $user_tabel = $this->db->protect_identifiers('user', true);

        $this->db->query("INSERT INTO {$message_tabel} SELECT {$message_id}, {$user_tabel}.id, 0, 0 FROM {$user_tabel}");

        return $this->db->affected_rows() > 0;
    }
}
