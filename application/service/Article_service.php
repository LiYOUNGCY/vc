<?php


class Article_service extends MY_Service{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('article_comment_model');   
        $this->load->model('article_like_model');
        
        $this->load->service('user_service');
        $this->load->service('feed_service');
        $this->load->service('article_like_service');
    }
    
    
    /**
     * 发表文章
     * @return bool
     */
    public function publish_article($user_id, $article_title, $article_subtitle, $article_type, $article_content)
    {
        //将文章插入到数据库
        $article_id = $this->article_model->publish_article($user_id, $article_title, $article_subtitle, $article_type, $article_content);
        if( ! empty($article_id))
        {
            //更新动态表 
            $this->feed_service->insert_article_feed($user_id, $article_id, $this->_extract_article($article_id, $article_title, $article_subtitle, $article_content));
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
            
            //查询作者的信息
            $article[$key]['author'] = $this->user_service->get_user_base_id($article[$key]['uid']);
            unset($article[$key]['id']);
            unset($article[$key]['title']); 
            unset($article[$key]['uid']);
        }
        return $article;
    }


    /**
     * [get_article_by_id 获取文章的全部信息]
     */
    public function get_article_by_id($aid)
    {
        return $this->article_model->get_article_by_id($aid);
    }


    /**
     * [get_comment_by_aid 获取文章评论]
     */
    public function get_comment_by_aid($aid)
    {
        $query = $this->article_comment_model->get_comment_by_aid($aid);
        
        foreach ($query as $key => $value) {
            $query[$key]['user'] = $this->user_service->get_user_base_id($query[$key]['uid']); 
        }
        
        return $query;
    }
    
    public function vote_article($aid, $uid)
    {
    	$article = $this->article_model->get_article_by_id($aid);
    	if(empty($article))
    	{
    		$this->error->output('ARTICLE_NOT_EXIST');
    	}
    	$status = $this->article_like_service->vote_article($aid, $uid);
    	
    	//点赞
    	if($status)
    	{
    		//更新文章的 like 数加一
    		$this->article_model->argee_article($aid);
    		
    		//解析文章
    		$content = $this->_extract_vote($article['id'], $article['uid'], $article['title'], $article['subtitle'], $article['content']);
    		//更新动态表
    		$this->feed_service->insert_vote_feed($uid, $article['id'], $content);
    	}
    	else 
    	{
    		//文章的 like 数减一
    		$this->article_model->disargee_article($aid);
    		
    		//删除动态表的动态
            $this->feed_service->delete_vote_feed($uid, $article['id']);
    	}
    }
    
    
    /**
     * 将文章的信息转换为动态表的格式
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
        return $content;
    }
}