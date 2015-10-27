<?php

/**
 * 支付页面.
 */
class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 使用支付宝支付
     */
    public function index()
    {
        require_once APPPATH . 'third_party/alipay/alipay.config.php';
        require_once APPPATH . 'third_party/alipay/lib/alipay_submit.class.php';

//        var_dump($alipay_config);

        /**************************请求参数**************************/

        //支付类型
        $payment_type = '1';
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = 'http://www.artvc.com/pay/success';
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = 'http://www.artvc.com/pay/success';
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //商户订单号
        // $out_trade_no = $_POST['WIDout_trade_no'];
        $out_trade_no = time();
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        // $subject = $_POST['WIDsubject'];
        $subject = 'TEST';
        //必填

        //付款金额
        // $total_fee = $_POST['WIDtotal_fee'];
        $total_fee = 1;
        //必填

        //订单描述

        // $body = $_POST['WIDbody'];
        $body = 'TEST';
        //商品展示地址
        // $show_url = $_POST['WIDshow_url'];
        $show_url = 'www.artvc.com';
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

        //防钓鱼时间戳
        $anti_phishing_key = '';
        //若要使用请调用类文件submit中的query_timestamp函数

        //客户端的IP地址
        $exter_invoke_ip = '';
        //非局域网的外网IP地址，如：221.0.0.1


        /************************************************************/

        //构造要请求的参数数组，无需改动
        $parameter = array(
            'service' => 'create_direct_pay_by_user',
            'partner' => trim($alipay_config['partner']),
            'seller_id' => trim($alipay_config['partner']),
            'seller_email' => trim($alipay_config['seller_email']),
            'payment_type' => $payment_type,
            'notify_url' => $notify_url,
            'return_url' => $return_url,
            'out_trade_no' => $out_trade_no,
            'subject' => $subject,
            'total_fee' => $total_fee,
            'body' => $body,
            'show_url' => $show_url,
            'anti_phishing_key' => $anti_phishing_key,
            'exter_invoke_ip' => $exter_invoke_ip,
            '_input_charset' => trim(strtolower($alipay_config['input_charset'])),
        );

        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
//        var_dump($alipaySubmit);
        $html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');
//        var_dump($html_text);
        echo $html_text;
    }

    /**
     * 支付成功的回调
     */
    public function success()
    {
        require_once APPPATH . 'third_party/alipay/alipay.config.php';
        require_once APPPATH . 'third_party/alipay/lib/alipay_notify.class.php';
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if ($verify_result) {
            //验证成功
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
            } else {
                echo 'trade_status=' . $_GET['trade_status'];
            }

            echo '验证成功<br />';

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            echo '验证失败';
        }
    }
}