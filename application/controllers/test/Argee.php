<?php


class Argee extends MY_Controller
{
    public function index()
    {
        $this->load->service('article_service');
        $this->article_service->vote_article(4, 16);
    }
}
