<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/9/16
 * Time: 1:46 PM
 */

require_once 'templates/John.php';

class Users_row
{
    private $CI;

    private $template;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->template = new John();
    }

    public function init_row(array $content_data)
    {
        $this->template->init_template($content_data);

        return $this;
    }

    public function get_row()
    {
        $this->template->get_content();
    }
}