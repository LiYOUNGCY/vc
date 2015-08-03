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
            $status  = $this->article_service->get_article_vote_by_both($aid, $this->user['id']);            
        }
        else
        {
            $status  = 0;
        }
        
        $data['article'] = $article;
        //echo json_encode($status);
        $data['status'] = $status;

        $data['comment'] = $comment;


        $user['user']    = $this->user;
        $data['sidebar'] = $this->load->view('common/sidebar', $user, TRUE);
        $data['footer']  = $this->load->view('common/footer', '', TRUE);
        $data['user']    = $this->user;

        $this->article_service->read_article($aid);
        
        $head['css'] = array(
                'common.css',
                'paperfold/buddycloud.css',
                'paperfold/paperfold.css',
                'flex-style.css',
                'font-awesome/css/font-awesome.min.css'
            );
        $head['javascript'] = array(
                'jquery.js',
                'vc.js',
                'paperfold/modernizr.custom.01022.js',
                'jquery.flexText.min.js',
                'jquery.qqFace.js',
                'error.js',
                'timeago.js'
            );
        $this->load->view('common/head', $head);
        $this->load->view('article_detail', $data);
    }

    public function get_vote_list()
    {
        $aid = $this->sc->input('aid');
        $data = $this->article_service->get_vote_person_by_aid($aid);
        echo json_encode($data);
    }
    
    /**
     * [vote_article 文章点赞]
     * @return [type] [description]
     */
    public function vote_article()
    {
    	$aid = $this->sc->input('aid');
    	$uid = $this->user['id'];
    	$this->article_service->vote_article($aid, $uid);
    }

    /**
     * [write_comment 评论文章]
     * @return [type] [description]
     */
    public function write_comment()
    {
        $aid = $this->sc->input('aid');
        $uid = $this->user['id'];
        $comment = $this->sc->input('comment');
        $this->article_service->write_comment($aid, $uid, $comment);
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
            $redirect = base_url().$this->user['alias'].'/article';
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