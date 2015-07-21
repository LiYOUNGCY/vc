<?php

class Feed_service extends MY_Service {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('feed_model');
        $this->load->model('user_model');
        $this->load->model('article_model');
    }

 
    /**
     * [get_feed_list 获取动态列表]
     * @param  [type] $page [页数]
     * @param  [type] $uid [用户id]
     * @return [type]       [description]
     */
    public function get_feed_list($page = 0, $uid, $limit = 10, $order = 'id DESC')
    {
       //获取用户关注列表
       $uids = $this->user_model->get_user_follow(0,$uid,NULL);
       $count= empty($uids) ? 0 : count($uids);
       $uids[$count]['follow'] = $uid;      

       $new_uids = array();
       if( ! empty($uids))
       {
           foreach ($uids as $k => $v) {
                array_push($new_uids,$v['follow']);
           }
       }

       //获取动态列表
       $feed = $this->feed_model->get_feed_list($page,$new_uids,$limit,$order);

       foreach ($feed as $k => $v) {
            $feed[$k]['user']  = $this->user_model->get_user_by_id($v['uid']);   
            $content = (array)json_decode($v['content']);
            //点赞
            if($v['type'] == 1)
            {
                $feed[$k]['author'] = $this->user_model->get_user_by_id($content['article_id']);
            }
            //发布
            else if($v['type'] == 2)
            {
                //获取点赞列表与点赞用户信息
                $vote = $this->article_model->get_article_vote($content['article_id']);
                foreach ($vote as $k1 => $v1) {
                    $feed[$k]['like'][$v1['uid']] = $this->user_model->get_user_by_id($v1['uid']);
                }
            }
       }
       return $feed;
    }
    

	/**
	 * 插入文章类的动态
	 */
    public function insert_article_feed($uid, $cid, $content)
    {
    	$this->feed_model->insert_feed($uid, $cid, 2, $content);
    }

    /**
     * [delete_article_feed 删除文章类的动态]
     */
    public function delete_article_feed($uid, $cid)
    {
      $this->feed_model->delete_feed($uid, $cid, 2);
    }
    
    
    /**
     * 插入点赞类的动态
     */
    public function insert_vote_feed($uid, $cid, $content)
    {
    	$this->feed_model->insert_feed($uid, $cid, 1, $content);
    }

    /**
     * [delete_vote_feed 删除点赞类的动态]
     */
    public function delete_vote_feed($uid, $cid)
    {
      $this->feed_model->delete_feed($uid, $cid, 1);
    }
}