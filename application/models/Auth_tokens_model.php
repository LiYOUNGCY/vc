<?php
/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/14
 * Time: 13:25
 */

class Auth_tokens_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function confirm_token($selector, $token)
    {
        echo $selector;

        
        $query = $this->db->select('uid, token')->where('selector', $selector)->where('expires >', time())->get('auth_tokens')->result_array();
        var_dump($query);
        if( count($query) === 1 && strcmp($query[0]['token'], $token) === 0 ) 
        {
            echo "dasfasdf";
            return $query[0];
        }

        return FALSE;
    }

    public function set_token ($uid, $selector, $token, $expires = '')
    {
        if( is_numeric($expires) )
        {
            $expires = time() + $expires;
        }
        else
        {
            //时间加 7 天
            $expires = time() + 7*24*60*60;
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

    public function get_token_by_selector ($selector)
    {
        $query = $this->db->where('selector', $selector)->get('auth_tokens')->result_array();

        if( count($query) === 1 )
        {
            return true;
        }

        return false;
    }

    public function update_token_by_selector ($selector, $token)
    {
        $update_arr = array(
            'token'     => $token
        );
        $this->db->update('auth_tokens', $update_arr, array('selector' => $selector));
        return $this->db->affected_rows() === 1;
    }

    public function delete_all_token_by_user ($uid)
    {
        $this->db->delete('auth_token', array('uid' => $uid));
    }
}