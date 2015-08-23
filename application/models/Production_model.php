<?php

class Production_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取作品列表
     * @param  page 页数          integer
     * @param  meid 我的id      [int]
     * @param  uid  艺术家id      [int]
     * @param  limit页面个数限制  integer
     * @param  order 排序          string
     * @return [type]
     */
    public function get_production_list($page = 0, $meid = NULL, $status = NULL, $uid = NULL, $limit = 6, $order = 'id DESC')
    {
        $status = explode(',', $status);
        $query = $this->db->select('
                                    production.id,
                                    production.aid,
                                    production.name,
                                    production.pic,
                                    production.h,
                                    production.w,
                                    production.l,
                                    production.type,
                                    production.like,
                                    production.intro,
                                    production.price,
                                    production.creat_time
		');

        if (is_numeric($meid)) {
        }
        if ( ! empty($uid)) {
            $query = $query->where('uid', $uid);
        }
        if( ! empty($status))
        {
            $query = $query->where_in('production.status', $status);           
        }

        $query = $query->order_by($order)->limit($limit, $page * $limit)->get('production')->result_array();
        return $query;
    }

    /**
     * 根据id获取艺术品详情
     * @param  [type]
     * @return [type]
     */
    public function get_production_by_id($id)
    {
        $query = $this->db->where('id', $id)
            ->get('production')
            ->row_array();
        return $query;
    }

    /**
     * [insert_production 添加艺术品]
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
    public function insert_production($name, $uid, $intro, $aid, $price, $pic, $l, $w, $h, $type, $marterial, $creat_time)
    {
        $data = array(
            'name' => $name,
            'intro' => $intro,
            'aid' => $aid,
            'price' => $price,
            'pic' => $pic,
            'l' => $l,
            'w' => $w,
            'h' => $h,
            'type' => $type,
            'marterial' => $marterial,
            'creat_time' => $creat_time,
            'publish_time' => date("Y-m-d H:i:s", time()),
            'creat_by' => $uid
        );
        $this->db->insert('production', $data);
        return $this->db->insert_id();
    }
    /**
     * [update_production 更新]
     * @param  [type] $pid [description]
     * @param  [type] $arr [description]
     * @return [type]      [description]
     */
    public function update_production($pid, $arr)
    {
        $arr['modify_time'] = date("Y-m-d H:i:s", time());
        $this->db->where('id', $pid)->update('production', $arr);
        return $this->db->affected_rows() === 1;
    }


    /**
     * 点赞时，艺术品的 like 加一
     */
    public function argee_production($pid)
    {
        $table_name = $this->db->protect_identifiers('production', TRUE);
        $this->db->query("UPDATE {$table_name} SET {$table_name}.`like` = {$table_name}.`like` + 1 WHERE {$table_name}.id = {$pid}");
    }
    
    /**
     * 取消点赞时，艺术品的 like 减一
     */
    public function disargee_production($pid)
    {
        $table_name = $this->db->protect_identifiers('production', TRUE);
        $this->db->query("UPDATE {$table_name} SET {$table_name}.`like` = {$table_name}.`like` - 1 WHERE {$table_name}.id = {$pid} and {$table_name}.`like` > 0");
    }

    public function get_production_count()
    {
        return $this->db->count_all('production');
    }

    public function delete_production($pid)
    {
        $this->db->delete('production',array('id' => $pid));
        return $this->db->affected_rows() === 1;
    }

    public function admin_get_production_list($page = 0, $limit = 10, $order = 'id DESC')
    {
        $query = $this->db->order_by($order)
                          ->limit($limit, $page * $limit)
                          ->get('production')
                          ->result_array();
        return $query;
    }

} 