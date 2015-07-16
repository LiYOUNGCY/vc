<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/15
 * Time: 22:23
 */
class Article_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function publish_article($user_id, $article_title, $article_subtitle, $article_type, $article_content)
    {
        $data = array(
            'uid'           => $user_id,
            'type'          => $article_type,
            'title'         => $article_title,
            'subtitle'      => $article_subtitle,
            'content'       => $article_content,
            'publish_time'  => date("Y-m-d H:i:s", time())
        );

        $this->db->insert('article', $data);

        if( $this->db->affected_rows() !== 1 )
        {
            return FALSE;
        }

        $data['id'] = $this->db->insert_id();

        return $data;
    }

    public function get_article_by_id($aid)
    {
        return $this->db->where('id', $aid)->get('article')->result_array();
    }
}