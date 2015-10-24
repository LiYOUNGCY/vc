<?php

class Topic extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('article_like_model');
        $this->load->model('article_comment_model');
        $this->load->model('topic_tag_who_model');
        $this->load->model('topic_tag_where_model');
        $this->load->model('topic_tag_when_model');
    }

    public function index($type = 'topic', $page = 0)
    {
        //页面限制个数
        $limit = 10;
        //获取文章列表
        $article = $this->article_model->admin_get_article_list($page, 2, $limit);
        $count = $this->article_model->get_article_count();

        $user['user'] = $this->user;
        $navbar = $this->load->view('admin/common/navbar', $user, true);

        //分页数据
        $p = array(
            'count' => $count,
            'page' => $page,
            'limit' => $limit,
            'pageurl' => base_url().ADMINROUTE.'article/a/',
        );

        $pagination = $this->load->view('admin/common/pagination', $p, true);
        $foot = $this->load->view('admin/common/foot', '', true);
        //页面数据
        $body = array(
            'navbar' => $navbar,
            'foot' => $foot,
            'pagination' => $pagination,
            'article' => $article,
        );
        $this->load->view('admin/common/head');
        $this->load->view('admin/topic/topic_list', $body);
    }

    // ------------------ 送礼 -> who ----------------------------


    public function who($type = 'publish', $id = null)
    {
        if ($type == 'publish') {
            $who = $this->topic_tag_who_model->get_topic_tag_who_list();
            $count = count($who);

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
                'pageurl' => base_url().ADMINROUTE.'topic/p/',
            );

            $pagination = $this->load->view('admin/common/pagination', $p, true);
            $foot = $this->load->view('admin/common/foot', '', true);

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'pagination' => $pagination,
                'data' => $who,
            );
            $this->load->view('admin/common/head');
            $this->load->view('admin/topic/who_list', $body);
        } elseif ($type == 'update') {
            if (!is_numeric($id)) {
                show_404();
            }
            $who = $this->topic_tag_who_model->get_topic_tag_who_by_id($id);

            if (empty($who)) {
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
                'data' => $who,
            );
            $this->load->view('admin/topic/who_edit', $body);
        }
    }

    public function add_who()
    {
        $name = $this->sc->input('name');

        $result = $this->topic_tag_who_model->insert_topic_tag_who($name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'topic/who/publish";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="'.base_url().ADMINROUTE.'topic/who/publish";</script>';
        }
    }

    public function delete_who()
    {
        $id = $this->sc->input('ids');
        $id = explode(',', $id);

        foreach ($id as $k => $v) {
            $result = $this->topic_tag_who_model->delete_topic_tag_who($v);

            if (!$result) {
                $this->error->output('INVALID_REQUEST');
            }
        }

        echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
    }

    public function update_who()
    {
        $id = $this->sc->input('id');
        $name = $this->sc->input('name');

        $result = $this->topic_tag_who_model->update_topic_tag_who($id, $name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'topic/who/publish";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="'.base_url().ADMINROUTE.'topic/who/publish";</script>';
        }
    }

    // --------------- 装修 -> where ---------------------


        public function where($type = 'publish', $id = null)
        {
            if ($type == 'publish') {
                $where = $this->topic_tag_where_model->get_topic_tag_where_list();
                $count = count($where);

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
                'pageurl' => base_url().ADMINROUTE.'topic/p/',
            );

                $pagination = $this->load->view('admin/common/pagination', $p, true);
                $foot = $this->load->view('admin/common/foot', '', true);

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'pagination' => $pagination,
                'data' => $where,
            );
                $this->load->view('admin/common/head');
                $this->load->view('admin/topic/where_list', $body);
            } elseif ($type == 'update') {
                if (!is_numeric($id)) {
                    show_404();
                }
                $where = $this->topic_tag_where_model->get_topic_tag_where_by_id($id);

                if (empty($where)) {
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
                'data' => $where,
            );
                $this->load->view('admin/topic/where_edit', $body);
            }
        }

    public function add_where()
    {
        $name = $this->sc->input('name');

        $result = $this->topic_tag_where_model->insert_topic_tag_where($name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'topic/where/publish";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="'.base_url().ADMINROUTE.'topic/where/publish";</script>';
        }
    }

    public function delete_where()
    {
        $id = $this->sc->input('ids');
        $id = explode(',', $id);

        foreach ($id as $k => $v) {
            $result = $this->topic_tag_where_model->delete_topic_tag_where($v);

            if (!$result) {
                $this->error->output('INVALID_REQUEST');
            }
        }

        echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
    }

    public function update_where()
    {
        $id = $this->sc->input('id');
        $name = $this->sc->input('name');

        $result = $this->topic_tag_where_model->update_topic_tag_where($id, $name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'topic/where/publish";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="'.base_url().ADMINROUTE.'topic/where/publish";</script>';
        }
    }

    // ---------- 收藏 -> when -----------------

    public function when($type = 'publish', $id = null)
    {
        if ($type == 'publish') {
            $when = $this->topic_tag_when_model->get_topic_tag_when_list();
            $count = count($when);

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
                'pageurl' => base_url().ADMINROUTE.'topic/p/',
            );

            $pagination = $this->load->view('admin/common/pagination', $p, true);
            $foot = $this->load->view('admin/common/foot', '', true);

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'pagination' => $pagination,
                'data' => $when,
            );
            $this->load->view('admin/common/head');
            $this->load->view('admin/topic/when_list', $body);
        } elseif ($type == 'update') {
            if (!is_numeric($id)) {
                show_404();
            }
            $when = $this->topic_tag_when_model->get_topic_tag_when_by_id($id);

            if (empty($when)) {
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
                'data' => $when,
            );
            $this->load->view('admin/topic/when_edit', $body);
        }
    }

    public function add_when()
    {
        $name = $this->sc->input('name');

        $result = $this->topic_tag_when_model->insert_topic_tag_when($name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'topic/when/publish";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="'.base_url().ADMINROUTE.'topic/when/publish";</script>';
        }
    }

    public function delete_when()
    {
        $id = $this->sc->input('ids');
        $id = explode(',', $id);

        foreach ($id as $k => $v) {
            $result = $this->topic_tag_when_model->delete_topic_tag_when($v);

            if (!$result) {
                $this->error->output('INVALID_REQUEST');
            }
        }

        echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
    }

    public function update_when()
    {
        $id = $this->sc->input('id');
        $name = $this->sc->input('name');

        $result = $this->topic_tag_when_model->update_topic_tag_when($id, $name);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'topic/when/publish";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="'.base_url().ADMINROUTE.'topic/when/publish";</script>';
        }
    }
}
