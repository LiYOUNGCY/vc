<?php
class Pay extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('transaction_service');
	}

	/**
	 * [creat_payment 创建支付]
	 * @return [type] [description]
	 */
	public function creat_payment()
	{
		$channel = $this->sc->input('channel');
		switch ($channel) {
			case 'alipay':
				$this->_alipay();
				break;
			default:
				$this->error->output('INVALID_REQUEST');
				break;
		}
	}

	private function _alipay()
	{
		$transaction = $this->sc->input(array('pids', 'amount', 'tel', 'address'));
		$this->transaction_service->creat_payment($this->user['id'], $transaction['pids'], $transaction['amount'], $transaction['tel'], $transaction['address'],'alipay');		
	}

}