<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/15
 * Time: 12:52
 */
class Article_service extends MY_Service{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('feed_model');
        $this->load->model('article_like_model');
    }


    /**
     * 发表文章
     * @param $user_id
     * @param $article_title
     * @param $article_subtitle
     * @param $article_type
     * @param $article_content
     * @return bool
     */
    public function publish_article($user_id, $article_title, $article_subtitle, $article_type, $article_content)
    {
        //将文章插入到数据库
        $article_id = $this->article_model->publish_article($user_id, $article_title, $article_subtitle, $article_type, $article_content);

        if($article_id === FALSE) {
            return FALSE;
        }

        $content = $this->_extract_article($article_id, $article_title, $article_subtitle, $article_content);

        //更新动态表
        return $this->feed_model->insert_feed($user_id, 2, $content) ? TRUE : FALSE;
    }


    public function article_vote($aid, $uid)
    {
        //点赞， 更新动态表
        if( $this->article_like_model->article_vote($aid, $uid) )
        {
            $content = $this->_extract_vote($aid);
            $this->feed->insert_feed($uid, 1, $content);
        }
    }

    private function _extract_vote($aid)
    {
        $article = $this->article_model->get_article_by_id($aid);
        $content = array(
            'article_id'        => $article['id'],
            'article_uid'       => $article['uid'],
            'article_title'     => $article['title'],
            'article_subtitle'  => $article['subtitle'],
            'article_content'   => $this->_extract_content($article['content']),
            'article_image'     => $this->_extract_first_img($article['content'])
        );
    }


    /**
     * 将文章的信息转换为动态表的格式
     * @param $article_id
     * @param $article_title
     * @param $article_subtitle
     * @param $article_content
     * @return string
     */
    private function _extract_article($article_id, $article_title, $article_subtitle, $article_content)
    {
        $content = array(
            'article_id'        => $article_id,
            'article_title'     => $article_title,
            'article_subtitle'  => $article_subtitle,
            'article_content'   => $this->_extract_content($article_content),
            'article_image'     => $this->_extract_first_img($article_content)
        );
        return json_encode($content);
    }

    /**
     * 删除文章的格式，空格
     * @param $article_content
     * @return string
     */
    private function _extract_content($article_content)
    {
        //去掉 HTML 的开标签
        $article_content = preg_replace("/(<([\w]+)[^>]*>)/i", "", $article_content);

        //去掉 HTML 的闭标签
        $article_content = preg_replace("/(<\/([\w]+)[^>]*>)/i", "", $article_content);

        //去掉空格
        $article_content = preg_replace("/\s/", "", $article_content);

        $clean_content = mb_substr($article_content, 0, 100);
        return $clean_content;
    }


    /**
     * 获取文章中的第一张图片
     * @param $article_content
     * @return string
     */
    private function _extract_first_img($article_content)
    {
        $match = array();
        preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/", $article_content, $match);
        return isset( $match[1][0] ) ? $match[1][0] : '';
    }
}