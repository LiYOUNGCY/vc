<?php

class Callback extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('transaction_service');
    }

    /**
     * [alipay_callback 支付回调].
     *
     * @return [type] [description]
     */
    public function alipay_callback()
    {
        $t = $this->sc->input(array('trade_status', 'out_trade_no', 'extra_common_param'));
        $extra_common_param = json_decode($t['extra_common_param']);
        $result = $this->transaction_service->alipay_callback('return', $t['trade_status'], $t['out_trade_no'], $extra_common_param['buyer'], $extra_common_param['pids'],
            $extra_common_param['amount'], $extra_common_param['address'], $extra_common_param['tel']);
        if ($result) {
            //跳转页面
        } else {
            $this->error->output('TRANSACT_FAILED');
        }
    }

    /**
     * [alipay_notify_callback 支付异步回调].
     *
     * @return [type] [description]
     */
    public function alipay_notify_callback()
    {
        $t = $this->sc->input(array('trade_status', 'out_trade_no', 'extra_common_param'));
        $extra_common_param = json_decode($t['extra_common_param']);
        $result = $this->transaction_service->alipay_callback('notify', $t['trade_status'], $t['out_trade_no'], $extra_common_param['buyer'], $extra_common_param['pids'],
            $extra_common_param['amount'], $extra_common_param['address'], $extra_common_param['tel']);
        if ($result) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }
}
