<?php

class Feed_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_feed($uid, $cid, $type, $content)
    {
    	if( is_array($content) ) {
    		$content = json_encode($content);
    	}
        $data = array(
            'uid'       => $uid,
            'cid'       => $cid,
            'type'      => $type,
            'content'   => $content,
            'publish_time'   => date('y-m-d h:i:s',time())
        );

        $this->db->insert('feed', $data);
        return $this->db->affected_rows() === 1 ? $this->db->insert_id() : FALSE;
    }

    public function delete_feed($uid, $cid, $type)
    {
        $data = array(
                'uid'   => $uid,
                'cid'   => $cid,
                'type'  => $type
            );
        $this->db->delete('feed', $data);
        return $this->db->affected_rows() === 1;
    }
}