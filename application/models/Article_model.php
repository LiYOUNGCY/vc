<?php


class Article_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
	
    /**
     * 把文章的信息插入到数据库
     */
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
        
        return $this->db->insert_id();
    }

    public function get_article_by_id($aid)
    {
        return $this->db->where('id', $aid)->get('article')->row_array();
    }

    /**
     * [get_intro 获取简介]
     * @param  [type] $uid [用户id]
     * @return [type]      [description]
     */
	public function get_intro_by_uid($uid)
    {
        $query = $this->db->where(array('uid' => $uid,'type' => 3))
                          ->get('article')
                          ->row_array();
        return $query;
    }

    /**
     * [get_article_list 获取文章列表]
     * @param  integer $page  [页数]
     * @param  [type]  $meid  [我的id]
     * @param  [type]  $uid   [用户id]
     * @param  [type]  $type  [文章类型]
     * @param  [type]  $tag   [文章标签]
     * @param  integer $limit [页面个数限制]
     * @param  string  $order [排序]
     * @return [type]         [description]
     */
    public function get_article_list($page = 0, $meid = NULL, $uid = NULL, $type = NULL, $tag = NULL, $limit = 6, $order = "id DESC")
    {
        $query = $this->db
            ->select('article.id, article.uid, article.title, article.subtitle, article.content, article.like')
            ->from('article');

        if( is_numeric($meid))
        {
            $query = $query->select('article_like.status');
            $query = $query->join('article_like', "article_like.aid = article.id AND article_like.uid = {$meid}", 'left');
        }
        if( ! empty($uid))
        {
            $query->where('article.uid',$uid);
        }
        if( ! empty($type))
        {
            $query->where('article.type',$type);
        }
        if(! empty($tag))
        {
            $query->where('article.tag',$tag);
        }
        // else
        // {
        //     //$query = $query->join('article_like', 'article_like.aid = article.id', 'left');
        // }

        $query =$query->order_by($order)->limit($limit, $page*$limit)->get()->result_array();

        return $query;
    }

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

    public function get_uid_by_aid($aid)
    {
        $query = $this->select('uid')->where('id', $aid)->get('article')->result_array();
        return count($query) === 1 ? $query[0] : NULL;
    }

    /**
     * 点赞时，文章的 like 加一
     */
    public function argee_article($aid)
    {
    	$table_name = $this->db->protect_identifiers('article', TRUE);
    	$this->db->query("UPDATE {$table_name} SET {$table_name}.`like` = {$table_name}.`like` + 1 WHERE {$table_name}.id = {$aid}");
    }
    
    /**
     * 取消点赞时，文章的 like 减一
     */
    public function disargee_article($aid)
    {
    	$table_name = $this->db->protect_identifiers('article', TRUE);
    	$this->db->query("UPDATE {$table_name} SET {$table_name}.`like` = {$table_name}.`like` - 1 WHERE {$table_name}.id = {$aid} and {$table_name}.`like` > 0");
    }


    public function read_article($aid)
    {
        $table_name = $this->db->protect_identifiers('article', TRUE);
        $this->db->query("UPDATE {$table_name} SET {$table_name}.`read` = {$table_name}.`read` + 1 WHERE {$table_name}.id = {$aid}");
    }
}