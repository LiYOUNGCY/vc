<?php 
class Push
{	
	public function __construct()
	{
		$this->appkey = '55bc441c14ec0a7d21a70c5a';
		$this->seckey = 'sec-qOhmS7TXcfPIwSg6XTbFP4DBCyEEudCgKQlrZNQH9DmvP3QF';
	}
	
	public function push_to_topic($uid, $msg)
	{
		$uid  = md5(md5("artvc".$uid));
		
		$method = 'publish';
		$appkey = $this->appkey;
		$seckey = $this->seckey;
		$topic  = $uid;
		$url = "http://rest.yunba.io:8080?method={$method}&appkey={$appkey}&seckey={$seckey}&topic={$topic}&msg={$msg}";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
	}
}