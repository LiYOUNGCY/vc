<?php 
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('conversation_service');
	}
	
	public function index()
	{
		$data['css'] = array(
			'common.css',
			'flex-style.css', 
			'message.css',
			'qqFace.css'
		);

		$data['javascript'] = array(
			'jquery.js', 
			'jquery.flexText.min.js', 
			'jquery.qqFace.js'
		);


		$this->load->view('common/head', $data);
		$this->load->view('conversation');
	}
	/**
	 * [get_conversation_content 获取对话内容]
	 * @param  [type] $cid [对话id]
	 * @return [type]      [description]
	 */
	public function get_conversation_content($cid)
	{
		$page = $this->sc->input('page');
		if( ! is_numeric($cid))
		{
			show_404();
		}
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
		$content    = $this->sc->input('content');
		/*
		$this->user = array();
		$this->user['id'] = 4;
		$reciver_id = 9;
		*/
		$this->conversation_service->publish_conversation($this->user['id'],$reciver_id,$content);

	}
}