<?php

class Err extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $this->bar();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function bar()
    {
        throw new Exception('Error Processing Request', 1);
    }

    public function inverse($x)
    {
        if (!$x) {
            throw new Exception('Division by zero.', 1);
        }

        return 1 / $x;
    }
}
