<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/13/16
 * Time: 1:48 AM
 */

require_once 'templates/Nick.php';

class Change_reader_number_modal
{
    private $CI;

    private $template;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->template = new Nick();
    }

    public function init_modal(array $content_data)
    {
        $this->template->init_template($content_data);

        return $this;
    }

    public function get_modal()
    {
        $this->template->get_content();
    }
}