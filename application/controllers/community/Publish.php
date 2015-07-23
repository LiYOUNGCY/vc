<?php 
class Publish extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('community_service');		
	}

	public function index()
	{

	}

	/**
	 * [publish_community 创建圈子]
	 * @return [type] [description]
	 */
	public function publish_community()
	{
		$community_name = $this->sc->input('community_name');
		$community_intro= $this->sc->input('community_intro');

		$community_name = 'test_name';
		$community_intro= 'test_intro';
		$this->user = array();
		$this->user['id'] = 4;

		$result = $this->community_service->publish_community($community_name,$community_intro,$this->user['id']);
		if($result)
		{
			echo "success";
		}
		else
		{
			echo "failed";
		}
	}	

	/**
	 * [publish_post 发布帖子]
	 * @return [type] [description]
	 */
	public function publish_post()
	{
		$cid     = $this->sc->input('cid');
		$title   = $this->sc->input('post_title');
		$content = $this->sc->input('post_content');

		$cid   = 1;
		$title = 'test_post_title';
		$content = 'test_post_content';
		$this->user = array();
		$this->user['id'] = 5;

		$result = $this->community_service->publish_post($cid,$this->user['id'],$title,$content);
		if($result)
		{
			echo "success";
		}
		else
		{
			echo "failed";
		}	
	}
	/**
	 * [publish_answer 回复帖子]
	 * @return [type] [description]
	 */
	public function publish_answer()
	{
		$pid 	 = $this->sc->input('post_id');
		$content = $this->sc->input('answer_content');
		$result  = $this->community_service->publish_answer($pid,$this->user['id'],$content);
		if($result)
		{
			echo "success";
		}
		else
		{
			echo "failed";
		}		
	}
} 