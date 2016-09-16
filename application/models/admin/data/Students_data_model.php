<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 8/31/16
 * Time: 9:40 PM
 */

class Students_data_model extends CI_Model
{
    public function insert_students($students_data)
    {
        $this->db->insert_batch('students', $students_data);
    }

    public function add_student_photo($AVN_id, $photo_name)
    {
        $this->db
            ->where('students.AVN_id', $AVN_id)
            ->update('students', array(
                'photo' => $photo_name
            ));
    }

    public function update_student($student_data, $student_id)
    {
        $this->db
            ->where('students.id', $student_id)
            ->update('students', $student_data);
    }

    public function get_student_id($AVN_id)
    {
        $student_id = $this->db
            ->select('st.id')
            ->where('st.AVN_id', $AVN_id)
            ->get('students AS st')->row_array();

        return $student_id['id'] ?? NULL;
    }
}