<?php

class Feed_service extends MY_Service {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('feed_model');
    }

    /**
     * [insert_article_feed 添加发布新文章动态]
     * @param  [type] $user_id          [description]
     * @param  [type] $article_id       [description]
     * @param  [type] $article_title    [description]
     * @param  [type] $article_subtitle [description]
     * @param  [type] $article_content  [description]
     * @return [type]                   [description]
     */
    public function insert_article_feed($user_id, $article_id, $article_title, $article_subtitle, $article_content)
    {
        $content = $this->_extract_article($article_id, $article_title, $article_subtitle, $article_content);
        //更新动态表
        return $this->feed_model->insert_feed($user_id, 2, $content) ? TRUE : FALSE;
    }

    /**
     * [insert_vote_feed 添加新点赞动态]
     * @param  [type] $user_id          [description]
     * @param  [type] $article_id       [description]
     * @param  [type] $article_uid      [description]
     * @param  [type] $article_title    [description]
     * @param  [type] $article_subtitle [description]
     * @param  [type] $article_content  [description]
     * @param  [type] $article_image    [description]
     * @return [type]                   [description]
     */
    public function insert_vote_feed($user_id,$article_id,$article_uid,$article_title,$article_subtitle,$article_content)
    {
        $content = $this->_extract_vote($article_id, $article_uid, $article_title, $article_subtitle, $article_content);
        //更新动态表
        return $this->feed_model->insert_feed($user_id, 1, $content) ? TRUE : FALSE;
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

    /**
     * 解析文章点赞的 content
     * @param $aid
     * @return array
     */
    private function _extract_vote($article_id, $article_uid, $article_title, $article_subtitle, $article_content)
    {

        $content = array(
            'article_id'        => $article_id,
            'article_uid'       => $article_uid,
            'article_title'     => $article_title,
            'article_subtitle'  => $article_subtitle,
            'article_content'   => Common::extract_content($article_content),
            'article_image'     => Common::extract_first_img($article_content)
        );
        return json_encode($content);
    }   
}