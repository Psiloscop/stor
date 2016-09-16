<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/12/16
 * Time: 8:48 PM
 */

class Change_reader_number_modal_model extends CI_Model
{
    private $content_data;

    public function init_content(array $content_params)
    {
        $base_url = $content_params['basic_content_url'];
        $reader_id = $content_params['reader_id'];
        $reader_number = $this->get_data($reader_id);

        $this->content_data = array(
            'template' => 'nick',
            'title' => '',
            'form' => array('url' => ''),
            'fields' => array(
                array('tag' => 'input', 'title' => 'Номер читательского билета', 'attributes' => array(
                    'id' => 'number', 'name' => 'number', 'value' => $reader_number, 'class' => 'form-control'
                ))
            ),
            'buttons' => array()
        );

        $this->content_data['title'] = 'Изменение номера ЧБ читателя';
        $this->content_data['form']['url'] = $base_url.'change_reader_number/'.$reader_id;

        $this->content_data['buttons'][] = array(
            'id' => 'add_user', 'title' => 'Изменить номер ЧБ', 'classes' => array('submit_modal')
        );
    }

    private function get_data($reader_id)
    {
        $reader_number = $this->db
            ->select('number')
            ->where('id', $reader_id)
            ->get('students')->row_array()['number'];

        return $reader_number;
    }

    public function get_content()
    {
        return $this->content_data;
    }
}