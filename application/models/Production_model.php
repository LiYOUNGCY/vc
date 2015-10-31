<?php

class Production_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取作品列表.
     *
     * @param  page 页数          integer
     * @param  meid 我的id      [int]
     * @param  aid  艺术家id      [int]
     * @param  limit页面个数限制  integer
     * @param  order 排序          string
     *
     * @return [type]
     */
    public function get_production_list(
        $page = 0,
        $meid = null,
        $status = null,
        $search = null,
        $aid = null,
        $limit = 6,
        $order = 'id DESC'
    ) {
        $medium = $search['medium'];
        $categories = $search['categories'];
        $style = $search['style'];
        $price = $search['price'];
        $status = explode(',', $status);

        $query = $this->db->select('
                                    production.id,
                                    production.aid,
                                    production.name,
                                    image.thumb_path as pic,
                                    production.h,
                                    production.w,
                                    production.l,
                                    production_style.name as style,
                                    production.like,
                                    production.intro,
                                    production.price,
                                    production.creat_time,
                                    image.thumb_width as width,
                                    image.thumb_height as height
		')
            ->from('production')
            ->from('production_style')
            ->from('image')
            ->where('production_style.id = production.style')
            ->where('image.image_id = production.image_id');

        if (is_numeric($meid)) {
        }
        if (isset($medium) && is_numeric($medium)) {
            $query = $query->where('medium', $medium);
        }
        if (isset($categories) && is_numeric($categories)) {
            $query = $query->where('categories', $categories);
        }
        if (isset($style) && is_numeric($style)) {
            $query = $query->where('style', $style);
        }
        if (isset($price) && is_string($price)) {
            //解析 price 123, 456
            $price = explode(',', $price);
            foreach ($price as $key => $value) {
                $price[$key] = intval($value);
            }
            if (isset($price[0])) {
                $query = $query->where('production.price >= ', $price[0]);
            }
            if (isset($price[1]) && $price[1] > 0) {
                $query = $query->where('production.price < ', $price[1]);
            }
        }
        if (!empty($aid)) {
            $query = $query->where('aid', $aid);
        }
        if (!empty($status)) {
            $query = $query->where_in('production.status', $status);
        }

        $query = $query->order_by($order)->limit($limit, $page * $limit)->get()->result_array();

        return $query;
    }

    /**
     * 根据id获取艺术品详情.
     *
     * @param  [type]
     *
     * @return [type]
     */
    public function get_production_by_id($id)
    {
        $query = $this->db
            ->select('
            production.id,
            production.aid,
            image.image_id,
            image.image_path as pic,
            production.intro,
            production.price,
            production.w,
            production.l,
            production.h,
            production_medium.name as medium,
            production_style.name as style,
            production.like,
            production.name,
            production.publish_time,
            production.creat_time
            ')
            ->from('production, production_style, image, production_medium')
            ->where('production.id', $id)
            ->where('production.image_id = image.image_id')
            ->where('production.medium = production_medium.id')
            ->where('production.style = production_style.id')
            ->get()
            ->row_array();

        return $query;
    }

    /**
     * 根据id获取艺术品详情.
     *
     * @param  [type]
     *
     * @return [type]
     */
    public function get_production_detail_by_id($id)
    {
        $query = $this->db
            ->select('
            production.id,
            production.aid,
            image.image_id,
            image.image_path as pic,
            production.intro,
            production.price,
            production.w,
            production.l,
            production.h,
            production.medium,
            production.style,
            production.like,
            production.name,
            production.publish_time,
            production.creat_time
            ')
            ->from('production, production_style, image, production_medium')
            ->where('production.id', $id)
            ->where('production.image_id = image.image_id')
            ->where('production.medium = production_medium.id')
            ->where('production.style = production_style.id')
            ->get()
            ->row_array();

        return $query;
    }

    /**
     * [insert_production 添加艺术品].
     */
    public function insert_production($uid, $data)
    {
        $data['publish_time'] = date('Y-m-d H:i:s', time());
        $data['creat_by'] = $uid;

        $this->db->insert('production', $data);

        return $this->db->insert_id();
    }

    /**
     * [update_production 更新].
     *
     * @param [type] $pid [description]
     * @param [type] $arr [description]
     *
     * @return [type] [description]
     */
    public function update_production($id, $uid, $data)
    {
        $data['modify_by'] = $uid;
        $data['modify_time'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id)->update('production', $data);

        return $this->db->affected_rows();
    }

    /**
     * 点赞时，艺术品的 like 加一.
     */
    public function argee_production($pid)
    {
        $table_name = $this->db->protect_identifiers('production', true);
        $this->db->query("UPDATE {$table_name} SET {$table_name}.`like` = {$table_name}.`like` + 1 WHERE {$table_name}.id = {$pid}");
    }

    /**
     * 取消点赞时，艺术品的 like 减一.
     */
    public function disargee_production($pid)
    {
        $table_name = $this->db->protect_identifiers('production', true);
        $this->db->query("UPDATE {$table_name} SET {$table_name}.`like` = {$table_name}.`like` - 1 WHERE {$table_name}.id = {$pid} and {$table_name}.`like` > 0");
    }

    public function get_production_count()
    {
        return $this->db->count_all('production');
    }

    public function delete_production($pid)
    {
        $this->db->delete('production', array('id' => $pid));

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

    /**
     * 对艺术品进行模糊搜索.
     *
     * @param $keyword
     *
     * @return mixed
     */
    public function get_production_by_keyword($keyword)
    {
        $query = $this->db->select('
                                    production.id,
                                    production.name,
                                    image.image_path as pic,
                                    production.like,
                                    production.intro,
                                    production.price,
                                    production.publish_time
		')
            ->from('production, image')
            ->where('production.image_id = image.image_id')
            ->where('production.status', 0)
            ->like('production.name', $keyword)
            ->get()
            ->result_array();

        return $query;
    }

    /**
     * 作品下架.
     */
    public function pull_off($id)
    {
        $data = array(
            'status' => 2,
        );
        $this->db->where('id', $id)->update('production', $data);

        return $this->db->affected_rows() === 1;
    }

    /**
     * 作品上架.
     */
    public function put_on($id)
    {
        $data = array(
            'status' => 0,
        );
        $this->db->where('id', $id)->update('production', $data);

        return $this->db->affected_rows() === 1;
    }

    /**
     * 删除艺术品所有的裱.
     *
     * @param $production_id
     */
    public function delete_production_frame($production_id)
    {
        $this->db->where('production_id', $production_id)->delete('production_frame');
    }

    /**
     * 插入艺术品的裱.
     *
     * @param $production_id
     * @param $frame_id
     *
     * @return mixed
     */
    public function insert_production_frame($production_id, $frame_id)
    {
        $data = array(
            'production_id' => $production_id,
            'frame_id' => $frame_id,
        );

        $this->db->insert('production_frame', $data);

        return $this->db->insert_id();
    }

    /**
     * [exist_production 检查艺术品是否在].
     *
     * @param [type] $production_id [description]
     *
     * @return [type] [description]
     */
    public function exist_production($production_id)
    {
        $this->db->from('production')->where('id', $production_id);

        return $this->db->count_all_results() === 1;
    }

    public function get_production_with_frame($production_id, $frame_id)
    {
        $frame_table = $this->db->dbprefix('frame');
        $production_table = $this->db->dbprefix('production');
        $query = $this->db
            ->select("
                    production.id as production_id,
                    production.name,
                    image.image_path as pic,
                    production_style.name as style,
                    production_medium.name as medium,
                    production.price,
                    production.w,
                    production.h,
                    production.status,
                    production.creat_time,
                    frame.id as frame_id,
                    frame.name as frame_name,
                    frame.price as frame_price,
                    artist.id as artist_id,
                    artist.name as artist_name,
                    ({$frame_table}.price + {$production_table}.price) as sum_price
                    ")
            ->from('production, image, frame, artist, production_medium, production_style, production_frame')
            ->where('production.image_id = image.image_id')
            ->where('artist.id = production.aid')
            ->where('production.style = production_style.id')
            ->where('production.medium = production_medium.id')
            ->where('production.id', $production_id)
            ->where('production_frame.production_id = production.id')
            ->where('production_frame.frame_id = frame.id')
            ->where('frame.id', $frame_id)
            ->get()->result_array();

        return $query;
    }
}
