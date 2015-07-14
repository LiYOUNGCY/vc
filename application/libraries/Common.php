<?php
class Common{
	/**
	 * 获取真实的IP地址
	 * @return [type] [description]
	 */
	static function getIP() {

	    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
	        $ip = getenv("HTTP_CLIENT_IP");
	    else
	        if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
	            $ip = getenv("HTTP_X_FORWARDED_FOR");
	        else
	            if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
	                $ip = getenv("REMOTE_ADDR");
	            else
	                if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
	                    $ip = $_SERVER['REMOTE_ADDR'];
	                else
	                    $ip = "unknown";
	    return ($ip);
	}

	/**
	 * [get_route 获取路由]
	 * @return [type] [description]
	 */
	static function get_route()
	{
		$CI = &get_instance();
		$class = $CI->router->fetch_class();
		$dir   = $CI->router->fetch_directory();
		$method= $CI->router->fetch_method();
		$route = "{$dir}{$class}/{$method}";
		return $route;
	}
}