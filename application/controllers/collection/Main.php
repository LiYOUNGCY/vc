<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('collection_service');
	}
	
	public function index($type = 'article')
	{
		
	}	

	/**
	 * [get_article_collection_list 获取文章收藏列表]
	 * @return [type] [description]
	 */
	public function get_article_collection_list()
	{	
		$page = $this->sc->input('page');
		$collection = $this->collection_service->get_article_collection_list($page,$this->user['id']);
		echo json_encode($collection);
	}

	/**
	 * [get_production_collection_list 获取作品收藏列表]
	 * @return [type] [description]
	 */
	public function get_production_collection_list()
	{	
		$page = $this->sc->input('page');
		$collection = $this->collection_service->get_production_collection_list($page,$this->user['id']);
		echo json_encode($collection);		
	}	
}