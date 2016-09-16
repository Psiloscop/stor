<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/11/16
 * Time: 4:37 PM
 */

class Harry
{
    private $CI;

    private $path;
    private $template_data;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->path = 'templates/harry/';
    }

    public function init_template(array $data)
    {
        $this->template_data = $data;
    }

    public function get_content()
    {
        return $this->CI->load->view($this->path.'Info_table_view', $this->template_data, TRUE);
    }
}