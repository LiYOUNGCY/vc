<?php

class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('search_service');
    }

    public function test()
    {
        $keyword = $this->sc->input('search', 'get');
        $query = $this->search_service->search($keyword);

        echo json_encode($query);
    }

    public function index()
    {
        $keyword = $this->sc->input('keyword', 'get');

        $query = $this->search_service->search($keyword);

        $head['css'] = array(
            'base.css',
            'font-awesome/css/font-awesome.min.css',
            'alert.css',
            'material-cards.css',
        );

        $head['javascript'] = array(
            'jquery.js',
            'alert.min.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', true);
        $data['top'] = $this->load->view('common/top', $user, true);

        $data['footer'] = $this->load->view('common/footer', '', true);

        $queue = array();

        foreach ($query as $key => $value) {
            if (!empty($value)) {
                array_unshift($queue, $key);
            } else {
                array_push($queue, $key);
            }
        }

        $data['query'] = $query;
        $data['queue'] = $queue;
        $head['title'] = '搜索结果';

        $this->load->view('common/head', $head);
        $this->load->view('search_list', $data);

//        echo json_encode($query);
//        var_dump($queue);
    }
}
