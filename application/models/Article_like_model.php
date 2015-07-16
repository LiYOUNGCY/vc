<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/15
 * Time: 21:56
 */
class Article_like_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function article_vote($aid, $uid)
    {
        $query = $this->get_article_vote_by_both($aid, $uid);

        $data = array(
            'aid'           => $aid,
            'uid'           => $uid,
            'status'        => 1,
            'update_time'   => date("Y-m-d H:i:s", time())
        );

        if(! isset($query) ) {
            $this->db->insert('article_like', $data);
            return $this->db->affected_rows() === 1;
        }
        elseif( count($query) ) {
            $status = !$query[0]['status'];
            $this->db->where('aid', $aid)
                ->where('uid', $uid)
                ->update('article_like', array('status' => $status, 'update_time' => date("Y-m-d H:i:s", time())));

            return $status;
        }

        return FALSE;
    }

    public function get_article_vote_by_both($aid, $uid)
    {
        return $this->db->where('aid', $aid)->where('uid', $uid)->get('article_like')->result_array();
    }
}