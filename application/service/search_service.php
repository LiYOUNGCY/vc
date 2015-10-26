<?php

class Search_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('production_model');
        $this->load->model('artist_model');
    }

    /**
     * 对专题，艺术品，艺术家，资讯进行搜索.
     *
     * @param $keyword
     *
     * @return mixed
     */
    public function search($keyword)
    {
        $query = array();
        $article = $this->article_model->get_article_by_keyword($keyword);
        $production = $this->production_model->get_production_by_keyword($keyword);
        $artist = $this->artist_model->get_artist_by_keyword($keyword);

        //对专题，艺术品，艺术家，资讯的介绍，截取前50个字。

        foreach ($article as $key => $value) {

            //文章
            if($value['type'] == 1) {
                //对每篇文章内容进行字数截取
                $article[$key]['content'] = Common::extract_article($article[$key]['id'], $article[$key]['title'], $article[$key]['content']);
            }

            //专题
            if($value['type'] == 2) {
                //对每篇文章内容进行字数截取
                $article[$key]['content'] = Common::extract_topic($article[$key]['id'], $article[$key]['title'], $article[$key]['content']);
            }

            //对时间的截取
            $article[$key]['publish_time'] = substr($article[$key]['publish_time'], 0, 10);
        }

        foreach ($production as $key => $value) {
            $production[$key]['intro'] = Common::extract_content($production[$key]['intro']);
            $production[$key]['publish_time'] = substr($production[$key]['publish_time'], 0, 10);
        }

        foreach ($artist as $key => $value) {
            $artist[$key]['intro'] = Common::extract_content($artist[$key]['intro']);
            $artist[$key]['creat_time'] = substr($artist[$key]['creat_time'], 0, 10);
        }

        $query['article'] = $article;
        $query['production'] = $production;
        $query['artist'] = $artist;

        return $query;
    }
}
