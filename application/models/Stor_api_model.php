<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/13/16
 * Time: 10:00 PM
 */

class Stor_api_model extends CI_Model
{
    public function check_reader_existence($username, $number)
    {
        $reader_count = $this->db
            ->where('username', $username)
            ->where('number', $number)
            ->count_all_results('students');

        return $reader_count == 1 ? TRUE : FALSE;
    }
}