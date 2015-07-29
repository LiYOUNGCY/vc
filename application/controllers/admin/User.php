<?php
class User extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
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
				'user' 		 => $user
			);
 			$this->load->view('admin/common/head');	
			$this->load->view('admin/user/list',$body);
		
		}
		else
		{

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
		$user = $this->sc->input(array('uid','name','email','phone','role','pic','sex','intro','alias','area','forbidden'));
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
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().ADMINROUTE.'user/edit/u/'.$uid.'";','type' => 1));			
		}
	}
}