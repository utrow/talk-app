<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Db_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /* ----------------------------------------------------
    //    Messages
    ----------------------------------------------------*/
    public function insert_messages($id = null, $userid = null)
    {
        $this->db->insert('messages', [
            'ts' => time(),
            'to_user' => $userid,
            'from_user' => $userid,
            'text' => $text,
        ]);
    }
    public function get_messages($userid = null, $limit = null, $top = null)
    {
        if (isset($userid)) {
            $this->db->from('messages');
            $this->db->where('to_user', $userid);
            $this->db->order_by('ts', "asc");
            $images = $this->db->get()->result();
            return $images;
        }
    }
    public function count_image_messages($userid = null)
    {
        if (isset($userid)) {
            $this->db->from('messages');
            $this->db->where('userid', $userid);

            return 0;
        }
        return 0;
    }

    /* ----------------------------------------------------
    //    Friends
    ----------------------------------------------------*/

    // ADD
    public function add_friends($userid, $friendid)
    {
        return $this->db->insert('friends', [
            'userid' => $userid,
            'friend_userid' => $friendid,
        ]);
    }
    public function get_friends($userid)
    {
        $this->db->select('userid,friend_userid,username');
        $this->db->from('friends');
        $this->db->where('userid', $userid);
        $this->db->join('users', 'friends.friend_userid = users.id','left');
        $query = $this->db->get();
        foreach ($query->result()  as $friend) {
            
        }
        return $query->result();
    }
    public function del_friends($uniq = null)
    {
        if (isset($uniq)) {
            $this->db->from('friends');
            $this->db->where('userid', $uniq);
            // LIMIT 1
            $user = $this->db->get()->row();
            if (isset($user)) {
                return $user->userid;
            }
            return null;
        }
    }
    public function exist_friend($username)
    {
        $this->db->from('users');
        $this->db->where('username', $username);
        $user = $this->db->get()->row();
        if (!empty($user)) {
            return $user;
        }
        return false;
    }
}
