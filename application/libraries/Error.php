<?php
/**
 * 错误消息类
 * 定义错误的代码及其错误名称
 * 错误类的命名规则
 */

class Error {

	function __construct() {
	}

	public function output($key) {
		$msg = array();
		$msg['error'] = lang('error_'.strtoupper($key));
		echo json_encode($msg);
		//遇到错误终止运行
		exit();
	}
}
