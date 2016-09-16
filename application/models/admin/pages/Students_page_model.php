<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/10/16
 * Time: 2:56 PM
 */

class Students_page_model extends CI_Model
{
    private $content_data;

    public function init_content($content_params)
    {
        $basic_url = $content_params['basic_content_url'];

        $this->content_data = array(
            'template' => 'parker',
            'title' => 'Информация о загруженных студентах AVN',
            'items' => array(
                array('id' => 'student_count', 'title' => 'Количество студентов'),
                array('id' => 'registered_student_count', 'title' => 'Количество зарегистрированных студентов'),
                array('id' => 'last_downloading_date', 'title' => 'Дата последней загрузки студентов'),
                array('id' => 'last_downloading_count', 'title' => 'Количество добавленных студентов последней загрузки')
            ),
            'buttons' => array(
                array('id' => 'load_students', 'title' => 'Загрузить данные о студентах из AVN', 'url' => $basic_url.'modal',
                    'classes' => array('modal_getter'))
            ),
            'data' => $this->get_data()
        );
    }

    private function get_data()
    {
        $student_data = $this->db
            ->select('COUNT(st.id) AS student_count,
                SUM(IF(st.number IS NOT NULL, 1, 0)) AS registered_student_count', FALSE)
            ->from('students AS st')
            ->get()->row_array();

        $downloading_data = $this->db
            ->select('dj.downloading_count AS last_downloading_count,
                DATE_FORMAT(dj.downloading_date, "%d.%m.%Y") AS last_downloading_date', FALSE)
            ->from('downloading_journal AS dj')
            ->order_by('dj.downloading_date', 'desc')
            ->limit(1)
            ->get()->row_array();

        return array_merge($student_data, $downloading_data ?? array());
    }

    public function get_content()
    {
        return $this->content_data;
    }
}