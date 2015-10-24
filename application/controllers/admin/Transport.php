<?php

class Transport extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transport_model');
    }

    public function index($type = 'publish', $id = null)
    {
        if ($type == 'publish') {
            $transport = $this->transport_model->get_transport_list();
            $count = count($transport);

            if ($count == 0) {
                $count = 1;
            }

            $user['user'] = $this->user;
            $navbar = $this->load->view('admin/common/navbar', $user, true);

            //分页数据
            $p = array(
                'count' => $count,
                'page' => 0,
                'limit' => $count,
                'pageurl' => base_url().ADMINROUTE.'transport',
            );

            // $pagination = $this->load->view('admin/common/pagination', $p, true);
            $foot = $this->load->view('admin/common/foot', '', true);

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                // 'pagination' => $pagination,
                'data' => $transport,
            );
            $this->load->view('admin/common/head');
            $this->load->view('admin/transport/transport_list', $body);
        } elseif ($type == 'update') {
            if (!is_numeric($id)) {
                show_404();
            }
            $transport = $this->transport_model->get_transport_by_id($id);

            if (empty($transport)) {
                show_404();
            }

            $user['user'] = $this->user;
            $navbar = $this->load->view('admin/common/navbar', $user, true);
            $foot = $this->load->view('admin/common/foot', '', true);
            $this->load->view('admin/common/head');

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'data' => $transport,
            );
            $this->load->view('admin/transport/transport_edit', $body);
        }
    }

    public function add_transport()
    {
        $name = $this->sc->input('name');

        $result = $this->transport_model->insert_transport($name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'transport/transport/publish";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="'.base_url().ADMINROUTE.'transport/transport/publish";</script>';
        }
    }

    public function delete_transport()
    {
        $id = $this->sc->input('ids');
        $id = explode(',', $id);

        foreach ($id as $k => $v) {
            $result = $this->transport_model->delete_transport($v);

            if (!$result) {
                $this->error->output('INVALID_REQUEST');
            }
        }

        echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
    }

    public function update_transport()
    {
        $id = $this->sc->input('id');
        $name = $this->sc->input('name');

        $result = $this->transport_model->update_transport($id, $name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'transport/transport/publish";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="'.base_url().ADMINROUTE.'transport/transport/publish";</script>';
        }
    }
}
