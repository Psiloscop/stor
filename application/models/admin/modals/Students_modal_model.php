<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/7/16
 * Time: 9:59 PM
 */

class Students_modal_model extends CI_Model
{
    private $content_data;

    public function init_content(array $content_params)
    {
        $base_url = $content_params['basic_content_url'];

        $this->content_data = array(
            'template' => 'tomas',
            'title' => 'Загрузка студентов из AVN',
            'form' => array(
                'url' => $base_url.'get_students'
            ),
            'buttons' => array(
                array(
                    'id' => 'get_students',
                    'title' => 'Начать загрузку',
                    'classes' => array('get_students')
                )
            )
        );
    }

    public function get_content()
    {
        return $this->content_data;
    }
}