<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/6/16
 * Time: 10:50 PM
 */

class Users_data_model extends CI_Model
{
    public function get_user_data($user_id)
    {
        return $this->db
            ->select('us.id, us.FIO, us.username, us.usertype')
            ->from('users AS us')
            ->where('us.id', $user_id)
            ->get()->row_array();
    }

    public function add_user($user_data)
    {
        $this->db->insert('users', $user_data);

        return $this->db->insert_id();
    }

    public function update_user($user_id, $user_data)
    {
        $this->db
            ->where('id', $user_id)
            ->update('users', $user_data);
    }

    public function del_user($user_id)
    {
        $this->db
            ->where('id', $user_id)
            ->delete('users');
    }
}