<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/15
 * Time: 12:07
 */
class Publish extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');
    }

    /**
     * 发布文章
     */
    public function index()
    {
        $article_title      = $this->sc->input('title');
        $article_subtitle   = $this->sc->input('subtitle');
        $article_content    = $this->sc->input('content');
        $article_type       = $this->sc->input('type');
        $this->user = array();
        $this->user['id'] = 4;
        //把文章插入到数据库
        $article = $this->article_service->publish_article($this->user['id'], $article_title, $article_subtitle, $article_type, $article_content);     
    }
}