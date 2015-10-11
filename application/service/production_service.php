<?php

class Production_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('production_model');
        $this->load->model('production_like_model');
        $this->load->model('article_model');
        $this->load->model('artist_model');
        $this->load->model('production_medium_model');
        $this->load->model('production_style_model');
        $this->load->model('production_price_model');
        $this->load->model('production_categories_model');
    }

    /**
     * 获得作品列表
     * @param  page 页数   [int]
     * @param  uid  用户id [uid]
     * @return [type]
     */
    public function get_production_list($page, $uid, $search)
    {
        $production = $this->production_model->get_production_list($page, $uid, '0', $search);
        foreach ($production as $k => $v) {
            //获取艺术家信息
            if (!empty($v['aid'])) {
                $production[$k]['artist'] = $this->artist_model->get_artist_base_id($v['aid']);
            } else {
                $production[$k]['artist'] = NULL;
            }
            unset($production[$k]['aid']);
        }
        return $production;
    }


    public function get_medium_list()
    {
        $query = $this->production_medium_model->get_medium_list();
        return $query;
    }

    public function get_style_list()
    {
        $query = $this->production_style_model->get_style_list();
        return $query;
    }

    public function get_categories_list()
    {
        $query = $this->production_categories_model->get_categories_list();
        return $query;
    }

    public function get_price_list()
    {
        $query = $this->production_price_model->get_price_list();
        return $query;
    }

    public function get_type_list($page, $limit)
    {
        $this->load->model('production_type_model');
        $type = $this->production_type_model->get_type_list($page, $limit);
        return $type;
    }

    public function get_marterial_list($page, $limit)
    {
        $this->load->model('production_marterial_model');
        $marterial = $this->production_marterial_model->get_marterial_list($page, $limit);
        return $marterial;
    }

    /**
     * 根据id获取艺术品详情
     * @param  [type]
     * @return [type]
     */
    public function get_production_by_id($id)
    {
        $p = $this->production_model->get_production_by_id($id);
        if (!empty($p)) {
            //获取艺术家信息
            if (!empty($p['aid'])) {
                $p['artist'] = $this->artist_model->get_artist_by_id($p['aid']);
                $p['artist']['intro'] = mb_strlen($p['artist']['intro']) > 100 ?
                    mb_substr($p['artist']['intro'], 0, 100) . '..' :
                    $p['artist']['intro'];
            } else {
                $p['artist'] = NULL;
            }
            unset($p['aid']);
            return $p;
        } else {
            return FALSE;
        }
    }

    /**
     * [like_production 艺术品点赞]
     * @return [type] [description]
     */
    public function like_production($pid, $uid)
    {
        //艺术品存在检查
        $production = $this->production_model->get_production_by_id($pid);
        if (empty($production)) {
            $this->error->output('INVALID_REQUEST');
        }

        $status = $this->production_like_model->insert_like($pid, $uid);
        //成功
        if ($status) {
            echo json_encode(array('success' => 0));
            //首次点赞
            if (!isset($status['status'])) {
                //更新艺术品的 like 数加一
                $this->production_model->argee_production($pid);
            } else {
                if ($status['status'] == 0) {
                    //文章的 like 数减一
                    $this->production_model->disargee_production($pid);
                } else {
                    //更新文章的 like 数加一
                    $this->production_model->argee_production($pid);
                }
            }

        } //失败
        else {
            $this->error->output('INVALID_REQUEST');
        }
    }

    public function check_has_like($pid, $uid)
    {
        $result = $this->production_like_model->check_like($pid, $uid);
        if (empty($result)) {
            return FALSE;
        } else {
            return $result['status'];
        }
    }

    /**
     * 获取艺术品相关联的专题
     * @param  pid 艺术品id [int]
     * @return [type]
     */
    public function get_topic_by_production($pid, $uid)
    {
        $topic = $this->article_model->get_article_list(0, $uid, NULL, NULL, $pid);
        foreach ($topic as $k => $v) {
            $topic[$k]['article_img'] = Common::extract_first_img($topic[$k]['content']);
        }
        return $topic;
    }

    /**
     * [publish_production 发布艺术品]
     * @param  [type] $name       [description]
     * @param  [type] $uid        [description]
     * @param  [type] $intro      [description]
     * @param  [type] $aid        [description]
     * @param  [type] $price      [description]
     * @param  [type] $pic        [description]
     * @param  [type] $l          [description]
     * @param  [type] $w          [description]
     * @param  [type] $h          [description]
     * @param  [type] $type       [description]
     * @param  [type] $marterial  [description]
     * @param  [type] $creat_time [description]
     * @return [type]             [description]
     */
    public function publish_production($uid, $data)
    {
        $insert_result = $this->production_model->insert_production($uid, $data);
        if ($insert_result) {
            //更新艺术家作品数
            $this->artist_model->update_artist($data['aid'], array('production' => array('production + 1', FALSE)));
            return $insert_result;
        } else {
            return FALSE;
        }
    }

    /**
     * [update_production 更新艺术品]
     * @param  [type] $pid    [艺术品id]
     * @param  [type] $uid    [用户id]
     * @param  [type] $name   [艺术品名称]
     * @param  [type] $aid    [艺术家id]
     * @param  [type] $price  [价格]
     * @param  [type] $pic    [图片地址]
     * @param  [type] $status [艺术品状态]
     * @return [type]         [description]
     */
    public function update_production($pid, $uid, $name, $intro, $aid, $price, $pic, $l, $w, $h, $style, $medium, $creat_time, $status)
    {
        echo $style, $medium;
        $data = array(
            'name' => $name,
            'intro' => $intro,
            'aid' => $aid,
            'price' => $price,
            'pic' => $pic,
            'l' => $l,
            'w' => $w,
            'h' => $h,
            'style' => $style,
            'medium' => $medium,
            'creat_time' => $creat_time,
            'status' => $status,
            'modify_by' => $uid
        );
        $update_result = $this->production_model->update_production($pid, $data);
        if ($update_result) {
            return TRUE;
        } else {
            //删除oss上图片
            $this->_delete_oss_pic($pic);
            return FALSE;
        }
    }

    private function _delete_oss_pic($pic)
    {
        try {
            $this->load->library('oss');
            //删除原图
            $arr = explode('/', $pic);
            //$count = count($arr);
            unset($arr[0]);
            unset($arr[1]);
            unset($arr[2]);
            $pic = implode('/', $arr);
            $this->oss->delete_object($pic);

            //删除缩略图
            $toFile = Common::get_thumb_url($pic, 'thumb1_');
            $toFile1 = Common::get_thumb_url($pic, 'thumb2_');

            $this->oss->delete_object($toFile);
            $this->oss->delete_object($toFile1);
            return TRUE;

        } catch (Exception $e) {
            return FALSE;
        }

    }
}
