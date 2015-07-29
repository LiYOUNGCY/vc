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
	public function index()
	{
		/*$this->load->view()*/
	}

	/**
	 * [get_post_list 获取圈子信息与帖子列表]
	 * @return [type] [description]
	 */
	public function get_community()
	{
		$cid = $this->sc->input('cid');
		$page 	   = $this->sc->input('page');
		$community = $this->community_service->get_community($page,$this->user['id'],$cid);
		echo json_encode($community);		
	}

}