<?php
class Artist_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('artist_model');
		$this->load->model('production_model');
	}

	/**
	 * [get_artist_list 获取艺术家列表]
	 * @param  [type] $page [页数]
	 * @return [type]       [description]
	 */
	public function get_artist_list($page)
	{
		$artist = $this->artist_model->get_artist_list($page);
		foreach ($artist as $k => $v) {
			$artist[$k]['intro'] = Common::extract_content($v['intro']);
		}
		return $artist;
	}

	/**
	 * [get_artist_by_id 根据id获取艺术家详情]
	 * @param  [type] $aid [艺术家id]
	 * @return [type]      [description]
	 */
	public function get_artist_by_id($aid)
	{
		return $this->artist_model->get_artist_by_id($aid);
	}

	/**
	 * [get_artist_production 获取艺术家作品列表]
	 * @param  [type] $page [description]
	 * @param  [type] $aid  [description]
	 * @return [type]       [description]
	 */
	public function get_artist_production($page, $aid)
	{
		$production = $this->production_model->get_production_list($page,NULL,NULL,NULL,$aid);
		foreach ($production as $k => $v) {
			$production[$k]['pic'] = Common::get_thumb_url($production[$k]['pic']);
		}
		return $production;
	}

	public function publish_artist($uid, $name, $image_id, $intro, $evaluation)
	{
        return $this->artist_model->insert_artist($uid, $name, $image_id, $intro, $evaluation);
	}

	/**
	 * [update_artist 更新艺术家资料]
	 * @param  [type] $aid        [艺术家id]
	 * @param  [type] $uid        [用户id]
	 * @param  [type] $name       [名称]
	 * @param  [type] $intro      [介绍]
	 * @param  [type] $evaluation [评价]
	 * @param  [type] $pic        [头像]
	 * @return [type]             [description]
	 */
	public function update_artist($aid, $uid, $name, $intro, $evaluation, $pic)
	{
		$arr = array(
			'name' 		 => array($name,TRUE),
			'intro'      => array($intro,TRUE),
			'evaluation' => array($evaluation,TRUE),
			'pic' 		 => array($pic,TRUE),
			'modify_by'  => array($uid,TRUE)
		);
		$result = $this->artist_model->update_artist($aid,$arr);
		if($result)
		{
			return TRUE;
		}
		else
		{
			$this->_delete_oss_pic($pic);
			return FALSE;
		}
	}

	private function _delete_oss_pic($pic)
	{
		try
		{
			$this->load->library('oss');
			//删除原图
			$arr   = explode('/',$pic);
			$count = count($arr);
			unset($arr[0]);
			unset($arr[1]);
			unset($arr[2]);
			$pic = implode('/', $arr);
			$this->oss->delete_object($pic);
			return TRUE;
		}
		catch(Exception $e)
		{
			return FALSE;
		}
	}

    public function publish($id)
    {
        return $this->artist_model->publish($id);
    }

    public function cancel_publish($id)
    {
        return $this->artist_model->cancel_publish($id);
    }
}
