<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/17
 * Time: 14:01
 */
class Article_comment_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 插入文章的评论
     * @param $aid
     * @param $uid
     * @param $content
     * @return mixed
     */
    public function article_comment_model($aid, $uid, $content)
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
}