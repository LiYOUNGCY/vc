<?php 
class Contacts_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_follow_model');
		$this->load->model('user_model');
		$this->load->model('notification_model');
	}

	/**
	 * [get_contacts_list 获取联系人列表]
	 * @param  [type] $page [页数]
	 * @param  [type] $uid  [用户id]
	 * @param  [type] $type [类型 follow关注,follower粉丝]
	 * @return [type]       [description]
	 */
	public function get_contacts_list($page, $uid, $type)
	{
		switch($type){
			case 'follow':
				$type = 0;
				break;
			case 'follower':
				$type =1;
				break;
			default:
				$type = 0;
				break;
		}

		$contacts = $this->user_follow_model->get_user_follow($page,$uid,$type);
		//获取用户基本信息
		foreach ($contacts as $k => $v) {			
			$contacts[$k] = $this->user_model->get_user_base_id($v['uid']);		
		}

		return $contacts;
	}

	/**
	 * [following 关注或取消关注]
	 * @param  [type] $myid [关注者id]
	 * @param  [type] $uid  [被关注者id]
	 * @return [type]       [description]
	 */
	public function following($myid,$uid)
	{
		$follow_status = $this->user_follow_model->check_follow($myid, $uid);
		if( ! empty($follow_status))
		{
			$arr = array(
				'status' => ! $follow_status['status']
			);
			$result = $this->user_follow_model->update_follow($follow_status['id'],$arr);
			if($result)
			{
				//增加粉丝数				
				$amount = $follow_status['status'] == 1 ? 1 : -1;
				$this->user_model->update_count($uid,array('name' => 'follower', 'amount' => $amount));
			}
		}
		else
		{
			$result = $this->user_follow_model->insert_follow($myid, $uid);	
			if($result)
			{
				//添加消息
				$notification_result = $this->notification_model->insert($myid,$uid,4,"");	
				//增加粉丝数
				$this->user_model->update_count($uid,array('name' => 'follower', 'amount' => 1));							
			}	
		}
		return $result;
	}
}