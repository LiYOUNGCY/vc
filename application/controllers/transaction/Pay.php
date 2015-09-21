<?php
class Pay extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('transaction_service');
	}
	public function index()
	{
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
        $data['title']        = "支付";
        $body['top']          = $top;
        $body['sign']         = $this->load->view('common/sign', '', TRUE);
        $body['footer']       = $this->load->view('common/footer', '', TRUE);
        $body['user']         = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('pay', $body);

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