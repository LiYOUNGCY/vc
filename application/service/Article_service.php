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
        $this->load->model('article_like_model');
        $this->load->model('article_comment_model');
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
    /**
     * [get_article_list 获取文章列表]
     * @param  [type]  $page [页数]
     * @param  integer $uid  [用户id]
     * @param  integer $type [文章类型]
     * @return [type]        [description]
     */
    public function get_article_list($page, $uid = -1, $type)
    {
        switch ($type) {
            case 'article':
                $type = 1;
                break;
            case 'exhibition':
                $type = 2;
                break;
            default:
                $type = 1;
                break;
        }

        $article = $this->article_model->get_article_list($page, $uid, $type);

        foreach( $article as $key => $value )
        {
            //对每篇文章内容进行字数截取
            $article[$key]['content'] = Common::extract_content($article[$key]['content']);
        }

        return $article;
    }
    
    /**
     * [get_article_by_id 获取文章详细信息]
     * @param  [type] $aid [description]
     * @return [type]      [description]
     */
    public function get_article_by_id($aid)
    {
        $article = $this->article_model->get_article_by_id($aid);
        return $article;
    }

    /**
     * 文章点赞或取消
     * @param $aid  文章id
     * @param $uid  用户id
     */
    public function article_vote($aid, $uid)
    {
        //点赞     
        return  $this->article_like_model->article_vote($aid, $uid);    
    }

    /**
     * [update_count 更新文章字段数量]
     * @param  [type] $aid    [文章id]
     * @param  [type] $name   [字段名称]
     * @param  [type] $amount [数量]
     * @return [type]         [description]
     */
    public function update_count($aid,$name,$amount)
    {
        return $this->article_model->update_count($aid,array('name' => $name, 'amount' => $amount));
    }

    public function get_user_by_aid($uid)
    {
        return $this->article_like_model->get_user_by_aid($uid);
    }

    public function insert_article_comment($aid, $uid, $content)
    {
        return $this->article_comment_model->article_comment_model($aid, $uid, $content);
    }

    public function get_uid_by_aid($aid)
    {
        return $this->article_model->get_uid_by_aid($aid);
    }
}