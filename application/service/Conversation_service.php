<?php 
class Conversation_service extends MY_Service{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('conversation_model');
		$this->load->model('conversation_content_model');
		$this->load->model('notification_model');
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
			return $content;			
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
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
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}				
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
			echo 'success';
			//添加私信消息（异步）
			$this->insert_conversation_notification($sender_id,$reciver_id,$content,$cid);
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
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
	public function insert_conversation_notification($sender_id, $reciver_id, $content, $cid)
	{
		$check_result = $this->notification_model->check_conversation_notification($sender_id,$reciver_id);

		if(empty($check_result))
		{
			//添加私信消息
			$arr = array(
				'conversation_id' 	   => $cid,
				'conversation_content' => $content,
				'count' 			   => 0
			);
			$this->notification_model->insert($sender_id,$reciver_id,1,json_encode($arr));			
		}
		else
		{
			//更新私信消息
			$count = 0;
			if($check_result['read_flag'] == 0)
			{
				//增加未读私信个数
				$notification_content = (array)json_decode($check_result['content']);
				$count = (int)$notification_content['count'] + 1;
			}

			$arr = array(
				'content'  => json_encode(array('conversation_id' => $cid,'conversation_content' => $content,'count' => $count)),
				'read_flag'=> 0
			);
			$nid = $check_result['id'];
			$this->notification_model->update_notification($nid,$arr);			
		}
	}
}