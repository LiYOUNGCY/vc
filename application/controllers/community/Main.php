<?php 
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('community_service');
	}

	/**
	 * [index 进入圈子]
	 * @return [type]      [description]
	 */
	public function index($cid)
	{
		if( ! is_numeric($cid))
		{
			show_404();
		}
		$community = $this->community_service->get_community_by_id($cid);
		if( ! empty($community))
		{
			$data['css'] = array('common.css', 'font-awesome/css/font-awesome.min.css');
	        $data['javascript'] = array('jquery.js','timeago.js','error.js');
	        $u['user']    = $this->user;
	        $this->load->view('common/head', $data);
	    	$data['sidebar'] = $this->load->view('common/sidebar', $u, TRUE);
	     	$data['footer'] = $this->load->view('common/footer',"", TRUE);

	     	$data['community'] = $community;
			$this->load->view('quanzi',$data);			
		}
		else
		{
			show_404();
		}

	}

	/**
	 * [get_post_list 获取帖子列表]
	 * @return [type] [description]
	 */
	public function get_community()
	{
		$cid = $this->sc->input('cid');
		$page 	   = $this->sc->input('page');
		$community = $this->community_service->get_community($page,$cid);
		echo json_encode($community);		
	}

}
