<?php

/**
 * 创建订单的页面.
 */
class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('user_service');
    }

    /**
     * [index description].
     *
     * @return [type] [description]
     */
    public function index()
    {
        //收货地址
        $address = $this->user_service->get_address($this->user['id']);
        //配送方式

        //作品列表
    }
}
