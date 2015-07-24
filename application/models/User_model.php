<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends CI_Model
{
  private $base_field;
	public function __construct()
	{
		parent::__construct();
		$this->load->library('passwordhash');
		$this->passwordhash->setPasswordHash(8, FALSE);

    $this->base_field = array('id', 'name', 'pic', 'alias', 'role');
	}


	/**
	 * [register_action description]
	 * @param  [array] $register_type [array('phone' => xxx), array('email'	=> xxx)]
	 */
	public function register_action ($name, $register_type, $pwd) 
	{
		if(! ( isset($register_type['email']) || isset($register_type['phone']) ) )
		{
			return FALSE;
		}

        if( isset($register_type['email']) && $this->have_email($register_type['email']) )
        {
            $this->error->output('email_repeat');
        }
        elseif( isset($register_type['phone']) && $this->have_phone($register_type['phone']) )
        {
            $this->error->output('phone_repeat');
        }


		$register_type['pwd'] = $this->passwordhash->HashPassword($pwd);
		$register_type['name']= $name;
        $register_type['register_time'] = date("Y-m-d H:i:s", time());

		$this->db->insert('user', $register_type);
        $uid = $this->db->insert_id();

		//注册成功
		if($this->db->affected_rows() === 1) 
        {
            //插入 user_online 表
            $this->_insert_user_online($uid);

            return $uid;
		}
		else 
        {
			$this->error->output('register_error');
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
		$query = $this->db->select($this->base_field)->select('pwd');

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
			return FALSE;
		}

		$data = $query->get('user')->result_array();

		//验证密码
		if( count($data) === 1 )
		{
			$data = $data[0];

			if( $this->passwordhash->CheckPassword($pwd, $data['pwd']) )
			{
				// 删除 pwd 字段
				unset($data['pwd']);

				// 返回用户数据
				return $data;
			}
      else
      {
        return FALSE;
      }
		}
    else
    {
      return FALSE;
    }
	}


    /**
     * 当用户登录的时候，刷新 user_online 表
     */
    public function get_login_msg_by_id($uid)
    {
        $this->_update_user_online_by_id($uid);
        return $this->get_user_by_id($uid);
    }

    /**
     * [check_email 检查 email 是否重复]
     */
	public function have_email ($email)
	{
		return $this->db->where('email', $email)->from('user')->count_all_results() !== 0 ? true : false;
	}


    /**
     * [check_phone 检查 phone 是否重复]
     */
	public function have_phone ($phone)
	{
		return $this->db->where('phone', $phone)->from('user')->count_all_results() !== 0 ? true : false;
	}

	
	/**
	 * [get_user_base_id 获得用户的基本的信息]
	 */
	public function get_user_base_id($uid)
	{
		
		return $this->get_user_by_id($uid, $this->base_field);
	}

	/**
	 * [get_user_by_id 获取用户信息]
	 * @param  [type] $uid    [用户id]
	 * @param  [type] $custom [自定义查询条件]
	 */
    public function get_user_by_id($uid, $custom='')
    {
    	if( ! empty($custom))
    	{
    		$this->db->select($custom);
    	}
      $query = $this->db->where('id', $uid)->get('user')->result_array();

      //删除敏感信息
      unset($query[0]['pwd']);

      return ! empty($query) ? $query[0] : NULL;
    }


    /**
     * [_update_user_online_by_id 登陆时，更新用户的登陆时间和 ip ]
     */
    private function _update_user_online_by_id($uid)
    {
        $data = array(
            'last_active'   => date("Y-m-d H:i:s", time()),
            'ip'            => Common::getIP()
        );
        $this->db->where('uid',$uid)->update('user_online', $data);
    }


    
    /**
     * [_insert_user_online 用户注册时，插入一条信息]
     */
    private function _insert_user_online($uid)
    {
        $data = array(
            'uid'           => $uid,
            'last_active'   => date("Y-m-d H:i:s", time()),
            'ip'            => Common::getIP()
        );
        $this->db->insert('user_online', $data);
    }


    /**
     * [update_count 更新用户字段数量]
     * @param  array  $field [字段(格式:array('name'=>'like','amount'=>1))]
     * @return [type]        [description]
     */
    public function update_count($uid,$field = array()){
    	$where = array('id' => $uid);
        $query = $this->db->select($field['name'])
                          ->from('user')
                          ->where($where)
                          ->get()
                          ->row_array();
                          
        if(!empty($query)){
            $query[$field['name']]=(int)$query[$field['name']]+(int)$field['amount'];     
            $this->db->where($where)->update('user',$query);
            return $this->db->affected_rows() === 1;
        }
        else{
            return FALSE;
        }
    }


    /**
     * [update_account 更新用户信息字段]
     * @param  [type] $uid    [description]
     * @param  [type] $update [array('name'	=> 'tom', .......)]
     * @return [type]         [description]
     */
    public function update_account($uid, $update)
    {

    	if(! is_array($update))
    	{
    		return FASLE;
    	}

    	//删除敏感字段
    	unset($update['pwd']);
    	$this->db->where('id', $uid)->update('user', $update);
    	return $this->db->affected_rows() === 1;
    }


    /**
     * [change_password 更改密码]
     */
    public function change_password($uid, $old_pwd, $new_pwd)
    {
    	$pwd = $this->db->select('pwd')->where('id',$uid)->get('user')->result_array();

    	if(count($pwd) === 1)
    	{
    		$pwd = $pwd[0]['pwd'];
    		if( $this->passwordhash->CheckPassword($old_pwd, $pwd) )
    		{
    			$new_pwd = $this->passwordhash->HashPassword($new_pwd);
    			$this->db->where('id', $uid)->update('user', array('pwd' => $new_pwd));
    			return $this->db->affected_rows() === 1;
    		}
    	}
    	$this->error->output('old_password_error');
    }

}