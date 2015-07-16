<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/15
 * Time: 12:07
 */
class Main extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');
    }

    public function get_article_list()
    {
        //获得页数 和 登陆者的 id
        $page = $this->sc->input('page');
        $uid  = $this->sc->input('uid');

        $query = $this->article_service->get_article_list($page, $uid);
        var_dump($query);
    }
}