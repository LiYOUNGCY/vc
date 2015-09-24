<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Main extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('user_service');
	}


	public function index($type = 'forget')
	{
		$data['css'] = array(
            'swiper.min.css',
            'font-awesome/css/font-awesome.min.css',
            'base.css'
            
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'error.js',
            'validate.js'
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', TRUE);
       
        $data['title']        = "忘记密码";
        $body['top']          = $this->load->view('common/top', $user, TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('forget_pwd', $body);
	}

	/**
	 * [login_by_email 邮箱登陆]
	 */
	public function login_by_email()
	{
		$email 		= $this->sc->input('email');
		$pwd   		= $this->sc->input('pwd');
		$rememberme = $this->sc->input('rememberme');

		$result = $this->user_service->login_action($pwd, $email, NULL, $rememberme);
		if($result)
		{
			//登陆成功, 重定向
			echo json_encode(array('success' => 0, 'note' => '','script' => 'window.location.reload();'));
		}
		else
		{
			$this->error->output('LOGIN_ERROR');
		}

	}


	/**
	 * [login_by_phone 手机号码登陆]
	 */
	public function login_by_phone()
	{
		$phone 		= $this->sc->input('phone');
		$pwd   		= $this->sc->input('pwd');
		$rememberme = $this->sc->input('rememberme');

		$result = $this->user_service->login_action($pwd, NULL, $phone, $rememberme);
		if($result)
		{
			//登陆成功, 重定向
			echo json_encode(array('success' => 0, 'note' => '','script' => 'window.location.reload();'));
		}
		else
		{
			$this->error->output('LOGIN_ERROR');
		}
	}

	/**
	 * [logout 注销]
	 * @return [type] [description]
	 */
	public function logout()
	{
		$this->user_service->logout();
		//重定向至首页
		redirect(base_url(),'location');
	}

	/**
	 * [register 邮箱注册]
	 */
	public function register_by_email()
	{
		$email 	= $this->sc->input('email');
		$name   = $email;
		$pwd 	= $this->sc->input('pwd');


		$result = $this->user_service->register_action($name, $pwd, $email, NULL);
		if($result)
		{
			//注册成功, 重定向首页
			echo json_encode(array('success' => 0, 'note' => '','script' => 'window.location.href="'.base_url().'";'));
		}
		else
		{
			$this->error->output('REGISTER_ERROR');
		}

	}


	/**
	 * [register_by_phone 手机号码注册]
	 */
	public function register_by_phone()
	{
		$phone 	= $this->sc->input('phone');
		$name   = $phone;
		$pwd 	= $this->sc->input('pwd');

		$result = $this->user_service->register_action($name, $pwd, NULL, $phone);
		if($result)
		{
			//注册成功, 重定向首页
			echo json_encode(array('success' => 0, 'note' => '','script' => 'window.location.href="'.base_url().'";'));
		}
		else
		{
			$this->error->output('REGISTER_ERROR');
		}
	}

	/**
	 * [check_phone 查看手机是否重复]
	 * @return [type] [description]
	 */
	public function check_phone()
	{
		$phone  = $this->sc->input('phone');
		$result = $this->user_service->check_phone($phone);
		if($result)
		{
			$this->error->output('PHONE_REPEAT');
		}
		else
		{
			echo json_encode(array('success' => 0));
		}

	}

	/**
	 * [check_email 查看邮箱是否重复]
	 * @return [type] [description]
	 */
	public function check_email()
	{
		$email  = $this->sc->input('email');
		$result = $this->user_service->check_email($email);
		if($result)
		{
			$this->error->output('EMAIL_REPEAT');
		}
		else
		{
			echo json_encode(array('success' => 0));
		}
	}


    /**
     * 发送手机验证码
     * @return [type] [description]
     */
	public function validate_phone() {
        $phone = $this->sc->input('phone');

		echo $this->user_service->validate_phone($phone);
	}

	public function get_info_by_id()
    {
        $id = $this->sc->input('id');

        $result = $this->user_service->get_user_by_id($id);
        echo json_encode($result);
    }

    public function get_time()
    {
        $currentTime = array();

        $currentTime['success'] = 0;
        $currentTime['time'] = date('Y-m-d H:i:s');

        echo json_encode($currentTime);
    }
}
