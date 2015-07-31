<?php 

class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('notification_service');
	}

	/**
	 * [index 显示消息列表]
	 * @return [type] [description]
	 */
	public function index($type = 'all')
	{
		if( !is_string($type) ) {
			show_404();
		}

		$head['css'] = array(
			'common.css'
		);

		$head['javascript'] = array(
			'jquery.js',
			'vchome.js',
			'error.js'
		);

		$user['user'] 	= $this->user;
        $body['sidebar']= $this->load->view('common/sidebar', $user, TRUE);

		if(strcmp($type, 'all') == 0) 
		{

			$this->load->view('common/head', $head);
			$this->load->view('notification_list', $body);
		}
		elseif(strcmp($type, 'conversation') == 0)
		{
			$data['css'] = array(
				'common.css',
				'message.css',
				'message_center.css'
			);

			$data['javascript'] = array(
				'jquery.js',
				'error.js'
			);

			$this->load->view('common/head', $data);
			$this->load->view('conversation_list', $body);			

		}
	}

	/**
	 * [get_notification_list 获取消息列表]
	 * @return [type] [description]
	 */
	public function get_notification_list()
	{
		$page = $this->sc->input('page');
		//消息类型
		$type = $this->sc->input('type');
		$type = ! empty($type) ? $type : 'all';

		$notification = $this->notification_service->get_notification_list($page,$this->user['id'],$type);

		echo json_encode($notification);
	}

	/**
	 * [read 阅读消息]
	 * @return [type] [description]
	 */
	public function read()
	{
		$nid = $this->sc->input('nid');
		$type= $this->sc->input('type');

		$result = $this->notification_service->update($this->user['id'],$nid,$type,array('read_flag' => 1));
		if(!empty($result))
		{
			echo "success";
		}
		else
		{
			echo "failed";
		}
	}

	/**
	 * [delete 删除消息]
	 * @return [type] [description]
	 */
	public function delete()
	{
		$nid = $this->sc->input('nid');
		$type= $this->sc->input('type');			
		$result = $this->notification_service->delete($this->user['id'],$nid,$type);
		if(!empty($result))
		{
			echo "success";
		}
		else
		{
			echo "failed";
		}
	}
}