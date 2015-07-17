<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/16
 * Time: 14:59
 */
class Detail extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');
        $this->load->service('feed_service');   
        $this->load->service('notification_service');
        $this->load->service('user_service');
    }

    /**
     * [article_vote 文章点赞或取消]
     * @return [type] [description]
     */
    public function article_vote()
    {
        //获得文章id
        $aid = $this->sc->input('aid');
        $vote_result = $this->article_service->article_vote($aid, $this->user['id']);
        if(!empty($vote_result))
        {
            echo "success";            
            if($vote_result['status'] == 1)
            {
                //增加文章点赞数
                $this->article_service->update_count($aid,'like',1);             
            }
            else
            {
                //减少文章点赞数
                $this->article_service->update_count($aid,'like',-1);                
            }
            //首次点赞
            if( $vote_result['type'] == 0)
            {
                //添加点赞动态                
                $article = $this->article_service->get_article_by_id($aid);
                $feed_result = $this->feed_service->insert_vote_feed($this->user['id'], $article['id'], $article['uid'], $article['title'], $article['subtitle'], $article['content']);
                //添加点赞消息
                $content = array('content_id' => $article['id'], 'content_type' => 'article');
                $notification_result = $this->notification_service->insert($this->user['id'],$article['uid'],3,$content);               
            }
        }
        else
        {
            echo "failed";
        }
    }


    public function index($aid)
    {
        if(! is_numeric($aid))
        {
            //不是数字,错误!!
            exit();
        }

        $article = $this->article_service->get_article_by_id($aid);

        //获取点赞的人的列表的 uid
        $article['like_people'] = $this->article_service->get_user_by_aid($aid);

        //将 uid 转换为对应的参数
        if( isset($article['like_people']) ) {
            foreach( $article['like_people'] as $key => $value ) {
                $article['like_people'][$key] = $this->user_service->get_user_by_id($article['like_people'][$key]['uid']);
            }
        }

        echo json_encode($article);
    }

    public function insert_article_comment()
    {
        $aid    = $this->sc->input('$aid');
        $uid    = $this->user['id'];
        $comment = $this->sc->input('content');

        //首先，找下有没有这一篇文章
        $article_user_id = $this->article_service->get_uid_by_aid($aid);
        if($article_user_id === NULL)
        {
            //错误
            echo 'no article user';
            exit();
        }

        $comment_id = $this->article_service->insert_article_comment($aid, $uid, $comment);

        $content   = array('content_id' => $comment_id, 'content_type' => 'article','comment_content' => $comment);
        $this->notification_service->insert($uid, $article_user_id, 2,$content);
    }
}