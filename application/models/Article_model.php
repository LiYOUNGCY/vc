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


    /**
     * 取文章列表，每页默认6条
     * uid 查看某人对文章是否点赞
     * @param int $page
     * @param int $uid
     * @param int $limit
     * @param string $order
     * @return mixed
     */
    public function get_article_list($page = 0, $uid = -1, $limit = 6, $order = "desc")
    {
        $query = $this->db
            ->select('article.id, article.uid, article.title, article.content, article.like, article_like.status')
            ->from('article');

        if( is_numeric($uid) && $uid != -1)
        {
            $query = $query->join('article_like', "article_like.aid = article.id AND article_like.uid = {$uid}", 'left');
        }
        else
        {
            $query = $query->join('article_like', 'article_like.aid = article.id', 'left');
        }

        $query =$query->order_by('publish_time', $order)->limit($limit, $page*$limit)->get()->result_array();


        //Test
        foreach( $query as $key => $value)
        {
//            $query[$key]['content'] = htmlentities($query[$key]['content']);
            $query[$key]['author'] = $this->db
                ->select('user.id, user.name, user.role, user.alias')
                ->where('id', $query[$key]['uid'])
                ->get('user')
                ->result_array()[0];
        }

        return $query;
    }
}