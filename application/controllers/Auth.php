<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->model(['Authmodel']);
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function weblogin()
    {
        $this->load->library('parser');
        $this->parser->parse('auth/weblogin',
            ['token' => $this->Authmodel->generate_token()]);
    }
    public function token()
    {
        header("Content-Type: text/javascript; charset=utf-8");
        echo json_encode(
            ['token' => $this->Authmodel->generate_token()]
            , JSON_UNESCAPED_UNICODE);
        exit();
    }
    public function register()
    {
        $return = ['code' => ''];
        if ($this->input->post() !== false) {
            if ($this->input->post('password') == "") {
                $return = ['code' => -1, 'text' => 'パスワードを入力してください。'];
            } else if ($this->input->post('password') != $this->input->post('repassword')) {
                $return = ['code' => -1, 'text' => 'パスワードの再入力が間違っています。'];
            } else {
                $return = $this->Authmodel->register(
                    $this->input->post('username'),
                    $this->input->post('password'),
                    $this->input->post('repassword'),
                    $this->input->post('token'));
            }
        }
        header("Content-Type: text/javascript; charset=utf-8");
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        exit();
    }
    public function loggedin()
    {
       $state = $this->Authmodel->login_check();
       $return = ['code' => $state];
        header("Content-Type: text/javascript; charset=utf-8");
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        exit();
    }
    public function login()
    {
        $return = [];
        if ($this->input->post() !== false) {
            $result = $this->Authmodel->login(
                $this->input->post('username'),
                $this->input->post('password')
            );
            switch ($result) {
                case 1:
                    $return = ['code' => $result,'user' => $this->session->userdata];
                    break;
                case 0:
                    $return = ['code' => $result,'text' => 'パスワードが間違っています'];
                    break;
                case -1:
                    $return = ['code' => $result,'text' => 'トークンエラー'];
                    break;

            }
        }

        header("Content-Type: text/javascript; charset=utf-8");
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function logout()
    {
        $return = ['code' => '0'];
        $return['code'] = $this->Authmodel->logout();
        header("Content-Type: text/javascript; charset=utf-8");
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        exit();
    }

}
