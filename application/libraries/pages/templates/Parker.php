<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/10/16
 * Time: 2:49 PM
 */

class Parker
{
    private $CI;

    private $path;
    private $template_data;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->path = 'templates/parker/';
    }

    public function init_template(array $data)
    {
        $this->template_data = $data;
    }

    public function get_content()
    {
        $this->CI->load->view($this->path.'Main_view', $this->template_data);
    }
}