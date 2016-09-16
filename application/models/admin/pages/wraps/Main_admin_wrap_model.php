<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/5/16
 * Time: 2:58 PM
 */

class Main_admin_wrap_model extends CI_Model
{
    private $wrap;

    private $role = 'Администратор';
    private $separator = ' :: ';

    public function init_wrap($page_name, $base_menu_url)
    {
        $this->wrap = array(
            'header' => array(
                'title' => 'StoR' . $this->separator . $this->role . $this->separator . $page_name
            ),
            'navigation' => array(
                'title' => 'StoR',
                'menus' => array(
                    array(
                        'nav_id' => 'nav_students',
                        'page_id' => 'students',
                        'title' => 'Студенты',
                        'ref' => $base_menu_url.'students'
                    ),
                    array(
                        'nav_id' => 'nav_users',
                        'page_id' => 'users',
                        'title' => 'Пользователи',
                        'ref' => $base_menu_url.'users'
                    ),
                    array(
                        'nav_id' => 'nav_settings',
                        'page_id' => 'settings',
                        'title' => 'Настройки',
                        'items' => array(
                            array(
                                'id' => 'item_irbis64',
                                'title' => 'Соединение с САБ ИРБИС64',
                                'ref' => $base_menu_url.'irbis64'
                            )
                        )
                    )
                )
            )
        );
    }

    public function get_wrap()
    {
        return $this->wrap;
    }
}