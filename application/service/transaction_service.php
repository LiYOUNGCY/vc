<?php

class Transaction_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaction_model');
        $this->load->model('production_model');
    }

    /**
     * [get_transaction_list 获取交易列表].
     *
     * @param [type] $page [description]
     *
     * @return [type] [description]
     */
    public function get_transaction_list($page, $uid)
    {
        $t = $this->transaction_model->get_transaction_list($page, $uid);
        foreach ($t as $k => $v) {
            $arr = explode(',', $v['pids']);
            $t[$k]['production'] = array();
            foreach ($arr as $k1 => $v1) {
                $p = $this->production_model->get_production_by_id($v1);
                if (!empty($p)) {
                    if (!empty($p['pic'])) {
                        $p['pic'] = Common::get_thumb_url($p['pic']);
                    }
                    array_push($t[$k]['production'], $p);
                }
            }
            unset($t[$k]['pids']);
        }

        return $t;
    }

    /**
     * [creat_payment 创建支付].
     *
     * @param [type] $buyer   [description]
     * @param [type] $pids    [description]
     * @param [type] $amount  [description]
     * @param [type] $tel     [description]
     * @param [type] $address [description]
     *
     * @return [type] [description]
     */
    public function creat_payment($buyer, $pids, $amount, $tel, $address, $channel)
    {
        $arr = explode(',', $pids);
        $total_fee = 0;
        $title_str = '';
        foreach ($arr as $k => $v) {
            //传递参数被篡改
            if (!is_numeric($v)) {
                $this->error->output('TRANSACT_DATA');
            }
            $p = $this->production_model->get_production_by_id($v);
            //商品不存在，已售出，下架
            if (empty($p) || $p['status'] == 1 || $p['status'] == 2) {
                $this->error->output('NO_GOOD');
            }
            $total_fee += (double) $p['price'];
            $title_str .= $p['name'].', ';
        }
        //显示价格被篡改
        if ($total_fee != $amount) {
            $this->error->output('TRANSACT_DATA');
        }

        $order_no = time().'u_'.$buyer;
        $subject = lang('BUY_SUBJECT');
        $body = $title_str;
        $extra_common_param = array('buyer' => $buyer, 'pids' => $pids, 'amount' => $amount, 'tel' => $tel, 'address' => $address);
        $extra_common_param = json_encode($extra_common_param);
        //创建支付
        switch ($channel) {
            case 'alipay':return $this->_alipay();break;
        }
    }

    /**
     * [_alipay 支付宝支付].
     *
     * @param [type] $order_no           [description]
     * @param [type] $subject            [description]
     * @param [type] $body               [description]
     * @param [type] $extra_common_param [description]
     *
     * @return [type] [description]
     */
    private function _alipay($order_no, $subject, $body, $extra_common_param)
    {
    }

    /**
     * [alipay_callback 支付回调].
     *
     * @param [type] $role         [回调类型(notify,return)]
     * @param [type] $trade_status [交易状态]
     * @param [type] $order_no     [订单号]
     * @param [type] $buyer        [用户id]
     * @param [type] $pids         [作品id集合]
     * @param [type] $amount       [金额]
     * @param [type] $address      [收货地址]
     * @param [type] $tel          [联系方式]
     *
     * @return [type] [description]
     */
    public function alipay_callback($role, $trade_status, $order_no, $buyer, $pids, $amount, $address, $tel)
    {
        $this->load->library('alipay');
        if ($role == 'return') {
            $verify_result = $this->alipay->verifyReturn();
        } else {
            $verify_result = $this->alipay->verifyNotify();
        }

        if ($verify_result) {
            //支付成功
            if ($trade_status == 'TRADE_SUCCESS') {
                //检查是否已经保存该记录
                $t = $this->transaction_model->get_transaction_by_order_no($order_no);
                if (!empty($t)) {
                    return true;
                }

                $result = $this->transaction_model->insert_transaction($order_no, $buyer, $pids, $amount, $address, $tel);
                //改变商品状态为已售出				
                if ($result) {
                    $arr = explode(',', $pids);
                    foreach ($arr as $k => $v) {
                        $this->production_model->update_production($v, array('status' => 1));
                    }
                }

                return $result;
            }
            //退款成功
            elseif ($trade_status == 'TRADE_FINISHED') {
            }
            //交易失败
            else {
                return false;
            }
        } else {
            return false;
        }
    }
}
