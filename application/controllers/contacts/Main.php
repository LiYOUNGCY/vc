<?php 
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('contacts_service');
	}

	/**
	 * [index 显示界面]
	 * @return [type] [description]
	 */
	public function index()
	{
		
	}

	/**
	 * [get_contacts_list 获取我的联系人列表]
	 * @return [type]       [description]
	 */	
	public function get_contacts_list()
	{
		$page = $this->sc->input('page');
		//列表类型
		$type = $this->sc->input('type');
		$type = ! empty($type) ? $type : 'follow';

		$contacts = $this->contacts_service->get_contacts_list($page,$this->user['id'],$type);
		echo json_encode($contacts);
	}

	/**
	 * [following 关注或取消关注]
	 * @return [type] [description]
	 */
	public function following()
	{
		$uid = $this->sc->input('uid');
		$result = $this->contacts_service->following($this->user['id'],$uid);	
		if($result)
		{
			echo "success";
		}
		else
		{
			echo "failed";
		}
	}
}