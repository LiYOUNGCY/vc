<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [index 显示管理员主面板]
	 * @return [type] [description]
	 */
	public function index()
	{
		$navbar = $this->load->view('admin/common/navbar',"",TRUE);
		$foot = $this->load->view('admin/common/foot',"",TRUE);				
		$body['navbar'] = $navbar;	
		$body['foot']	= $foot;

		$this->load->view('admin/common/head');		
		$this->load->view('admin/main',$body);
	}

	/**
	 * [logout 注销]
	 * @return [type] [description]
	 */
	public function logout()
	{
		$this->load->service('user_service');
		$this->user_service->logout();
		redirect(base_url().ADMINROUTE.'login','location');
	}
}