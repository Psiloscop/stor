<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/9/16
 * Time: 10:17 PM
 */

class Reader_info_table_model extends CI_Model
{
    private $content_data = array();

    public function init_content(array $content_params, array $db_params)
    {
        $basic_url = $content_params['basic_content_url'];

        $this->content_data['data'] = $this->get_data($db_params['query_string'], $db_params['by_id']);
        $this->content_data['tasks'] = array();

        $irbis_reader_data = NULL;

        if($this->content_data['data']['number'] != NULL)
        {
            $this->load->model('api/Irbis_functions');

            $irbis_reader_data = $this->Irbis_functions->get_reader_data($this->content_data['data']['number']);
        }

        if($this->content_data['data']['number'] == '-')
        {
            $this->content_data['tasks'][] = array(
                'url' => $basic_url.'register_reader_modal',
                'title' => 'Зарегистрировать',
                'classes' => array('modal_getter')
            );
        }
        else
        {
            $this->content_data['tasks'][] = array(
                'url' => $basic_url.'change_reader_number_modal',
                'title' => 'Изменить номер ЧБ',
                'classes' => array('modal_getter')
            );
        }

        if($irbis_reader_data != NULL)
        {
            $reg_date = NULL;

            if(isset($irbis_reader_data[52][0]['#']))
            {
                $reg_date = $irbis_reader_data[52][count($irbis_reader_data[52]) - 1]['#'];
            }
            else if(isset($irbis_reader_data[52]['#']))
            {
                $reg_date = $irbis_reader_data[52]['#'];
            }
            else if(isset($irbis_reader_data[51]['#']))
            {
                $reg_date = $irbis_reader_data[51]['#'];
            }

            if($reg_date != NULL)
            {
                $reg_date = substr($reg_date, 0, 4).'-'.substr($reg_date, 4, 2).'-'.substr($reg_date, 6, 2);

                if(strtotime($reg_date) < strtotime(date('Y').'-09-01'))
                {
                    $this->content_data['tasks'][] = array(
                        'url' => $basic_url.'update_reader',
                        'title' => 'Перерегистрировать',
                        'classes' => array('action_executer')
                    );
                }
            }
        }
    }

    private function get_data($query_string, $by_id)
    {
        $this->db
            ->select('
                st.id, st.AVN_id, st.last_name, st.first_name,
                IFNULL(st.middle_name, "-") AS middle_name,
                st.username, IFNULL(st.number, "-") AS number,
                IF(st.gender = "м", "мужской", "женский") AS gender,
                IFNULL(DATE_FORMAT(st.birth_date, "%d.%m.%Y"), "-") AS birth_date,
                fc.faculty, sg.study_group, sf.study_form, st.photo,
                IF(st.payment_form = "к", "контракт", "бюджет") AS payment_form,
                IF(st.number IS NULL, "Не зарегистрирован", "Зарегистрирован") AS status', FALSE)
            ->join('study_groups AS sg', 'sg.id = study_group_id', 'left')
            ->join('faculties AS fc', 'fc.id = faculty_id', 'left')
            ->join('study_forms AS sf', 'sf.id = study_form_id', 'left');

        $by_id
            ? $this->db->where('st.id', $query_string)
            : $this->db->where('MATCH(st.last_name, st.first_name, st.middle_name, st.number) AGAINST("'.$query_string.'")');

        return $this->db->get('students AS st')->row_array();
    }

    public function get_content()
    {
        return $this->content_data;
    }
}