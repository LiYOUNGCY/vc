<?php
class Image_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CImage');
		$this->load->library('Oss');
	}

	/**
	 * [up_um_img UMeditor上传图片]
	 * @return [type] [description]
	 */
	public function up_um_img($fileField, $config)
	{
		$result = FALSE;
		$this->load->library('Um_upload',array(
						'fileField' => $fileField,
						'config'	=> $config
						));

		$up_result = $this->um_upload->upFile();

		//上传到本服务器成功
		if($up_result)
		{
			$osspath = $this->um_upload->getFileInfo();

			$osspath = !empty($osspath['url']) ? $osspath['url'] : NULL;

			/**
			 * [生成缩略图]
			 * $tofile [缩略图本地保存路径]
			 * $osspath[原图本地保存路径]
			 */
			$toFile = Common::get_thumb_url($pic_path,'thumb1_');
			$thumb_result = $this->cimage->img2thumb($osspath,$toFile,300,230,1);

			//生成缩略图成功
			if($thumb_result)
			{
				//上传缩略图到oss
				$toFile = substr($toFile, 2);
				$oss_result = $this->oss->upload_by_file($toFile);
				//缩略图上传成功
				if($oss_result)
				{
					/**
					 * [上传原图到oss]
					 * $oss_result [type]
					 */
					$osspath = substr($osspath, 2);
					$oss_result = $this->oss->upload_by_file($osspath);

					//设置上传结果
					$result = $oss_result;

					//上传原图成功
					if($oss_result)
					{
						//设置图片url
						$this->um_upload->setFullName(OSS_URL."/{$osspath}");
					}
					//失败
					else
					{
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
		$min_height= 400;
		$config['upload_path'] = './public/headpic/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '5000';
		$config['remove_spaces']=TRUE;
		if( isset($_FILES[$form_name]))
		{
			$imgname = $this->security->sanitize_filename($_FILES[$form_name]["name"]); //获取上传的文件名称
			$filetype = pathinfo($imgname, PATHINFO_EXTENSION);//获取后缀
			$config['file_name']=time()."_{$uid}.".$filetype;
			//图片新路径
			$pic_path=substr($config['upload_path'],2).$config['file_name'];

			$this->load->library('upload', $config);
			$upload_result = $this->upload->do_upload($form_name);
			//上传成功
			if($upload_result)
			{
				//裁剪图片
				$thumb_result = $this->cimage->img2thumb("./{$pic_path}","./{$pic_path}",$min_width,$min_height,1);
				if($thumb_result)
				{
					//裁剪成功
					$result = array();
					$result['success']  = 0;
					$result['filepath'] = $pic_path;
				}
				else
				{
					//删除原图并输出错误
					@unlink("./{$pic_path}");
					$result['error'] = lang('error_INVALID_REQUEST');
				}
			}
			//上传失败
			else
			{
				$result = array();
				$result['error'] = $this->upload->display_errors();
			}
		}
		else
		{
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
		$this->img_shot->initialize($filename,$x,$y,$w,$h);
		$shot_name = $this->img_shot->generate_shot($filename);
		//成功
		if( ! empty($shot_name))
		{
			$upload_result = $this->oss->upload_by_file($shot_name);
			if($upload_result)
			{
				$osspath = OSS_URL."/{$shot_name}";
				$this->load->model('user_model');
				$update_result = $this->user_model->update_account($uid,array('pic' => $osspath));
				if($update_result)
				{
					@unlink("./{$filename}");
					return TRUE;
				}
				else
				{
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
        $this->img_shot->initialize($filename,$x,$y,$w,$h);
        $shot_name = $this->img_shot->generate_shot($filename);
        //成功
        if( ! empty($shot_name))
        {
            $upload_result = $this->oss->upload_by_file($shot_name);
            if($upload_result)
            {
                $osspath = OSS_URL."/{$shot_name}";
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
		$config['remove_spaces']=TRUE;
		if( isset($_FILES[$form_name]))
		{
			$imgname = $this->security->sanitize_filename($_FILES[$form_name]["name"]); //获取上传的文件名称
			$filetype = pathinfo($imgname, PATHINFO_EXTENSION);//获取后缀
			$config['file_name']=time()."_{$uid}.".$filetype;
			//图片新路径
			$pic_path=substr($config['upload_path'],2).$config['file_name'];

			$this->load->library('upload', $config);
			$upload_result = $this->upload->do_upload($form_name);

			//判断宽高是否超出限制
			$src_w 		= $this->upload->data('image_width');
			$src_h 	    = $this->upload->data('image_height');
			if($src_w < 600)
			{
				@unlink("./{$pic_path}");
				$result['error'] = lang('error_OVER_SIZE');
				return $result;
			}
			//最小宽
			$min_width  = 300;
			$min_width1 = 600;
			$min_height = $src_h * ($min_width / $src_w);
			$min_height1= $src_h * ($min_width1 / $src_w);
			//上传成功
			if($upload_result)
			{
				/**
				 * [生成缩略图]
				 * $tofile [缩略图本地保存路径]
				 * $osspath[原图本地保存路径]
				 */
				$toFile = Common::get_thumb_url($pic_path,'thumb1_');
				$toFile1= Common::get_thumb_url($pic_path,'thumb2_');
				$thumb_result = $this->cimage->img2thumb("./{$pic_path}","./{$toFile}",$min_width,$min_height,1);
				$thumb_result1= $this->cimage->img2thumb("./{$pic_path}","./{$toFile1}",$min_width1,$min_height1,1);
				//生成缩略图成功
				if($thumb_result && $thumb_result1)
				{
					//上传缩略图到oss
					$oss_result = $this->oss->upload_by_file($toFile);
					$oss_result1= $this->oss->upload_by_file($toFile1);
					//缩略图上传成功
					if($oss_result && $oss_result1)
					{
						/**
						 * [上传原图到oss]
						 * $oss_result [type]
						 */
						$oss_result = $this->oss->upload_by_file($pic_path);
						//设置上传结果
						$result = $oss_result;

						//上传原图成功
						if($oss_result)
						{
							//设置图片url
							$result = array();
							$result['success']  = 0;
							$result['pic']   = OSS_URL."/{$pic_path}";
							$result['thumb'] = OSS_URL."/{$toFile1}" ;
						}
						//失败
						else
						{
							//删除oss上缩略图
							$this->oss->delete_object($toFile);
							$this->oss->delete_object($toFile1);
						}
					}
					//删除本地缩略图
					@unlink($toFile);
					@unlink($toFile1);
				}
				else
				{
					$result['error'] = lang('error_INVALID_REQUEST');
				}
				//删除原图
				@unlink("./{$pic_path}");
			}
			//上传失败
			else
			{
				$result = array();
				$result['error'] = $this->upload->display_errors();
			}
		}
		else
		{
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
		$config['upload_path'] = './public/slider/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '5000';
		$config['remove_spaces']=TRUE;
		if( isset($_FILES[$form_name]))
		{
			$imgname = $this->security->sanitize_filename($_FILES[$form_name]["name"]); //获取上传的文件名称
			$filetype = pathinfo($imgname, PATHINFO_EXTENSION);//获取后缀
			$config['file_name']=time()."_{$uid}.".$filetype;
			//图片新路径
			$pic_path=substr($config['upload_path'],2).$config['file_name'];

			$this->load->library('upload', $config);
			$upload_result = $this->upload->do_upload($form_name);

			//最小宽
			$min_width  = 960;
			$min_width1 = 470;
			//上传成功
			if($upload_result)
			{
				/**
				 * [生成缩略图]
				 * $tofile [缩略图本地保存路径]
				 * $osspath[原图本地保存路径]
				 */
				$thumb_result = $this->cimage->img2thumb("./{$pic_path}","./{$pic_path}",$min_width,$min_height,1);
				//生成缩略图成功
				if($thumb_result)
				{
					/**
					 * [上传缩略图到oss]
					 * $oss_result [type]
					 */
					$oss_result = $this->oss->upload_by_file($pic_path);
					//设置上传结果
					$result = $oss_result;

					//上传原图成功
					if($oss_result)
					{
						//设置图片url
						$result = array();
						$result['success']  = 0;
						$result['pic']   = OSS_URL."/{$pic_path}";
					}
				
				}
				else
				{
					$result['error'] = lang('error_INVALID_REQUEST');
				}
				//删除原图
				@unlink("./{$pic_path}");
			}
			//上传失败
			else
			{
				$result = array();
				$result['error'] = $this->upload->display_errors();
			}
		}
		else
		{
			$result = array();
			$result['error'] = lang('error_INVALID_REQUEST');
		}
		return $result;		
	}
}
