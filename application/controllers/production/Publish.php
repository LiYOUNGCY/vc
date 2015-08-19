<?php
class Publish extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('production_service');
	}

	public function index($type = 'publish', $pid = NULL)
	{
		$head['css'] = array(
			'base.css',
			'font-awesome/css/font-awesome.min.css',
			'alert.css',
			'jquery.Jcrop.css'
		);

		$head['javascript'] = array(
			'jquery.js',
			'error.js',
			'timeago.js',
			'alert.min.js',
			'autosize.js',
			'ajaxfileupload.js'
		);

		$user['user']= $this->user;
		$data['top'] = $this->load->view('common/top', $user, TRUE);

		if($type == 'publish')
		{
			$head['title'] = '发布艺术品';
			$this->load->view('common/head', $head);
			$this->load->view('publish_production', $data);
		}
		else if($type == 'update')
		{
			if( ! is_numeric($pid))
			{
				show_404();
			}
			$production = $this->production_service->get_production_by_id($pid);
			if(empty($production))
			{
				show_404();
			}

			echo var_dump($production);
		}
	}

	/**
	 * [publish_production 发布艺术品]
	 * @return [type] [description]
	 */
	public function publish_production()
	{
        $error_redirect = array(
            'script' => "window.location.href='".base_url()."publish/production';"
        );
        $this->sc->set_error_redirect($error_redirect);

        $arr = $this->sc->input(array('production_name','production_intro','aid','price','pic','l','w','h','type','marterial','creat_time'));

		$result = $this->production_service->publish_production(
			$arr['name'],$this->user['id'],$arr['production_intro'],
			$arr['price'],$arr['pic'],$arr['l'],$arr['w'],$arr['h'],
			$arr['type'],$arr['marterial'],$arr['creat_time']);
		if($result)
		{

			redirect(base_url().'production/'.$result,'location');			
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().'publish/production";'));
		}
	}

	/**
	 * [update_production 更新艺术品]
	 * @return [type] [description]
	 */
	public function update_production()
	{
		$pid = $this->input->post('pid');
		if( ! is_numeric($pid))
		{
			show_404();
		}

        $error_redirect = array(
            'script' => "window.location.href='".base_url()."update/production/".$pid."';"
        );
        $this->sc->set_error_redirect($error_redirect);


		$arr = $this->sc->input(array('pid','production_name','production_intro','aid','price','pic','l','w','h','type','marterial','creat_time','status'));	
		$result = $this->production_service->update_production(
			$arr['pid'],$this->user['id'],$arr['name'],$arr['intro'],
			$arr['aid'],$arr['price'],$arr['pic'],$arr['l'],$arr['w'],
			$arr['h'],$arr['type'],$arr['marterial'],$arr['creat_time'],$arr['status']);
		if($result)
		{
			redirect(base_url().'production/'.$pid,'location');
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' =>  'window.location.href="'.base_url().'update/production/'.$pid.'";'));
		}

	}
}