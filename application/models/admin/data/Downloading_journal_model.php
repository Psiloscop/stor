<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/9/16
 * Time: 12:22 AM
 */

class Downloading_journal_model extends CI_Model
{
    public function add_download_info($student_count)
    {
        $this->db->insert('downloading_journal', array(
            'downloading_count' => $student_count,
            'downloading_date' => date('Y-m-d'),
        ));
    }
}