<?php


class Publish extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');
        $this->load->library('htmlpurifier');
    }

    /**
     * 发布文章
     */
    public function index()
    {
        $head['css'] = array(
                'common.css',
                'font-awesome/css/font-awesome.min.css',
                '../ueditor/themes/default/css/umeditor.css',
                'ueditor.css',
                'radiocheck.min.css'
            );
        $head['javascript'] = array(
                'jquery.js',
                'vchome.js'
            );
        $user['user']    = $this->user;
        $data['sidebar'] = $this->load->view('common/sidebar', $user, TRUE);

        $this->load->view('common/head', $head);
        $this->load->view('publish_article', $data);
    }

    /**
     * [publish_article 发布文章]
     * @return [type] [description]
     */
    public function publish_article()
    {
        $article_title      = $this->sc->input('article_title');
        $article_subtitle   = $this->sc->input('article_subtitle');
        $article_content    = $this->sc->input('article_content','post',FALSE);
        //过滤富文本
        $article_content    = $this->htmlpurifier->purify($article_content);
        $article_tag        = $this->sc->input('article_tag');
        //把文章插入到数据库
        $result = $article = $this->article_service->publish_article($this->user['id'], $article_title, $article_subtitle, 1, $article_tag, $article_content);
        if($result)
        {
            echo 'success';
        }
        else
        {
            $this->error->output('INVALID_REQUEST');
        }
    }

    /**
     * [update_article 更新文章]
     * @return [type] [description]
     */
    public function update_article()
    {
        $aid                = $this->sc->input('aid');
        $article_title      = $this->sc->input('article_title');
        $article_subtitle   = $this->sc->input('article_subtitle');
        $article_content    = $this->sc->input('article_content');
        //过滤富文本
        $article_content    = $this->htmlpurifier->purify($article_content);        
        $article_tag        = $this->sc->input('article_tag'); 

        $result = $this->article_service->update_article($aid,$this->user['id'],$article_title,$article_subtitle,1,$article_tag,$article_content);       
        if($result)
        {
            echo "success";
        }
        else
        {
            $this->error->output('INVALID_REQUEST');
        } 
    }

    
}