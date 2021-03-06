<?php

class Detail extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('production_service');
    }

    public function index($pid)
    {
        if (!is_numeric($pid)) {
            show_404();
        }
        $production = $this->production_service->get_production_by_id($pid);
        if (empty($production)) {
            show_404();
        }

        if (isset($this->user['id'])) {
            $production['like_status'] = $this->production_service->check_has_like($pid, $this->user['id']);
        } else {
            $production['like_status'] = 0;
        }

        $production['publish_time'] = substr($production['publish_time'], 0, 10);

        $body['production'] = $production;
        $body['frame'] = $this->production_service->get_frame_by_production_id($pid);

        $uid = isset($this->user['id']) ? $this->user['id'] : null;
        //获取相关联的专题
        //$data['topic'] 			= $this->production_service->get_topic_by_production($pid,$uid);

        $data['css'] = array(
            'font-awesome/css/font-awesome.min.css',
            'base.css',
            'alert.css',
        );
        $data['javascript'] = array(
            'jquery.js',
            'alert.min.js',
            'error.js',

            'zoomtoo.js',
            'zoom.js',
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', true);

        $data['title'] = $production['name'];
        $body['top'] = $this->load->view('common/top', $user, true);
        $body['footer'] = $this->load->view('common/footer', '', true);
        $body['user'] = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('production_detail', $body);

//         var_dump($body);
    }

    /**
     * [like_production 点赞作品].
     *
     * @return [type] [description]
     */
    public function like_production()
    {
        $pid = $this->sc->input('pid');
        $pid = empty($pid) ? $this->sc->output_error() : $pid;

        if (empty($this->user['id'])) {
            $this->sc->output_error();
        }

        $this->production_service->like_production($pid, $this->user['id']);
    }
}
