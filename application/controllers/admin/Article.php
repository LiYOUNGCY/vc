<?php 
class Article extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('article_model');
		$this->load->model('article_like_model');
		$this->load->model('article_comment_model');

	}
	
	public function index($type = 'a',$page = 0)
	{
		if($type == 'a')
		{
			//页面限制个数
			$limit= 10;
			//获取文章列表
			$article = $this->article_model->admin_get_article_list($page,$limit);
			$count   = $this->article_model->get_article_count();
			
			$navbar  = $this->load->view('admin/common/navbar',"",TRUE);

			//分页数据
			$p = array(
				'count'   => $count,
				'page'    => $page,
				'limit'   => $limit,
				'pageurl' => base_url().ADMINROUTE.'article/a/'
			);
			
			$pagination = $this->load->view('admin/common/pagination',$p,TRUE);
			$foot 		= $this->load->view('admin/common/foot',"",TRUE);		
			//页面数据
			$body = array(
				'navbar' 	 => $navbar,
				'foot' 	 	 => $foot,
				'pagination' => $pagination,
				'article'    => $article
			);
 			$this->load->view('admin/common/head');	
			$this->load->view('admin/article/list',$body);			
		}
	}

	public function edit($type = 'a',$id = NULL)
	{
        $navbar  = $this->load->view('admin/common/navbar',"",TRUE);   	
        $foot 	 = $this->load->view('admin/common/foot',"",TRUE);		

        $this->load->view('admin/common/head');	
		$article = $this->article_model->get_article_by_id($id);

		//页面数据
		$body = array(
			'navbar' 	 => $navbar,
			'foot' 	 	 => $foot,
			'article'    => $article
		);        		
        if( empty($article)) 
        {
            show_404();
        }
        else
        {
            $this->load->view('admin/article/edit', $body);
        }  

	}	


	public function delete_article()
	{
		$aid = $this->sc->input('aids');
		$aid = explode(",",$aid);
		foreach ($aid as $k => $v) {
			$result = $this->article_model->delete_article($v);			 
			$this->article_like_model->delete_like_by_aid($v);
			$this->article_comment_model->delete_comment_by_aid($v);
		}
		if($result)
		{
			echo json_encode(array('success' => 0,'note' => lang('OPERATE_SUCCESS'),'script' => 'location.reload();'));
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

		$error_redirect = array(
            'script' => "window.location.href='".base_url()."update/article/".$this->input->post('aid')."';"
        );
        $this->sc->set_error_redirect($error_redirect);

        $aid                = $this->sc->input('aid');
        $article_title      = $this->sc->input('article_title');
        $article_subtitle   = $this->sc->input('article_subtitle');
        $article_content    = $this->sc->input('article_content');
        //过滤富文本
        $this->load->library('htmlpurifier');        
        $article_content    = $this->htmlpurifier->purify($article_content);        
        //$article_tag        = $this->sc->input('article_tag');	
        $arr = array(
        	'title'    => $article_title,
        	'subtitle' => $article_subtitle,
        	'content'  => $article_content
        );
        $result = $this->article_model->update_article($aid,$arr);
		if($result)
		{
			echo '<script>alert("操作成功!");window.location.href="'.base_url().ADMINROUTE.'article/edit/a/'.$aid.'";</script>';
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().ADMINROUTE.'article/edit/a/'.$aid.'";'));				
		}
	}
}