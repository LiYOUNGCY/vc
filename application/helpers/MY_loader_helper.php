<?php

if( !function_exists( 'load_header') )
{
    function load_header($str)
    {
        $data['title'] = $str;
        $CI = & get_instance();

        $data['css'] = array();

        foreach(func_get_args() as $value) {
            if(substr($value, -3, 3) == 'css') {
                array_push($data['css'], $value);
            }
        }

        $CI->load->view('common/head', $data);
    }
}