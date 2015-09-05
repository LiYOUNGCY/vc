<?php
class Alipay{
	public function __construct()
	{
		require_once(APPPATH.'third_party/alipay/alipay.config.php');
	}

	public function verifyReturn()
	{
		$alipayNotify = new AlipayNotify($alipay_config);
		return $alipayNotify->verifyReturn();		
	}

	public function verifyNotify()
	{
		$alipayNotify = new AlipayNotify($alipay_config);
		return $alipayNotify->verifyNotify();			
	}	
}