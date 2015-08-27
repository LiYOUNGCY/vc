<?php


class Main extends MY_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->service('home_service');
    }


    /**
     * [index 显示首页]
     * @return [type]       [description]
     */
    public function index()
    {
        $data['css'] = array(
            'swiper.min.css',
            'font-awesome/css/font-awesome.min.css',
            'base.css'
            
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'error.js',
            'validate.js'
        );

        $all = $this->home_service->enter_index();
        $data['topic']      = $all['topic'];
        $data['production'] = $all['production'];
        $data['artist']     = $all['artist'];
        $data['slider']     = $all['slider'];

        $user['user'] = $this->user;
        $top = $this->load->view('common/top', $user, TRUE);
        $data['title']        = "最专业的艺术导购";
        $body['top']          = $top;
        $body['sign']         = $this->load->view('common/sign', '', TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('home', $body);
        
    }
}
