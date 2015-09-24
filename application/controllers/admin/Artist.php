<?php

class Artist extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('artist_model');
    }

    public function index($type = 'artist', $page = 0)
    {
        if ($type == 'artist') {
            //页面限制个数
            $limit = 10;

            $artist = $this->artist_model->admin_get_artist_list($page, $limit);
            $count = $this->artist_model->get_artist_count();

            $user['user'] = $this->user;
            $navbar = $this->load->view('admin/common/navbar', $user, TRUE);

            //分页数据
            $p = array(
                'count' => $count,
                'page' => $page,
                'limit' => $limit,
                'pageurl' => base_url() . ADMINROUTE . 'article/artist/'
            );

            $pagination = $this->load->view('admin/common/pagination', $p, TRUE);
            $foot = $this->load->view('admin/common/foot', "", TRUE);

            //页面数据
            $body = array(
                'navbar' => $navbar,
                'foot' => $foot,
                'pagination' => $pagination,
                'artist' => $artist
            );

            $this->load->view('admin/common/head');
            $this->load->view('admin/artist/artist_list', $body);
        }
    }


    public function delete_artist()
    {
        $aid = $this->sc->input('aids');
        $aid = explode(",", $aid);

        foreach ($aid as $k => $v) {
            $result = $this->artist_model->delete_artist($v);

            if (!$result) {
                $this->error->output('INVALID_REQUEST');
            }
        }

        echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => 'location.reload();'));
    }
}
