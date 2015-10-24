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
        $query = $this->message_model->send_message_to_all_users($send_id, $message_text);

        return $query;
    }
}
