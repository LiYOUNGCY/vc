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
        $data = array();
        $data['medium'] = $this->production_service->get_medium_list();
        $data['style'] = $this->production_service->get_style_list();

        if ($type == 'publish') {
            $head['title'] = '发布艺术品';
            $this->load->view('publish_production', $data);
        } else if ($type == 'update') {
            if (!is_numeric($pid)) {
                show_404();
            }
            $production = $this->production_service->get_production_detail_by_id($pid);

//            echo json_encode($production);

            if (empty($production)) {
                show_404();
            }

            $data['production'] = $production;
            $this->load->view('update_production', $data);
        }
    }

    /**
     * [publish_production 发布艺术品]
     * @return [type] [description]
     */
    public function publish_production()
    {
        $data = array(
                'name',
                'intro',
                'aid',
                'medium',
                'style',
                'creat_time',
                'w',
                'h',
                'l',
                'image_id',
                'price'
            );

        $data = $this->sc->input($data);

        $result = $this->production_service->publish_production($this->user['id'], $data);

        if(! $result) {
            $this->message->error();
        }

        redirect(base_url() . ADMINROUTE . 'production');
    }

    /**
     * [update_production 更新艺术品]
     * @return [type] [description]
     */
    public function update_production()
    {
        $id = $this->sc->input('id');
        $image_id = $this->sc->input('image_id');

        $data = array(
                'name',
                'intro',
                'aid',
                'medium',
                'style',
                'creat_time',
                'w',
                'h',
                'l',
                'price'
            );
        $data = $this->sc->input($data);

        //有新的图片上传
        if($image_id != null) {
            $data['image_id'] = $image_id;
        }

        $result = $this->production_service->update_production($id, $this->user['id'], $data);

        if($result) {
            redirect(base_url() . ADMINROUTE . 'production');
        }
    }


    /**
     * 作品下架
     */
    public function pull_off()
    {
        $id = $this->sc->input('id');

        $result = $this->production_model->pull_off($id);

        if ($result) {
            $output = array(
                'success' => 0
            );
            echo json_encode($output);
        } else {
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

        if ($result) {
            $output = array(
                'success' => 0
            );
            echo json_encode($output);
        } else {
            $output = array(
                'error' => -1
            );
            echo json_encode($output);
        }
    }
}
