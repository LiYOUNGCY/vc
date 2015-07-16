<?php

class Feed_service extends MY_Service {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('feed_model');
    }

    public function insert_feed($user_id, $article_id, $article_title, $article_subtitle, $article_content)
    {
        $content = $this->_extract_article($article_id, $article_title, $article_subtitle, $article_content);
        //更新动态表
        return $this->feed_model->insert_feed($user_id, 2, $content) ? TRUE : FALSE;
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
            'article_content'   => Common::extract_content($article_content),
            'article_image'     => Common::extract_first_img($article_content)
        );
        return json_encode($content);
    }
}