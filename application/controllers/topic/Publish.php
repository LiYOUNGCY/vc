<?php

class Publish extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');
    }


    public function index($type = 'publish', $pid = NULL)
    {
        /*
        $head['css'] = array(
            'base.css',
            'font-awesome/css/font-awesome.min.css',
            'alert.css',
            'jquery.Jcrop.css',
            'edit_style.css'
        );

        $head['javascript'] = array(
            'jquery.js',
            'error.js',
            'timeago.js',
            'alert.min.js',
            'autosize.js',
            'ajaxfileupload.js'
        );
        */
        //$user['user'] = $this->user;
        //$user['sign'] = $this->load->view('common/sign', '', TRUE);
        //$data['top'] = $this->load->view('common/top', $user, TRUE);
        //$data['footer'] = $this->load->view('common/footer', $user, TRUE);

        if ($type == 'publish') {
            $data = array();
            $data['tag'] = $this->article_service->get_topic_tag();
            $this->load->view('publish_topic', $data);
        } else if ($type == 'update' && is_numeric($pid)) {
            if (!is_numeric($pid)) {
                show_404();
            }
            $head['title'] = '修改专题';
            $this->load->view('common/head', $head);
            $data['pid'] = $pid;
            $this->load->view('update_topic', $data);
        } else {
            show_404();
        }
    }

    public function get_article($aid)
    {
        if (is_numeric($aid)) {
            $this->load->service('article_service');
            $article = $this->article_service->get_article_by_id($aid);
            echo json_encode($article);
        }
    }

    public function save_topic()
    {

        $title = $this->sc->input('title');
        $content = $this->sc->input('content');
        $who = $this->sc->input('who');
        $where = $this->sc->input('where');
        $when = $this->sc->input('when');

        $uid = $this->user['id'];



        $id = $this->article_service->publish_topic($title, $content, $uid, $who, $where, $when);

        if (!isset($id)) {
            $this->sc->output_error();
        }
        $this->sc->output_success();
    }
}
