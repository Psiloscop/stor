<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/11/16
 * Time: 4:36 PM
 */

require_once 'templates/Harry.php';

class Reader_info_table
{
    private $CI;

    private $template;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->template = new Harry();
    }

    public function init_info_table(array $content_data)
    {
        $this->template->init_template($content_data);

        return $this;
    }

    public function get_info_table()
    {
        return $this->template->get_content();
    }
}