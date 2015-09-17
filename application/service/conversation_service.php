<?php 
class Conversation_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('conversation_model');
		$this->load->model('conversation_content_model');
		$this->load->model('conversation_custom_model');
		$this->load->model('notification_model');
		$this->load->model('user_model');
        $this->load->model('customer_model');
	}

	/**
	 * [get_conversation_content 获取对话内容]
	 * @param  [type] $page [页数]
	 * @param  [type] $uid  [用户id]
	 * @param  [type] $cid  [对话id]
	 * @return [type]       [description]
	 */
	public function get_conversation_content($page, $uid, $cid)
	{	
		$check_result = $this->check_has_conversation($uid,$cid);
		if($check_result)
		{
			$content = $this->conversation_content_model->get_conversation_content($page,$cid);
			if( ! empty($content))
			{
				$bid = $content[0]['sender_id'] == $uid ? $content[0]['reciver_id'] : $content[0]['sender_id'];
				//对方信息
				$conversation['he'] = $this->user_model->get_user_base_id($bid);
				//我的信息
				$conversation['me']= $this->user_model->get_user_base_id($uid);

				$conversation['list'] = $content;
				return $conversation;
			}
			else
			{
				return FALSE;
			}	
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().'notification";','type' => 0));
		}
	}

	/**
	 * [check_has_conversation 查看是否参与该对话]
	 * @param  [type] $uid [用户id]
	 * @param  [type] $cid [对话id]
	 * @return [type]      [description]
	 */
	public function check_has_conversation($uid,$cid)
	{
		$result = $this->conversation_model->get_conversation_by_id($cid);
		if( ! empty($result))
		{
			if($result['aid'] == $uid || $result['bid'] == $uid)
			{
				return $result;
			}
		}
		return false;			
	}

	/**
	 * [publish_conversation 发送私信]
	 * @param  [type] $sender_id  [发送者id]
	 * @param  [type] $reciver_id [接收者id]
	 * @param  [type] $content    [对话内容]
	 * @return [type]             [description]
	 */
	public function publish_conversation($sender_id, $reciver_id, $content)
	{
		if($sender_id == $reciver_id)
		{
			return FALSE;
		}
		$content = Common::replace_face_url($content);
		$aid = "";
		$bid = "";
		if($sender_id < $reciver_id)
		{
			$aid = $sender_id;
			$bid = $reciver_id;
		}
		else
		{
			$aid = $reciver_id;
			$bid = $sender_id;
		}
		$check_result = $this->conversation_model->get_conversation_by_uid($aid,$bid);
		$cid = "";
		$insert_result = FALSE;
		//未建立过对话
		if(empty($check_result))
		{
			//添加新对话
			$cid = $this->conversation_model->insert_conversation($aid,$bid);
			//添加对话内容
			$insert_result = $this->conversation_content_model->insert_conversation_content($cid,$sender_id,$reciver_id,$content);
		}
		//已建立过对话
		else
		{
			$cid = $check_result['id'];
			//$this->conversation_model->update_conversation($cid,array());
			//添加对话内容
			$insert_result = $this->conversation_content_model->insert_conversation_content($cid,$sender_id,$reciver_id,$content);			
		}
		if($insert_result)
		{
			echo json_encode(array('success' => 0));
			//添加私信消息（异步）
			$this->insert_conversation_notification($sender_id,$reciver_id,$content,$cid);
			
			$this->insert_conversation_notification($reciver_id,$sender_id,$content,$cid,1);
            //推送
            $this->load->library('push');
            $this->push->push_to_topic($reciver_id,"");                    
            
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * [insert_conversation_notification 添加私信消息]
	 * @param  [type] $sender_id  [发送者id]
	 * @param  [type] $reciver_id [接收者id]
	 * @param  [type] $content    [对话内容]
	 * @param  [type] $cid        [description]
	 * @return [type]             [description]
	 */
	public function insert_conversation_notification($sender_id, $reciver_id, $content, $cid, $read_flag = 0)
	{
		$check_result = $this->notification_model->check_conversation_notification($sender_id,$reciver_id);

		if(empty($check_result))
		{
			//添加私信消息
			$arr = array(
				'conversation_id' 	   => $cid,
				'conversation_content' => $content,
				'count' 			   => 1,
				'publish_time' 		   => date('Y-m-d H-m-s')				
			);
			$this->notification_model->insert($sender_id,$reciver_id,1,json_encode($arr),$read_flag);			
		}
		else
		{
			//更新私信消息
			$count = 1;
			if($check_result['read_flag'] == 0)
			{
				//增加未读私信个数
				$notification_content = (array)json_decode($check_result['content']);
				$count = (int)$notification_content['count'] + 1;
			}

			$arr = array(
				'content'      => json_encode(array('conversation_id' => $cid,'conversation_content' => Common::extract_content($content),'count' => $count)),
				'read_flag'	   => $read_flag,
				'publish_time' => date('Y-m-d H-m-s')
			);
			$nid = $check_result['id'];
			$this->notification_model->update_notification($nid,$arr);			
		}
	}
 	

 	/**
 	 * [get_custom_service_list 获取客服列表]
 	 * @return [type] [description]
 	 */
	public function get_custom_service_list()
	{
		$custom = $this->conversation_custom_model->get_conversation_custom_list();
		foreach ($custom as $k => $v) {
			$user = $this->user_model->get_user_base_id($v['uid']);
			if( ! empty($user))
			{
				$custom[$k]['info'] = $user;		
				unset($custom['id']);			
				unset($custom[$k]['info']['id']);
			}
		}
		return $custom;
	}

	/**
	 * [get_latest_list 获取最近消息]
	 * @param  [type] $page [description]
	 * @param  [type] $uid  [description]
	 * @return [type]       [description]
	 */
	public function get_latest_list($page,$uid)
	{
		$notification = $this->notification_model->get_notification_list($page,$uid,1);		
		foreach ($notification as $k => $v) {
			//获取对方的信息
			$he = $notification[$k]['sender_id'] == $uid ? $notification[$k]['reciver_id'] : $uid;
			$user = $this->user_model->get_user_base_id($he);
			if( ! empty($user))
			{
				$notification[$k]['user'] = $user;
				unset($notification[$k]['reciver_id']);
				unset($notification[$k]['sender_id']);
				unset($notification[$k]['type']);
			}
		}		
		return $notification;
	}

	public function insert_message($data) {
		return $this->customer_model->insert_message($data);
	}
}	