<?php

class Topic extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('article_like_model');
        $this->load->model('article_comment_model');
    }

    public function index($type = 'topic', $page = 0)
    {
        //页面限制个数
        $limit= 10;
        //获取文章列表
        $article = $this->article_model->admin_get_article_list($page, 2, $limit);
        $count   = $this->article_model->get_article_count();

        $user['user'] = $this->user;
        $navbar = $this->load->view('admin/common/navbar', $user,TRUE);

        //分页数据
        $p = array(
            'count'   => $count,
            'page'    => $page,
            'limit'   => $limit,
            'pageurl' => base_url().ADMINROUTE.'article/a/'
        );

        $pagination = $this->load->view('admin/common/pagination',$p,TRUE);
        $foot 		= $this->load->view('admin/common/foot',"",TRUE);
        //页面数据
        $body = array(
            'navbar' 	 => $navbar,
            'foot' 	 	 => $foot,
            'pagination' => $pagination,
            'article'    => $article
        );
        $this->load->view('admin/common/head');
        $this->load->view('admin/topic/topic_list',$body);
    }
}
