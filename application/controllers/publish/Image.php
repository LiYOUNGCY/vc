<?php

class Image extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('image_service');
    }

    /**
     * [up_um_img UMeditor上传图片].
     *
     * @return [type] [description]
     */
    public function up_um_img()
    {
        //上传配置
        $config = array(
            'savePath' => './public/upload/',                                   //存储文件夹
            'allowFiles' => array('.gif', '.png', '.jpg', '.jpeg', '.bmp'),   //允许的文件格式
        );
        //上传文件域名
        $fileField = 'upfile';
        if (isset($_FILES[$fileField])) {
            $info = $this->image_service->up_um_img($fileField, $config);

            $callback = isset($_GET['callback']) ? $_GET['callback'] : null;
            //返回数据
            if ($callback) {
                echo '<script>'.$callback.'('.json_encode($info).')</script>';
            } else {
                echo json_encode($info);
            }
        }
    }

    /**
     * [upload_headpic 上传头像].
     *
     * @return [type] [description]
     */
    public function upload_headpic()
    {
        $uid = $this->user['id'];
        $result = $this->image_service->upload_headpic('upfile', $uid);
        header('Content-Type:application/json');
        echo json_encode($result);
    }

    /**
     * [save_headpic 保存裁剪后的头像].
     *
     * @return [type] [description]
     */
    public function save_headpic()
    {
        $img = $this->sc->input(array('img', 'x', 'y', 'w', 'h'));
        $uid = $this->user['id'];
        $result = $this->image_service->save_headpic($img['img'], $img['x'], $img['y'], $img['w'], $img['h'], $uid);
        if ($result) {
            redirect(base_url().'feed', 'location');
        } else {
            $this->error->output('INVALID_REQUEST', array('script' => 'window.location.href = "'.base_url().'feed";'));
        }
    }

    /**
     * [upload_production 上传艺术品图].
     *
     * @return [type] [description]
     */
    public function upload_production()
    {
        $uid = $this->user['id'];
        $result = $this->image_service->upload_production('upfile', $uid);
        header('Content-Type:application/json');
        echo json_encode($result);
    }

    /**
     * [upload_slider 上传轮播图].
     *
     * @return [type] [description]
     */
    public function upload_slider()
    {
        $uid = $this->user['id'];
        $result = $this->image_service->upload_slider('upfile', $uid);
        header('Content-Type:application/json');
        echo json_encode($result);
    }

    public function upload_image()
    {
        $result = $this->image_service->upload_image_with_thumb('image_upload', 300, null);
        header('Content-Type:application/json');

        if ($result != false) {
            $this->message->success($result);
        }

        $this->message->error();
    }

    /**
     * 专题上传图片.
     */
    public function upload_topic_image()
    {
        $result = $this->image_service->upload_image_with_thumb('image_upload', 300, 188);
        header('Content-Type:application/json');

        if ($result != false) {
            $this->message->success($result);
        }

        $this->message->error();
    }

    /**
     * [upload_avatar 上传艺术家头像].
     *
     * @return [type] [description]
     */
    public function upload_avatar()
    {
        $result = $this->image_service->upload_avatar('image_upload');
        header('Content-Type:application/json');
        echo json_encode($result);

        // $this->message->error();
    }

    /**
     * [crop_image 裁剪图片].
     */
    public function crop_image()
    {
        $image = $this->sc->input('img');
        $x = $this->sc->input('x');
        $y = $this->sc->input('y');
        $w = $this->sc->input('w');
        $h = $this->sc->input('h');

        $image_name = explode('/', $image);
        $image_name = $image_name[count($image_name) - 1];

        $this->image_service->crop_image($image_name, $x, $y, $w, $h);

        $this->message->success();
    }
}
