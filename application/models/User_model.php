<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends CI_Model
{
  private $base_field;
	public function __construct()
	{
		parent::__construct();
		$this->load->library('passwordhash');
		$this->passwordhash->setPasswordHash(8, FALSE);

        $this->base_field = array('id', 'name', 'pic', 'role', 'honour', 'email_status','phone','email','address',);
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
        $register_type['pic'] = base_url().'public/img/pfp7.png';

		$this->db->insert('user', $register_type);
        $uid = $this->db->insert_id();

		//注册成功
		if($this->db->affected_rows() === 1)
        {
            //插入 user_online 表
            $this->_insert_user_online($uid);
            $this->db->insert('user_address', array('uid'=>$uid));

            return $uid;
		}
        $this->error->output('register_error');
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
            //$query = $query->where('email_status', 1);
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


        $address['address'] = $update['address'];
        $address['contact'] = $update['contact'];
        $address['phone']   = $update['phone'];

        unset($update['uid']);
        unset($update['address']);
        unset($update['contact']);
        unset($update['phone']);

        $result1 = true;

        //更新 收货信息
        $this->db->where('uid', $uid)->update('user_address', $address);
        if( $this->db->affected_rows() !== 1 ) {
            $result1 = false;
        }


    	//删除敏感字段
    	unset($update['pwd']);
    	$this->db->where('id', $uid)->update('user', $update);
        return (($this->db->affected_rows() === 1 ) || $result1);
    }


    public function get_address($uid) {
        return $this->db->where('uid', $uid)->get('user_address')->row_array();
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
        $this->error->output('old_password_error',array('script' => 'window.location.href = "'.base_url().'setting/pwd";'));
    }
    /**
     * [update_password 更新用户密码]
     * @param  [type] $uid [用户id]
     * @param  [type] $pwd [密码]
     * @return [type]      [description]
     */
    public function update_password($uid, $pwd)
    {
      $this->db->where('id',$uid)->update('user',array('pwd' => $this->passwordhash->HashPassword($pwd)));
      return $this->db->affected_rows() === 1;
    }

    /**
     * [get_user_list 获取用户列表]
     * @param  [type]  $page   [页数]
     * @param  integer $limit  [页面个数限制]
     * @param  string  $order  [排序]
     * @param  array  $custom  [自定义条件查询]
     * @return [type]          [description]
     */
    public function get_user_list($page = 0, $limit = 10, $order = 'id DESC', $custom = array())
    {
      if( ! empty($custom))
      {
        $this->db->select($custom);
      }
      else
      {
        $this->db->select('user.id,user.name,role,user_role.name as role_name,phone,email,forbidden,register_time,user_online.last_active');
      }
      $query = $this->db->join('user_online','user.id = user_online.uid','left')
                        ->join('user_role','user.role = user_role.id','left')
                        ->order_by($order)
                        ->limit($limit,$page*$limit)
                        ->get('user')
                        ->result_array();
      return $query;
    }

    /**
     * [get_user_count 获取用户数量]
     * @return [type] [description]
     */
    public function get_user_count()
    {
       return $this->db->count_all('user');
    }

    public function delete_user($uid)
    {
        $this->db->where_in('id',$uid)->delete('user');
        $this->db->where_in('uid',$uid)->delete('user_online');
        return $this->db->affected_rows() > 0;
    }

    /**
     * [get_role_list 获得角色列表]
     * @return [type] [description]
     */
    public function get_role_list()
    {
      $query = $this->db->get('user_role')->result_array();
      return $query;
    }


    public function get_role_count()
    {
        $query = $this->db->count_all('user_role');
        return $query;
    }

    public function delete_role($roles)
    {
        $this->db->where_in('id',$roles)->delete('user_role');
        return $this->db->affected_rows() > 0;
    }

    public function add_role($name)
    {
        $data = array(
            'name'  => $name
        );

        $this->db->insert('user_role', $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_role_by_id($id)
    {
        $query = $this->db->where('id', $id)->get('user_role')->row_array();
        return $query;
    }

    public function update_role_by_id($id, $data)
    {
        unset($data['id']);
        $this->db->where('id', $id)->update('user_role', $data);
        return $this->db->affected_rows() === 1;
    }

    /**
     * [get_user_online_by_id 获得用户的登录信息]
     * @return [type] [description]
     */
    public function get_user_online_by_id($uid)
    {
       $query = $this->db->where('uid',$uid)->get('user_online')->row_array();
       return $query;
    }


    /**
     * [insert_user 添加用户]
     * @return [type] [description]
     */
    public function insert_user($arr)
    {
        if(isset($arr['pwd']))
        {
            $arr['pwd'] = $this->passwordhash->HashPassword($arr['pwd']);
        }
        $this->db->insert('user',$arr);
        $uid = $this->db->insert_id();
        if($uid)
        {
             //插入 user_online 表
            $this->_insert_user_online($uid);
            //更新默认键值
            $this->update_account($uid,array('alias' => 'home/uid_'.$uid,'pic' => base_url().'public/img/pfp7.png'));
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function active_email_status($uid)
    {
        $this->db->where('id', $uid)->update('user', array('email_status'=>1));
    }

    public function change_phone($id, $phone) {
        $this->db->where('id', $id)->update('user', array('phone'=>$phone));
        return $this->db->affected_rows() === 1;
    }
}
