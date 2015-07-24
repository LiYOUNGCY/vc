<?php


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
        
    }

    /**
     * [publish_article 发布文章]
     * @return [type] [description]
     */
    public function publish_article()
    {
        $article_title      = $this->sc->input('article_title');
        $article_subtitle   = $this->sc->input('article_subtitle');
        $article_content    = $this->sc->input('article_content');
        $article_type       = $this->sc->input('article_type');
        $this->user = array();
        $this->user['id'] = 4;
        //把文章插入到数据库
        $result = $article = $this->article_service->publish_article($this->user['id'], $article_title, $article_subtitle, $article_type, $article_content);
        if($result)
        {
            echo 'success';
        }
        else
        {
            $this->error->output('INVALID_REQUEST');
        }
    }
}