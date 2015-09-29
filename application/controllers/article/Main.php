<?php


class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');
    }


    /**
     * [index 显示文章列表]
     * @param  string $type [文章类型(article 文章 topic 专题)]
     * @return [type]       [description]
     */
    public function index($type = 'article')
    {

        $get_tag = $this->sc->input('tag', 'get');
        $get_tag = isset($get_tag) && is_numeric($get_tag) ? $get_tag : 0;
        $data['css'] = array(
            'base.css',
            'font-awesome/css/font-awesome.min.css'
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'jquery.pageslide.min.js'
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', TRUE);
        $body['top'] = $this->load->view('common/top', $user, TRUE);

        $body['get_tag']    = $get_tag;
        $body['user']       = $this->user;
        $body['footer']     = $this->load->view('common/footer', '', TRUE);

        //文章类型
        $body['article_type'] = $type;
        if ($type == 'article') {
            $data['title']  = "资讯";
            $body['tag']    = $this->article_service->get_article_tag();

            $this->load->view('common/head', $data);
            $this->load->view('article', $body);
        } else if ($type == 'topic') {
            $data['title'] = "专题";
            $body['tag'] = $this->article_service->get_topic_tag();

            $this->load->view('common/head', $data);
            $this->load->view('topic_list', $body);
        }
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
        $tag = $this->sc->input('tag', 'get');
        $tag = is_numeric($tag) ? $tag : 0;

        $uid = isset($this->user['id']) ? $this->user['id'] : NULL;

        $article = $this->article_service->get_article_list($page, $uid, $tag);
        echo json_encode($article);
    }


    /**
     * [get_topic_list 获得专题列表]
     * @return [type] [description]
     */
    public function get_topic_list()
    {
        $page = $this->sc->input('page');
        $who  = $this->sc->input('w1', 'get');
        $when = $this->sc->input('w2', 'get');
        $where= $this->sc->input('w3', 'get');

        $topic = $this->article_service->get_topic_list($page, $who, $when, $where);
        echo json_encode($topic);
    }
}
