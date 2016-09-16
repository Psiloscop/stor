<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/3/16
 * Time: 7:44 PM
 */

class Claire
{
    private $CI;

    private $path;

    private $header_data;
    private $navigation_data;
    private $footer_data;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->path = 'wraps/claire/';
    }

    public function get_authorization_page()
    {
        $this->CI->load->view('Authorization_view');
    }

    public function get_main_page()
    {
        $this->above_part();
        $this->below_part();
    }

    public function init_header(array $data)
    {
        $this->header_data = $data;

        return $this;
    }

    public function init_navigation(array $data)
    {
        $this->navigation_data = $data;

        return $this;
    }

    public function init_footer(array $data)
    {
        $this->footer_data = $data;

        return $this;
    }

    public function above_part()
    {
        $this->CI->load->view($this->path.'Html_open_view');
        $this->CI->load->view($this->path.'Header_view', $this->header_data);
        $this->CI->load->view($this->path.'Body_open_view');
        $this->CI->load->view($this->path.'Navigation_view', $this->navigation_data);
    }

    public function below_part()
    {
        $this->CI->load->view($this->path.'Modal_view');
        $this->CI->load->view($this->path.'Footer_view', $this->footer_data);
        $this->CI->load->view($this->path.'Body_close_view');
        $this->CI->load->view($this->path.'Html_close_view');
    }
}