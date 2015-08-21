<?php


class Article_comment_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 新增评论
     */
    public function insert_comment($aid, $uid, $pid, $content)
    {
        $data = array(
            'aid'           => $aid,
            'uid'           => $uid,
            'pid'           => $pid,
            'content'       => $content,
            'publish_time'  => date("Y-m-d H:i:s", time())
        );

        $this->db->insert('article_comment', $data);
        return $this->db->insert_id();
    }
    
    /**
     * 根据id获取评论详情
     * @return [type]
     */
    public function get_comment_by_id($id)
    {
        return $this->db->where('id',$id)
                        ->get('article_comment')
                        ->row_array();
    }   

    public function get_comment_by_aid($aid,$order = 'publish_time DESC')
    {
        return $this->db->where('aid', $aid)
                        ->order_by($order)
                        ->get('article_comment')
                        ->result_array();
    }

    public function delete_comment_by_aid($aid)
    {
        $this->db->delete('article_comment',array('aid' => $aid));
        return $this->db->affected_rows() > 0;
    }    
}