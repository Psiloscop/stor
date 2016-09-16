<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/10/16
 * Time: 2:56 PM
 */

class Readers_page_model extends CI_Model
{
    private $content_data;

    public function init_content($content_params)
    {
        $basic_url = $content_params['basic_content_url'];

        $this->content_data = array(
            'template' => 'ada',
            'url' => $basic_url.'search_readers',
            'title' => 'Поиск читателей'
        );
    }

    public function get_content()
    {
        return $this->content_data;
    }
}