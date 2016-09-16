<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/9/16
 * Time: 10:17 PM
 */

class Readers_data_model extends CI_Model
{
    public function get_reader_count($query_string)
    {
        $result_count = $this->db
            ->where('MATCH(st.last_name, st.first_name, st.middle_name, st.number) AGAINST("'.$query_string.'")')
            ->count_all_results('students AS st');

        return $result_count;
    }

    public function get_reader_data($reader_id)
    {
        $this->db
            ->select('
                st.last_name, st.first_name, st.middle_name, st.gender,
                DATE_FORMAT(st.birth_date, "%Y%m%d") AS birth_date,
                fc.faculty, sg.study_group, sf.study_form, cnt.code,
                IF(st.payment_form = "к", 1, 0) AS payment_form,
                st.number', FALSE)
            ->join('study_groups AS sg', 'sg.id = study_group_id', 'left')
            ->join('faculties AS fc', 'fc.id = faculty_id', 'left')
            ->join('study_forms AS sf', 'sf.id = study_form_id', 'left')
            ->join('countries AS cnt', 'cnt.id = citizenship_id', 'left')
            ->where('st.id', $reader_id);

        return $this->db->get('students AS st')->row_array();
    }

    public function register_reader_to_irbis($reader_id, $reader_number)
    {
        $this->load->model('api/Irbis_functions');

        $reader_data = $this->get_reader_data($reader_id);

        $this->Irbis_functions->register_reader($reader_data, $reader_number);

        $this->db
            ->where('id', $reader_id)
            ->update('students', array(
                'number' => $reader_number
            ));
    }

    public function update_reader_to_irbis($reader_id)
    {
        $this->load->model('api/Irbis_functions');

        $reader_number = $this->get_reader_data($reader_id)['number'];

        $this->Irbis_functions->update_reader($reader_number);
    }

    public function change_reader_number($reader_id, $reader_number)
    {
        $this->load->model('api/Irbis_functions');

        $reader_data = $this->get_reader_data($reader_id);

        $this->Irbis_functions->change_reader_number($reader_data, $reader_number);

        $this->db
            ->where('id', $reader_id)
            ->update('students', array(
                'number' => $reader_number
            ));
    }
}