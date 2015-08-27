<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('cart_service');
	}
	public function index()
	{
		
	}
	/**
	 * [get_good_list 获取购物车物品列表]
	 * @return [type] [description]
	 */
	public function get_good_list()
	{
		$page = $this->sc->input('page');
		$limit= 10;
		$goods = $this->cart_service->get_good_list($this->user['id'],$page,$limit);
		//分页输出
		$arr['goods'] = array_slice($goods, $page * $limit, $limit);
		//购物车总数量
		$arr['count'] = count($goods);
		
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