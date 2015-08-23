<?php 
class Production extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('production_model');
		$this->load->model('production_type_model');
		$this->load->model('production_marterial_model');

	}
	
	public function index($type = 'p',$page = 0)
	{
		if($type == 'p')
		{
			//页面限制个数
			$limit= 10;
			//获取艺术品列表
			$production = $this->production_model->admin_get_production_list($page,$limit);
			$this->load->model('artist_model');			
			foreach ($production as $k => $v) {
				if( ! empty($v['aid']))
				{
					$a =  $this->artist_model->get_artist_by_id($v['aid']);
					$production[$k]['artist'] = empty($a) ? "" : $a['name'];							
				}
				else
				{
					$production[$k]['artist'] = "";
				}

			}
			$status  = array('已上架','已售出','已下架');
			$count   = $this->production_model->get_production_count();
			
			$navbar  = $this->load->view('admin/common/navbar',"",TRUE);

			//分页数据
			$p = array(
				'count'   => $count,
				'page'    => $page,
				'limit'   => $limit,
				'pageurl' => base_url().ADMINROUTE.'production/p/'
			);
			
			$pagination = $this->load->view('admin/common/pagination',$p,TRUE);
			$foot 		= $this->load->view('admin/common/foot',"",TRUE);		

			//页面数据
			$body = array(
				'navbar' 	 => $navbar,
				'foot' 	 	 => $foot,
				'pagination' => $pagination,
				'production' => $production,
				'status' 	 => $status
			);
 			$this->load->view('admin/common/head');	
			$this->load->view('admin/production/list',$body);			
		}

	}

	public function delete_production()
	{
		$aid = $this->sc->input('aids');
		$aid = explode(",",$aid);
		foreach ($aid as $k => $v) {
			$result = $this->production_model->delete_production($v);			 
		}
		if($result)
		{
			echo json_encode(array('success' => 0,'note' => lang('OPERATE_SUCCESS'),'script' => 'location.reload();'));
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}		
	}


}