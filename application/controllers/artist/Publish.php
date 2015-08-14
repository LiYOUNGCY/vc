<?php
class Publish extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('artist_service');
	}

	public function index($type = 'publish', $aid = NULL)
	{
		if($type == 'publish')
		{

		}
		else if($type == 'update')
		{
 			if( ! is_numeric($aid))
            {
                show_404();
            }
            $artist = $this->artist_service->get_artist_by_id($aid);

		}
	}

	/**
	 * [publish_artist 添加艺术家]
	 * @return [type] [description]
	 */
	public function publish_artist()
	{
		
        $error_redirect = array(
            'script' => "window.location.href='".base_url()."publish/artist';"
        );
        $this->sc->set_error_redirect($error_redirect);

		$name 		= $this->sc->input('artist_name');
		$intro		= $this->sc->input('intro');
		$evaluation = $this->sc->input('evaluation');
		$pic 		= $this->sc->input('pic');
		
		$result = $this->artist_service->publish_artist($this->user['id'],$name,$intro,$evaluation,$pic);
		if($result)
		{
			redirect(base_url().'artist/'.$result,'location');
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().'publish/artist";'));
		}
	}	

	/**
	 * [update_artist 更新艺术家]
	 * @return [type] [description]
	 */
	public function update_artist()
	{
		
		$aid = $this->input->post('aid');
		if( ! is_numeric($aid))
		{
			show_404();
		}
        $error_redirect = array(
            'script' => "window.location.href='".base_url()."update/artist/".$aid."';"
        );
        $this->sc->set_error_redirect($error_redirect);

		$aid 		= $this->sc->input('aid');
		$name 		= $this->sc->input('artist_name');
		$intro		= $this->sc->input('intro');
		$evaluation = $this->sc->input('evaluation');
		$pic 		= $this->sc->input('pic');
		
		$result = $this->artist_service->update_artist($aid,$this->user['id'],$name,$intro,$evaluation,$pic);
		if($result)
		{
            redirect(base_url()."artist/".$aid,'location');			
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().'update/artist/'.$aid.'";'));		
		}
	}
}