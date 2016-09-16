<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/6/16
 * Time: 12:16 PM
 */

class Users_row_model extends CI_Model
{
    private $content_data;

    public function init_content(array $content_params, $user_id)
    {
        $base_url = $content_params['basic_content_url'];
        
        $this->content_data = array(
            'template' => 'john',
            'fields' => array(
                array('tag' => 'input', 'attributes' => array(
                    'id' => 'FIO', 'name' => 'FIO', 'class' => 'form-control'
                )),
                array('tag' => 'input', 'attributes' => array(
                    'id' => 'username', 'name' => 'username', 'class' => 'form-control'
                )),
                array('tag' => 'input', 'attributes' => array(
                    'id' => 'password', 'name' => 'password', 'class' => 'form-control'
                )),
                array('tag' => 'select', 'id' => 'usertype', 'name' => 'usertype',
                    'options' => array('admin' => 'Администратор', 'librarian' => 'Библиотекарь', 'both' => 'Обе роли'),
                    'attributes' => array('id' => 'usertype', 'class' => 'form-control')
                )
            ),
            'dd_items' => array()
        );

        $user_data = $this->init_data($user_id);

        $this->content_data['dd_items'][] = array(
            'id' => 'edit_user', 'title' => 'Изменить данные о пользователе',
            'classes' => array('submit_row'), 'url' => $base_url.'edit_user/'.$user_id
        );
        $this->content_data['dd_items'][] = array(
            'id' => 'cancel_editing', 'title' => 'Отменить редактирование',
            'classes' => array('submit_row'), 'url' => $base_url.'row/'.$user_id.'/1'
        );

        for($index = 0, $count = count($this->content_data['fields']); $index < $count; $index++)
        {
            if($this->content_data['fields'][$index]['tag'] === 'input')
            {
                $this->content_data['fields'][$index]['attributes']['value'] =
                    $user_data[$this->content_data['fields'][$index]['attributes']['id']];
            }
            else if($this->content_data['fields'][$index]['tag'] === 'select')
            {
                $this->content_data['fields'][$index]['selected'] =
                    $user_data[$this->content_data['fields'][$index]['attributes']['id']];
            }
        }
    }

    private function init_data($user_id)
    {
        return $this->db
            ->select('us.id, us.FIO, us.username, us.password, us.usertype')
            ->from('users AS us')
            ->where('id', $user_id)
            ->get()->row_array();
    }

    public function get_content()
    {
        return $this->content_data;
    }
}