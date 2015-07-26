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

	/**
	 * [delete_post 删除帖子]
	 * @return [type] [description]
	 */
	public function delete_post()
	{
		$pid = $this->sc->input('pid');
		$result = $this->community_service->delete_post($pid,$this->user['id']);
		if($result)
		{
			echo "success";
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}

	/**
	 * [delete_answer 删除回复]
	 * @return [type] [description]
	 */
	public function delete_answer()
	{
		$aid = $this->sc->input('aid');
		$result = $this->community_service->delete_answer($aid,$this->user['id']);
		if($result)
		{
			echo json_encode(array('success' => 0));
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}		
	}
}