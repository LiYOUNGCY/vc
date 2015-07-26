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

        $uid  = isset($this->user['id']) ? $this->user['id'] : NULL;
        //文章标签类型
        $tag = $this->sc->input('tag');

        $article = $this->article_service->get_article_list($page,$uid,'article',$tag);
        echo json_encode($article);
    }

    
    public function index()
    {
        $data['css'] = array(
            'common.css',
            'font-awesome/css/font-awesome.min.css'
        );
        $data['javascript'] = array(
            'j162.min.js'
        );

        $user['user'] = $this->user;
        $sidebar = $this->load->view('common/sidebar', $user, TRUE);

        $body['sidebar'] = $sidebar;
        $body['user'] = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('article', $body);
    }
}