<?php


class Article_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('article_comment_model');
        $this->load->model('article_like_model');
        $this->load->model('user_model');
        $this->load->model('notification_model');
    }

    /**
     * 发表文章.
     */
    public function publish_article($user_id, $article_title, $article_type, $pids, $article_content, $tags)
    {
        //将文章插入到数据库
        $article_id = $this->article_model->publish_article($user_id, $article_title, $article_type, $pids, $article_content, $tags);

        return empty($article_id) ? false : true;
    }

    /**
     * @to do
     */
    public function publish_topic($title, $content, $uid, $who, $where, $when)
    {
        return $this->article_model->insert_topic($title, $content, $uid, $who, $where, $when);
    }

    /**
     * 获取资讯列表.
     *
     * @param $page
     * @param $uid
     * @param $tag
     *
     * @return mixed
     */
    public function get_article_list($page, $uid, $tag)
    {
        $article = $this->article_model->get_article_list($page, $uid, null, null, $tag);
        foreach ($article as $key => $value) {
            //对每篇文章内容进行字数截取
            $article[$key]['content'] = Common::extract_article($article[$key]['id'], $article[$key]['title'], $article[$key]['content']);

            //对文章标题字数截取
            $article[$key]['content']['sort_title'] = mb_strlen($article[$key]['content']['article_title']) > 9 ? mb_substr($article[$key]['content']['article_title'], 0, 9).'..' : $article[$key]['content']['article_title'];

            //查询作者的信息
            //$article[$key]['author'] = $this->user_model->get_user_base_id($article[$key]['uid']);
            unset($article[$key]['id']);
            unset($article[$key]['title']);
            //unset($article[$key]['uid']);
        }

        return $article;
    }

    /**
     * 获取专题的列表.
     *
     * @param $page
     * @param $who
     * @param $when
     * @param $where
     */
    public function get_topic_list($page, $who, $when, $where)
    {
        $topic = $this->article_model->get_topic_list($page, $who, $when, $where);

        foreach ($topic as $key => $value) {
            //对每篇文章内容进行字数截取
            $topic[$key]['content'] = Common::extract_topic($topic[$key]['id'], $topic[$key]['title'], $topic[$key]['content']);

            //对文章标题字数截取
            $topic[$key]['content']['sort_title'] = mb_strlen($topic[$key]['content']['article_title']) > 9 ?
                mb_substr($topic[$key]['content']['article_title'], 0, 9).'..' :
                $topic[$key]['content']['article_title'];

            unset($topic[$key]['id']);
            unset($topic[$key]['title']);
        }

        return $topic;
    }

    /**
     * [get_article_by_id 获取文章的全部信息].
     */
    public function get_article_by_id($aid)
    {
        $query = $this->article_model->get_article_by_id($aid);

        return $query;
    }

    /**
     * [get_article_vote_by_both 获取某篇文章被某人点赞的状态].
     *
     * @param [type] $aid [description]
     * @param [type] $uid [description]
     *
     * @return [type] [description]
     */
    public function get_article_vote_by_both($aid, $uid)
    {
        return $this->article_like_model->get_article_vote_by_both($aid, $uid)['status'];
    }

    /**
     * [get_comment_by_aid 获取文章评论].
     */
    public function get_comment_by_aid($aid)
    {
        $query = $this->article_comment_model->get_comment_by_aid($aid);

        foreach ($query as $key => $value) {
            $query[$key]['user'] = $this->user_model->get_user_base_id($query[$key]['uid']);
        }

        return $query;
    }

    public function read_article($aid)
    {
        $this->article_model->read_article($aid);
    }

    /**
     * [vote_article 点赞].
     */
    public function vote_article($aid, $uid)
    {
        //文章存在检查
        $article = $this->article_model->get_article_by_id($aid);
        if (empty($article)) {
            $this->error->output('INVALID_REQUEST');
        }

        $status = $this->article_like_model->article_vote($aid, $uid);
        //成功
        if ($status) {
            echo json_encode(array('success' => 0));
            //首次点赞
            if (!isset($status['status'])) {
                //更新文章的 like 数加一
                $this->article_model->argee_article($aid);
            } else {
                if ($status['status'] == 0) {
                    //文章的 like 数减一
                    $this->article_model->disargee_article($aid);
                } else {
                    //更新文章的 like 数加一
                    $this->article_model->argee_article($aid);
                }
            }
        }
        //失败
        else {
            $this->error->output('INVALID_REQUEST');
        }
    }

    /**
     * [write_comment 发表评论].
     *
     * @param [type] $aid     [文章id]
     * @param [type] $uid     [用户id]]
     * @param [type] $pid     [评论父id]
     * @param [type] $comment [评论内容]
     *
     * @return [type] [description]
     */
    public function write_comment($aid, $uid, $pid, $comment)
    {
        //文章存在检查
        $article = $this->article_model->get_article_by_id($aid);
        if (empty($article)) {
            $this->error->output('INVALID_REQUEST');
        }

        $comment = Common::replace_face_url($comment);
        $insert_result = $this->article_comment_model->insert_comment($aid, $uid, $pid, $comment);
        if ($insert_result) {
            echo json_encode(array('success' => 0, 'script' => 'location.reload();'));
            //如果是回复评论
            if (!empty($pid)) {
                //添加评论消息
                $c = $this->article_comment_model->get_comment_by_id($pid);
                if (!empty($c) && $c['uid'] != $uid) {
                    $this->notification_model->insert($uid, $c['uid'], 2, json_encode(array('content_id' => $aid, 'comment_content' => $comment)));
                }
            }
        } else {
            $this->error->output('INVALID_REQUEST');
        }
    }

    /**
     * 获取文章点过赞的人.
     */
    public function get_vote_person_by_aid($aid)
    {
        $users = $this->article_like_model->get_vote_person_by_aid($aid);

        foreach ($users as $key => $value) {
            $users[$key]['user'] = $this->user_model->get_user_base_id($users[$key]['uid']);
            unset($users[$key]['uid']);
        }

        return $users;
    }

    /**
     * [update_article 更新文章].
     *
     * @param [type] $aid [文章id]
     * @param [type] $uid [用户id]
     *
     * @return [type] [description]
     */
    public function update_article($aid, $uid, $article_title, $article_type, $pids, $article_content, $tags)
    {
        $arr = array(
            'title' => $article_title,
            'type' => $article_type,
            'pids' => $pids,
            'content' => $article_content,
            'modify_by' => $uid,
            'tag' => $tags,
        );

        return $this->article_model->update_article($aid, $arr);
    }

    /**
     * [delete_article 删除文章].
     *
     * @param [type] $aid [文章id]
     * @param [type] $uid [用户id]
     *
     * @return [type] [description]
     */
    public function delete_article($aid, $uid)
    {
        $result = $this->article_model->delete_article($aid, $uid);

        return $result;
    }

    public function delete_article_like_comment($aid)
    {
        $this->article_comment_model->delete_comment_by_aid($aid);
        $this->article_like_model->delete_like_by_aid($aid);
    }

    /**
     * 获得专题的标签.
     *
     * @return mixed
     */
    public function get_topic_tag()
    {
        $this->load->model('topic_tag_when_model');
        $this->load->model('topic_tag_where_model');
        $this->load->model('topic_tag_who_model');

        $query['when'] = $this->topic_tag_when_model->get_topic_tag_when_list();
        $query['where'] = $this->topic_tag_where_model->get_topic_tag_where_list();
        $query['who'] = $this->topic_tag_who_model->get_topic_tag_who_list();

        return $query;
    }

    public function get_article_tag()
    {
        $query = $this->article_model->get_article_tag();

        return $query;
    }

    public function publish($id)
    {
        return $this->article_model->publish($id);
    }

    public function cancel_publish($id)
    {
        return $this->article_model->cancel_publish($id);
    }
}
