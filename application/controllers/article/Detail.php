<?php


class Detail extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');
    }

    
    public function index($aid)
    {
        if(! is_numeric($aid))
        {
            show_404();
        }

        //获取文章信息
        $article = $this->article_service->get_article_by_id($aid);
        if($article == FALSE) 
        {
        	show_404();
        }

        //获取文章评论
        $comment = $this->article_service->get_comment_by_aid($aid);
        if(isset($this->user['id']))
        {
            //获取点赞状态
            $like_status    = $this->article_service->get_article_vote_by_both($aid, $this->user['id']);            
        }
        else
        {
            $like_status    = 0;
        }
        
        $data['article'] = $article;
        $data['like_status'] = $like_status;
        $data['comment'] = $comment;


        $user['user']    = $this->user;
        $data['top']     = $this->load->view('common/top', $user, TRUE);
        $data['footer']  = $this->load->view('common/footer', '', TRUE);
        $data['user']    = $this->user;
        $head['title']   = $article['title'];

        //增加浏览数
        $this->article_service->read_article($aid);
        
        $head['css'] = array(
            'base.css',
            'font-awesome/css/font-awesome.min.css',
            'alert.css'
        );

        $head['javascript'] = array(
            'jquery.js',
            'error.js',
            'timeago.js',
            'alert.min.js',
            'autosize.js'
        );
        $this->load->view('common/head', $head);
        $this->load->view('article_detail', $data);

//        echo json_encode($like_status);
    }
    /*
    public function get_vote_list()
    {
        $aid = $this->sc->input('aid');
        $data = $this->article_service->get_vote_person_by_aid($aid);
        echo json_encode($data);
    }
    */
    /**
     * [vote_article 文章点赞]
     * @return [type] [description]
     */
    public function vote_article()
    {
    	$aid = $this->sc->input('aid');
    	$uid = isset($this->user['id']) ? $this->user['id'] : null;

        if(empty($uid)) {
            $this->error->output('NOAUTH_ERROR');
        }

    	$this->article_service->vote_article($aid, $uid);
    }

    /**
     * [write_comment 评论文章]
     * @return [type] [description]
     */
    public function write_comment()
    {
        $aid = $this->sc->input('aid');
        $pid = $this->sc->input('parent_id');
        $comment = $this->sc->input('comment');
        $uid = isset($this->user['id']) ? $this->user['id'] : null;

        if( empty($uid) ) {
            $this->error->output('NOAUTH_ERROR');
//            echo 'dasfadsfdasf';
        }

        $this->article_service->write_comment($aid, $uid, $pid, $comment);
    }

    /**
     * [delete_article 删除文章]
     * @return [type] [description]
     */
    public function delete_article()
    {
        $aid = $this->sc->input('aid');
        $result = $this->article_service->delete_article($aid,$this->user['id']);
        if($result)
        {
            echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS') ,'script' => "window.location.href = '{$redirect}';"));
            //删除文章的点赞和评论
            $this->article_service->delete_article_like_comment($aid);
        }
        else
        {
            $this->error->output('INVALID_REQUEST');
        }        
    }
}