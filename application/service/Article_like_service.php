<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/16
 * Time: 12:46
 */
class Article_like_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_like_model');
    }

    /**
     * 为文章点赞
     * @param $aid  文章id
     * @param $uid  用户id
     */
    public function article_vote($aid, $uid)
    {
        //点赞， 更新动态表
        if( $this->article_like_model->article_vote($aid, $uid) )
        {
            $content = $this->_extract_vote($aid);
            $this->feed->insert_feed($uid, 1, $content);
        }
    }


    /**
     * 解析文章点赞的 content
     * @param $aid
     * @return array
     */
    private function _extract_vote($aid)
    {
        $article = $this->article_model->get_article_by_id($aid);
        $content = array(
            'article_id'        => $article['id'],
            'article_uid'       => $article['uid'],
            'article_title'     => $article['title'],
            'article_subtitle'  => $article['subtitle'],
            'article_content'   => Common::extract_content($article['content']),
            'article_image'     => Common::extract_first_img($article['content'])
        );
        return $content;
    }
}