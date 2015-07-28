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
			$this->load->view('admin/user',$body);
		
		}
		else
		{

		}
	}
}