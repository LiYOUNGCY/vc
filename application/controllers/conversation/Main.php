<?php 
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('conversation_service');
	}
	
	public function index()
	{
		
	}
	/**
	 * [get_conversation_content 获取对话内容]
	 * @param  [type] $cid [对话id]
	 * @return [type]      [description]
	 */
	public function get_conversation_content()
	{
		$page = $this->sc->input('page');
		$cid  = $this->sc->input('cid');
	
		$content = $this->conversation_service->get_conversation_content($page,$this->user['id'],$cid);
		echo json_encode($content);
	}

	/**
	 * [publish_conversation 发私信]
	 * @return [type] [description]
	 */
	public function publish_conversation()
	{
		$reciver_id = $this->sc->input('uid');
		$content    = $this->sc->input('conversation_content');
		/*
		$this->user = array();
		$this->user['id'] = 20;
		$reciver_id = 9;
		$content = '捉急吧';
		*/
		$this->conversation_service->publish_conversation($this->user['id'],$reciver_id,$content);

	}
}