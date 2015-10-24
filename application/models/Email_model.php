<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Email_model extends CI_Model
{
    public function insert_token($uid, $token)
    {
        $data = array(
            'uid' => $uid,
            'token' => $token,
            'exptime' => time() + 60 * 60 * 24 * 7,  // 7 日内激活邮箱
        );
        $this->db->insert('email', $data);
    }

    public function active_email($token)
    {
        $where = array(
            'token' => $token,
            'exptime >=' => time(),
            'status' => 0,
        );
        $query = $this->db->where($where)->get('email')->row_array();

        if (empty($query)) {
            return false;
        }

        //更新该验证码已使用
        $this->db->where('id', $query['id'])->update('email', array('status' => 1));

        return $query['uid'];
    }
}
