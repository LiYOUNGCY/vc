<?php

class Setting extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->service('user_service');
		$this->load->service('auth_service');
	}

	public function index($type = "user") {

        $data['css'] = array(
            'font-awesome/css/font-awesome.min.css',
            'base.css',
            'alert.css',
            'radiocheck.min.css'
        );

        $data['javascript'] = array(
            'jquery.js',
            'alert.min.js',
            'validate.js',
            'error.js',
            'geo.js'
        );


        $user['user']         = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', TRUE);

        $body['top']          = $this->load->view('common/top', $user, TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;


		if($type == 'safe')
		{
			//修改密码
            $data['title'] = '安全设置';
            $this->load->view('common/head', $data);
			$this->load->view('safe', $body);
		}
		//修改个人信息的页面
		else if($type == 'user')
		{
            $data['title'] = '修改个人信息';
            $this->load->view('common/head', $data);
			$this->load->view('setting', $body);
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
		$arr 	= array('name', 'sex', 'address', 'tel', 'email', 'phone');
		$data = $this->sc->input($arr);

		//更新用户资料
		$result = $this->user_service->update_account($this->user['id'], $data);
		if($result)
		{
			//更新 session 的信息

			$this->auth_service->set_login_session($this->user_service->get_user_base_id($this->user['id']));

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

