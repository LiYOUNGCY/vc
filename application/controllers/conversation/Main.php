<?php 
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('conversation_service');
	}
	
	public function index()
	{
		$head['css'] = array(
			'base.css',
            'alert.css',
            'qqFace.css'
		);
		$head['javascript'] = array(
			'jquery.js',
            'alert.min.js',
            'autosize.js',
            'jquery.qqFace.js'
		);
        $head['title']   = '在线客服';

        $user['user'] = $this->user;

        $body['top']     = $this->load->view('common/top', $user, TRUE);
        $body['footer']  = $this->load->view('common/footer', '', TRUE);
		$body['customer_id']	= 15;
        
		$this->load->view('common/head', $head);
		$this->load->view('customer', $body);
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
		$result = $this->conversation_service->publish_conversation($this->user['id'],$reciver_id,$content);
		if($result)
		{	
			echo json_encode(array('success' => 0));
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}
}