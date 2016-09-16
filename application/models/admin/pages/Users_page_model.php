<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/5/16
 * Time: 3:06 PM
 */

class Users_page_model extends CI_Model
{
    private $content_data;

    public function init_content(array $content_params, array $db_params)
    {
        $basic_url = $content_params['basic_content_url'];

        $this->content_data = array(
            'template' => 'james',
            'title' => 'Пользователи системы StoR',
            'fields' => array(
                array('id' => 'FIO', 'title' => 'ФИО'),
                array('id' => 'username', 'title' => 'Псевдоним'),
                array('id' => 'password', 'title' => 'Пароль'),
                array('id' => 'usertype', 'title' => 'Право')
            ),
            'row_ids' => array('id'),
            'row_actions' => array(
                array('id' => 'edit_user', 'title' => 'Редактировать', 'url' => $basic_url.'row',
                    'classes' => array('row_getter')),
                array('id' => 'del_user', 'title' => 'Удалить', 'url' => $basic_url.'message/del',
                    'classes' => array('del_user'))
            ),
            'menu_actions' => array(
                array('id' => 'add_user', 'title' => 'Добавить пользователя', 'url' => $basic_url.'modal',
                    'classes' => array('modal_getter'))
            ),
            'row_count' => $this->get_data($db_params, TRUE),
            'row_data' => $this->get_data($db_params, FALSE)
        );
    }

    private function get_data(array $db_params, $count_rows = FALSE)
    {
        $this->db
            ->select('us.id, us.FIO, us.username, @a := "******" AS password, us.usertype', FALSE)
            ->from('users AS us');

        if(isset($db_params['filter']['id']))
        {
            $this->db->where('us.id', $db_params['filter']['id']);
        }

        if(isset($db_params['filter']['usertype']))
        {
            $this->db->where('us.usertype', $db_params['filter']['usertype']);
        }

        if(!$count_rows)
        {
            $limit = $db_params['pagination']['limit'] ?? NULL;
            $offset = $db_params['pagination']['offset'] ?? NULL;

            $this->db->limit($limit, $offset);
        }

        return $count_rows ? $this->db->count_all_results() : $this->db->get()->result_array();
    }

    public function get_content()
    {
        return $this->content_data;
    }
}