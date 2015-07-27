<?php
class Image extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CImage');
	}

	/**
	 * [up_um_img UMeditor上传图片]
	 * @return [type] [description]
	 */
	public function up_um_img()
	{
		
	    //上传配置
	    $config = array(
	        "savePath"   => "./public/upload/" ,             //存储文件夹
	        "maxSize"    => 1000 ,                          //允许的文件最大尺寸，单位KB
	        "allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" )  //允许的文件格式
	    );	    	

		$this->load->library('Um_upload',array(
						'fileField' => 'upfile',
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
			$arr = explode('/',$osspath);
			$toFile = "thumb1_".$arr[count($arr)-1];
			$arr[count($arr)-1] = $toFile;
			$toFile = implode('/', $arr);
			$thumb_result = $this->cimage->img2thumb($osspath,$toFile,300,230,1);
			/**
			 * [上传到oss]
			 * $ossresult[上传结果]
			 */
			$this->load->library('Oss');
			if($thumb_result)
			{
				//上传缩略图到oss
				$toFile = substr($toFile, 2);
				$this->oss->upload_by_file($toFile);
			}
			//上传原图到oss
			$osspath = substr($osspath, 2);			
			$oss_result = $this->oss->upload_by_file($osspath);		

			//设置上传结果
			$this->um_upload->setStateInfo($oss_result);
			//上传至oss服务器成功
			if($oss_result)
			{	
				//设置图片url
				$this->um_upload->setFullName(OSS_URL."/{$osspath}");	
			}	
			//删除本地服务器图片		
			@unlink($osspath);
			@unlink($toFile);
		}

    	$callback= isset($_GET['callback']) ? $_GET['callback'] : NULL;
		$info = $this->um_upload->getFileInfo();

		//返回数据
		if($callback) {
	        echo '<script>'.$callback.'('.json_encode($info).')</script>';
	    } else {
	        echo json_encode($info);
	    }			
	}

	
}