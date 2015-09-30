<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User_service extends MY_Service
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->service('auth_service');
        $this->load->model('email_model');
	}


	/**
	 * [register_action 用户注册]
	 */
	public function register_action($name, $pwd, $email, $phone)
	{
		$register_type = array();
		if( !empty($phone) )
		{
			$register_type['phone'] = $phone;
		}
		else if( !empty($email) )
		{
			$register_type['email'] = $email;
		}
		else
		{
			//错误
			return FALSE;
		} 
        $user_id = $this->user_model->register_action($name, $register_type, $pwd);
		//注册成功，设置 session
		if ( !empty($user_id))
        {
			$user = $this->user_model->get_user_base_id($user_id);

            $this->validate_email($user_id, $email);
            //设置 SESSION
            $this->auth_service->set_login_session($user);
            return TRUE;
		}
        return FALSE;
	}

    public function active_email($token)
    {
        $result = $this->email_model->active_email($token);

        if( $result != FALSE && is_numeric($result) )
        {
            //到 user 表更新 email_status 字段
            $this->user_model->active_email_status($result);
            return TRUE;
        }
        return FALSE;
    }


	/**
	 * [login_action 用户登录]
	 */
	public function login_action($pwd, $email, $phone, $rememberme)
	{
		$login_type = array();

		if( ! empty($phone) )
		{
			$login_type ['phone'] = $phone;
		}
		else if( ! empty($email) )
		{
			$login_type ['email'] = $email;
		}
		else
		{
            return FALSE;
		}

		$user = $this->user_model->login_action($login_type, $pwd);
        if( ! empty($user))
        {
            if($rememberme)
            {
                //设置 cookie
                $this->auth_service->set_remember_me_cookie($user);
            }
            //设置 SESSION
            $this->auth_service->set_login_session($user);
            return $user;
        }
        else
        {
            return FALSE;
        }

	}

    /**
     * [logout 注销]
     * @return [type] [description]
     */
    public function logout()
    {
        $this->load->helper('cookie');
        // $this->load->library('session');
        delete_cookie('rmcn');

        session_destroy();
        
    }

    /**
     * [update_count 更新用户字段数量]
     * @param  [type] $uid    [用户id]
     * @param  [type] $name   [字段名称]
     * @param  [type] $amount [数量]
     * @return [type]         [description]
     */
    public function update_count($uid, $name, $amount)
    {
        return $this->user_model->update_count($uid,array('name' => $name, 'amount' => $amount));
    }


    /**
     * [get_user_by_id 获取用户信息]
     */
    public function get_user_by_id($uid,$custom = NULL)
    {
    	return $this->user_model->get_user_by_id($uid,$custom);
    }


    /**
     * [update_account 更新个人信息]
     */
    public function update_account($uid, $data)
    {
    	//清除值为空的变量
    	$this->_clear($data);
    	return $this->user_model->update_account($uid, $data);
    }


    /**
     * [get_user_base_id 获得用户的基本的信息]
     */
    public function get_user_base_id($uid)
    {

        return $this->user_model->get_user_base_id($uid);
    }


    /**
     * [change_password 更改密码]
     */
    public function change_password($uid, $old_pwd, $new_pwd)
    {
    	if(isset($old_pwd, $new_pwd))
    	{
    		return $this->user_model->change_password($uid, $old_pwd, $new_pwd);
    	}
    	return FALSE;
    }

    /**
     * [check_email 查看邮箱是否重复]
     * @param  [type] $email [邮箱]
     * @return [type]        [description]
     */
    public function check_email($email)
    {
    	return $this->user_model->have_email($email);
    }

    /**
     * [check_phone 查看手机是否重复]
     * @param  [type] $phone [手机]
     * @return [type]        [description]
     */
    public function check_phone($phone)
    {
    	return $this->user_model->have_phone($phone);
    }

    public function validate_phone($phone)
    {
        //生成 token
        $factory    = new RandomLib\Factory();
        $generator  = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));
        $code       = $generator->generateString(4, '1234567890');

        $this->load->library('phone_validate');
        $result = json_decode($this->phone_validate->send_code($phone, $code));
        // var_dump($result);
        $result->code = $code;

        return json_encode($result);
    }


    /**
     * 发送注册邮件
     */
    public function validate_email($uid, $email)
    {
        //生成 token
        $factory = new RandomLib\Factory();
        $generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));
        $token = md5(md5($generator->generate(128)).time());

        //发邮件
        $this->send_email($email, $token);


        $this->email_model->insert_token($uid, $token);
    }

    private function send_email($email, $token)
    {


        $this->load->library('email');

        $this->email->from('rachechenmu@163.com', 'Artvc');
        $this->email->to($email);

        $url = base_url().'account/email/active?token=';

        $this->email->subject('Artvc账号激活邮件');
        $this->email->message("你可以通过下面的链接激活您的账号。\n {$url}{$token}");

        $this->email->send();
    }

    public function change_phone($id, $phone) {
        return $this->user_model->change_phone($id, $phone);
    }


    /**
     * [_clear 清除值为空的变量]
     * @param  [array] $data [description]
     * @return [type]       [description]
     */
    private function _clear($data)
    {
        foreach ($data as $key => $value)
        {
            if(is_string($data[$key]))
            {
                //去除字符串两端的空格
                $data[$key] = trim($data[$key]);
            }
            //unset 空的变量
            if(empty($data[$key]))
            {
                unset($data[$key]);
            }
        }
        return $data;
    }
}
