<?php
class Home_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('user_follow_model');	
		$this->load->model('article_model');			
		$this->load->model('article_like_model');
		$this->load->model('article_comment_model');	
		$this->load->model('community_model');							
	}

	/**
	 * [get_user 获取主页用户信息]
	 * @param  [type] $uid   [我的id]
	 * @param  [type] $alias [用户别名]
	 * @return [type]        [description]
	 */
	public function get_user($uid,$alias)
	{
		$user = $this->user_model->get_user_by_alias($alias,array('id', 'name', 'pic', 'alias', 'role','intro','follower','area'));
		if( ! empty($user))
		{
			//获取关注状态
			if( ! empty($uid) && $uid != $user['id'])
			{
				$user['follow_status'] = $this->user_follow_model->check_follow($uid,$user['id']);				
			}
			return $user;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * [get_user_intro 获取用户简介]
	 * @param  [type] $uid [用户id]
	 * @return [type]      [description]
	 */
	public function get_user_intro($uid)
	{
		$intro = $this->article_model->get_intro_by_uid($uid);
		if( ! empty($intro))
		{
			//获取点赞列表
			$intro['like'] = $this->article_like_model->get_vote_person_by_aid($intro['id']);
			//获取评论列表
			$intro['comment'] = $this->article_comment_model->get_comment_by_aid($intro['id']);
			return $intro;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * [get_user_article 获取用户文章]
	 * @param  [type] $page [页数]
	 * @param  [type] $meid [我的id]
	 * @param  [type] $uid  [用户id]
	 * @param  [type] $type [文章类型]
	 * @return [type]       [description]
	 */
	public function get_user_article($page, $meid, $uid, $type)
	{
		$article = $this->article_model->get_article_list($page,$meid,$uid,$type);
		return $article;
	}

	/**
	 * [get_user_community 获取用户关注的圈子信息]
	 * @param  [type] $page [页数]
	 * @param  [type] $uid  [用户id]
	 * @return [type]       [description]
	 */
	public function get_user_community($page, $uid)
	{
		//获取用户关注的自媒体信息列表
		$follow = $this->user_follow_model->get_follow_media_by_uid($page,$uid);
		//获取该用户的信息
		$user   = $this->user_model->get_user_base_id($uid);

		//如果该用户是自媒体,加上该用户的信息
		if($user['role'] == 2)
		{
			$follow[count($follow)] = $user;					
		}		
		
		if( ! empty($follow))
		{
			$community = array();
			foreach ($follow as $k => $v) {
				//获取圈子的信息
				$c = $this->community_model->get_community_by_uid($follow[$k]['id']);	
				if( ! empty($c))
				{
					$c['media'] = $follow[$k];
					array_push($community,$c);					
				}
			}
			return $community;	
		}
		else
		{
			return FALSE;
		}
	}
}