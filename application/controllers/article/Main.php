<?php


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
    public function get_article_list()
    {
        //获得页数
        $page = $this->sc->input('page');

        $uid  = isset($this->user['id']) ? $this->user['id'] : -1;
        //文章标签类型
        $tag = $this->sc->input('tag');

        $article = $this->article_service->get_article_list($page,$uid,'article',$tag);
        echo json_encode($article);
    }

    
    public function index()
    {
        $this->load->view('main');
    }
}