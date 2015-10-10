<?php


//使用 image-workshop 库
use PHPImageWorkshop\ImageWorkshop;

class Image_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Cimage');
        $this->load->library('Oss');
        $this->load->model('image_model');

        //图片默认的路径
        $this->dir = 'public/image/';
    }

    /**
     * [up_um_img UMeditor上传图片]
     * @return [type] [description]
     */
    public function up_um_img($fileField, $config)
    {
        $result = FALSE;
        $this->load->library('Um_upload', array(
            'fileField' => $fileField,
            'config' => $config
        ));

        $up_result = $this->um_upload->upFile();
        //上传到本服务器成功
        if ($up_result) {
            $osspath = $this->um_upload->getFileInfo();

            $osspath = !empty($osspath['url']) ? $osspath['url'] : NULL;
            $arr = getimagesize($osspath);
            $min_width = 300;
            $min_height = 230;
            if (!empty($arr)) {
                $min_height = $arr[1] * ($min_width / $arr[0]);
                $min_height = $min_height > 230 ? $min_height : 230;
            }
            /**
             * [生成缩略图]
             * $tofile [缩略图本地保存路径]
             * $osspath[原图本地保存路径]
             */
            $toFile = Common::get_thumb_url($osspath, 'thumb1_');
            $thumb_result = $this->cimage->img2thumb($osspath, $toFile, $min_width, $min_height, 1);

            //生成缩略图成功
            if ($thumb_result) {
                //上传缩略图到oss
                $toFile = substr($toFile, 2);
                $oss_result = $this->oss->upload_by_file($toFile);
                //缩略图上传成功
                if ($oss_result) {
                    /**
                     * [上传原图到oss]
                     * $oss_result [type]
                     */
                    $osspath = substr($osspath, 2);
                    $oss_result = $this->oss->upload_by_file($osspath);

                    //设置上传结果
                    $result = $oss_result;

                    //上传原图成功
                    if ($oss_result) {
                        //设置图片url
                        $this->um_upload->setFullName(OSS_URL . "/{$osspath}");
                    } //失败
                    else {
                        //删除oss上缩略图
                        $this->oss->delete_object($toFile);
                    }
                }

                //删除本地缩略图
                @unlink($toFile);
            }
            //删除本地服务器图片
            @unlink($osspath);
        }
        //设置上传结果
        $this->um_upload->setStateInfo($result);
        $info = $this->um_upload->getFileInfo();
        return $info;
    }

    /**
     * [upload_headpic 上传头像]
     * @param  [type] $form_name [表单名]
     * @return [type]            [description]
     */
    public function upload_headpic($form_name, $uid)
    {
        $min_width = 400;
        $min_height = 400;
        $config['upload_path'] = './public/headpic/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '5000';
        $config['remove_spaces'] = TRUE;
        if (isset($_FILES[$form_name])) {
            $imgname = $this->security->sanitize_filename($_FILES[$form_name]["name"]); //获取上传的文件名称
            $filetype = pathinfo($imgname, PATHINFO_EXTENSION);//获取后缀
            $config['file_name'] = time() . "_{$uid}." . $filetype;
            //图片新路径
            $pic_path = substr($config['upload_path'], 2) . $config['file_name'];

            $this->load->library('upload', $config);
            $upload_result = $this->upload->do_upload($form_name);
            //上传成功
            if ($upload_result) {
                //裁剪图片
                $thumb_result = $this->cimage->img2thumb("./{$pic_path}", "./{$pic_path}", $min_width, $min_height, 1);
                if ($thumb_result) {
                    //裁剪成功
                    $result = array();
                    $result['success'] = 0;
                    $result['filepath'] = $pic_path;
                } else {
                    //删除原图并输出错误
                    @unlink("./{$pic_path}");
                    $result['error'] = lang('error_INVALID_REQUEST');
                }
            } //上传失败
            else {
                $result = array();
                $result['error'] = $this->upload->display_errors();
            }
        } else {
            $result = array();
            $result['error'] = lang('error_INVALID_REQUEST');
        }
        return $result;
    }




    /**
     * [save_headpic 保存裁剪后的头像]
     * @param  [type] $filename [文件路径]
     * @param  [type] $x        [目标x坐标]
     * @param  [type] $y        [目标y坐标]
     * @param  [type] $w        [目标宽度]
     * @param  [type] $h        [目标高度]
     * @param  [type] $uid      [用户id]
     * @return [type]           [description]
     */
    public function save_headpic($filename, $x, $y, $w, $h, $uid)
    {
        //生成裁剪后的图
        $this->load->library('Img_shot');
        $this->img_shot->initialize($filename, $x, $y, $w, $h);
        $shot_name = $this->img_shot->generate_shot($filename);
        //成功
        if (!empty($shot_name)) {
            $upload_result = $this->oss->upload_by_file($shot_name);
            if ($upload_result) {
                $osspath = OSS_URL . "/{$shot_name}";
                $this->load->model('user_model');
                $update_result = $this->user_model->update_account($uid, array('pic' => $osspath));
                if ($update_result) {
                    @unlink("./{$filename}");
                    return TRUE;
                } else {
                    //删除oss上的文件
                    $this->oss->delete_object($shot_name);
                }
            }
        }
        //删除原图并输出错误
        @unlink("./{$filename}");
        return FALSE;
    }


    /**
     * [save_headpic 保存裁剪后的头像]
     * @param  [type] $filename [文件路径]
     * @param  [type] $x        [目标x坐标]
     * @param  [type] $y        [目标y坐标]
     * @param  [type] $w        [目标宽度]
     * @param  [type] $h        [目标高度]
     * @return [type]           [description]
     */
    public function save_artist_pic($filename, $x, $y, $w, $h)
    {
        //生成裁剪后的图
        $this->load->library('Img_shot');
        $this->img_shot->initialize($filename, $x, $y, $w, $h);
        $shot_name = $this->img_shot->generate_shot($filename);
        //成功
        if (!empty($shot_name)) {
            $upload_result = $this->oss->upload_by_file($shot_name);
            if ($upload_result) {
                $osspath = OSS_URL . "/{$shot_name}";
                @unlink("./{$filename}");
                return $osspath;
            }
        }
        //删除原图并输出错误
        @unlink("./{$filename}");
        return FALSE;
    }

    /**
     * [upload_production 上传图片(保存缩略图与原图)]
     * @param  [type] $form_name [description]
     * @param  [type] $uid       [description]
     * @return [type]            [description]
     */
    public function upload_production($form_name, $uid)
    {

        $config['upload_path'] = './public/production/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '5000';
        $config['remove_spaces'] = TRUE;
        if (isset($_FILES[$form_name])) {
            $imgname = $this->security->sanitize_filename($_FILES[$form_name]["name"]); //获取上传的文件名称
            $filetype = pathinfo($imgname, PATHINFO_EXTENSION);//获取后缀
            $config['file_name'] = time() . "_{$uid}." . $filetype;
            //图片新路径
            $pic_path = substr($config['upload_path'], 2) . $config['file_name'];

            $this->load->library('upload', $config);
            $upload_result = $this->upload->do_upload($form_name);

            //判断宽高是否超出限制
            $src_w = $this->upload->data('image_width');
            $src_h = $this->upload->data('image_height');
            /*
            if($src_w < 600)
            {
                @unlink("./{$pic_path}");
                $result['error'] = lang('error_OVER_SIZE');
                return $result;
            }
            */
            //最小宽
            $min_width = 300;
            $min_width1 = 600;
            $min_height = $src_h * ($min_width / $src_w);
            $min_height1 = $src_h * ($min_width1 / $src_w);
            //上传成功
            if ($upload_result) {
                /**
                 * [生成缩略图]
                 * $tofile [缩略图本地保存路径]
                 * $osspath[原图本地保存路径]
                 */
                $toFile = Common::get_thumb_url($pic_path, 'thumb1_');
                $toFile1 = Common::get_thumb_url($pic_path, 'thumb2_');
                $thumb_result = $this->cimage->img2thumb("./{$pic_path}", "./{$toFile}", $min_width, $min_height, 1);
                $thumb_result1 = $this->cimage->img2thumb("./{$pic_path}", "./{$toFile1}", $min_width1, $min_height1, 1);
                //生成缩略图成功
                if ($thumb_result && $thumb_result1) {
                    //上传缩略图到oss
                    $oss_result = $this->oss->upload_by_file($toFile);
                    $oss_result1 = $this->oss->upload_by_file($toFile1);
                    //缩略图上传成功
                    if ($oss_result && $oss_result1) {
                        /**
                         * [上传原图到oss]
                         * $oss_result [type]
                         */
                        $oss_result = $this->oss->upload_by_file($pic_path);
                        //设置上传结果
                        $result = $oss_result;

                        //上传原图成功
                        if ($oss_result) {
                            //设置图片url
                            $result = array();
                            $result['success'] = 0;
                            $result['pic'] = OSS_URL . "/{$pic_path}";
                            $result['thumb'] = OSS_URL . "/{$toFile1}";
                        } //失败
                        else {
                            //删除oss上缩略图
                            $this->oss->delete_object($toFile);
                            $this->oss->delete_object($toFile1);
                        }
                    }
                    //删除本地缩略图
                    @unlink($toFile);
                    @unlink($toFile1);
                } else {
                    $result['error'] = lang('error_INVALID_REQUEST');
                }
                //删除原图
                @unlink("./{$pic_path}");
            } //上传失败
            else {
                $result = array();
                $result['error'] = $this->upload->display_errors();
            }
        } else {
            $result = array();
            $result['error'] = lang('error_INVALID_REQUEST');
        }
        return $result;
    }

    /**
     * [upload_slider 上传轮播图]
     * @param  [type] $form_name [description]
     * @param  [type] $uid       [description]
     * @return [type]            [description]
     */
    public function upload_slider($form_name, $uid)
    {
        $config['upload_path'] = './public/img/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '5000';
        $config['remove_spaces'] = TRUE;
        if (isset($_FILES[$form_name])) {
            $imgname = $this->security->sanitize_filename($_FILES[$form_name]["name"]); //获取上传的文件名称
            $filetype = pathinfo($imgname, PATHINFO_EXTENSION);//获取后缀
            $config['file_name'] = time() . "_{$uid}." . $filetype;
            //图片新路径
            $pic_path = substr($config['upload_path'], 2) . $config['file_name'];

            $this->load->library('upload', $config);
            $upload_result = $this->upload->do_upload($form_name);

            //最小宽
            $min_width = 960;
            $min_height = 470;
            //上传成功
            if ($upload_result) {
                /**
                 * [生成缩略图]
                 * $tofile [缩略图本地保存路径]
                 * $osspath[原图本地保存路径]
                 */
                $thumb_result = $this->cimage->img2thumb("./{$pic_path}", "./{$pic_path}", $min_width, $min_height, 1);
                //生成缩略图成功
                if ($thumb_result) {
                    /**
                     * [上传缩略图到oss]
                     * $oss_result [type]
                     */
                    $oss_result = $this->oss->upload_by_file($pic_path);
                    //设置上传结果
                    $result = $oss_result;

                    //上传原图成功
                    if ($oss_result) {
                        //设置图片url
                        $result = array();
                        $result['success'] = 0;
                        $result['pic'] = OSS_URL . "/{$pic_path}";
                    }

                } else {
                    $result['error'] = lang('error_INVALID_REQUEST');
                }
                //删除原图
                @unlink("./{$pic_path}");
            } //上传失败
            else {
                $result = array();
                $result['error'] = $this->upload->display_errors();
            }
        } else {
            $result = array();
            $result['error'] = lang('error_INVALID_REQUEST');
        }
        return $result;
    }


    public function upload_image($field_name, $thumb_width, $thumb_heigh, $create_thumb = TRUE)
    {
        // $this->load->library('image_lib');
        $upload_config['upload_path'] = $this->dir;
        $upload_config['allowed_types'] = 'gif|jpg|png';
        $upload_config['remove_spaces'] = TRUE;
        $upload_config['encrypt_name'] = TRUE;
        $upload_config['file_ext_tolower'] = TRUE;

        $this->load->library('upload', $upload_config);
        $result = $this->upload->do_upload($field_name);
        if ( empty($result) ) {
            return false;
        }

        $file_name = $this->upload->data('file_name');
        $file = substr($upload_config['upload_path'], 0) . $file_name;

        $upload_path = $this->oss->upload_by_file($file);

        if( $create_thumb ) {
            $this->_create_thumb($file, $thumb_width, $thumb_heigh);
        }

        if (!empty($upload_path)) {
            $result = array();
            $result['oss_path'] = $upload_path;
            $result['path'] = $this->dir.$file_name;
            return $result;
        }

        return false;
    }


    /**
     * [upload_avatar 上传头像，因为头像需要裁剪，所以不上传到云服务器，等裁剪后再上传到服务器]
     * @param  [type] $field_name [description]
     * @return [type]             [description]
     */
    public function upload_avatar($field_name)
    {
        $upload_config['upload_path'] = $this->dir;
        $upload_config['allowed_types'] = 'gif|jpg|png';
        $upload_config['remove_spaces'] = TRUE;
        $upload_config['encrypt_name'] = TRUE;
        $upload_config['file_ext_tolower'] = TRUE;

        $this->load->library('upload', $upload_config);
        $result = $this->upload->do_upload($field_name);
        if ( empty($result) ) {
            return false;
        }

        $file['path'] = $this->dir.$this->upload->data('file_name');

        return $file;
    }


    /**
     * 裁剪图片
     * @param  [type] $image_name [图片的文件名，不含路径名]
     * @param  [type] $positionX  [起始X]
     * @param  [type] $positionY  [起始Y]
     * @param  [type] $newWidth   [裁剪的宽]
     * @param  [type] $newHeight  [裁剪的高]
     * @return [type]             [description]
     */
    public function crop_image($image_name, $positionX, $positionY, $newWidth, $newHeight)
    {
        $result = array();

        $layer = ImageWorkshop::initFromPath($this->dir.$image_name);
        //从左上角开始算
        $position = "LT";
        $layer->cropInPixel($newWidth, $newHeight, $positionX, $positionY, $position);

        // Saving the result
        $filename = 'Crop_'.$image_name;
        $createFolders = true;
        $backgroundColor = null; // transparent, only for PNG (otherwise it will be white if set null)
        $imageQuality = 95; // useless for GIF, usefull for PNG and JPEG (0 to 100%)

        $layer->save($this->dir, $filename, $createFolders, $backgroundColor, $imageQuality);

        //上传到 oss
        $result['image_path'] = $this->oss->upload_by_file($this->dir . $filename);

        //记录到数据库
        $result['image_id'] = $this->image_model->insert_artist_image($result['image_path'], $newWidth, $newHeight);

        //删除本地图
        // @unlink($this->dir . $filename);
        // @unlink($this->dir . $image_name);

        return $result;
    }

        /**
     * 生成缩略图
     * @param $width
     * @param $height
     * @param $path
     */
    private function _create_thumb($path, $width = null, $height = null)
    {
        $dir = 'public/image/';
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['master_dim'] = 'width';
        $config['new_image'] = $dir;
        if(isset($width))
            $config['width'] = $width;
        if(isset($height))
            $config['height'] = $height;

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();

        //上传到服务器
        $file_name = explode('/', $path);
        $file_name = $file_name[count($file_name) - 1];
        $file_name = str_replace('.', '_thumb.', $file_name);

        $newName = $dir.$file_name;

        // $newName = Common::get_thumb_url($path, 'thumb1_');
        // rename($dir.$file_name, $newName);

        $this->oss->upload_by_file($newName);
    }
}
