<?php

class Setting extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->service('user_service');
	}

	public function index($type = "user") {
		$head['css'] = array(
				'common.css',
				'normalize.css',
				'default.css',
				'radiocheck.min.css',
				'font-awesome/css/font-awesome.min.css'
			);
		$head['javascript'] = array(
				'jquery.js',
				'vchome.js'
			);
		$this->load->view('common/head', $head);

		$user['user'] 	= $this->user;
        $data['sidebar']= $this->load->view('common/sidebar', $user, TRUE);
        $data['footer']	= $this->load->view('common/footer', '', TRUE);

		if($type == 'pwd')
		{
			//修改密码
			$this->load->view('set_pwd_view', $data);
		}
		//修改个人信息的页面
		else if($type == 'user')
		{
			$this->load->view('setting', $data);			
		}
	}

	/**
	 * [change_password 修改密码]
	 * @return [type] [description]
	 */
	public function change_password()
	{
		$error_redirect = array(
			'script' => 'window.location.href ="'.base_url().'setting/pwd";'
		);
		$this->sc->set_error_redirect($error_redirect);
		$old_pwd = $this->sc->input('old_pwd');
		$pwd 	 = $this->sc->input('pwd');
		$this->sc->input('confirm_pwd');

		$result = $this->user_service->change_password($this->user['id'], $old_pwd, $pwd);
		if($result)
		{
			echo "<script>alert('".lang('OPERATE_SUCCESS')."');window.location.href='".base_url()."setting/pwd';</script>";	
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}

	/**
	 * [update_account 更新个人资料]
	 * @return [type] [description]
	 */
	public function update_account()
	{
		$error_redirect = array(
			'script' => 'window.location.href ="'.base_url().'setting";'
		);
		$this->sc->set_error_redirect($error_redirect);
		$arr 	= array('name', 'alias', 'sex', 'area', 'email', 'phone', 'birthday');
		$data = $this->sc->input($arr);

		$result = $this->user_service->update_account($this->user['id'], $data);
		
		if($result)
		{
			echo "<script>alert('".lang('OPERATE_SUCCESS')."');window.location.href='".base_url()."setting';</script>";	
		}	
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href ="'.base_url().'setting";'));
		}
	}
	
	public function get_msg()
	{
		$uid = $this->user['id'];

		$data = $this->user_service->get_user_by_id($uid);

		echo json_encode($data);
	}
}