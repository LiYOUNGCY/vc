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
        //文章类型
        $type= $this->sc->input('type');

        $article = $this->article_service->get_article_list($page,$uid,$type,$tag);
        echo json_encode($article);
    }

    /**
     * [index 显示文章列表]
     * @param  string $type [文章类型(article 文章 exhibition 展览)]
     * @param  string $tag  [文章标签(interview 访谈, discuss议论,consult咨询)]
     * @return [type]       [description]
     */
    public function index($type = 'article', $tag = '')
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

        $body['sidebar']      = $sidebar;
        $body['user']         = $this->user;
        //文章类型与标签
        $body['article_type'] = $type;
        $body['article_tag']  = $tag;
        $this->load->view('common/head', $data);
        $this->load->view('article', $body);
    }
}