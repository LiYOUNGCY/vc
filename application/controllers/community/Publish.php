<?php 
class Publish extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('community_service');		
	}

	/**
	 * [index 显示发布界面]
	 * @param  string $type [界面类型]
	 * @return [type]       [description]
	 */
	public function index($type = 'community')
	{
		if($type == 'community')
		{

		}
		else if($type == 'post')
		{

		}
	}

	/**
	 * [publish_community 创建圈子]
	 * @return [type] [description]
	 */
	public function publish_community()
	{
		$community_name = $this->sc->input('community_name');
		$community_intro= $this->sc->input('community_intro');

		$result = $this->community_service->publish_community($community_name,$community_intro,$this->user['id']);
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
	 * [update_community 更新圈子]
	 * @return [type] [description]
	 */
	public function update_community()
	{
		$community_id   = $this->sc->input('cid');
		$community_name = $this->sc->input('community_name');
		$community_intro= $this->sc->input('community_intro');
		$result = $this->community_service->update_community($community_id,$community_name,$community_intro,$this->user['id']);
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
	 * [publish_post 发布帖子]
	 * @return [type] [description]
	 */
	public function publish_post()
	{
		$cid     = $this->sc->input('cid');
		$title   = $this->sc->input('post_title');
		$content = $this->sc->input('post_content');

		$result = $this->community_service->publish_post($cid,$this->user['id'],$title,$content);
		if( ! $result)
		{
			echo "failed";
		}
	}

	/**
	 * [update_post 更新帖子]
	 * @return [type] [description]
	 */
	public function update_post()
	{
		$pid     = $this->sc->input('pid');
		$title   = $this->sc->input('post_title');
		$content = $this->sc->input('post_content');		

		$result = $this->community_service->update_post($pid,$title,$content,$this->user['id']);
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
	 * [publish_answer 回复帖子]
	 * @return [type] [description]
	 */
	public function publish_answer()
	{
		$pid 	 = $this->sc->input('post_id');
		$content = $this->sc->input('answer_content');
		
		$result  = $this->community_service->publish_answer($pid,$this->user['id'],$content);
		if( ! $result)
		{
			echo "failed";
		}	
	}
} 