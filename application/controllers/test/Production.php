<?php


class Production extends MY_Controller
{
    public function index()
    {
        $this->load->model('frame_model');
        echo json_encode($this->frame_model->get_frame_by_production(1));
    }
}
