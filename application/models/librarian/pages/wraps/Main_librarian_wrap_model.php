<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/5/16
 * Time: 2:58 PM
 */

class Main_librarian_wrap_model extends CI_Model
{
    private $wrap;

    private $role = 'Библиотекарь';
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
                        'nav_id' => 'nav_readers',
                        'page_id' => 'readers',
                        'title' => 'Читатели',
                        'ref' => $base_menu_url.'readers'
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