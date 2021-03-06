<?php


class Article_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * [publish_article 保存文章].
     *
     * @param [type] $user_id         [description]
     * @param [type] $article_title   [description]
     * @param [type] $article_type    [description]
     * @param [type] $pids            [description]
     * @param [type] $article_content [description]
     * @param [type] $tags            [description]
     *
     * @return [type] [description]
     */
    public function publish_article($user_id, $article_title, $article_type, $pids, $article_content, $tags)
    {
        $data = array(
            'uid' => $user_id,
            'type' => $article_type,
            'title' => $article_title,
            'pids' => $pids,
            'content' => $article_content,
            'publish_time' => date('Y-m-d H:i:s', time()),
            'creat_by' => $user_id,
            'tag' => $tags,
        );

        $this->db->insert('article', $data);

        if ($this->db->affected_rows() !== 1) {
            return false;
        }

        return $this->db->insert_id();
    }

    /**
     * [get_article_by_id 获取文章详情].
     *
     * @param [type] $aid [description]
     *
     * @return [type] [description]
     */
    public function get_article_by_id($aid)
    {
        return $this->db->where('id', $aid)->get('article')->row_array();
    }

    /**
     * 发布专题.
     */
    public function insert_topic($title, $content, $uid, $who, $where, $when)
    {
        $data = array(
            'who' => $who,
            'where' => $where,
            'when' => $when,
        );

        $this->db->insert('topic_tag', $data);
        $tid = $this->db->insert_id();

        $data = array(
            'uid' => $uid,
            'type' => 2,
            'title' => $title,
            'content' => $content,
            'publish_time' => date('Y-m-d H:i:s', time()),
            'creat_by' => $uid,
            'tid' => $tid,
        );

        $this->db->insert('article', $data);

        return $this->db->insert_id();
    }

    /**
     * [get_article_list 获取文章列表].
     *
     * @param int    $page  [页数]
     * @param [type] $meid  [我的id]
     * @param [type] $uid   [用户id]
     * @param [type] $type  [文章类型]
     * @param int    $limit [页面个数限制]
     * @param string $order [排序]
     *
     * @return [type] [description]
     */
    public function get_article_list($page = 0, $meid = null, $uid = null, $pid = null, $tag = null, $limit = 6, $order = 'id DESC')
    {
        $query = $this->db
            ->select('
            article.id,
            article.uid,
            article.title,
            article.content,
            article.like,
            article.read
            ')
            ->from('article')
            ->where('article.type', 1)
            ->where('article.publish_status', '1');

        if (is_numeric($meid)) {
            $query = $query->select('article_like.status as like_status');
            $query = $query->join('article_like', "article_like.aid = article.id AND article_like.uid = {$meid}", 'left');
        }
        if (!empty($uid)) {
            $query = $query->where('article.uid', $uid);
        }
        if (!empty($type)) {
            $query = $query->where('article.type', $type);
        }
        if (!empty($pid)) {
            $query = $query->like('article.pids', "|{$pid}|");
        }
        if (!empty($tag)) {
            $query = $query->like('article.tag', "|{$tag}|");
        }

        $query = $query->where('article.publish_status', '1');
        $query = $query->order_by($order)->limit($limit, $page * $limit)->get()->result_array();

        return $query;
    }

    public function get_topic_list($page = 0, $who = null, $when = null, $where = null, $limit = 6)
    {
        $query = $this->db
            ->select('
            article.id,
            article.uid,
            article.title,
            article.content,
            article.read,
            article.like,
            ')
            ->from('article, topic_tag')
            ->where('article.tid = topic_tag.id')
            ->where('article.publish_status', 1)
            ->where('article.type', 2);

        if (isset($who) && is_numeric($who)) {
            $query = $query->where('topic_tag.who', $who);
        }

        if (isset($when) && is_numeric($when)) {
            $query = $query->where('topic_tag.when', $when);
        }

        if (isset($where) && is_numeric($where)) {
            $query = $query->where('topic_tag.where', $where);
        }

        $query = $query->order_by('article.id DESC')->limit($limit, $page * $limit)->get()->result_array();

        return $query;
    }

    public function update_count($aid, $field = array())
    {
        $where = array('id' => $aid);
        $query = $this->db->select($field['name'])
            ->from('article')
            ->where($where)
            ->get()
            ->row_array();

        if (!empty($query)) {
            $query[$field['name']] = (int) $query[$field['name']] + (int) $field['amount'];
            $this->db->where($where)->update('article', $query);

            return $this->db->affected_rows() === 1;
        } else {
            return false;
        }
    }

    public function get_uid_by_aid($aid)
    {
        $query = $this->select('uid')->where('id', $aid)->get('article')->result_array();

        return count($query) === 1 ? $query[0] : null;
    }

    /**
     * 点赞时，文章的 like 加一.
     */
    public function argee_article($aid)
    {
        $table_name = $this->db->protect_identifiers('article', true);
        $this->db->query("UPDATE {$table_name} SET {$table_name}.`like` = {$table_name}.`like` + 1 WHERE {$table_name}.id = {$aid}");
    }

    /**
     * 取消点赞时，文章的 like 减一.
     */
    public function disargee_article($aid)
    {
        $table_name = $this->db->protect_identifiers('article', true);
        $this->db->query("UPDATE {$table_name} SET {$table_name}.`like` = {$table_name}.`like` - 1 WHERE {$table_name}.id = {$aid} and {$table_name}.`like` > 0");
    }

    public function read_article($aid)
    {
        $table_name = $this->db->protect_identifiers('article', true);
        $this->db->query("UPDATE {$table_name} SET {$table_name}.`read` = {$table_name}.`read` + 1 WHERE {$table_name}.id = {$aid}");
    }

    /**
     * [delete_article 删除文章].
     *
     * @param [type] $aid [文章id]
     * @param [type] $uid [用户id]
     *
     * @return [type] [description]
     */
    public function delete_article($aid, $uid = null)
    {
        $where = array();
        $where['id'] = $aid;
        if (!empty($uid)) {
            $where['uid'] = $uid;
        }
        $this->db->delete('article', $where);

        return $this->db->affected_rows() === 1;
    }

    /**
     * [update_article 更新文章].
     *
     * @param [type] $aid [文章id]
     * @param [type] $uid [用户id]
     * @param [type] $arr [键值数组]
     *
     * @return [type] [description]
     */
    public function update_article($aid, $arr, $uid = null)
    {
        $arr['modify_time'] = date('Y-m-d H:i:s', time());
        if (!empty($uid)) {
            $this->db->where('uid', $uid);
        }
        $this->db->where('id', $aid)
            ->update('article', $arr);

        return $this->db->affected_rows() === 1;
    }

    public function admin_get_article_list($page = 0, $type, $limit = 10, $order = 'id DESC')
    {
        $article = $this->db->select('
        article.id,
        user.name as author,
        article.type,
        article_type.name as type_name,
        article.title,
        article.publish_time,
        article.read,
        article.like,
        article.publish_status'
        )
            ->where('article.type', $type)
            ->join('article_type', 'article.type = article_type.id', 'left')
            ->join('user', 'user.id = article.uid')
            ->order_by($order)
            ->limit($limit, $page * $limit)
            ->get('article')
            ->result_array();

        return $article;
    }

    public function get_article_count()
    {
        return $this->db->count_all('article');
    }

    /**
     * 根据关键字进行模糊搜索文章和专题.
     *
     * @param $keyword
     */
    public function get_article_by_keyword($keyword)
    {
        $query = $this->db
            ->select(
                'article.id,
                article.uid,
                article.title,
                article.content,
                article.like,
                article.read,
                article.publish_time,
                article.type
                ')
            ->where('publish_status', 1)
            ->from('article')
            ->like('article.title', $keyword)
            ->get()
            ->result_array();

        return $query;
    }

    public function get_all_tag()
    {
        $query = $this->db->get('article_tag')->result_array();

        return $query;
    }

    public function get_tag_count()
    {
        return $this->db->count_all('article_tag');
    }

    public function get_article_tag()
    {
        $query = $this->db->where('type', 1)->get('article_tag')->result_array();

        return $query;
    }

    public function get_article_tag_count()
    {
        return $this->db->where('type', 1)->count_all_results('article_tag');
    }

    public function get_tag_by_id($id)
    {
        $query = $this->db->where('id', $id)->get('article_tag')->row_array();

        return $query;
    }

    public function add_tag($name, $type)
    {
        $data = array(
            'name' => $name,
            'type' => $type,
        );

        $this->db->insert('article_tag', $data);

        return $this->db->insert_id();
    }

    public function update_tag($id, $name, $type)
    {
        $data = array(
            'name' => $name,
            'type' => $type,
        );
        $this->db->where('id', $id);
        $this->db->update('article_tag', $data);

        return $this->db->affected_rows();
    }

    public function delete_tag($id)
    {
        $this->db->delete('article_tag', array('id' => $id));

        return $this->db->affected_rows() === 1;
    }

    public function publish($id)
    {
        $data = array(
            'publish_status' => 1,
        );
        $this->db->where('id', $id)->update('article', $data);

        return $this->db->affected_rows() === 1;
    }

    public function cancel_publish($id)
    {
        $data = array(
            'publish_status' => 0,
        );
        $this->db->where('id', $id)->update('article', $data);

        return $this->db->affected_rows() === 1;
    }
}
