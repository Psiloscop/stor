<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/6/16
 * Time: 12:16 PM
 */

class Users_modal_model extends CI_Model
{
    private $content_data;

    public function init_content(array $content_params)
    {
        $base_url = $content_params['basic_content_url'];
        
        $this->content_data = array(
            'template' => 'nick',
            'title' => '',
            'form' => array('url' => ''),
            'fields' => array(
                array('tag' => 'input', 'title' => 'ФИО', 'attributes' => array(
                    'id' => 'FIO', 'name' => 'FIO', 'class' => 'form-control'
                )),
                array('tag' => 'input', 'title' => 'Псевдоним', 'attributes' => array(
                    'id' => 'username', 'name' => 'username', 'class' => 'form-control'
                )),
                array('tag' => 'input', 'title' => 'Пароль', 'attributes' => array(
                    'id' => 'password', 'name' => 'password', 'class' => 'form-control'
                )),
                array('tag' => 'select', 'id' => 'usertype', 'name' => 'usertype', 'title' => 'Право',
                    'options' => array('admin' => 'Администратор', 'librarian' => 'Библиотекарь', 'both' => 'Обе роли'),
                    'attributes' => array('id' => 'usertype', 'class' => 'form-control')
                )
            ),
            'buttons' => array()
        );

        $this->content_data['title'] = 'Добавление нового пользователя';
        $this->content_data['form']['url'] = $base_url.'add_user';

        $this->content_data['buttons'][] = array(
            'id' => 'add_user', 'title' => 'Сохранить пользователя', 'classes' => array('submit_modal')
        );
    }

    public function get_content()
    {
        return $this->content_data;
    }
}