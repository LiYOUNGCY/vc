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
		//专题
		$latest_topic      = $this->article_model->get_topic_list(0);
        foreach($latest_topic as $key => $value )
        {
            $content = $latest_topic[$key]['content'];
            //对每篇文章内容进行字数截取
            $latest_topic[$key]['content'] = Common::extract_topic($latest_topic[$key]['id'], $latest_topic[$key]['title'], $content);
            $latest_topic[$key]['content']['article_bigimage'] = str_replace('_thumb', '', $latest_topic[$key]['content']['article_image']);

            //对文章标题字数截取
            $latest_topic[$key]['content']["sort_title"] = mb_strlen($latest_topic[$key]['content']["article_title"]) > 9 ? mb_substr($latest_topic[$key]['content']["article_title"], 0, 9).'..' : $latest_topic[$key]['content']["article_title"];

            unset($latest_topic[$key]['id']);
            unset($latest_topic[$key]['title']);
        }
        //艺术品
		$latest_production = $this->production_model->get_production_list();
		// //获取艺术品类型信息
		// $this->load->model('production_medium_model');
		// $production_type   = $this->production_medium_model->get_medium_list();

		foreach ($latest_production as $k => $v) {
			//显示缩略图
//			$latest_production[$k]['pic']   = Common::get_thumb_url($v['pic']);
			$latest_production[$k]['bigpic']= $v['pic'];
			// $latest_production[$k]['intro'] = Common::extract_content($latest_production[$k]['intro']);
			//获取艺术家信息
			if( ! empty($v['aid']))
			{
				$latest_production[$k]['artist'] = $this->artist_model->get_artist_base_id($v['aid']);
			}
			else
			{
				$latest_production[$k]['artist'] = NULL;
			}
			unset($latest_production[$k]['aid']);
            unset($latest_production[$k]['intro']);
			//艺术品信息
			// if( ! empty($v['type']))
			// {
			// 	$latest_production[$k]['type_name'] = isset($production_type[$v['type']]) ?  $production_type[$v['type']] : "";
			// }
		}

		//$latest_artist     = $this->artist_model->get_artist_list(0,6,'id DESC');
		$slider 		   = $this->slider_model->get_slider_list();

		$result = array(
			'topic' 	 => $latest_topic,
			'production' => $latest_production,
			//'artist'	 => $latest_artist,
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
