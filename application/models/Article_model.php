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
        return $this->db->where('id', $aid)->get('article')->row_array();
    }


    /**
     * [get_article_list 获取文章列表]
     * @param  integer $page  [页数]
     * @param  integer $uid   [用户id]
     * @param  [type]  $type  [文章类型(文章,展览)]
     * @param  integer $limit [页面个数限制]
     * @param  string  $order [排序]
     * @return [type]         [description]
     */
    public function get_article_list($page = 0, $uid = -1, $type, $limit = 6, $order = "id desc")
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

        $query =$query->order_by($order)->limit($limit, $page*$limit)->get()->result_array();


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

    /**
     * [update_count 更新文章字段数量]
     * @param  array  $field [字段(格式:array('name'=>'like','amount'=>1))]
     * @return [type]        [description]
     */
    public function update_count($aid,$field = array()){
        $where = array('id' => $aid);
        $query = $this->db->select($field['name'])
                          ->from('article')
                          ->where($where)
                          ->get()
                          ->row_array();
                          
        if(!empty($query)){
            $query[$field['name']]=(int)$query[$field['name']]+(int)$field['amount'];     
            $this->db->where($where)->update('article',$query);
            return $this->db->affected_rows() === 1;
        }
        else{
            return FALSE;
        }
    }    
}