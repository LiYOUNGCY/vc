<?php

class Publish extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('artist_service');
        $this->load->service('image_service');
    }

    /**
     * @param string $type
     * @param null   $aid
     *                     添加/修改艺术家的页面
     */
    public function index($type = 'publish', $aid = null)
    {
        $head['css'] = array(
            // 'base.css',
            'font-awesome/css/font-awesome.min.css',
            'alert.css',
            'jquery.Jcrop.css',
            'edit_style.css',
        );

        $head['javascript'] = array(
            'jquery.js',
            'error.js',
            'timeago.js',
            'alert.min.js',
            'autosize.js',
            'ajaxfileupload.js',
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', true);
        $data['top'] = $this->load->view('common/top', $user, true);
        $data['footer'] = $this->load->view('common/footer', '', true);

        if ($type == 'publish') {
            $head['title'] = '添加艺术家';
            $this->load->view('common/head', $head);
            $this->load->view('publish_artist', $data);
        } elseif ($type == 'update') {
            if (!is_numeric($aid)) {
                show_404();
            }
            $artist = $this->artist_service->get_artist_by_id($aid);
//			echo json_encode($artist);
            $data['artist'] = $artist;
            $head['title'] = '修改艺术家信息';
            $this->load->view('common/head', $head);
            $this->load->view('update_artist', $data);
        }
    }

    /**
     * [publish_artist 添加艺术家].
     *
     * @return [type] [description]
     */
    // public function publish_artist()
    // {

 //        $error_redirect = array(
 //            'script' => "window.location.href='".base_url()."publish/artist';"
 //        );
 //        $this->sc->set_error_redirect($error_redirect);

 //        $this->load->service('image_service');
 //        $img = $this->sc->input(array('img','x','y','w','h'));
 //        $pic = $this->image_service->save_artist_pic($img['img'],$img['x'],$img['y'],$img['w'],$img['h']);
 //        //裁剪成功
 //        if($pic)
 //        {
 //            $name       = $this->sc->input('artist_name');
 //            $intro      = $this->sc->input('intro');
 //            $evaluation = $this->sc->input('evaluation');

 //            $result = $this->artist_service->publish_artist($this->user['id'],$name,$intro,$evaluation,$pic);
 //            if($result)
 //            {
 //                redirect(base_url().'artist/'.$result,'location');
 //            }
 //        }
 //        $this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().'publish/artist";'));
    // }


    public function publish_artist()
    {
        $img = $this->sc->input('img');
        $img = explode('/', $img);
        $img = $img[count($img) - 1];
        $x = $this->sc->input('x');
        $y = $this->sc->input('y');
        $w = $this->sc->input('w');
        $h = $this->sc->input('h');

        $name = $this->sc->input('artist_name');
        $intro = $this->sc->input('intro');
        $evaluation = $this->sc->input('evaluation');

        //保存图片
        $image_id = $this->image_service->crop_image($img, $x, $y, $w, $h)['image_id'];

        $result = $this->artist_service->publish_artist($this->user['id'], $name, $image_id, $intro, $evaluation);

        if ($result) {
            redirect(base_url().ADMINROUTE.'artist');
        }
    }

    /**
     * [update_artist 更新艺术家].
     *
     * @return [type] [description]
     */
    public function update_artist()
    {
        $aid = $this->sc->input('aid');
        $img = $this->sc->input('img');
        $name = $this->sc->input('artist_name');
        $intro = $this->sc->input('intro');
        $evaluation = $this->sc->input('evaluation');

        //已有图片
        if ($img == null) {
            $image_id = $this->sc->input('image_id');
            $result = $this->artist_service->update_artist($aid, $this->user['id'], $name, $image_id, $intro, $evaluation);

            if ($result) {
                redirect(base_url().ADMINROUTE.'artist');
            }
        }
        //重新上传图片
        else {
            $img = explode('/', $img);
            $img = $img[count($img) - 1];
            $x = $this->sc->input('x');
            $y = $this->sc->input('y');
            $w = $this->sc->input('w');
            $h = $this->sc->input('h');
            $image_id = $this->image_service->crop_image($img, $x, $y, $w, $h)['image_id'];
            $result = $this->artist_service->update_artist($aid, $this->user['id'], $name, $image_id, $intro, $evaluation);

            if ($result) {
                redirect(base_url().ADMINROUTE.'artist');
            }
        }

        $this->message->error();
    }

    public function publish()
    {
        $id = $this->sc->input('id');

        $result = $this->artist_service->publish($id);

        if ($result) {
            $output = array(
                'success' => 0,
            );
            echo json_encode($output);
        } else {
            $output = array(
                'error' => -1,
            );
            echo json_encode($output);
        }
    }

    public function cancel_publish()
    {
        $id = $this->sc->input('id');

        $result = $this->artist_service->cancel_publish($id);

        if ($result) {
            $output = array(
                'success' => 0,
            );
            echo json_encode($output);
        } else {
            $output = array(
                'error' => -1,
            );
            echo json_encode($output);
        }
    }
}
