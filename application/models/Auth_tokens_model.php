<?php
/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/14
 * Time: 13:25
 */

class Auth_tokens_Model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 检验 token 是否有效
     * @param $selector
     * @param $token
     * @return uid or false;
     */
    public function confirm_token($selector, $token)
    {
        $query = $this->db->select('uid, token')->where('selector', $selector)->where('expires >', time())->get('auth_tokens')->result_array();
        if( count($query) === 1 && strcmp($query[0]['token'], $token) === 0 ) 
        {
            unset($query['token']);
            return $query[0]['uid'];
        }

        return FALSE;
    }


    /**
     * 插入 token 到数据库
     * @param $uid
     * @param $selector
     * @param $token
     * @param string $expires
     * @return bool
     */
    public function set_token ($uid, $selector, $token, $expires = '')
    {
        if (is_numeric($expires)) {
            $expires = time() + $expires;
        } else {
            //时间加 30 天
            $expires = time() + 30 * 24 * 60 * 60;
        }


        $data = array(
            'uid'       => $uid,
            'selector'  => $selector,
            'token'     => $token,
            'expires'   => $expires
        );

        $this->db->insert('auth_tokens', $data);
        return $this->db->affected_rows() === 1;
    }


    /**
     * 更新 TOKEN 根据 SELECTOR
     * @param $selector
     * @param $token
     * @param string $expires
     * @return bool
     */
    public function update_token_by_selector ($selector, $token, $expires = '')
    {
        if( is_numeric($expires) )
        {
            $expires = time() + $expires;
        }
        else
        {
            //时间加 30 天
            $expires = time() + 30*24*60*60;
        }

        $update_arr = array(
            'token'     => $token,
            'expires'   => $expires
        );
        $this->db->update('auth_tokens', $update_arr, array('selector' => $selector));
        return $this->db->affected_rows() === 1;
    }

    /**
     * 删除所有的 token 和 selector
     * @param $uid
     */
    public function delete_all_token_by_user ($uid)
    {
        $this->db->delete('auth_token', array('uid' => $uid));
    }
}