<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/10/16
 * Time: 3:50 PM
 */

require_once 'wraps/Claire.php';
require_once 'templates/Ada.php';

class Readers_page
{
    private $CI;

    private $wrap;
    private $template;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->wrap = new Claire();
        $this->template = new Ada();
    }

    public function init_page(array $wrap_data, array $content_data)
    {
        $this->wrap->init_header($wrap_data['header'] ?? array());
        $this->wrap->init_navigation($wrap_data['navigation'] ?? array());
        $this->wrap->init_footer($wrap_data['footer'] ?? array());

        $this->template->init_template($content_data);

        return $this;
    }

    public function get_page()
    {
        $this->wrap->above_part();

        $this->template->get_content();

        $this->wrap->below_part();
    }
}