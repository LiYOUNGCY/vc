<?php

class Slider extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('slider_model');
    }

    public function index()
    {
        //获取轮播列表
        $slider = $this->slider_model->get_slider_list();
        $user['user'] = $this->user;
        $navbar = $this->load->view('admin/common/navbar', $user, true);

        $foot = $this->load->view('admin/common/foot', '', true);
        //页面数据
        $body = array(
            'navbar' => $navbar,
            'foot' => $foot,
            'slider' => $slider,
        );

        $this->load->view('admin/common/head');
        $this->load->view('admin/slider/list', $body);
    }

    public function edit($id = null)
    {
        $user['user'] = $this->user;
        $navbar = $this->load->view('admin/common/navbar', $user, true);
        $foot = $this->load->view('admin/common/foot', '', true);

        $this->load->view('admin/common/head');
        $slider = $this->slider_model->get_slider_by_id($id);

        //页面数据
        $body = array(
            'navbar' => $navbar,
            'foot' => $foot,
            'slider' => $slider,
        );
        if (empty($slider)) {
            show_404();
        } else {
            $this->load->view('admin/slider/edit', $body);
        }
    }

    public function delete_slider()
    {
        $aid = $this->sc->input('aids');
        $aid = explode(',', $aid);
        foreach ($aid as $k => $v) {
            $result = $this->slider_model->delete_slider($v);
        }
        if ($result) {
            echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
        } else {
            $this->error->output('INVALID_REQUEST');
        }
    }
    /**
     * [update_slider 更新轮播].
     *
     * @return [type] [description]
     */
    public function update_slider()
    {
        $sid = $this->sc->input('id');
        if (!is_numeric($sid)) {
            show_404();
        }
        $error_redirect = array(
            'script' => "window.location.href='".base_url().ADMINROUTE.'slider/edit/'.$sid."';",
        );
        $this->sc->set_error_redirect($error_redirect);

        $title = $this->sc->input('slider_title');
        $pic = $this->sc->input('pic');
        $href = $this->sc->input('href');
        $type = $this->sc->input('type');

        $arr = array(
            'title' => $title,
            'pic' => $pic,
            'href' => $href,
            'modify_by' => $this->user['id'],
            'type'  => $type
        );

        $result = $this->slider_model->update_slider($sid, $arr);
        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'slider/edit/'.$sid.'";</script>';
        } else {
            $this->error->output('INVALID_REQUEST', array('script' => 'window.location.href="'.base_url().ADMINROUTE.'slider/edit/'.$sid.'";'));
        }
    }

    /**
     * [publish_slider 添加轮播].
     *
     * @return [type] [description]
     */
    public function add_slider()
    {
        $error_redirect = array(
            'script' => 'window.location.href = "'.base_url().ADMINROUTE.'slider";',
        );
        $this->sc->set_error_redirect($error_redirect);

        $title = $this->sc->input('slider_title');
        $pic = $this->sc->input('pic');
        $href = $this->sc->input('href');
        $type = $this->sc->input('type');

        $result = $this->slider_model->insert_slider($title, $pic, $href, $this->user['id'], $type);
        if ($result) {
            redirect(base_url().ADMINROUTE.'slider', 'location');
        } else {
            $this->error->output('INVALID_REQUEST', array('script' => 'window.location.href="'.base_url().ADMINROUTE.'slider";'));
        }
    }
}
