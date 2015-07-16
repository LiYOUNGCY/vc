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