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
            'error.js',
            'geo.js',
            'ajaxfileupload.js'
        );


        $user['user']         = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', TRUE);
        $body = array();

        $body['top']          = $this->load->view('common/top', $user, TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);

        $address = $this->user_service->get_address($this->user['id']);
        $body['user']= $this->user_service->get_user_by_id($this->user['id']);
//        $body['user']         = $this->user;

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
            foreach ($address as $key => $value) {
                $body['user'][$key] = $value;
            }

            $this->load->view('common/head', $data);
			$this->load->view('setting', $body);
//            echo json_encode($body);
		}
	}


	/**
	 * [change_password 修改密码]
	 * @return [type] [description]
	 */
	public function change_password()
	{
		$old_pwd = $this->sc->input('old_pwd');
		$pwd 	 = $this->sc->input('pwd');

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
        $data = array(
            'name',
            'sex',
            'phone',
            'contact'
        );


        $data = $this->sc->input($data);
        $province = $this->sc->input('province');
        $city = $this->sc->input('city');
        $town = $this->sc->input('town');
        $address = $this->sc->input('address');

        $address = $province.$city.$town.$address;

        $data['address'] = $address;

        $result = $this->user_service->update_account($this->user['id'], $data);

        if( $result ) {
            $this->sc->output_success();
        }
        else {
            $this->sc->output_error();
        }

//        var_dump($data);

    }

    public function change_phone()
    {
        $phone = $this->sc->input('phone');
        $id = $this->user['id'];

        $result = $this->user_service->change_phone($id, $phone);

        if($result)
        {
            $this->sc->output_success();
        }
        else
        {
            $this->sc->output_error();
        }
    }
}

