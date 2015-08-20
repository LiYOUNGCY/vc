<?php
class Home_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('article_model');
		$this->load->model('artist_model');
		$this->load->model('production_model');
		$this->load->model('slider_model');
	}

	/**
	 * [enter_index 进入主页]
	 * @return [type] [description]
	 */
	public function enter_index()
	{
		$latest_article    = $this->article_model->get_article_list();
		$latest_production = $this->production_model->get_production_list();
		$latest_artist     = $this->artist_model->get_artist_list(0,6,'id DESC');
		$slider 		   = $this->slider_model->get_slider_list();

		$result = array(
			'article' 	 => $latest_article,
			'production' => $latest_production,
			'artist'	 => $latest_artist,
			'slider' 	 => $slider
		);
		return $result;
	}

	/**
	 * [get_slider_list 获取轮播列表]
	 * @return [type] [description]
	 */
	public function get_slider_list()
	{
		$slider = $this->slider_model->get_slider_list();			
		return $slider;
	}

	/**
	 * [get_slider_by_id 获取轮播详情]
	 * @param  [type] $id [轮播图id]
	 * @return [type]     [description]
	 */
	public function get_slider_by_id($id)
	{
		$slider = $this->slider_model->get_slider_by_id($id);
		return $slider;
	}

	public function publish_slider($title, $pic, $href, $uid)
	{
		$result = $this->slider_model->insert_slider($title,$pic,$href,$uid);	
	    return $result;
	}

	/**
	 * [update_slider 更新轮播图]
	 * @param  [type] $sid   [description]
	 * @param  [type] $title [description]
	 * @param  [type] $pic   [description]
	 * @param  [type] $href  [description]
	 * @param  [type] $uid   [description]
	 * @return [type]        [description]
	 */
	public function update_slider($sid ,$title, $pic, $href, $uid)
	{
		$arr = array(
			'title'      => $title,
			'pic' 	     => $pic,
			'href' 	     => $href,
			'modify_by'  => $uid
		);
		$result = $this->slider_model->update_slider($sid,$arr);
		return $result;
	}
}