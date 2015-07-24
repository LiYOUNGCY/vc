<?php 
class Post extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('community_service');		
	}

	/**
	 * [index 获取帖子详情]
	 * @param  [type] $pid [帖子id]
	 * @return [type]      [description]
	 */
	public function index($pid)
	{
		if( ! is_numeric($pid))
		{
			show_404();
		}
		$post = $this->community_service->get_post_detail($pid,$this->user['id']);
		echo json_encode($post);
	}
}