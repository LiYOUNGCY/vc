<?php 
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('community_service');
	}

	/**
	 * [index 进入圈子]
	 * @return [type]      [description]
	 */
	public function index()
	{
		$data['css'] = array('common.css', 'font-awesome/css/font-awesome.min.css');
        $data['javascript'] = array('jquery.js','timeago.js');
        $u['user']    = $this->user;
        $this->load->view('common/head', $data);
    	$data['sidebar'] = $this->load->view('common/sidebar', $u, TRUE);
     	$data['footer'] = $this->load->view('common/footer',"", TRUE);

		$this->load->view('quanzi',$data);
	}

	/**
	 * [get_post_list 获取圈子信息与帖子列表]
	 * @return [type] [description]
	 */
	public function get_community()
	{
		$cid = $this->sc->input('cid');
		$page 	   = $this->sc->input('page');
		$community = $this->community_service->get_community($page,$this->user['id'],$cid);
		echo json_encode($community);		
	}

}
