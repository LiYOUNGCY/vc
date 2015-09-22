<?php

class Production extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('production_model');
        $this->load->model('production_medium_model');
        $this->load->model('production_categories_model');
        $this->load->model('production_style_model');
        $this->load->model('production_price_model');
    }

    public function index($type = 'p', $page = 0)
    {
        if ($type == 'p') {
            //页面限制个数
            $limit = 10;
            //获取艺术品列表
            $production = $this->production_model->admin_get_production_list($page, $limit);
            $this->load->model('artist_model');
            foreach ($production as $k => $v) {
                if (!empty($v['aid'])) {
                    $a = $this->artist_model->get_artist_by_id($v['aid']);
                    $production[$k]['artist'] = empty($a) ? "" : $a['name'];
                } else {
                    $production[$k]['artist'] = "";
                }

            }
            $status = array('已上架', '已售出', '已下架');
            $count = $this->production_model->get_production_count();

            $navbar = $this->load->view('admin/common/navbar', "", TRUE);

            //分页数据
            $p = array(
                'count' => $count,
                'page' => $page,
                'limit' => $limit,
                'pageurl' => base_url() . ADMINROUTE . 'production/p/'
            );

            $pagination = $this->load->view('admin/common/pagination', $p, TRUE);
            $foot = $this->load->view('admin/common/foot', "", TRUE);

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'pagination' => $pagination,
                'production' => $production,
                'status' => $status
            );
            $this->load->view('admin/common/head');
            $this->load->view('admin/production/list', $body);
        }

    }

    public function delete_production()
    {
        $aid = $this->sc->input('aids');
        $aid = explode(",", $aid);
        foreach ($aid as $k => $v) {
            $result = $this->production_model->delete_production($v);
        }
        if ($result) {
            echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
        } else {
            $this->error->output('INVALID_REQUEST');
        }
    }


    public function medium($type = 'publish', $id = NULL)
    {
        if ($type == 'publish') {
            $medium = $this->production_medium_model->get_medium_list();
            $count = count($medium);

            if ($count == 0) {
                $count = 1;
            }

            $navbar = $this->load->view('admin/common/navbar', "", TRUE);

            //分页数据
            $p = array(
                'count' => $count,
                'page' => 0,
                'limit' => $count,
                'pageurl' => base_url() . ADMINROUTE . 'production/p/'
            );

            $pagination = $this->load->view('admin/common/pagination', $p, TRUE);
            $foot = $this->load->view('admin/common/foot', "", TRUE);

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'pagination' => $pagination,
                'data' => $medium
            );
            $this->load->view('admin/common/head');
            $this->load->view('admin/production/medium_list', $body);
        } else if ($type == 'update') {
//            if (!is_numeric($id)) {
//                show_404();
//            }
            $medium = $this->production_medium_model->get_medium_by_id($id);

//            if (empty($medium)) {
//                show_404();
//            }

            $navbar = $this->load->view('admin/common/navbar', "", TRUE);
            $foot = $this->load->view('admin/common/foot', "", TRUE);
            $this->load->view('admin/common/head');

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'data' => $medium
            );
            $this->load->view('admin/production/medium_edit', $body);
        }
    }

    public function add_medium()
    {
        $name = $this->sc->input('name');

        $result = $this->production_medium_model->insert_medium($name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="' . base_url() . ADMINROUTE . 'production/medium/publish";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="' . base_url() . ADMINROUTE . 'production/medium/publish";</script>';
        }
    }

    public function delete_medium()
    {
        $id = $this->sc->input('ids');
        $id = explode(",", $id);


        foreach ($id as $k => $v) {
            $result = $this->production_medium_model->delete_medium($v);

            if (!$result) {
                $this->error->output('INVALID_REQUEST');
            }
        }

        echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
    }

    public function update_medium()
    {
        $id = $this->sc->input('id');
        $name = $this->sc->input('name');

        $result = $this->production_medium_model->update_medium($id, $name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="' . base_url() . ADMINROUTE . 'production/medium/publish";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="' . base_url() . ADMINROUTE . 'production/medium/publish";</script>';
        }
    }

    public function categories($type = 'publish', $id = NULL)
{
    if ($type == 'publish') {
        $categories = $this->production_categories_model->get_categories_list();
        $count = count($categories);

        if ($count == 0) {
            $count = 1;
        }

        $navbar = $this->load->view('admin/common/navbar', "", TRUE);

        //分页数据
        $p = array(
            'count' => $count,
            'page' => 0,
            'limit' => $count,
            'pageurl' => base_url() . ADMINROUTE . 'production/p/'
        );

        $pagination = $this->load->view('admin/common/pagination', $p, TRUE);
        $foot = $this->load->view('admin/common/foot', "", TRUE);

        //页面数据
        $body = array(
            'navbar' => $navbar,
            'foot' => $foot,
            'pagination' => $pagination,
            'data' => $categories
        );
        $this->load->view('admin/common/head');
        $this->load->view('admin/production/categories_list', $body);
    } else if ($type == 'update') {
//            if (!is_numeric($id)) {
//                show_404();
//            }
        $categories = $this->production_categories_model->get_categories_by_id($id);

//            if (empty($categories)) {
//                show_404();
//            }

        $navbar = $this->load->view('admin/common/navbar', "", TRUE);
        $foot = $this->load->view('admin/common/foot', "", TRUE);
        $this->load->view('admin/common/head');

        //页面数据
        $body = array(
            'navbar' => $navbar,
            'foot' => $foot,
            'data' => $categories
        );
        $this->load->view('admin/production/categories_edit', $body);
    }
}


    public function add_categories()
    {
        $name = $this->sc->input('cname');

        $result = $this->production_categories_model->insert_categories($name);

        redirect(base_url().'admin/production/categories');
    }

    public function delete_categories()
    {
        $id = $this->sc->input('ids');
        $id = explode(",", $id);


        foreach ($id as $k => $v) {
            $result = $this->production_categories_model->delete_categories($v);

            if (!$result) {
                $this->error->output('INVALID_REQUEST');
            }
        }

        echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
    }

    public function update_categories()
    {
        $id = $this->sc->input('id');
        $name = $this->sc->input('name');

        $result = $this->production_categories_model->update_categories($id, $name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="' . base_url() . ADMINROUTE . 'production/categories";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="' . base_url() . ADMINROUTE . 'production/categories";</script>';
        }
    }


    //-------------------------------Style---------------------------

    public function style($type = 'publish', $id = NULL)
    {
        if ($type == 'publish') {
            $style = $this->production_style_model->get_style_list();
            $count = count($style);

            if ($count == 0) {
                $count = 1;
            }

            $navbar = $this->load->view('admin/common/navbar', "", TRUE);

            //分页数据
            $p = array(
                'count' => $count,
                'page' => 0,
                'limit' => $count,
                'pageurl' => base_url() . ADMINROUTE . 'production/p/'
            );

            $pagination = $this->load->view('admin/common/pagination', $p, TRUE);
            $foot = $this->load->view('admin/common/foot', "", TRUE);

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'pagination' => $pagination,
                'data' => $style
            );
            $this->load->view('admin/common/head');
            $this->load->view('admin/production/style_list', $body);
        } else if ($type == 'update') {
//            if (!is_numeric($id)) {
//                show_404();
//            }
            $style = $this->production_style_model->get_style_by_id($id);

//            if (empty($style)) {
//                show_404();
//            }

            $navbar = $this->load->view('admin/common/navbar', "", TRUE);
            $foot = $this->load->view('admin/common/foot', "", TRUE);
            $this->load->view('admin/common/head');

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'data' => $style
            );
            $this->load->view('admin/production/style_edit', $body);
        }
    }


    public function add_style()
    {
        $name = $this->sc->input('cname');

        $result = $this->production_style_model->insert_style($name);

        redirect(base_url().'admin/production/style');
    }

    public function delete_style()
    {
        $id = $this->sc->input('ids');
        $id = explode(",", $id);


        foreach ($id as $k => $v) {
            $result = $this->production_style_model->delete_style($v);

            if (!$result) {
                $this->error->output('INVALID_REQUEST');
            }
        }

        echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
    }

    public function update_style()
    {
        $id = $this->sc->input('id');
        $name = $this->sc->input('name');

        $result = $this->production_style_model->update_style($id, $name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="' . base_url() . ADMINROUTE . 'production/style";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="' . base_url() . ADMINROUTE . 'production/style";</script>';
        }
    }


    // ------------------- 价格段 -------------------------------------

    public function price($type = 'publish', $id = NULL)
    {
        if ($type == 'publish') {
            $price = $this->production_price_model->get_price_list();
            $count = count($price);

            if ($count == 0) {
                $count = 1;
            }

            $navbar = $this->load->view('admin/common/navbar', "", TRUE);

            //分页数据
            $p = array(
                'count' => $count,
                'page' => 0,
                'limit' => $count,
                'pageurl' => base_url() . ADMINROUTE . 'production/p/'
            );

            $pagination = $this->load->view('admin/common/pagination', $p, TRUE);
            $foot = $this->load->view('admin/common/foot', "", TRUE);

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'pagination' => $pagination,
                'data' => $price
            );
            $this->load->view('admin/common/head');
            $this->load->view('admin/production/price_list', $body);
        } else if ($type == 'update') {
//            if (!is_numeric($id)) {
//                show_404();
//            }
            $price = $this->production_price_model->get_price_by_id($id);

            $value = explode(',', $price['value']);
            $price['min'] = $value[0];
            $price['max'] = $value[1];

//            if (empty($price)) {
//                show_404();
//            }

            $navbar = $this->load->view('admin/common/navbar', "", TRUE);
            $foot = $this->load->view('admin/common/foot', "", TRUE);
            $this->load->view('admin/common/head');

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'data' => $price
            );
            $this->load->view('admin/production/price_edit', $body);
        }
    }


    public function add_price()
    {
//        $name = $this->sc->input('cname');
        $value[0] = $this->sc->input('min');
        $value[1] = $this->sc->input('max');
        $name = "{$value[0]}-{$value[1]}";

        $value[0] = empty($value[0]) ? '' : $value[0];
        $value[1] = empty($value[1]) ? '' : $value[1];

        $value = "{$value[0]},{$value[1]}";
        var_dump($value);

        $result = $this->production_price_model->insert_price($name, $value);

        redirect(base_url().'admin/production/price');
    }

    public function delete_price()
    {
        $id = $this->sc->input('ids');
        $id = explode(",", $id);


        foreach ($id as $k => $v) {
            $result = $this->production_price_model->delete_price($v);

            if (!$result) {
                $this->error->output('INVALID_REQUEST');
            }
        }

        echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
    }

    public function update_price()
    {
        $id = $this->sc->input('id');
        $value[0] = $this->sc->input('min');
        $value[1] = $this->sc->input('max');
        $name = "{$value[0]}-{$value[1]}";

        $value[0] = empty($value[0]) ? '' : $value[0];
        $value[1] = empty($value[1]) ? '' : $value[1];

        $value = "{$value[0]},{$value[1]}";


        $result = $this->production_price_model->update_price($id, $name, $value);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="' . base_url() . ADMINROUTE . 'production/price";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="' . base_url() . ADMINROUTE . 'production/price";</script>';
        }
    }
}