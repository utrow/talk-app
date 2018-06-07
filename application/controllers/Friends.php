<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Friends extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Db_mdl', 'Authmodel']);
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }
    public function add()
    {
        $userid = $this->Authmodel->login_check();
        if ($userid >= 0) {
            $friend = $this->Db_mdl->exist_friend($this->input->post('username'));
            if($friend!=false){
                $result = $this->Db_mdl->add_friends($userid,$friend->id);
                
                if($result){
                    $return = ['code' => 1, 'user' => $friend ];
                }
                else{
                    $return = ['code' => -1, 'text' => 'すでに友だちに追加されています'];
                }
            }
            else {
                $return = ['code' => -1, 'text' => 'そのユーザIDは存在しません。'];
            }
           
        }
        else{
            $return = ['code' => -1, 'text' => '認証に失敗しました。'];
        }
        header("Content-Type: text/javascript; charset=utf-8");
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        exit();

    }
    function list() {
        $userid = $this->Authmodel->login_check();
        if ($userid >= 0) {
            $friends = $this->Db_mdl->get_friends($userid);

            $return = ['code' => 1, 'friends' => $friends];
        }
        else{
            $return = ['code' => -1, 'text' => '認証に失敗しました。'];
        }
        header("Content-Type: text/javascript; charset=utf-8");
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        exit();

    }
}
