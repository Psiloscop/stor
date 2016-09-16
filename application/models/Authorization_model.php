<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'exceptions/User_auth_exception.php';

class Authorization_model extends CI_Model
{
    function get_user_data($username, $password)
    {
        $user = $this->db
            ->select('us.id, us.FIO, us.usertype', FALSE)
            ->where('us.username', $username)
            ->where('us.password', $password)
            ->get('users AS us')->row_array();

        if(empty($user))
        {
            throw new User_auth_exception('Пользователь не найден');
        }

        return $user;
    }
}