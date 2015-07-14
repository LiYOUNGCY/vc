<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * [register_action description]
	 * @param  [array] $register_type [array('phone' => xxx), array('email'	=> xxx)]
	 * @param  [string] $pwd           [description]
	 * @return [bool]                [description]
	 */
	public function register_action ($name, $register_type, $pwd) 
	{
		if(! ( isset($register_type['email']) || isset($register_type['phone']) ) )
		{
			return NULL;
		}

		$this->load->library('passwordhash');
		$this->passwordhash->setPasswordHash(8, FALSE);


		$register_type['pwd'] = $this->passwordhash->HashPassword($pwd);
		$register_type['name']= $name;

		$this->db->insert('user', $register_type);

		//注册成功
		if($this->db->affected_rows() === 1) {
			$data = $register_type;
			return $data;
		}
		else {
			return NULL;
		}
	}


	/**
	 * [login_action description]
	 * @param  [array] $login_type [array('phone' => xxx), array('email'	=> xxx)]
	 * @param  [string] $pwd          [description]
	 * @return [type]               [description]
	 */
	public function login_action ($login_type, $pwd)
	{
		$this->load->library('passwordhash');
		$this->passwordhash->setPasswordHash(8, FALSE);


		$query = $this->db->select('*');

		if ( isset ($login_type['phone']) )
		{
			$query = $query->where('phone', $login_type['phone']);
		}
		else if( isset( $login_type['email'] ) )
		{
			$query = $query->where('email', $login_type['email']);
		}
		//调用错误
		else
		{
			return NULL;
		}

		$query = $query->get('user')->result_array();


		//验证密码
		if( count($query) === 1 && $this->passwordhash->CheckPassword($pwd, $data['pwd']) )
		{
			// 删除 pwd 字段
			unset($query[0]['pwd']);

			// 返回用户数据
			return $query;
		}

		return NULL;
	}

	public function check_email ($email)
	{
		return $this->db->where('email', $email)->from('user')->count_all_results() === 0 ?
			true : false; 
	}

	public function check_phone ($phone)
	{
		return $this->db->where('phone', $phone)->from('user')->count_all_results() === 0 ?
			true : false; 
	}
}