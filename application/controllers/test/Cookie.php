<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cookie extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
    }

    public function start()
    {
        echo 'set cookie';
        set_cookie('a', 'b');
    }

    public function check()
    {
        get_cookie('a');
    }

    public function test()
    {
        $factory = new RandomLib\Factory();
        $generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));
        // $generator = $factory->getLowStrengthGenerator();
        $bytes = $generator->generate(32);
        var_dump($bytes);
    }
}
