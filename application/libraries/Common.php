<?php

class Common
{
    /**
     * 获取真实的IP地址.
     *
     * @return [type] [description]
     */
    public static function getIP()
    {
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = 'unknown';
        }

        return ($ip);
    }

    /**
     * [get_route 获取路由].
     *
     * @return [type] [description]
     */
    public static function get_route()
    {
        $CI = &get_instance();
        $class = $CI->router->fetch_class();
        $dir = $CI->router->fetch_directory();
        $method = $CI->router->fetch_method();
        $route = "{$dir}{$class}/{$method}";

        return $route;
    }

    /**
     * [extract_article 格式化文章至列表].
     *
     * @param [type] $article_id      [文章id]
     * @param [type] $article_title   [文章标题]
     * @param [type] $article_content [文章内容]
     *
     * @return [type] [description]
     */
    public static function extract_article($article_id, $article_title, $article_content)
    {
        $content = array(
            'article_id' => $article_id,
            'article_title' => $article_title,
            'article_content' => self::extract_content($article_content),
            'article_image' => self::extract_first_img($article_content),
        );

        return $content;
    }

    public static function extract_topic($article_id, $article_title, $article_content)
    {
        $content = array(
            'article_id' => $article_id,
            'article_title' => $article_title,
            'article_content' => self::extract_content($article_content),
            'article_image' => self::extract_first_img_by_topic($article_content),
        );

        return $content;
    }

    /**
     * 删除文章的格式，空格.
     *
     * @param $article_content
     *
     * @return string
     */
    public static function extract_content($article_content)
    {
        //去掉 HTML 的开标签
        $article_content = preg_replace("/(<([\w]+)[^>]*>)/i", '', $article_content);

        //去掉 HTML 的闭标签
        $article_content = preg_replace("/(<\/([\w]+)[^>]*>)/i", '', $article_content);

        //去掉空格
        $article_content = preg_replace("/\s/", '', $article_content);

        if (mb_strlen($article_content) > 70) {
            $article_content = mb_substr($article_content, 0, 70);
            $article_content .= '...';
        }

        return $article_content;
    }

    public static function extract_first_img_by_topic($article_content)
    {
        $match = array();
        preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/", $article_content, $match);
        if ($match[1][0]) {
            return self::get_thumb_url_by_suffix($match[1][0]);
        }

        return;
    }

    /**
     * 获取文章中的第一张图片.
     *
     * @param $article_content
     *
     * @return string
     */
    public static function extract_first_img($article_content)
    {
        $match = array();
        preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/", $article_content, $match);
//        $result = isset($match[1][0]) ? $match[1][0] : '';
        if (isset($match[1][0])) {
            $path = $match[1][0];
            $path = explode('/', $path);
            $count = count($path);
            if (strstr($path[$count - 1], 'thumb2_')) {
                $path[$count - 1] = str_replace('thumb2_', '', $path[$count - 1]);
            }
//    		$filename = str_replace('.', '_thumb.', $path[$count-1]);
            $file = explode('.', $path[$count - 1]);
            $filename = 'thumb1_'.$file[0].'.'.$file[1];
//            $filename = 'f011597f8615be412c8fad36e7c0f694_thumb.jpg';
            $path[$count - 1] = $filename;
            $path = implode('/', $path);

            return $path;
        } else {
            $default_img = base_url().'public/img/defaultBG.jpg';

            return $default_img;
        }
    }

    public static function get_thumb_url($pic, $pre = 'thumb1_')
    {
        $arr = explode('/', $pic);
        if (!empty($arr)) {
            $arr[count($arr) - 1] = $pre.$arr[count($arr) - 1];
            $pic = implode('/', $arr);

            return $pic;
        }

        return '';
    }

    public static function get_thumb_url_by_suffix($path)
    {
        $image = explode('/', $path);
        if (!empty($image)) {
            $len = count($image);
            $image[$len - 1] = str_replace('.', '_thumb.', $image[$len - 1]);

            return implode('/', $image);
        }

        return;
    }

    /**
     * [has_first_img 是否有图片].
     *
     * @return bool [description]
     */
    public static function has_first_img($content)
    {
        $match = array();
        preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/", $content, $match);

        return isset($match[1][0]) ? $match[1][0] : '';
    }

    public static function arr_sort($array, $key, $order = 'asc')
    {
        //asc是升序 desc是降序

        $arr_nums = $arr = array();

        foreach ($array as $k => $v) {
            $arr_nums[$k] = $v[$key];
        }

        if ($order == 'asc') {
            asort($arr_nums);
        } else {
            arsort($arr_nums);
        }

        foreach ($arr_nums as $k => $v) {
            array_push($arr, $array[$k]);
        }

        return $arr;
    }

    public static function replace_face_url($str)
    {
        $face_url = base_url().'public/img/face/';
        $str = str_replace('>', '<；', $str);
        $str = str_replace('>', '>；', $str);
        $str = str_replace("\n", '<br/>', $str);
        $str = preg_replace("[\[em_([0-9]*)\]]", "<img src=\"{$face_url}$1.gif\" />", $str);

        return $str;
    }

    public static function is_ajax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }

        return false;
    }
}
