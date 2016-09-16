<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/5/16
 * Time: 2:37 PM
 */

class Authorization_page
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function get_page()
    {
        $this->CI->load->view('pages/Authorization_view');
    }
}