<?php
class Image extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
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
			$osspath = substr($osspath, 2);
			$this->load->library('Oss');
			//上传到oss
			$oss_result = $this->oss->upload_by_file($osspath);		

			//设置上传结果
			$this->um_upload->setStateInfo($oss_result);
			//上传至oss服务器成功
			if($oss_result)
			{	
				//设置图片url
				$this->um_upload->setFullName(OSS_URL."/{$osspath}");	
				//删除本地服务器图片		
				@unlink($osspath);
			}	

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