<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/9/16
 * Time: 10:17 PM
 */

class Reader_search_result_model extends CI_Model
{
    private $content_data = array();

    public function init_content($query_string)
    {
        $this->db
            ->select('st.id, CONCAT(st.last_name, " ", st.first_name, " ", IFNULL(st.middle_name, "")) AS FIO,
                CONCAT("Дата рождения: ", IFNULL(DATE_FORMAT(st.birth_date, "%d.%m.%Y"), "-"), ", Факультет: ", fc.faculty,
                ", Группа: ", sg.study_group, ", Форма обучения: ", sf.study_form,
                ", Форма оплаты: ", IF(st.payment_form = "к", "контракт", "бюджет")) AS description ', FALSE)
            ->join('study_groups AS sg', 'sg.id = study_group_id', 'left')
            ->join('faculties AS fc', 'fc.id = faculty_id', 'left')
            ->join('study_forms AS sf', 'sf.id = study_form_id', 'left')
            ->where('MATCH(st.last_name, st.first_name, st.middle_name, st.number) AGAINST("'.$query_string.'")');

        $this->content_data['data'] = $this->db->get('students AS st')->result_array();
    }

    public function get_content()
    {
        return $this->content_data;
    }
}