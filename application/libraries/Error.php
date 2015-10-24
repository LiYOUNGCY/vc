<?php
/**
 * 错误消息类
 * 定义错误的代码及其错误名称
 * 错误类的命名规则.
 */
class Error
{
    public function __construct()
    {
    }

    /**
     * [output 错误处理].
     *
     * @param [type] $key            [错误代号]
     * @param [type] $error_redirect [错误重定向数组]
     *
     * @return [type] [description]
     */
    public function output($key, $error_redirect = array('script' => ''))
    {
        $msg = array();
        $msg['error'] = lang('error_'.strtoupper($key));

        //如果重定向脚本不为空
        if (!empty($error_redirect['script'])) {
            $msg['script'] = $error_redirect['script'];
        }

        //如果错误类型是ajax提交
        if (Common::is_ajax()) {
            echo json_encode($msg);
            //遇到错误终止运行
            exit();
        }
        //如果错误类型是form提交
        else {
            $script = "<script>alert('{$msg['error']}');".$error_redirect['script'].'</script>';
            echo $script;
            exit();
        }
    }
}
