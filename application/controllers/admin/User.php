<?php
class User extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('auth_model');
	}

	public function index($type = 'u', $page = 0)
	{
		if($type == 'u')
		{
			//页面限制个数
			$limit= 10;
			//获取用户列表
			$user = $this->user_model->get_user_list($page);
			$count= $this->user_model->get_user_count();
			$role = $this->user_model->get_role_list();

			$navbar 	= $this->load->view('admin/common/navbar',"",TRUE);

			//分页数据
			$p = array(
				'count'   => $count,
				'page'    => $page,
				'limit'   => $limit,
				'pageurl' => base_url().ADMINROUTE.'user/u/'
			);
			
			$pagination = $this->load->view('admin/common/pagination',$p,TRUE);
			$foot 		= $this->load->view('admin/common/foot',"",TRUE);		
			//页面数据
			$body = array(
				'navbar' 	 => $navbar,
				'foot' 	 	 => $foot,
				'pagination' => $pagination,
				'user' 		 => $user,
				'role' 		 => $role
			);
 			$this->load->view('admin/common/head');	
			$this->load->view('admin/user/list',$body);
		
		}
		else
		{
			$limit= 10;
			$auth = $this->auth_model->get_user_auth($page,$limit);
			$count= $this->auth_model->get_auth_count();
			$role = $this->user_model->get_role_list();

			$navbar = $this->load->view('admin/common/navbar',"",TRUE);

			//分页数据
			$p = array(
				'count'   => $count,
				'page'    => $page,
				'limit'   => $limit,
				'pageurl' => base_url().ADMINROUTE.'user/a/'
			);
			
			$pagination = $this->load->view('admin/common/pagination',$p,TRUE);
			$foot 		= $this->load->view('admin/common/foot',"",TRUE);		
			//页面数据
			$body = array(
				'navbar' 	 => $navbar,
				'foot' 	 	 => $foot,
				'pagination' => $pagination,
				'auth' 		 => $auth,
				'role' 		 => $role
			);
 			$this->load->view('admin/common/head');	
			$this->load->view('admin/user/a_list',$body);			
		}
	}

	public function edit($type = 'u',$id)
	{
		if( !is_numeric($id))
		{
			show_404();
		}		
		//用户编辑页面显示
		if($type == 'u')
		{

			$user = $this->user_model->get_user_by_id($id);
			if(empty($user))
			{
				show_404();
			}
			$user_online = $this->user_model->get_user_online_by_id($id);
			if( ! empty($user_online))
			{
				$user['last_active'] = $user_online['last_active'];
				$user['ip'] 		 = $user_online['ip'];
			}
			$role = $this->user_model->get_role_list();

			$navbar = $this->load->view('admin/common/navbar',"",TRUE);
			$foot 		= $this->load->view('admin/common/foot',"",TRUE);			
			//页面数据
			$body = array(
				'navbar' 	 => $navbar,
				'foot' 	 	 => $foot,
				'user' 		 => $user,
				'role' 		 => $role
			);		
 			$this->load->view('admin/common/head');	
			$this->load->view('admin/user/edit',$body);

		}
		else
		{
			$auth = $this->auth_model->get_user_auth_by_id($id);
			if(empty($auth))
			{
				show_404();
			}
			$role = $this->user_model->get_role_list();
			$navbar = $this->load->view('admin/common/navbar',"",TRUE);
			$foot 		= $this->load->view('admin/common/foot',"",TRUE);			
			//页面数据
			$body = array(
				'navbar' 	 => $navbar,
				'foot' 	 	 => $foot,
				'auth' 		 => $auth,
				'role' 		 => $role
			);		
 			$this->load->view('admin/common/head');	
			$this->load->view('admin/user/a_edit',$body);			
		}
	}

	/**
	 * [add_user 添加用户]
	 */
	public function add_user()
	{
		$error_redirect = array(
			'script' => 'window.location.href = "'.base_url().ADMINROUTE.'user/u";'
		);
		$this->sc->set_error_redirect($error_redirect);
		$user = $this->sc->input(array('name','phone','email','pwd','role'));
		
        if( ! empty($user['email']) && $this->user_model->have_email($user['email']))
        {
            $this->error->output('email_repeat',array('script' => 'window.location.href ="'.base_url().ADMINROUTE.'user/u";'));
        }
        if( ! empty($user['phone']) && $this->user_model->have_email($user['phone']))
        {
			$this->error->output('phone_repeat',array('script' => 'window.location.href ="'.base_url().ADMINROUTE.'user/u";'));
        }

		$result = $this->user_model->insert_user($user);
		if($result)
		{
			echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'user/u/";</script>';
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().ADMINROUTE.'user/u";'));			
		}
		
	}		

	/**
	 * [delete_user 删除用户]
	 * @return [type] [description]
	 */
	public function delete_user()
	{

		$uid = $this->sc->input('uids');
		$uid = explode(",",$uid);
		$result = $this->user_model->delete_user($uid);
		if($result)
		{
			echo json_encode(array('success' => 0,'note' => lang('OPERATE_SUCCESS'),'script' => 'location.reload();'));
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}
	
	/**
	 * [forbid_user 封禁用户]
	 * @return [type] [description]
	 */
	public function forbid_user()
	{
		$uid = $this->sc->input('uid');
		$result = $this->user_model->update_account($uid,array('forbidden' => 1));
		if($result)
		{
			echo json_encode(array('success' => 0,'note' => lang('OPERATE_SUCCESS'),'script' => 'location.reload();'));
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}

	/**
	 * [update_user 更新用户资料]
	 * @return [type] [description]
	 */
	public function update_user()
	{

		$error_redirect = array(
			'script' => 'window.location.href = "'.base_url().ADMINROUTE.'user/edit/u/'.$this->input->post('uid').'";'
		);
		$this->sc->set_error_redirect($error_redirect);

		$user = $this->sc->input(array('uid','name','email','phone','role','pic','sex','intro','alias','area','forbidden'));
		$user['alias'] = 'home/'.$user['alias'];
		$pwd  = $this->input->post('pwd',TRUE);
		$uid  = $user['uid'];
		$changepwd_result = FALSE;
		if( ! empty($pwd))
		{
			//修改密码
			$changepwd_result = $this->user_model->update_password($uid,$pwd);
		}
		unset($user['uid']);
		$result = $this->user_model->update_account($uid,$user);
		if($result || $changepwd_result)
		{
			echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'user/edit/u/'.$uid.'";</script>';
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().ADMINROUTE.'user/edit/u/'.$uid.'";'));			
		}
	}

	/**
	 * [delete_auth 删除权限]
	 * @return [type] [description]
	 */
	public function delete_auth()
	{
		$auth = $this->sc->input('uids');
		$auth = explode(",",$auth);		
		$result = $this->auth_model->delete_auth($auth);
		if($result)
		{
			echo json_encode(array('success' => 0,'note' => lang('OPERATE_SUCCESS'),'script' => 'location.reload();'));			
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}

	/**
	 * [add_auth 添加权限]
	 */
	public function add_auth()
	{
		$error_redirect = array(
			'script' => 'window.location.href = "'.base_url().ADMINROUTE.'user/a";',
			'type' 	 => 1
		);
		$this->sc->set_error_redirect($error_redirect);
		$auth = $this->sc->input(array('name','route','role_group'));		
		$result = $this->auth_model->insert_auth($auth);
		if($result)
		{
			echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'user/a/";</script>';
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().ADMINROUTE.'user/a";'));			
		}
	}

	/**
	 * [update_auth 更新权限]
	 * @return [type] [description]
	 */
	public function update_auth()
	{
		$auth = $this->sc->input(array('id','name','route','role_group'));
		$aid  = $auth['id'];
		$result = $this->auth_model->update_auth($aid,$auth);
		if($result)
		{
			echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'user/edit/a/'.$aid.'";</script>';
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().ADMINROUTE.'user/edit/a/'.$aid.'";'));			
		}		
	}
}