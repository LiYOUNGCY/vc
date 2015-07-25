<?php

class Feed_service extends MY_Service {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('feed_model');
        $this->load->model('user_model');
        $this->load->model('user_follow_model');        
        $this->load->model('article_like_model');
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
       $uids = $this->user_follow_model->get_user_follow(0,$uid,NULL);
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
            $feed[$k]['user']  = $this->user_model->get_user_base_id($v['uid']);   
            $content = (array)json_decode($v['content']);
            //点赞
            if($v['type'] == 1)
            {
                $feed[$k]['author'] = $this->user_model->get_user_base_id($content['article_id']);
            }
            //发布
            else if($v['type'] == 2)
            {
                //获取点赞列表与点赞用户信息
                $vote = $this->article_like_model->get_vote_person_by_aid($content['article_id']);
                $feed[$k]['like'] = array();
                foreach ($vote as $k1 => $v1) {
                    array_push($feed[$k]['like'], $this->user_model->get_user_base_id($v1['uid']));
                }
            }
       }
       return $feed;
    }
}