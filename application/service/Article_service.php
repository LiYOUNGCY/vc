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
        $this->load->model('feed_model');   
        $this->load->model('user_model'); 
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
        if( ! empty($article))
        {
            //更新动态表
            $this->insert_article_feed($user_id, $article['id'], $article['title'], $article['subtitle'], $article['content']);               
            return TRUE;
        }
        else
        {
            return FALSE;
        }
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
            $content = $this->article_model->get_article_by_id($article[$key]['id']);
            $article[$key]['content'] = $this->_extract_article($article[$key]['id'], $content['title'], $content['subtitle'], $content['content']);

            $arr = array('role', 'name', 'pic', 'alias');
            $article[$key]['author'] = $this->user_model->get_user_by_id($value['uid'], $arr); 
            unset($article[$key]['id']);
            unset($article[$key]['title']); 
            unset($article[$key]['uid']);     
            //unset($article[$key]['content']);
        }

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
        $vote_result = $this->article_like_model->article_vote($aid, $uid);
        if( ! empty($vote_result))
        {
            echo "success";            
            if($vote_result['status'] == 1)
            {
                //增加文章点赞数
                $this->article_model->update_count($aid,array('name' => 'like','amount' => 1));             
            } 
            else
            {
                //减少文章点赞数
                $this->article_model->update_count($aid,array('name' => 'like','amount' => -1));              
            }
            //首次点赞
            if( $vote_result['type'] == 0)
            {
                //添加点赞动态                
                $article = $this->article_model->get_article_by_id($aid);
                $feed_result = $this->insert_vote_feed($uid, $article['id'], $article['uid'], $article['title'], $article['subtitle'], $article['content']);
                //添加点赞消息
                $content = array('content_id' => $article['id'], 'content_type' => 'article');
                $notification_result = $this->notification_model->insert($uid,$article['uid'],3,json_encode($content));               
            } 
            return TRUE;             
        }    
        else
        {
            return FALSE;
        }
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
        $content = json_encode($this->_extract_article($article_id, $article_title, $article_subtitle, $article_content));
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
     * [get_article_by_id 获取文章的全部信息]
     * @param  [type] $aid [description]
     * @return [type]      [description]
     */
    public function get_article_by_id($aid)
    {
        return $this->article_model->get_article_by_id($aid);
    }


    /**
     * [get_comment_by_aid 获取文章评论]
     * @param  [type] $aid [description]
     * @return [type]      [description]
     */
    public function get_comment_by_aid($aid)
    {
        return $this->article_comment_model->get_comment_by_aid($aid);
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
            'article_content'   => Common::extract_content($article_content).'...',
            'article_image'     => Common::extract_first_img($article_content)
        );
        return $content;
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