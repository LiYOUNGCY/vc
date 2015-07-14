<?php


class Remember extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		echo "Remember ME TEST";

		echo '<br/>', $this->user['id'], '<br/>';

		var_dump($_SESSION);
		$this->lang->load('example', 'zh-CN');
		echo lang('test');
	}
}