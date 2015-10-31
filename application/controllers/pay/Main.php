<?php

/**
 * 支付页面.
 */
class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('order_service');
        $this->load->service('user_service');
        $this->load->service('cart_service');
    }


    public function pay_for_cart()
    {
        $user_id = $this->user['id'];
        $contact_id = $this->user_service->get_address($user_id)['id'];
        $transport_id = $this->sc->input('tid');
        $issue_header = $this->sc->input('ish');
        $use_js = $this->sc->input('uj');
        if($use_js != 'qsc') {
            show_404();
        }

        $order = $this->order_service->buy_in_cart($user_id, $contact_id, $transport_id, $issue_header);

        $this->_alipay($order['order_no'], $order['order_name'], $order['total']);
    }

    public function pay_for_production()
    {
        $user_id = $this->user['id'];
        $contact_id = $this->user_service->get_address($user_id)['id'];
        $transport_id = $this->sc->input('tid');
        $issue_header = $this->sc->input('ish');
        $production_id = $this->sc->input('pid');
        $frame_id = $this->sc->input('fid');

        $use_js = $this->sc->input('uj');
        if($use_js != 'qsc') {
            show_404();
        }

        $order = $this->order_service->buy_production($user_id, $contact_id, $transport_id, $issue_header, $production_id, $frame_id);

        if($order == false) {
            echo '发生未知错误';
            exit();
        }


        $this->_alipay($order['order_no'], $order['order_name'], $order['total']);
    }

    /**
     * 支付前的验证
     */
    public function validate_pay()
    {
        $user_id = $this->user['id'];
        $transport_id = $this->sc->input('transport_id');

        $this->order_service->validate_pay($user_id, $transport_id);
        $this->message->success();
    }

    /**
     * 使用支付宝支付
     */
    private function _alipay($order_no, $order_name, $total)
    {
        require_once(APPPATH . 'third_party/alipay/alipay.config.php');
        require_once(APPPATH . 'third_party/alipay/lib/alipay_submit.class.php');

        /**************************请求参数**************************/

        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = "http://www.artvc.cc/artvc/pay/result";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //商户订单号
//        $out_trade_no = $_POST['WIDout_trade_no'];
        $out_trade_no = $order_no;
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject = $order_name;
        //必填

        //付款金额
        $total_fee = $total;
        //必填


        /************************************************************/

//构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipay_config['partner']),
            "seller_email" => trim($alipay_config['seller_email']),
            "payment_type" => $payment_type,
            "return_url" => $return_url,
            "out_trade_no" => $out_trade_no,
            "subject" => $subject,
            "total_fee" => $total_fee,
            'it_b_pay' => '1d', //一天后关闭支付
            "_input_charset" => trim(strtolower($alipay_config['input_charset']))
        );

//建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
        echo $html_text;
    }

    /**
     * 支付的回调
     */
    public function result()
    {
        require_once(APPPATH . 'third_party/alipay/alipay.config.php');
        require_once(APPPATH . 'third_party/alipay/lib/alipay_notify.class.php');
//计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if ($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号

            $out_trade_no = $_GET['out_trade_no'];

            //支付宝交易号

            $trade_no = $_GET['trade_no'];

            //交易状态
            $trade_status = $_GET['trade_status'];


            if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

                //交易成公，商品下架, 更新订单状态
                $this->order_service->complete_transaction($out_trade_no);

                //清空购物车
                $this->cart_service->empty_cart($this->user['id']);
                echo '恭喜你，支付成功';
            } else {
                echo "trade_status=" . $_GET['trade_status'];
            }

            echo "验证成功<br />";

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            echo "验证失败";
        }
    }

    public function test()
    {
        $this->order_service->buy_production(2, 1, 1, '', 51, 5);
    }
}