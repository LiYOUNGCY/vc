<?php
class upload extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->load->view('test/upload');
	}

	public function upload_file()
	{
		$min_width = 400;
		$min_height= 400;
		$config['upload_path'] = './public/headpic/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '5000';
		$config['remove_spaces']=TRUE;

		$imgname = $this->security->sanitize_filename($_FILES['upfile']["name"]); //获取上传的文件名称
		$filetype = pathinfo($imgname, PATHINFO_EXTENSION);//获取后缀
		$config['file_name']=time().".".$filetype;
		//图片新路径
		$pic_path='public/headpic/'.$config['file_name'];		

		//上传成功
		$this->load->library('upload', $config);
		$result = $this->upload->do_upload('upfile');
		if($result)
		{
			//裁剪图片
			$this->load->library('CImage');
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
				$this->error->output('INVALID_REQUEST');
			}
		}
		else
		{
			//上传失败
			$result = array();	
			$result['error'] = $this->upload->display_errors();
		}
		header('Content-Type:text/x-json');
		echo json_encode($result);			
	}

	public function cut_image()
	{
		$img = $this->sc->input(array('img','x','y','w','h'));	
		$this->load->library('Img_shot');
		$this->img_shot->initialize($img['img'],$img['x'],$img['y'],$img['w'],$img['h']);
		$shot_name = $this->img_shot->generate_shot($img);		
		if( ! empty($shot_name))
		{
			$this->load->library('oss');
			$upload_result = $this->oss->upload_by_file($shot_name);
			if($upload_result)
			{
				$osspath = OSS_URL."/{$shot_name}";
				echo var_dump($osspath);
				//$this->load->model('user_model');
			}
		}
	}

}