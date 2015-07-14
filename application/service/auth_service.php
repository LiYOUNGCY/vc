<?php 
class Auth_service extends MY_Service{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
	}
	
	/**
	 * [check_user_auth 检查用户权限]
	 * @return [type] [description]
	 */
	public function check_user_auth()
	{

		if(!empty($auths = $this->cache->memcached->get('role_auth')))
		{
			echo var_dump($auths);
			return $this->_is_auth_success($auths);
		}
		else
		{
			$auths = $this->auth_model->get_user_auth();
			$new_auths = array();
			foreach ($auths as $k => $v)
			{
				if( ! empty($v['route']) && ! empty($v['role']))
				{
					$new_auths[$v['route']] = $v['role'];
				}
			}
			$this->cache->memcached->save('role_auth',$new_auths,60);
			return $this->_is_auth_success($new_auths);
		}

	}

	/**
	 * [_is_auth_success 验证权限是否成功]
	 * @param  [type]  $auths [description]
	 * @return boolean        [description]
	 */
	private function _is_auth_success($auths)
	{
		$route = Common::get_route();
		//需权限
		if(array_key_exists($route,$auths))
		{
			$user 	   = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;
			$user_role = isset($user['role']) 	  ? $user['role'] 	  : NULL; 
			//有权限
			if(strstr($auths[$route],"|{$user_role}|"))
			{
				return TRUE;
			}
			else
			{
				//有登录权限
				if(strstr($auths[$route],"|1|") && ! empty($user))return TRUE;
				//没有权限	
				return FALSE;
			}
		}
		//无需权限
		else
		{
			return TRUE;
		}		
	}

}