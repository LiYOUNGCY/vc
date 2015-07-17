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
    }

    /**
     * [get_article_list 获取文章列表]
     * @param $[type] [文章类型]
     * @return [type] [description]
     */
    public function get_article_list($type = 'article')
    {
        //获得页数
        $page = $this->sc->input('page');
        $uid  = isset($this->user['id']) ? $this->user['id'] : -1;
        $article = $this->article_service->get_article_list($page,$uid,$type);
        if( ! empty($article))
        {
            var_dump($article);
        }
        else
        {
            echo "failed";
        }
    }
}