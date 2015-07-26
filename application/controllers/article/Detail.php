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

        $data['like_people'] = $this->article_service->get_vote_person_by_aid($aid);
        $data['article'] = $article;
        $data['comment'] = $comment;
        $data['sidebar'] = $this->load->view('common/sidebar', '', TRUE);

        $this->article_service->read_article($aid);
        
        $head['css'] = array(
                'common.css',
                'paperfold/buddycloud.css',
                'paperfold/paperfold.css'
            );
        $head['javascript'] = array(
                'jquery.js',
                'vchome.js',
                'paperfold/modernizr.custom.01022.js',
                'paperfold/paperfold.js',
                'paperfold/ui.js'
            );
        $this->load->view('common/head', $head);
        $this->load->view('article_detail', $data);
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
        $aid = 16;
        $uid = 23;
        $comment = 'sad';
        $this->article_service->write_comment($aid, $uid, $comment);
    }
}