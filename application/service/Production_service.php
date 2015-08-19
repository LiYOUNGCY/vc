<?php
class Production_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('production_model');
		$this->load->model('production_collection_model');
		$this->load->model('article_model');
		$this->load->model('artist_model');
	}

	/**
	 * 获得作品列表
	 * @param  page 页数   [int]
	 * @param  uid  用户id [uid]
	 * @return [type]
	 */
	public function get_production_list($page,$uid)
	{
		$production = $this->production_model->get_production_list($page, $uid, '0');
		foreach ($production as $k => $v) {
			//显示缩略图

			$production[$k]['pic'] = Common::get_thumb_url($production[$k]['pic']);
			//获取艺术家信息
			if( ! empty($v['aid']))
			{
				$production[$k]['artist'] = $this->artist_model->get_artist_by_id($v['aid']);
			}
			else
			{
				$production[$k]['artist'] = NULL;
			}
			unset($production[$k]['aid']);
		}
		return $production;
	}

	/**
	 * 查看是否收藏该艺术品
	 * @param  uid 用户id   [int]
	 * @param  pid 艺术品id [int]
	 * @return [type]
	 */
	public function check_production_collection($uid, $pid)
	{
		return $this->production_collection_model->check_production_collection($uid,$pid);
	}
	/**
	 * 根据id获取艺术品详情
	 * @param  [type]
	 * @return [type]
	 */
	public function get_production_by_id($id)
	{
		$p = $this->production_model->get_production_by_id($id);
		if( ! empty($p))
		{
			//获取艺术家信息
			if( ! empty($p['aid']))
			{
				$p['artist'] = $this->artist_model->get_artist_by_id($p['aid']);
			}
			else
			{
				$p['artist'] = NULL;
			}
			unset($p['aid']);
			return $p;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * 获取艺术品相关联的专题
	 * @param  pid 艺术品id [int]
	 * @return [type]
	 */
	public function get_topic_by_production($pid, $uid)
	{
		$topic = $this->article_model->get_article_list(0,$uid,NULL,NULL,$pid);
		foreach ($topic as $k => $v) {
			$topic[$k]['article_img'] = Common::extract_first_img($topic[$k]['content']);
		}
		return $topic;
	}
	/**
	 * 收藏艺术品
	 * @param  pid 艺术品id [int]
	 * @param  uid 用户id   [int]
	 * @return [type]
	 */
	public function collect_production($pid, $uid)
	{
		return $this->production_collection_model->insert_collection($pid,$uid);
	}

	/**
	 * [publish_production 发布艺术品]
	 * @param  [type] $name       [description]
	 * @param  [type] $uid        [description]
	 * @param  [type] $intro      [description]
	 * @param  [type] $aid        [description]
	 * @param  [type] $price      [description]
	 * @param  [type] $pic        [description]
	 * @param  [type] $l          [description]
	 * @param  [type] $w          [description]
	 * @param  [type] $h          [description]
	 * @param  [type] $type       [description]
	 * @param  [type] $marterial  [description]
	 * @param  [type] $creat_time [description]
	 * @return [type]             [description]
	 */
	public function publish_production($name, $uid, $intro, $aid, $price, $pic, $l, $w, $h, $type, $marterial, $creat_time)
	{
		$insert_result = $this->production_model->insert_production($name,$uid,$aid,$price,$pic);
		if($insert_result)
		{
			//更新艺术家作品数
			$this->artist_model->update_artist($aid,array('production' => array('production + 1',FALSE)));
			return $insert_result;
		}
		else
		{
			//删除oss上图片
			$this->_delete_oss_pic($pic);
			return FALSE;
		}
	}

	/**
	 * [update_production 更新艺术品]
	 * @param  [type] $pid    [艺术品id]
	 * @param  [type] $uid    [用户id]
	 * @param  [type] $name   [艺术品名称]
	 * @param  [type] $aid    [艺术家id]
	 * @param  [type] $price  [价格]
	 * @param  [type] $pic    [图片地址]
	 * @param  [type] $status [艺术品状态]
	 * @return [type]         [description]
	 */
	public function update_production($pid, $uid, $name, $intro, $aid, $price, $pic, $l, $w, $h, $type, $marterial, $creat_time, $status)
	{
		$data = array(
			'name'   	=> $name,
			'intro' 	=> $intro,
			'aid'    	=> $aid,
			'price'  	=> $price,
			'pic'  	 	=> $pic,
			'l'			=> $l,
			'w' 		=> $w,
			'h' 		=> $h,
			'type' 		=> $type,
			'marterial' => $marterial,
			'creat_time'=> $creat_time,
			'status' 	=> $status,
			'modify_by' => $uid
		);
		$update_result = $this->production_model->update_production($pid,$data);
		if($update_result)
		{
			return TRUE;
		}
		else
		{
			//删除oss上图片
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
			//$count = count($arr);
			unset($arr[0]);
			unset($arr[1]);
			unset($arr[2]);
			$pic = implode('/', $arr);
			$this->oss->delete_object($pic);

			//删除缩略图
			$toFile = Common::get_thumb_url($pic,'thumb1_');
			$toFile1= Common::get_thumb_url($pic,'thumb2_');		
			
			$this->oss->delete_object($toFile);		
			$this->oss->delete_object($toFile1);				
			return TRUE;		
		}
		catch(Exception $e)
		{
			return FALSE;
		}

	}
}
