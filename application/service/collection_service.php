<?php 
class Collection_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('article_collection_model');
		$this->load->model('production_collection_model');
		$this->load->model('article_model');				
		$this->load->model('production_model');		
	}
	/**
	 * [get_article_collection_list 获取文章收藏列表]
	 * @param  [type] $page [页数]
	 * @param  [type] $uid  [用户id]
	 * @return [type]       [description]
	 */
	public function get_article_collection_list($page, $uid)
	{	
		$collection = $this->article_collection_model->get_collection_list($page,$uid);
		foreach ($collection as $k => $v) {
			//获取文章详情
			$article = $this->article_model->get_article_by_id($v['aid']);
			if( ! empty($article))
			{
				$a = Common::extract_article($article['id'],$article['title'],$article['content']);
				$a['read'] = $article['read'];
				$a['like'] = $article['like'];
				$a['type'] = $article['type'];
				$a['publish_time'] = $article['publish_time'];
				unset($collection[$k]['aid']);
				$collection[$k]['article'] = $a;
			}
			else
			{
				unset($collection[$k]);
			}			
		}
		return $collection;
	}

	/**
	 * [get_production_collection_list 获取艺术品收藏列表]
	 * @param  [type] $page [页数]
	 * @param  [type] $uid  [用户id]
	 * @return [type]       [description]
	 */
	public function get_production_collection_list($page,$uid)
	{	
		$collection = $this->production_collection_model->get_collection_list($page,$uid);
		foreach ($collection as $k => $v) {
			
			$production = $this->production_model->get_production_by_id($v['pid']);
			//获取艺术品详情
			if( ! empty($production))
			{
				$production['pic'] = Common::get_thumb_url($production['pic']);
				unset($production['creat_by']);
				unset($production['modify_by']);
				unset($production['modify_time']);
				unset($collection[$k]['pid']);
				$collection[$k]['production'] = $production;
			}
			else
			{
				unset($collection[$k]);
			}
		}
		return $collection;
	}

}