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
	public function index($type = 'systemmsg')
	{
		if( !is_string($type) ) {
			show_404();
		}

		$data['css'] = array(
            'swiper.min.css',
            'font-awesome/css/font-awesome.min.css',
            'base.css'
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'error.js',
            'validate.js'
        );

        $user['user'] = $this->user;
        $top = $this->load->view('common/top', $user, TRUE);
        $data['title']        = "我的消息 - 用户中心";
        $body['top']          = $top;
        $body['sign']         = $this->load->view('common/sign', '', TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;

        $this->load->view('common/head', $data);
		if (strcmp($type, 'systemmsg') == 0) 
		{
			$this->load->view('systemmsg', $body);
		}
		elseif (strcmp($type, 'goodsmsg') == 0) 
		{			
			$this->load->view('goodsmsg', $body);			
		}
		elseif (strcmp($type, 'csmsg') == 0) 
		{				
			$this->load->view('comment_list', $body);
		}
	}

	/**
	 * [get_notification_list 获取消息列表]
	 * @return [type] [description]
	 */
	public function get_notification_list()
	{
		// $page = $this->sc->input('page');
		$page = 0;
		//消息类型
		// $type = $this->sc->input('type');
		$type = 1;
		$type = ! empty($type) ? $type : 'all';

		$notification = $this->notification_service->get_notification_list($page,$this->user['id'],$type);

		echo json_encode($notification);
	}

	/**
	 * [read 阅读消息]
	 * @return [type] [description]
	 */
	/*
	public function read()
	{
		$nid = $this->sc->input('nid');
		$type= $this->sc->input('type');

		$result = $this->notification_service->update($this->user['id'],$nid,$type,array('read_flag' => 1));
		if(!empty($result))
		{
			echo json_encode(array('success' => 0));
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}
	*/
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
			echo json_encode(array('success' => 0));
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}
}