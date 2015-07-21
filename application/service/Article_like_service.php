<?php

class Article_like_service extends MY_Service
{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('user_service');
		$this->load->model('article_like_model');
	}
	
	
	/**
	 * 获取文章点过赞的人
	 */
	public function get_vote_person_by_aid($aid)
	{
		$users = $this->article_like_model->get_vote_person_by_aid($aid);
		
		foreach ($users as $key => $value)
		{
			$users[$key] = $this->user_service->get_user_base_id($users[$key]['uid']);
			unset($users[$key]['uid']);
		}
		return $users;
	}
	
	/**
	 * 为文章点赞
	 * @return [TRUE: 点赞, FALSE: 取消点赞]
	 */
	public function vote_article($aid, $uid)
	{
		return $this->article_like_model->article_vote($aid, $uid);
	}
}