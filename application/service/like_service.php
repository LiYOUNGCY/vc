<?php 
class Like_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('article_like_model');
		$this->load->model('production_like_model');
		$this->load->model('article_model');				
		$this->load->model('production_model');		
	}
	/**
	 * [get_article_like_list 获取文章收藏列表]
	 * @param  [type] $page [页数]
	 * @param  [type] $uid  [用户id]
	 * @return [type]       [description]
	 */
	public function get_article_like_list($page, $uid)
	{	
		$like = $this->article_like_model->get_like_list($page,$uid);
		foreach ($like as $k => $v) {
			//获取文章详情
			$article = $this->article_model->get_article_by_id($v['aid']);
			if( ! empty($article))
			{
				$a = Common::extract_article($article['id'],$article['title'],$article['content']);
				$a['read'] = $article['read'];
				$a['like'] = $article['like'];
				$a['type'] = $article['type'];
				$a['publish_time'] = $article['publish_time'];
				unset($like[$k]['aid']);
				$like[$k]['article'] = $a;
			}
			else
			{
				unset($like[$k]);
			}			
		}
		return $like;
	}

	/**
	 * [get_production_like_list 获取艺术品收藏列表]
	 * @param  [type] $page [页数]
	 * @param  [type] $uid  [用户id]
	 * @return [type]       [description]
	 */
	public function get_production_like_list($page,$uid)
	{	
		$like = $this->production_like_model->get_like_list($page,$uid);
		foreach ($like as $k => $v) {
			
			$production = $this->production_model->get_production_by_id($v['pid']);
			//获取艺术品详情
			if( ! empty($production))
			{
				$production['pic'] = Common::get_thumb_url($production['pic']);
				unset($production['creat_by']);
				unset($production['modify_by']);
				unset($production['modify_time']);
				unset($like[$k]['pid']);
				$like[$k]['production'] = $production;
			}
			else
			{
				unset($like[$k]);
			}
		}
		return $like;
	}

}