<?php 
class Community_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('community_model');
		$this->load->model('community_post_model');
		$this->load->model('community_answer_model');			
		$this->load->model('user_follow_model');
		$this->load->model('user_model');						
	}

	/**
	 * [get_community 获取帖子列表]
	 * @param  [type] $page [页数]
	 * @param  [type] $cid  [帖子id]
	 * @return [type]       [description]
	 */
	public function get_community($page, $cid)
	{
		//$follow_result = $this->check_follow_community($cid,$uid);
		//已关注该圈子
		//if($follow_result)
		//{
			//圈子基本信息
			//$result['community'] = $this->community_model->get_community_by_id($cid);
			//if( ! empty($result['community']))
			//{
				//帖子列表
				$post 	 = $this->community_post_model->get_post_list($page,$cid);
				foreach ($post as $k => $v) {
					$has_first_img = Common::has_first_img($post[$k]['content']);
					if( ! empty($has_first_img))
					{
						$post[$k]['has_img'] = 1;
					}
					else
					{
						$post[$k]['has_img'] = 0;
					}
					$post[$k]['content'] = Common::extract_content($post[$k]['content']);
					$post[$k]['user'] = $this->user_model->get_user_base_id($post[$k]['uid']);
				}				
				return $post;							
			//}		
			//else
			//{
				//$this->error->output('INVALID_REQUEST');
			//}
		//}
		//未关注该圈子
		//else
		//{
			//$this->error->output('INVALID_REQUEST');
		//}
	}

	public function get_community_by_id($cid)
	{
		$community 			 = $this->community_model->get_community_by_id($cid);
		if( ! empty($community))
		{
			$result['community'] = $community;
			$result['media'] 	 = $this->user_model->get_user_base_id($community['uid']);
			return $result;						
		}
		else
		{
			return FALSE;
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
	 * [update_community description]
	 * @param  [type] $cid             [圈子id]
	 * @param  [type] $community_name  [圈子名称]
	 * @param  [type] $community_intro [圈子介绍]
	 * @param  [type] $uid             [用户id]
	 * @return [type]                  [description]
	 */
	public function update_community($cid,$community_name,$community_intro,$uid)
	{
		$arr = array(
			'name' => array(TRUE,$community_name),
			'intro'=> array(TRUE,$community_intro)
		);
		return $this->community_model->update_community($cid,$arr,$uid);
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
			if($insert_result)
			{
				echo "success";
				$this->community_model->update_community($cid,array('post' => array(FALSE,'post+1')));
				return TRUE;
			}	
			else
			{
				return FALSE;
			}		
		}
		else
		{
			$this->error->output('INVALID_REQUEST');			
		}

	}

	/**
	 * [update_post 更新帖子]
	 * @param  [type] $pid     [帖子id]
	 * @param  [type] $content [内容]
	 * @param  [type] $title   [标题]
	 * @param  [type] $uid     [用户id]
	 * @return [type]          [description]
	 */
	public function update_post($pid, $title, $content, $uid)
	{
		$arr = array(
			'content' => array(TRUE,$content),
			'title'   => array(TRUE,$title)
		);
		return $this->community_post_model->update_post($pid,$arr,$uid);
	}

	/**
	 * [delete_post 删除帖子]
	 * @param  [type] $pid [帖子id]
	 * @param  [type] $uid [用户id]
	 * @return [type]      [description]
	 */
	public function delete_post($pid, $uid)
	{
		return $this->community_post_model->delete_post($pid,$uid);
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
		if($insert_result)
		{
			echo "success";
			$this->community_post_model->update_post($pid,array('answer' => array(FALSE,'answer+1'),'last_active' =>array(TRUE,date("Y-m-d H:i:s",time()))));
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * [delete_answer 删除回复]
	 * @param  [type] $aid [回复id]
	 * @param  [type] $uid [用户id]
	 * @return [type]      [description]
	 */
	public function delete_answer($aid, $uid)
	{
		$answer = $this->community_answer_model->get_answer_by_id($aid);
		if( ! empty($answer))
		{
			$post = $this->community_post_model->get_post_by_id($answer['pid']);
			if($post['uid'] == $uid)
			{
				$result = $this->community_answer_model->delete_answer($aid);
				return $result;
			}
		}		
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}
}