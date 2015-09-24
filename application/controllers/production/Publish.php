<?php

class Publish extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('production_service');
    }

    public function index($type = 'publish', $pid = NULL)
    {
        $head['css'] = array(
            'base.css',
            'font-awesome/css/font-awesome.min.css',
            'alert.css',
            'jquery.Jcrop.css',
            'easydropdown.css'
        );

        $head['javascript'] = array(
            'jquery.js',
            'error.js',
            'timeago.js',
            'alert.min.js',
            'autosize.js',
            'ajaxfileupload.js',
            'jquery.easydropdown.js'
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', TRUE);
        $data['top'] = $this->load->view('common/top', $user, TRUE);
        $data['footer'] = $this->load->view('common/footer', $user, TRUE);

        $production_type = $this->production_service->get_type_list(0, NULL);
        $production_marterial = $this->production_service->get_marterial_list(0, NULL);

        $data['medium'] = $this->production_service->get_medium_list();
        $data['style'] = $this->production_service->get_style_list();

        $data['production_type'] = $production_type;
        $data['production_marterial'] = $production_marterial;
        if ($type == 'publish') {
            $head['title'] = '发布艺术品';
            $this->load->view('common/head', $head);
            $this->load->view('publish_production', $data);
        } else if ($type == 'update') {
            if (!is_numeric($pid)) {
                show_404();
            }
            $production = $this->production_service->get_production_by_id($pid);

//            echo json_encode($production);

            if (empty($production)) {
                show_404();
            }

            $data['medium'] = $this->production_service->get_medium_list();
            $data['style'] = $this->production_service->get_style_list();

            $data['production'] = $production;
            $head['title'] = '修改艺术品信息';
            $this->load->view('common/head', $head);
            $this->load->view('update_production', $data);
        }
    }

    /**
     * [publish_production 发布艺术品]
     * @return [type] [description]
     */
    public function publish_production()
    {
        $error_redirect = array(
            'script' => "window.location.href='" . base_url() . "publish/production';"
        );
        $this->sc->set_error_redirect($error_redirect);

        $arr = $this->sc->input(array('production_name', 'production_intro', 'aid', 'price', 'pic', 'l', 'w', 'h', 'style', 'medium', 'creat_time'));

        $result = $this->production_service->publish_production(
            $arr['production_name'], $this->user['id'], $arr['production_intro'], $arr['aid'],
            $arr['price'], $arr['pic'], $arr['l'], $arr['w'], $arr['h'],
            $arr['style'], $arr['medium'], $arr['creat_time']);
        if ($result) {
            redirect(base_url() . 'admin/production');
        } else {
            $this->error->output('INVALID_REQUEST', array('script' => 'window.location.href="' . base_url() . 'publish/production";'));
        }
    }

    /**
     * [update_production 更新艺术品]
     * @return [type] [description]
     */
    public function update_production()
    {
        $pid = $this->input->post('pid');
        if (!is_numeric($pid)) {
            show_404();
        }

        $error_redirect = array(
            'script' => "window.location.href='" . base_url() . "update/production/" . $pid . "';"
        );
        $this->sc->set_error_redirect($error_redirect);


        $arr = $this->sc->input(array('pid', 'production_name', 'production_intro', 'aid', 'price', 'pic', 'l', 'w', 'h', 'style', 'medium', 'creat_time', 'status'));
        $result = $this->production_service->update_production(
            $arr['pid'], $this->user['id'], $arr['production_name'], $arr['production_intro'],
            $arr['aid'], $arr['price'], $arr['pic'], $arr['l'], $arr['w'],
            $arr['h'], $arr['style'], $arr['medium'], $arr['creat_time'], $arr['status']);
        if ($result) {
            redirect(base_url() . 'admin/production');
        } else {
            $this->error->output('INVALID_REQUEST', array('script' => 'window.location.href="' . base_url() . 'update/production/' . $pid . '";'));
        }
    }


    /**
     * 作品下架
     */
    public function pull_off()
    {
        $id = $this->sc->input('id');

        $result = $this->production_model->pull_off($id);

        if($result) {
            $output = array(
                'success' => 0
                );
            echo json_encode($output);
        }
        else {
            $output = array(
                'error' => -1
                );
            echo json_encode($output);
        }
    }


    /**
     * 作品上架
     */
    public function put_on()
    {
        $id = $this->sc->input('id');

        $result = $this->production_model->put_on($id);

        if($result) {
            $output = array(
                'success' => 0
                );
            echo json_encode($output);
        }
        else {
            $output = array(
                'error' => -1
                );
            echo json_encode($output);
        }
    }
}
