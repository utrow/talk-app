<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Authmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['cookie', 'url']);
        $this->load->database();
    }
    // Auth
    public function login_check()
    {
        if (isset($this->session->id)) {
            return $this->session->id;
        }
        return -1; //users.id

    }
    public function generate_token()
    {
        return hash('sha256', session_id());
    }
    public function varidate_token($token)
    {
        return $token === $this->generate_token();
    }

/*-----------------------------------------------
Register
------------------------------------------------*/
    public function register($username, $password,$repassword, $token)
    {
        if ($this->varidate_token($token)) {
            // ユーザ名重複チェック
            if ($this->user_exist($username) != false) {
                return ['code' => -1, 'text' => 'すでに使用されているユーザIDです。'];
            }
            $result = $this->db->insert('users', [
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT),
            ]);

            if ($result) {

                $this->db->from('users');
                $this->db->where('username', $username);
                $user = $this->db->insert_id();
                // insert 成功
                $this->session->set_userdata([
                    'id' => $user,
                    'username' => $username,
                ]);
                return ['code' => 1, 'user' =>  $this->session->userdata];
            }
            return ['code' => -2, 'value' => 'アカウントの作成に失敗しました。'];
        }
        return ['code' => -2, 'value' => 'token'];
    }
    private function user_exist($username)
    {
        $this->db->from('users');
        $this->db->where('username', $username);
        $user = $this->db->get()->row();
        if (!empty($user)) {
            return $user->id;
        }
        return false;
    }

/*-----------------------------------------------
Login
------------------------------------------------*/

    public function login($username, $password)
    {

        if ($this->varidate_token($this->input->post('token'))) {
            // DB
            $this->db->from('users');
            $this->db->where('username', $username);
            $user = $this->db->insert_id();
            if (!empty($user) && password_verify($password, $user->password)) {
                // 認証が成功したとき
                // ユーザ名をセット
                $this->session->set_userdata([
                    'id' => $user,
                    'username' => $username,
                ]);
                return 1;
            }
            return 0;

        }
        return -1;
    }
    public function logout()
    {
// セッション破棄
        session_destroy();
    }

    public function user_screeninfo()
    {
        if ($this->ion_auth->logged_in()) {
            // ログイン中のユーザ情報を取得
            $user = $this->ion_auth->user()->row();
            $group = $this->ion_auth->get_users_groups($user->id)->result();
            // OUTPUTするユーザ情報
            $user_scinfo = [
                'user_screenname' => $user->first_name,
                'user_username' => $user->username,
                'user_part' => $group[0]->description,
            ];
            return (object) $user_scinfo;
        }
        return 0;
    }

/*-----------------------------------------------
profile
------------------------------------------------*/
    public function change_screenname()
    {

    }

}
