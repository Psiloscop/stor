<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/3/16
 * Time: 8:20 PM
 */

require_once 'wraps/Claire.php';
require_once 'templates/James.php';

class Users_page
{
    private $CI;

    private $wrap;
    private $template;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->wrap = new Claire();
        $this->template = new James();
    }

    public function init_page(array $wrap_data, array $content_data)
    {
        $this->wrap->init_header($wrap_data['header'] ?? array());
        $this->wrap->init_navigation($wrap_data['navigation'] ?? array());
        $this->wrap->init_footer($wrap_data['footer'] ?? array());

        $this->template->init_template($content_data);

        return $this;
    }

    public function init_page_content(array $content_data, $init_pagination = TRUE)
    {
        $this->template->init_template($content_data, $init_pagination);

        return $this;
    }

    public function get_page()
    {
        $this->wrap->above_part();

        $this->template->get_content();

        $this->wrap->below_part();
    }

    public function get_page_table()
    {
        $this->template->get_table();
    }

    public function get_page_table_row($get_html_directly = FALSE)
    {
        return $this->template->get_table_row($get_html_directly);
    }
}