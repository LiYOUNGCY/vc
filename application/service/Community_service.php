<?php 
class Community_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('community_model');
		$this->load->model('community_post_model');
		$this->load->model('community_answer_model');			
		$this->load->model('user_follow_model');			
	}

	/**
	 * [get_community 获取圈子信息与帖子列表]
	 * @param  [type] $page [页数]
	 * @param  [type] $uid  [用户id]
	 * @param  [type] $cid  [帖子id]
	 * @return [type]       [description]
	 */
	public function get_community($page, $uid, $cid)
	{
		$follow_result = $this->check_follow_community($cid,$uid);
		//已关注该圈子
		if($follow_result)
		{
			//帖子列表
			$result['post'] 	 = $this->community_post_model->get_post_list($page,$cid);
			//圈子基本信息
			$result['community'] = $follow_result;
			return $result;
		}
		//未关注该圈子
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}

	/**
	 * [check_follow_community 查看是否关注该圈子]
	 * @param  [type] $cid [圈子id]
	 * @param  [type] $uid [用户id]
	 * @return [type]      [description]
	 */
	public function check_follow_community($cid, $uid)
	{
		$community = $this->community_model->get_community_by_id($cid);
		if( ! empty($community))
		{
			if($uid == $community['uid'])
			{
				return $community;
			}

			$follow_result = $this->user_follow_model->check_follow($uid,$community['uid']);
			if($follow_result)
			{
				//返回圈子信息
				return $community;
			}
			else
			{
				return FALSE;
			}				
		}
		else
		{
			show_404();
		}

	}

	/**
	 * [publish_community 创建圈子]
	 * @param  [type] $name [圈子名称]
	 * @param  [type] $intro[圈子介绍] 
	 * @param  [type] $uid  [用户id]
	 * @return [type]       [description]
	 */
	public function publish_community($name, $intro, $uid)
	{
		$check_result = $this->community_model->get_community_by_uid($uid);
		//未创建圈子
		if(empty($check_result))
		{	
			$insert_result = $this->community_model->insert_community($name,$intro,$uid);
			return $insert_result;
		}	
		//已创建圈子
		else
		{	
			$this->error->output('INVALID_REQUEST');
		}
	}

	/**
	 * [get_post_detail 获取帖子详情]
	 * @return [type] [description]
	 */
	public function get_post_detail($pid, $uid)
	{
		$post = $this->community_post_model->get_post_by_id($pid);
		if( ! empty($post))
		{
			//查看是否关注该圈子
			$follow_result = $this->check_follow_community($post['cid'],$uid);
			if($follow_result)
			{
				//获取评论
				$post['comment'] = $this->community_answer_model->get_answer_by_pid($pid);
				return $post;
			}
			else
			{
				$this->error->output('INVALID_REQUEST');				
			}
		}
		else
		{
			show_404();
		}
	}

	/**
	 * [publish_post 发布帖子]
	 * @param  [type] $cid     [圈子id]
	 * @param  [type] $uid     [用户id]
	 * @param  [type] $title   [标题]
	 * @param  [type] $content [内容]
	 * @return [type]          [description]
	 */
	public function publish_post($cid, $uid, $title, $content)
	{
		//$check_result = $this->check_follow_community($cid,$uid);
		//验证用户为拥有该圈子的自媒体
		$check_result = $this->community_model->get_community_by_uid($uid);		
		if( ! empty($check_result))
		{
			$insert_result = $this->community_post_model->insert_post($cid,$uid,$title,$content);
			return $insert_result;			
		}
		else
		{
			$this->error->output('INVALID_REQUEST');			
		}

	}

	/**
	 * [publish_answer 回复帖子]
	 * @param  [type] $pid     [帖子id]
	 * @param  [type] $uid     [用户id]
	 * @param  [type] $content [回复内容]
	 * @return [type]          [description]
	 */
	public function publish_answer($pid, $uid, $content)
	{
		//这里少了对用户的验证,验证是否关注该圈子
		$insert_result = $this->community_answer_model->insert_answer($pid,$uid,$content);
		return $insert_result;
	}


}