<?php


class Publish extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');
        $this->load->library('htmlpurifier');
    }

    /**
     * 发布文章或更新文章
     */
    public function index($type = 'publish', $aid = NULL)
    {
        $head['css'] = array(
            'base.css',
            'font-awesome/css/font-awesome.min.css',
            '../ueditor/themes/default/css/umeditor.css',
            'ueditor.css',
            'radiocheck.min.css'
        );
        $head['javascript'] = array(
            'jquery.js'
        );

        $user['user'] = $this->user;
        $body['top'] = $this->load->view('common/top', $user, TRUE);
        $body['footer'] = $this->load->view('common/footer', '', TRUE);


        if ($type == 'publish') {
            //发布文章界面
            $head['title'] = '发布文章';
            $this->load->view('common/head', $head);
            $this->load->view('publish_article', $body);
        } else if ($type == 'update') {
            if (!is_numeric($aid)) {
                show_404();
            }
            //更新文章界面
            $article = $this->article_service->get_article_by_id($aid);
            if (empty($article)) {
                show_404();
            }

            $head['title'] = '修改文章';
            $body['article'] = $article;
            $this->load->view('common/head', $head);
            $this->load->view('update_article', $body);
        }
    }

    /**
     * [publish_article 发布文章]
     * @return [type] [description]
     */
    public function publish_article()
    {
        /**
         * [日后修改]
         * @var [type]
         */
        $type = $this->input->post('article_type');
        switch ($type) {
            case 1:
                $type = 'article';
                break;
            case 2:
                $type = 'topic';
                break;
        }
        $error_redirect = array(
            'script' => "window.location.href='" . base_url() . "publish/{$type}';"
        );


        $this->sc->set_error_redirect($error_redirect);
        $article_title = $this->sc->input('article_title');
        $article_type = $this->sc->input('article_type');
        $pids = $this->sc->input('pids');
        $article_content = $this->sc->input('article_content', 'post', FALSE);
        //过滤富文本
        $article_content = $this->htmlpurifier->purify($article_content);
        //把文章插入到数据库
        $result = $article = $this->article_service->publish_article($this->user['id'], $article_title, $article_type, $pids, $article_content);
        if ($result) {
            redirect(base_url(), 'location');
        } else {
            $this->error->output('INVALID_REQUEST', array('script' => 'window.location.href="' . base_url() . 'publish/article";'));
        }
    }

    /**
     * [update_article 更新文章]
     * @return [type] [description]
     */
    public function update_article()
    {
        $aid = $this->input->post('aid');
        if (!is_numeric($aid)) {
            show_404();
        }

        /**
         * [日后修改]
         * @var [type]
         */
        $type = $this->input->post('article_type');
        switch ($type) {
            case 1:
                $type = 'article';
                break;
            case 2:
                $type = 'topic';
                break;
        }
        $error_redirect = array(
            'script' => "window.location.href='" . base_url() . "update/{$type}/" . $aid . "';"
        );

        $this->sc->set_error_redirect($error_redirect);

        $aid = $this->sc->input('aid');
        $article_title = $this->sc->input('article_title');
        $article_type = $this->sc->input('article_type');
        $pids = $this->sc->input('pids');
        $article_content = $this->sc->input('article_content', 'post', FALSE);
        //过滤富文本
        $article_content = $this->htmlpurifier->purify($article_content);

        $result = $this->article_service->update_article($aid, $this->user['id'], $article_title, $article_type, $pids, $article_content);
        if ($result) {
            redirect(base_url() . "article/" . $aid, 'location');
        } else {
            $this->error->output('INVALID_REQUEST', array('script' => 'window.location.href="' . base_url() . 'update/{$type}/' . $aid . '";'));
        }
    }


}
