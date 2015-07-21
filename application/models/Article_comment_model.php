<?php


class Article_comment_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 新增评论
     * @param $aid
     * @param $uid
     * @param $content
     * @return mixed
     */
    public function insert_comment($aid, $uid, $content)
    {
        $data = array(
            'aid'           => $aid,
            'uid'           => $uid,
            'content'       => $content,
            'publish_time'  => date("Y-m-d H:i:s", time())
        );

        $this->db->insert('article_comment', $data);
        return $this->db->insert_id();
    }

    public function get_comment_by_aid($aid)
    {
        return $this->db->where('aid', $aid)->get('article_comment')->result_array();
    }
}