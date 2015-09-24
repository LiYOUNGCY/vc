<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('cart_service');
	}
	public function index()
	{
		$head['css'] = array(
			'base.css',
			'font-awesome/css/font-awesome.min.css',
			'alert.css',
		);

		$head['javascript'] = array(
			'jquery.js',
			'error.js',
			'alert.min.js',
		);

		$user['user'] 		  = $this->user;
		$user['sign'] = $this->load->view('common/sign', '', TRUE);

        $head['title']        = "购物车";
        $body['top']          = $this->load->view('common/top', $user, TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;

		$this->load->view('common/head', $head);
		$this->load->view('cart', $body);
	}
	/**
	 * [get_good_list 获取购物车物品列表]
	 * @return [type] [description]
	 */
	public function get_good_list()
	{
		//$page = $this->sc->input('page');
		$page = 0;
		$limit= 10;
		$goods = $this->cart_service->get_good_list($this->user['id'],$page,$limit);
		if( ! empty($goods))
		{
			//分页输出
			$arr['goods'] = array_slice($goods, $page * $limit, $limit);
			//购物车总数量
			$arr['count'] = count($goods);			
		}
		else
		{
			$arr['goods'] = NULL;
			$arr['count'] = 0;
		}
		
		echo json_encode($arr);
	}

	/**
	 * [add_good 添加购物车物品]
	 */
	public function add_good()
	{
		$pid = $this->sc->input('pid');
		$result = $this->cart_service->add_good($this->user['id'],$pid);
		echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS')));
	}

	/**
	 * [remove_good 移除购物车物品]
	 * @return [type] [description]
	 */
	public function remove_good()
	{
		$id = $this->sc->input('id');
		$result = $this->cart_service->remove_good($id,$this->user['id']);
		if($result)
		{
			echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS')));
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}
}