<?php
class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('home_service');

	}

	/**
	 * [index 用户主页]
	 * @param  [type] $alias [description]
	 * @param  string $type  [description]
	 * @return [type]        [description]
	 */
	public function index($alias, $type = 'quanzi')
	{
		$uid = isset($this->user['id']) ? $this->user['id'] : NULL;
		$alias= 'home/'.$alias;
		$user = $this->home_service->get_user($uid,$alias);
		if($user)
		{
			$data['css'] = array(
				'common.css', 
				'font-awesome/css/font-awesome.min.css',
				'jquery.Jcrop.css'
				);
	        $data['javascript'] = array(
	        	'jquery.js',
	        	'ajaxfileupload.js',
	        	'jquery.Jcrop.js'
	        	);

	        $this->load->view('common/head', $data);
	        $u['user']    = $this->user;

        	$data['sidebar'] = $this->load->view('common/sidebar', $u, TRUE);
         	$data['footer'] = $this->load->view('common/footer',"", TRUE);       	
			$data['user'] = $user;
			$data['me'] = $this->user;
			//载入视图
			if($type == 'quanzi')
			{
				$this->load->view('home/quanzi',$data);
			}
			elseif($type == 'intro')
			{
				//获取用户简介
				$data['intro'] = $this->home_service->get_user_intro($user['id']);
				$this->load->view('home/intro',$data);				
			}
			//自媒体才有文章
			elseif($type == 'article' && $user['role'] == 2)
			{
				$this->load->view('home/article',$data);		
			}
			elseif($type == 'cooperate')
			{
				$this->load->view('home/cooperate',$data);
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}
	}

	/**
	 * [get_user_community 获取用户关注的圈子]
	 * @return [type] [description]
	 */
	public function get_user_community()
	{	
		$page= $this->sc->input('page');
		$uid = $this->sc->input('uid');
		$community = $this->home_service->get_user_community($page,$uid);
		echo json_encode($community);
	}

	/**
	 * [get_user_article 获取用户文章]
	 * @return [type] [description]
	 */
	public function get_user_article()
	{
		$page = $this->sc->input('page');
		$uid  = $this->sc->input('uid');
		$type = $this->sc->input('type');
		$meid = isset($this->user['id']) ? $this->user['id'] : NULL;
		$article = $this->home_service->get_user_article($page,$meid,$uid,$type); 
		echo json_encode($article);
	}
	
}