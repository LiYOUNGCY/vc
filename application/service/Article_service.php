<?php


class Article_service extends MY_Service{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('article_comment_model');   
        $this->load->model('article_like_model');
        $this->load->model('user_model');
        $this->load->model('feed_model');
        $this->load->model('notification_model');
    }
    
    
    /**
     * 发表文章
     */
    public function publish_article($user_id, $article_title, $article_subtitle, $article_type,  $article_tag, $article_content)
    {
        //将文章插入到数据库
        $article_id = $this->article_model->publish_article($user_id, $article_title, $article_subtitle, $article_type, $article_tag, $article_content);
        if( ! empty($article_id))
        {
            //更新动态表 
            $this->feed_model->insert_feed($user_id, $article_id, 2, $this->_extract_article($article_id, $article_title, $article_subtitle, $article_content));
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    /**
     * [get_article_list 获取文章列表]
     */
    public function get_article_list($page, $uid, $type,$tag)
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

        switch ($tag) {
            case 'interview':
                $tag = '|1|';
                break;
            case 'discuss':
                $tag = '|2|';
                break;
            case 'consult':
                $tag = '|3|';
                break;
            default:
                $tag = '';
                break;
        }
        $article = $this->article_model->get_article_list($page, $uid, NULL,$type,$tag);
        foreach( $article as $key => $value )
        {        
            
               
            //对每篇文章内容进行字数截取
            $article[$key]['content'] = $this->_extract_article($article[$key]['id'], $article[$key]['title'], $article[$key]['subtitle'], $article[$key]['content']);
            
            //对文章标题字数截取
            $article[$key]['content']["sort_title"] = mb_strlen($article[$key]['content']["article_title"]) > 9 ? mb_substr($article[$key]['content']["article_title"], 0, 9).'..' : $article[$key]['content']["article_title"];
            
            //查询作者的信息
            $article[$key]['author'] = $this->user_model->get_user_base_id($article[$key]['uid']);
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
        $query = $this->article_model->get_article_by_id($aid);
        if( ! empty($query))
        {
            $query['author'] = $this->user_model->get_user_base_id($query['uid']);
            return $query;            
        }
        else
        {
            return FALSE;
        }
    }

    public function get_article_vote_by_both($aid, $uid) {
        return $this->article_like_model->get_article_vote_by_both($aid, $uid)['status'];
    }


    /**
     * [get_comment_by_aid 获取文章评论]
     */
    public function get_comment_by_aid($aid)
    {
        $query = $this->article_comment_model->get_comment_by_aid($aid);
        
        foreach ($query as $key => $value) {
            $query[$key]['user'] = $this->user_model->get_user_base_id($query[$key]['uid']); 
        }
        
        return $query;
    }


    public function read_article($aid)
    {
        $this->article_model->read_article($aid);
    }
    

    /**
     * [vote_article 点赞]
     */
    public function vote_article($aid, $uid)
    {
    	$article = $this->article_model->get_article_by_id($aid);
    	if(empty($article))
    	{
    		$this->error->output('ARTICLE_NOT_EXIST');
    	}
    	$status = $this->article_like_model->article_vote($aid, $uid);
        //成功
    	if($status)
    	{
            echo json_encode(array('success' => 0));
            //首次点赞
            if( ! isset($status['status']))
            {
                //更新文章的 like 数加一
                $this->article_model->argee_article($aid);
                
                //解析文章
                $content = $this->_extract_vote($article['id'], $article['uid'], $article['title'], $article['subtitle'], $article['content']);
                //更新动态表
                $this->feed_model->insert_feed($uid, $article['id'], 1, $content);
                if($uid != $article['uid'])
                {
                    //更新消息
                    $content = json_encode(array('content_id' => $article['id'], 'content_title' => $article['title'], 'content_type' => 'article'));
                    $this->notification_model->insert($uid,$article['uid'],3,$content);                    
                    //推送
                    $this->load->library('push');
                    $this->push->push_to_topic($article['uid'],"");                    
                }

            }
            else
            {
                if($status['status'] == 0)
                {
                    //文章的 like 数减一
                    $this->article_model->disargee_article($aid);                   
                    //删除动态表的动态
                    //$this->feed_model->delete_feed($uid, $article['id'], 1);
                }
                else
                {
                     //更新文章的 like 数加一
                    $this->article_model->argee_article($aid);                   
                }
            }

    	}
        //失败
    	else 
    	{
            $this->error->output('INVALID_REQUEST');
    	}
    }

    /**
     * [write_comment 发表评论]
     * @param  [type] $aid     [文章id]
     * @param  [type] $uid     [用户id]
     * @param  [type] $comment [评论内容]
     * @return [type]          [description]
     */
    public function write_comment($aid, $uid, $comment)
    {
        $comment = Common::replace_face_url($comment);
        $insert_result = $this->article_comment_model->insert_comment($aid, $uid, $comment);
        if($insert_result)
        {
            echo json_encode(array('success' => 0,'script' => 'location.reload();'));
            $article = $this->article_model->get_article_by_id($aid);
            if($uid != $article['uid'])
            {
                 //更新消息
                $content = json_encode(array('content_id' => $aid, 'content_type' => 'article', 'content_title' => $article['title'], 'comment_content' => $comment));
                $this->notification_model->insert($uid,$article['uid'],2,$content);                
                //推送
                $this->load->library('push');
                $this->push->push_to_topic($article['uid'],"");                    
            }          
        }
        else
        {
            $this->error->output('INVALID_REQUEST');
        }
    }


    /**
     * 获取文章点过赞的人
     */
    public function get_vote_person_by_aid($aid)
    {
        $users = $this->article_like_model->get_vote_person_by_aid($aid);
        
        foreach ($users as $key => $value)
        {
            $users[$key]['user'] = $this->user_model->get_user_base_id($users[$key]['uid']);
            unset($users[$key]['uid']);
        }
        return $users;
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
            'article_content'   => Common::extract_content($article_content),
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

    /**
     * [update_article 更新文章]
     * @param  [type] $aid [文章id]
     * @param  [type] $uid [用户id]
     * @return [type]      [description]
     */
    public function update_article($aid, $uid, $article_title, $article_subtitle, $article_type, $article_tag, $article_content)
    {
        $arr = array(
            'title'    => $article_title,
            'subtitle' => $article_subtitle,
            'type'     => $article_type,
            'tag'      => $article_tag,
            'content'  => $article_content
        );
        return $this->article_model->update_article($aid,$arr,$uid);
    }

    /**
     * [delete_article 删除文章]
     * @param  [type] $aid [文章id]
     * @param  [type] $uid [用户id]
     * @return [type]      [description]
     */
    public function delete_article($aid,$uid)
    {
        return $this->article_model->delete_article($aid,$uid);
    }
}