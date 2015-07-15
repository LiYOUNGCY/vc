<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/15
 * Time: 12:07
 */
class Article extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');
    }

    public function publish()
    {
        $article_title      = $this->sc->input('title');
        $article_subtitle   = $this->sc->input('subtitle');
        $article_content    = $this->sc->input('content');
        $article_type       = $this->sc->input('type');

        $this->article_service->publish_article($this->user['id'], $article_title, $article_subtitle, $article_type, $article_content);
    }

    public function article_vote()
    {
        //获得点赞的人的 id 和文章id
        $aid = $this->sc->input('aid');
        $uid = $this->sc->input('uid');

        $this->article_service->article_vote($aid, $uid);
    }

    public function test()
    {

        $string = $this->load->file(APPPATH.'test.html', true);
        $ret = $this->article_service->_extract_first_img($string);
        echo htmlentities($ret);
    }
}