<?php

class Feed_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_feed($user_id, $type, $content)
    {
        $data = array(
            'uid'       => $user_id,
            'type'      => $type,
            'content'   => $content,
            'publish'   => date('y-m-d h:i:s',time())
        );

        $this->db->insert('feed', $data);
        return $this->db->affected_rows() === 1 ? $this->db->insert_id() : FALSE;
    }
}