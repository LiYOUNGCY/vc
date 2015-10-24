<?php

class Article extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('article_like_model');
        $this->load->model('article_comment_model');
    }

    public function index($type = 'a', $page = 0)
    {
        if ($type == 'a') {
            //页面限制个数
            $limit = 10;
            //获取文章列表
            $article = $this->article_model->admin_get_article_list($page, 1, $limit);
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
            $this->load->view('admin/article/list', $body);
        } elseif ($type == 'article_tag') {
            //获取文章标签列表
            $tag = $this->article_model->get_all_tag();
            $count = $this->article_model->get_tag_count();
            $user['user'] = $this->user;
            $navbar = $this->load->view('admin/common/navbar', $user, true);

            //分页数据
            $p = array(
                'count' => $count,
                'page' => 0,
                'limit' => $count,
                'pageurl' => base_url().ADMINROUTE.'article/article_tag/',
            );

            $pagination = $this->load->view('admin/common/pagination', $p, true);
            $foot = $this->load->view('admin/common/foot', '', true);
            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'pagination' => $pagination,
                'tag' => $tag,
            );
            $this->load->view('admin/common/head');
            $this->load->view('admin/article/tag_list', $body);
        }
    }

    public function edit($type = 'tag', $id = null)
    {
        if (empty($id) || !is_numeric($id)) {
            show_404();
        }

        $user['user'] = $this->user;
        $navbar = $this->load->view('admin/common/navbar', $user, true);
        $foot = $this->load->view('admin/common/foot', '', true);

        $this->load->view('admin/common/head');
        $tag = $this->article_model->get_tag_by_id($id);

        //页面数据
        $body = array(
            'navbar' => $navbar,
            'foot' => $foot,
            'tag' => $tag,
        );
        if (empty($tag)) {
            show_404();
        } else {
            $this->load->view('admin/article/tag_edit', $body);
        }
    }

    /**
     * 删除文章.
     */
    public function delete_article()
    {
        $aid = $this->sc->input('aids');
        $aid = explode(',', $aid);
        foreach ($aid as $k => $v) {
            $result = $this->article_model->delete_article($v);
            $this->article_like_model->delete_like_by_aid($v);
            $this->article_comment_model->delete_comment_by_aid($v);
        }
        if ($result) {
            echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
        } else {
            $this->error->output('INVALID_REQUEST');
        }
    }

    /**
     * 添加标签.
     */
    public function add_tag()
    {
        $type = $this->sc->input('type');
        $name = $this->sc->input('name');

        $result = $this->article_model->add_tag($name, $type);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'article/index/article_tag";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="'.base_url().ADMINROUTE.'article/index/article_tag";</script>';
        }
    }

    public function update_tag()
    {
        $id = $this->sc->input('id');
        $type = $this->sc->input('type');
        $name = $this->sc->input('name');

        $result = $this->article_model->update_tag($id, $name, $type);

        if ($result) {
            echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'article/index/article_tag";</script>';
        } else {
            echo '<script>alert("操作失败!");window.location.href="'.base_url().ADMINROUTE.'article/index/article_tag";</script>';
        }
    }

    /**
     * 删除标签.
     */
    public function delete_tag()
    {
        $id = $this->sc->input('aids');
        $id = explode(',', $id);
        foreach ($id as $key => $value) {
            $result = $this->article_model->delete_tag($value);
        }

        if ($result) {
            echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'window.location.href="'.base_url().ADMINROUTE.'article/index/article_tag";'));
        } else {
            $this->error->output('INVALID_REQUEST');
        }
    }
}
