<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/10/16
 * Time: 12:54 PM
 */

require_once 'templates/Willy.php';

class Readers_search_result
{
    private $CI;

    private $template;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->template = new Willy();
    }

    public function init_search_result(array $content_data)
    {
        $this->template->init_template($content_data);

        return $this;
    }

    public function get_search_result()
    {
        return $this->template->get_content();
    }
}