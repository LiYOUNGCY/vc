<?php

class Setting extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->service('user_service');
	}

	public function index() { 
		//修改个人信息的页面
		$this->load->view('setting');
	}


	public function change_password()
	{
		$old_pwd = $this->sc->input('old_pwd');
		$new_pwd = $this->sc->input('new_pwd');

		$this->user_service->change_password($this->user['id'], $old_pwd, $new_pwd);
	}


	public function update_account()
	{
		$arr 	= array('name', 'alias', 'sex', 'area', 'email', 'phone');
		$year 	= $this->sc->input('year');
		$mouth	= $this->sc->input('mouth');
		$day  	= $this->sc->input('day');

		$mouth 	= strlen($mouth) < 2 ? '0'.$mouth : $mouth;
		$day 	= strlen($day) < 2 ? '0'.$day : $day;

		$data = $this->sc->input($arr);

		$data['birthday'] = $year.'-'.$mouth.'-'.$day;
 

		$this->user_service->update_account($this->user['id'], $data);
	}

	public function pwd()
	{
		//加载修改密码的页面
	}

	public function get_msg()
	{
		//$uid = $this->user['id'];
		$uid = 4;

		$data = $this->user_service->get_user_by_id($uid);

		echo json_encode($data);
	}
}