<?php


class Message_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('message_model');
    }

    public function system_message($send_id, $message_text)
    {
        $query = $this->message_model->send_message_to_all_users($send_id, $message_text, SYSTEM_MESSAGE);

        return $query;
    }

    public function goods_message($send_id, $receiver_id, $message_text)
    {
      $query = $this->message_model->send_message_to_user($send_id, $receiver_id, $message_text, GOODS_MESSAGE);

      return $query;
    }

    public function get_system_message_by_user($user_id, $page)
    {
      $query = $this->message_model->get_message_by_user($user_id, SYSTEM_MESSAGE, $page);

      return $query;
    }

    public function get_goods_message_by_user($user_id, $page)
    {
      $query = $this->message_model->get_message_by_user($user_id, GOODS_MESSAGE, $page);

      return $query;
    }
}
