<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/10/16
 * Time: 12:57 PM
 */

class Willy
{
    private $CI;

    private $path;
    private $template_data;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->path = 'templates/willy/';
    }

    public function init_template(array $data)
    {
        $this->template_data = $data;
    }

    public function get_content()
    {
        return $this->CI->load->view($this->path.'Search_result_view', $this->template_data, TRUE);
    }
}