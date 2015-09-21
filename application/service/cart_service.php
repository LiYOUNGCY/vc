<?php
class Cart_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cart_model');
		$this->load->model('production_model');
	}

	/**
	 * [add_good 添加物品到购物车]
	 * @param [type] $uid [用户id]
	 * @param [type] $pid [物品id]
	 */
	public function add_good($uid, $pid)
	{
		if( ! isset($_SESSION['cart']))
		{
			//获取购物车物品列表
			$goods = $this->_get_all_good_list($uid);
			//设置session
			$this->session->set_userdata('cart',$goods);
		}

		$set = FALSE;
		foreach ($_SESSION['cart'] as $k => $v) {
			if($v['production']['id'] == $pid)
			{
				$set = TRUE;
				break;
			}
		}
		//购物车还未有该物品
		if( ! $set)
		{
			$production 	   = $this->production_model->get_production_by_id($pid);
			$production['pic'] = Common::get_thumb_url($production['pic']);			
			if(empty($production))
			{
				$this->error->output('INVALID_REQUEST');
			}				
			//将购物车物品信息添加到数据库
			$result = $this->cart_model->insert_good($uid,$pid);
			if( ! empty($result))
			{
				//将购物车物品信息添加到session					
				$arr = $_SESSION['cart'];
				$v   = array(
					 'id'         => $result['id'], 
					 'add_time'   => $result['add_time'],
					 'production' => $production
				);
				array_unshift($arr,$v);
				$this->session->set_userdata('cart',$arr);
			}
			else
			{
				$this->error->output('INVALID_REQUEST');
			}			
		}
		//购物车已有该物品
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
		return TRUE;
	}

	/**
	 * [remove_good 从购物车中删除物品]
	 * @param  [type] $id  [物品id]
	 * @param  [type] $uid [用户id]
	 * @return [type]      [description]
	 */
	public function remove_good($id, $uid)
	{
		$result = $this->cart_model->delete_good($id,$uid);
		if($result)
		{
			//删除session
			if(isset($_SESSION['cart']))
			{
				foreach ($_SESSION['cart'] as $k => $v) {
					if($v['id'] == $id)
					{
						unset($_SESSION['cart'][$k]);
						break;
					}
				}
			}
			return TRUE;
		}
		return FALSE;
		
	}

	/**
	 * [get_good_list 获取购物车物品列表]
	 * @param  [type]  $uid   [用户id]
	 * @param  integer $page  [页数]
	 * @param  integer $limit [页面个数限制]
	 * @return [type]         [description]
	 */
	public function get_good_list($uid, $page = 0, $limit = 10)
	{
		echo var_dump($_SESSION['cart']);
		if(isset($_SESSION['cart']))
		{
			if(empty($_SESSION['cart']))
			{
				return NULL;
			}
			return $_SESSION['cart'];

		}	
		else
		{
			//获取购物车物品列表
			$goods = $this->_get_all_good_list($uid);
			//添加到session
			$this->session->set_userdata('cart',$goods);
			return $goods;
		}
	}


	/**
	 * [_get_all_good_list 获取用户的所有购物车物品]
	 * @param  [type] $uid [用户id]
	 * @return [type]      [description]
	 */
	private function _get_all_good_list($uid)
	{
		$goods = $this->cart_model->get_good_list_by_uid($uid);
		foreach ($goods as $k => $v) {
			//获取物品详情
			$p = $this->production_model->get_production_by_id($goods[$k]['pid']);
			$p['pic'] = Common::get_thumb_url($p['pic']);
			unset($goods[$k]['pid']);	
			unset($goods[$k]['uid']);
			$goods[$k]['production'] = $p;
			$this->load->model('artist_model');
			if( ! empty($p['aid']))
			{
				$goods[$k]['artist'] = $this->artist_model->get_artist_base_id($p['aid']);				
			}
			else
			{
				$goods[$k]['artist'] = NULL;
			}
		}
		return $goods;	
	}


}