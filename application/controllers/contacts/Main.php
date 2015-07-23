<?php 
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('contacts_service');
	}

	/**
	 * [index 我的联系人列表]
	 * @param  string $type [follow关注 follower粉丝]
	 * @return [type]       [description]
	 */
	public function index($type = 'follow')
	{
		$page = $this->sc->input('page');
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