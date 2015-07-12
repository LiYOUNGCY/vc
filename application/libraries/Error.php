<?php
/**
 * 错误消息类
 * 定义错误的代码及其错误名称
 * 错误类的命名规则
 * 		1. 数据验证失败，加前缀 invalid_ 
 * 		2. 重复的用户名，手机号等 加前缀 same_
 */

class Error {
	private $errcode = array();

	function __construct() {
		/*
		$this->errcode = array(
			);
		*/
	}

	public function get_errcode($str) {
		if($str != "" && isset($this->errcode[$str])) {
			return $this->errcode[$str];
		}
		else {
			return "没定义错误";
		}
	}

	public function output($str) {
		$output['error'] = $this->get_errcode($str);
		echo json_encode($output);
	}
}


?>