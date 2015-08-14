<?php
class Publish extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('production_service');
	}

	public function index($type = 'publish', $pid = NULL)
	{
		if($type == 'publish')
		{
			$this->load->view('test/publish_production');
		}
		else if($type == 'update')
		{
			if( ! is_numeric($pid))
			{
				show_404();
			}
			$production = $this->production_service->get_production_by_id($pid);
			if(empty($production))
			{
				show_404();
			}

			echo var_dump($production);
		}
	}

	/**
	 * [publish_production 发布艺术品]
	 * @return [type] [description]
	 */
	public function publish_production()
	{
        $error_redirect = array(
            'script' => "window.location.href='".base_url()."publish/production';"
        );
        $this->sc->set_error_redirect($error_redirect);
		$name = $this->sc->input('production_name');
		$aid  = $this->sc->input('aid');
		$price= $this->sc->input('price');
		$pic  = $this->sc->input('pic');
	
		$result = $this->production_service->publish_production($name,$this->user['id'],$aid,$price,$pic);
		if($result)
		{

			redirect(base_url().'production/'.$result,'location');			
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' => 'window.location.href="'.base_url().'publish/production";'));
		}
	}

	/**
	 * [update_production 更新艺术品]
	 * @return [type] [description]
	 */
	public function update_production()
	{
		$pid = $this->input->post('pid');
		if( ! is_numeric($pid))
		{
			show_404();
		}

        $error_redirect = array(
            'script' => "window.location.href='".base_url()."update/production/".$pid."';"
        );
        $this->sc->set_error_redirect($error_redirect);

		$pid    = $this->sc->input('pid');
		$name   = $this->sc->input('production_name');
		$aid    = $this->sc->input('aid');
		$price  = $this->sc->input('price');
		$pic    = $this->sc->input('pic');		
		$status = $this->sc->input('status');

		$result = $this->production_service->update_production($pid,$this->user['id'],$name,$aid,$price,$pic,$status);
		if($result)
		{
			redirect(base_url().'production/'.$pid,'location');
		}
		else
		{
			$this->error->output('INVALID_REQUEST',array('script' =>  'window.location.href="'.base_url().'update/production/'.$pid.'";'));
		}

	}
}