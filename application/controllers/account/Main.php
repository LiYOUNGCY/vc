<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('user_service');
        $this->key = pack('H*', "5c204b7efffa0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
    }

    public function index()
    {
        $data['css'] = array(
            'swiper.min.css',
            'font-awesome/css/font-awesome.min.css',
            'base.css',
            'alert.css'
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'error.js',
            'alert.min.js'
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', true);

        $data['title'] = '忘记密码';
        $body['top'] = $this->load->view('common/top', $user, true);
        $body['footer'] = $this->load->view('common/footer', '', true);
        $body['user'] = $this->user;

        $this->load->view('common/head', $data);
        $this->load->view('forget_pwd', $body);
    }

    public function forget_password($type)
    {
        if (!isset($type)) {
            show_404();
        }

        if ($type == 'email') {
            $email = $this->sc->input('email');
            $user_id = $this->user_service->get_user_id_by_email($email);

            if ($user_id == false) {
                exit();
            }

            $this->user_service->forget_password_by_email($user_id, $email);


            $data['css'] = array(
                'swiper.min.css',
                'font-awesome/css/font-awesome.min.css',
                'base.css',
                'alert.css'
            );
            $data['javascript'] = array(
                'jquery.js',
                'masonry.pkgd.min.js',
                'jquery.imageloader.js',
                'error.js',
                'alert.min.js'
            );

            $user['user'] = $this->user;
            $user['sign'] = $this->load->view('common/sign', '', true);

            $data['title'] = '发送邮件成功';
            $body['top'] = $this->load->view('common/top', $user, true);
            $body['footer'] = $this->load->view('common/footer', '', true);
            $body['user'] = $this->user;
            $body['email'] = $email;

            $this->load->view('common/head', $data);
            $this->load->view('email_success', $body);

        }
    }

    public function reset_password()
    {
        $token = $this->sc->input('token', 'get');

        //邮箱验证
        if (!empty($token)) {
            $user_id = $this->user_service->get_user_id_by_token($token);
            $str = $this->encrypt($user_id);
        } //手机验证
        else {
            $phone = $this->sc->input('phone');
            $code = $this->sc->input('code');

            $user_id = $this->user_service->get_user_id_by_phone($phone);

            if (empty($user_id)) {
                echo '该手机号码没有注册';
                exit();
            }

            if (!empty($_SESSION['code']) && $code != $_SESSION['code']) {
                echo '验证码错误';
                exit();
            }
            $str = $this->encrypt($user_id);
        }


        $data['css'] = array(
            'swiper.min.css',
            'font-awesome/css/font-awesome.min.css',
            'base.css',
            'alert.css'
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'error.js',
            'alert.min.js'
        );

        $user['user'] = $this->user;
        $user['sign'] = $this->load->view('common/sign', '', true);

        $data['title'] = '重置密码';
        $body['top'] = $this->load->view('common/top', $user, true);
        $body['footer'] = $this->load->view('common/footer', '', true);
        $body['user'] = $this->user;
        $body['token'] = $str;

        $this->load->view('common/head', $data);
        $this->load->view('reset_password', $body);
    }

    public function set_password()
    {
        $token = $this->sc->input('token');
        $pwd = $this->sc->input('pwd');

        $user_id = (int)$this->decrypt($token);

        if ($user_id == false) {
            $this->message->error('重置密码链接已经失效');
        }

        $result = $this->user_service->set_password($user_id, $pwd);

        if (!$result) {
            $this->message->error();
        }

        $this->message->success();
    }

    /**
     * [login_by_email 邮箱登陆].
     */
    public function login_by_email()
    {
        $email = $this->sc->input('email');
        $pwd = $this->sc->input('pwd');
        $rememberme = $this->sc->input('rememberme');

        $result = $this->user_service->login_action($pwd, $email, null, $rememberme);
        if ($result) {
            //登陆成功, 重定向
            echo json_encode(array('success' => 0, 'note' => '', 'script' => 'window.location.reload();'));
        } else {
            $this->error->output('LOGIN_ERROR');
        }
    }

    /**
     * [login_by_phone 手机号码登陆].
     */
    public function login_by_phone()
    {
        $phone = $this->sc->input('phone');
        $pwd = $this->sc->input('pwd');
        $rememberme = $this->sc->input('rememberme');

        $result = $this->user_service->login_action($pwd, null, $phone, $rememberme);
        if ($result) {
            //登陆成功, 重定向
            echo json_encode(array('success' => 0, 'note' => '', 'script' => 'window.location.reload();'));
        } else {
            $this->error->output('LOGIN_ERROR');
        }
    }

    /**
     * [logout 注销].
     *
     * @return [type] [description]
     */
    public function logout()
    {
        $this->user_service->logout();
        //重定向至首页
        redirect(base_url(), 'location');
    }

    /**
     * [register 邮箱注册].
     */
    public function register_by_email()
    {
        $email = $this->sc->input('email');
        $name = $email;
        $pwd = $this->sc->input('pwd');

        $result = $this->user_service->register_action($name, $pwd, $email, null);
        if ($result) {
            //注册成功, 重定向首页
            echo json_encode(array('success' => 0, 'note' => '', 'script' => 'window.location.href="' . base_url() . '";'));
        } else {
            $this->error->output('REGISTER_ERROR');
        }
    }

    /**
     * [register_by_phone 手机号码注册].
     */
    public function register_by_phone()
    {
        $phone = $this->sc->input('phone');
        $name = $phone;
        $pwd = $this->sc->input('pwd');

        $result = $this->user_service->register_action($name, $pwd, null, $phone);
        if ($result) {
            //注册成功, 重定向首页
            echo json_encode(array('success' => 0, 'note' => '', 'script' => 'window.location.href="' . base_url() . '";'));
        } else {
            $this->error->output('REGISTER_ERROR');
        }
    }

    /**
     * [check_phone 查看手机是否重复].
     *
     * @return [type] [description]
     */
    public function check_phone()
    {
        $phone = $this->sc->input('phone');
        $result = $this->user_service->check_phone($phone);
        if ($result) {
            $this->error->output('PHONE_REPEAT');
        } else {
            echo json_encode(array('success' => 0));
        }
    }

    /**
     * [check_email 查看邮箱是否重复].
     *
     * @return [type] [description]
     */
    public function check_email()
    {
        $email = $this->sc->input('email');
        $result = $this->user_service->check_email($email);
        if ($result) {
            $this->error->output('EMAIL_REPEAT');
        } else {
            echo json_encode(array('success' => 0));
        }
    }

    /**
     * 发送手机验证码.
     *
     * @return [type] [description]
     */
    public function validate_phone()
    {
        $this->load->library('session');
        $phone = $this->sc->input('phone');

        $code = $this->user_service->validate_phone($phone);

        $this->session->set_userdata('code', $code);

        $this->message->success(array('code' => $code));
    }

    /**
     * [get_info_by_id 获取某个人的信息].
     *
     * @return [type] [description]
     */
    public function get_info_by_id()
    {
        $id = $this->sc->input('id');

        $result = $this->user_service->get_user_by_id($id);
        echo json_encode($result);
    }

    /**
     * [get_time 获取服务器时间].
     *
     * @return [type] [description]
     */
    public function get_time()
    {
        $currentTime = array();

        $currentTime['success'] = 0;
        $currentTime['time'] = date('Y-m-d H:i:s');

        echo json_encode($currentTime);
    }

    /**
     * [set_address 设置收货地址]
     */
    public function set_address()
    {
        $address = $this->sc->input('address');
        $phone = $this->sc->input('phone');
        $contact = $this->sc->input('contact');

        $query = $this->user_service->set_address($this->user['id'], $address, $phone, $contact);

        if (!$query) {
            $this->message->error();
        }

        $this->message->success();
    }

    /**
     * [get_address 获取收货地址]
     * @return [type] [description]
     */
    public function get_address()
    {
        $query = $this->user_service->get_address($this->user['id']);

        if (empty($query)) {
            $this->message->error();
        }

        $this->message->success($query);
    }

    public function test()
    {
        $ciphertext = $this->encrypt(12);
        echo $ciphertext, '<br>';

        $plaintext = $this->decrypt($ciphertext);
        echo $plaintext;
    }

    private function encrypt($plaintext)
    {
        # --- ENCRYPTION ---

        # the key should be random binary, use scrypt, bcrypt or PBKDF2 to
        # convert a string into a key
        # key is specified using hexadecimal
        $key = $this->key;

        # show key size use either 16, 24 or 32 byte keys for AES-128, 192
        # and 256 respectively
//        $key_size = strlen($key);

//        $plaintext = "This string was AES-256 / CBC / ZeroBytePadding encrypted.";

        # create a random IV to use with CBC encoding
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

        # creates a cipher text compatible with AES (Rijndael block size = 128)
        # to keep the text confidential
        # only suitable for encoded input that never ends with value 00h
        # (because of default zero padding)
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
            $plaintext, MCRYPT_MODE_CBC, $iv);

        # prepend the IV for it to be available for decryption
        $ciphertext = $iv . $ciphertext;

        # encode the resulting cipher text so it can be represented by a string
        $ciphertext_base64 = base64_encode($ciphertext);

        return $ciphertext_base64;
    }

    private function decrypt($ciphertext_base64)
    {
        $key = $this->key;
        $ciphertext_dec = base64_decode($ciphertext_base64);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

        # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
        $iv_dec = substr($ciphertext_dec, 0, $iv_size);

        # retrieves the cipher text (everything except the $iv_size in the front)
        $ciphertext_dec = substr($ciphertext_dec, $iv_size);

        # may remove 00h valued characters from end of plain text
        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
            $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);

        return $plaintext_dec;
    }
}
