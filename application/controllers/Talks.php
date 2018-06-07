<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Talks extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model(['Authmodel']);
        $userid = $this->Authmodel->login_check();
        if ($userid !== false) {

            echo '#' . $userid . 'でログイン中';
        } else {
            echo 'ログインされてない';
        }
    }

    public function index()
    {
    }
    function new ($ts = 0) {

    }
    public function send($to, $text)
    {

    }
}
