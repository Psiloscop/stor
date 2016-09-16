<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/3/16
 * Time: 8:20 PM
 */

require_once 'wraps/Claire.php';

class Main_page
{
    private $CI;

    private $wrap;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->wrap = new Claire();
    }

    public function init_page(array $wrap_data)
    {
        $this->wrap->init_header($wrap_data['header'] ?? array());
        $this->wrap->init_navigation($wrap_data['navigation'] ?? array());
        $this->wrap->init_footer($wrap_data['footer'] ?? array());

        return $this;
    }

    public function get_page()
    {
        $this->wrap->above_part();
        $this->wrap->below_part();
    }
}