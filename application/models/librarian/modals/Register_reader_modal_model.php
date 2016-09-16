<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/12/16
 * Time: 8:48 PM
 */

class Register_reader_modal_model extends CI_Model
{
    private $content_data;

    public function init_content(array $content_params)
    {
        $base_url = $content_params['basic_content_url'];
        $reader_id = $content_params['reader_id'];

        $this->content_data = array(
            'template' => 'nick',
            'title' => '',
            'form' => array('url' => ''),
            'fields' => array(
                array('tag' => 'input', 'title' => 'Номер читательского билета', 'attributes' => array(
                    'id' => 'number', 'name' => 'number', 'class' => 'form-control'
                ))
            ),
            'buttons' => array()
        );

        $this->content_data['title'] = 'Регистрация читателя';
        $this->content_data['form']['url'] = $base_url.'register_reader/'.$reader_id;

        $this->content_data['buttons'][] = array(
            'id' => 'add_user', 'title' => 'Зарегистрировать', 'classes' => array('submit_modal')
        );
    }

    public function get_content()
    {
        return $this->content_data;
    }
}