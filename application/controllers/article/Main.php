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
        // $page = 0;

        $uid  = isset($this->user['id']) ? $this->user['id'] : NULL;
        //文章类型
        $type= $this->sc->input('type');
        $article = $this->article_service->get_article_list($page,$uid,$type);
        echo json_encode($article);
    }

    /**
     * [index 显示文章列表]
     * @param  string $type [文章类型(article 文章 topic 专题)]
     * @return [type]       [description]
     */
    public function index($type = 'article')
    {
        $data['css'] = array(
            'base.css',
            'font-awesome/css/font-awesome.min.css'
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'jquery.scrollLoading.js'
        );

        $user['user'] = $this->user;
        $sidebar = $this->load->view('common/sidebar', $user, TRUE);

        $body['sidebar']      = $sidebar;
        $body['user']         = $this->user;
        //文章类型与标签
        $body['article_type'] = $type;
        $this->load->view('common/head', $data);
        $this->load->view('article', $body);
    }
}
