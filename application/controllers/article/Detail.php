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

    public function article_vote()
    {
        $aid = $this->sc->input('aid');
        $this->user = array();
        $this->user['id'] = 4;        
        $vote_result = $this->article_service->article_vote($aid, $this->user['id']);
        if( ! empty($vote_result))
        {
            echo "success";            
            if($vote_result['status'] == 1)
            {
                $this->article_service->update_count($aid,'like',1);             
            }
            else
            {
                $this->article_service->update_count($aid,'like',-1);                
            }
            if( $vote_result['type'] == 0)
            {               
                $article = $this->article_service->get_article_by_id($aid);
                $feed_result = $this->feed_service->insert_vote_feed($this->user['id'], $article['id'], $article['uid'], $article['title'], $article['subtitle'], $article['content']);
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
            show_404();
        }

        //获取文章信息
        $article = $this->article_service->get_article_by_id($aid);
        
        if($article == FALSE) 
        {
        	show_404();
        }

        //获取文章评论
        $comment = $this->article_service->get_comment_by_aid($aid);

        // $article['like_people'] = $this->article_service->get_user_by_aid($aid);

        // if( isset($article['like_people']) ) {
        //     foreach( $article['like_people'] as $key => $value ) {
        //         $article['like_people'][$key] = $this->user_service->get_user_by_id($article['like_people'][$key]['uid']);
        //     }
        // }
        
        $data['article'] = $article;
        $data['comment'] = $comment;

        $this->load->view('article_detail', $data);
    }

    public function insert_article_comment()
    {
        $aid    = $this->sc->input('$aid');
        $uid    = $this->user['id'];
        $comment = $this->sc->input('content');

        $article_user_id = $this->article_service->get_uid_by_aid($aid);
        if($article_user_id === NULL)
        {
            echo 'no article user';
            exit();
        }

        $comment_id = $this->article_service->insert_article_comment($aid, $uid, $comment);

        $content   = array('content_id' => $comment_id, 'content_type' => 'article','comment_content' => $comment);
        $this->notification_service->insert($uid, $article_user_id, 2,$content);
    }
}