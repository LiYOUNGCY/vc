<?php
class Transaction_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [insert_transaction 添加新交易记录]
	 * @param  [type] $buyer   [购买者id]
	 * @param  [type] $pids    [作品id集合]
	 * @param  [type] $amount  [金额]
	 * @param  [type] $address [收货地址]
	 * @param  [type] $tel     [联系方式]
	 * @return [type]          [description]
	 */
	public function insert_transaction($order_no, $buyer, $pids, $amount, $address, $tel)
	{
		$data = array(
			'order_no' => $order_no,
			'buyer'    => $buyer,
			'pids' 	   => $pids,
			'amount'   => $amount,
			'address'  => $address,
			'tel' 	   => $tel,
			'buy_time' => date('Y-m-d H:i:s',time())
		);
		$this->db->insert('transaction',$data);
		return $this->db->affected_rows() === 1;
	}

	public function get_transaction_by_order_no($order_no)
	{
		$query = $this->db->where('order_no',$order_no)
						  ->get('transaction')
						  ->row_array();
		return $query;
	}
	/**
	 * [update_transaction 更新交易记录]
	 * @param  [type] $tid [交易id]
	 * @param  [type] $arr [键值数组]
	 * @return [type]      [description]
	 */
	public function update_transaction($tid, $arr)
	{

	}

	/**
	 * [get_transaction_list 获取交易记录列表]
	 * @param  integer $page  [description]
	 * @param  [type]  $uid   [description]
	 * @param  integer $limit [description]
	 * @param  string  $order [description]
	 * @return [type]         [description]
	 */
	public function get_transaction_list($page = 0, $uid = NULL, $status = NULL, $limit = 10, $order = 'buy_time')
	{
		if( ! empty($uid))
		{
			$this->db->where('buyer',$uid);
		}
		if( ! empty($status))
		{
			$this->db->where('status',$status);
		}
		$query = $this->db->order_by($order)
						  ->limit($limit, $page * $limit)
						  ->get('transaction')
						  ->result_array();
		return $query;
	}
}