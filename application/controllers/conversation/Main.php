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
			'qqFace.css'
		);

		$data['javascript'] = array(
			'jquery.js', 
			'jquery.flexText.min.js', 
			'jquery.qqFace.js',
			'vchome.js',
			'error.js'
		);
		
        $user['user'] = $this->user;
        $body['sidebar'] = $this->load->view('common/sidebar', $user, TRUE);
        $body['footer']  = $this->load->view('common/footer', '', TRUE);
        
		$this->load->view('common/head', $data);
		$this->load->view('conversation',$body);
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

		//var_dump($this->user);

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
		$this->conversation_service->publish_conversation($this->user['id'],$reciver_id,$content);

	}
}