<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/6/16
 * Time: 11:20 AM
 */

class Nick
{
    private $CI;

    private $path;
    private $template_data;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->path = 'templates/nick/';
    }

    public function init_template(array $data)
    {
        $this->CI->load->helper('form');

        $this->template_data = $data;
    }

    public function get_content()
    {
        $this->CI->load->view($this->path.'Modal_view', $this->template_data);
    }
}