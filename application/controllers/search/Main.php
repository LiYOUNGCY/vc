<?php

class Main extends MY_Controller {
    function __construct()
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

    function index()
    {
        $keyword = $this->sc->input('search', 'get');

        $query = $this->search_service->search($keyword);

        $head['css'] = array(
            'base.css',
            'font-awesome/css/font-awesome.min.css',
            'alert.css',
            'material-cards.css'
        );

        $head['javascript'] = array(
            'jquery.js',
            'alert.min.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js'
        );

        $user['user']           = $this->user;
        $data['top']            = $this->load->view('common/top', $user, TRUE);

        $data['footer']         = $this->load->view('common/footer', '', TRUE);
        $data['query']          = $query;
        $head['title']          = '搜索结果';

        $query = 

        $this->load->view('common/head', $head);
        $this->load->view('search_list', $data);

//        echo json_encode($query);
    }
}