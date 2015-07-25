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





    /**
     * 删除文章的格式，空格
     * @param $article_content
     * @return string
     */
    static function extract_content($article_content)
    {
        //去掉 HTML 的开标签
        $article_content = preg_replace("/(<([\w]+)[^>]*>)/i", "", $article_content);

        //去掉 HTML 的闭标签
        $article_content = preg_replace("/(<\/([\w]+)[^>]*>)/i", "", $article_content);

        //去掉空格
        $article_content = preg_replace("/\s/", "", $article_content);

        $clean_content = mb_substr($article_content, 0, 70);
        return $clean_content;
    }


    /**
     * 获取文章中的第一张图片
     * @param $article_content
     * @return string
     */
    static function extract_first_img($article_content)
    {
        $match = array();
        preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/", $article_content, $match);
        return isset( $match[1][0] ) ? $match[1][0] : '';
    }

    static function arr_sort($array,$key,$order="asc")
    {//asc是升序 desc是降序

		$arr_nums=$arr=array();

		foreach($array as $k=>$v)
		{
			$arr_nums[$k]=$v[$key];
		}

		if($order=='asc')
		{
			asort($arr_nums);
		}
		else
		{
			arsort($arr_nums);
		}

		foreach($arr_nums as $k=>$v){
			array_push($arr, $array[$k]);

		}

		return $arr;

	}
}