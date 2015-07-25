<?php 

class Notification_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('notification_model');		
		$this->load->model('user_model');
	}

	/**
	 * [get_notification_list 获取用户的消息列表]
	 * @param  [type] $uid  [用户id]
	 * @param  [type] $type [消息类型]
	 * @return [type]       [description]
	 */
	public function get_notification_list($page,$uid,$type)
	{
		
		switch ($type) {
			case 'all':
				$type = 0;
				break;
			case 'conversation':
				$type = 1;
				break;
			case 'comment':
				$type =2;
				break;
			case 'like':
				$type =3;
				break;
			default:
				$type =0;
				break;
		}
		//全部
		if($type == 0)
		{
			//取出前100条私信消息
			$notification = $this->notification_model->get_notification_list(0,$uid,1,100);
			//取出所有消息组
			$group 	      = $this->notification_model->get_notification_group($uid);
			//合并成一个消息组
			$notification = array_merge($notification,$group);
			//根据时间排序
			$notification = Common::arr_sort($notification,'publish_time','desc');
		}
		else
		{
			$notification = $this->notification_model->get_notification_list($page,$uid,$type);			
		}
		//获取消息发送者信息
		foreach ($notification as $k => $v) {
			$notification[$k]['sender'] = $this->user_model->get_user_base_id($v['sender_id']);
		}
		
		return $notification;
	}

	/**
	 * [update 更新消息]
	 * @param  [type] $uid [用户id]
	 * @param  [type] $nid [消息id]
	 * @param  [type] $arr [更新键值]
	 * @return [type]      [description]
	 */
	public function update($uid,$nid,$arr)
	{	
		return $this->notification_model->update($uid,$nid,$arr);
	}

	/**
	 * [delete 删除消息]
	 * @param  [type] $nid [description]
	 * @return [type]      [description]
	 */
	public function delete($uid,$nid)
	{
		return $this->notification_model->delete($uid,$nid);
	}

	/**
	 * [insert 添加消息]
	 * @param  [type] $sender_id  [发送者id]
	 * @param  [type] $reciver_id [接受者id]
	 * @param  [type] $type       [消息类型]
	 * @param  [type] $content    [消息内容]
	 * @return [type]             [description]
	 */
	public function insert($sender_id,$reciver_id,$type,$content)
	{
		$content = json_encode($content);		
		return $this->notification_model->insert($sender_id,$reciver_id,$type,$content);
	}

}
