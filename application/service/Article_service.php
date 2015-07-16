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
        $article = $this->article_model->publish_article($user_id, $article_title, $article_subtitle, $article_type, $article_content);

        if($article === FALSE)
        {
            return FALSE;
        }

        return $article;
    }


}