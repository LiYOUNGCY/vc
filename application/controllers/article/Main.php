<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/15
 * Time: 12:07
 */
class Main extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');
        $this->load->service('feed_service');
        $this->load->service('article_like_service');
    }


    /**
     * 发布文章
     */
    public function publish()
    {
        $article_title      = $this->sc->input('title');
        $article_subtitle   = $this->sc->input('subtitle');
        $article_content    = $this->sc->input('content');
        $article_type       = $this->sc->input('type');

        //把文章插入到数据库
        $article = $this->article_service->publish_article($this->user['id'], $article_title, $article_subtitle, $article_type, $article_content);

        if( $article === FALSE ) {
            echo 'fault';
            return ;
        }

        //更新动态表
        $this->feed_service->insert_feed($this->user['id'], $article['id'], $article['title'], $article['subtitle'], $article['content']);
    }


    /**
     * 为文章点赞
     */
    public function article_vote()
    {
        //获得点赞的人的 id 和文章id
        $aid = $this->sc->input('aid');
        $uid = $this->user['id'];

        $this->article_like_service->article_vote($aid, $uid);
    }
}