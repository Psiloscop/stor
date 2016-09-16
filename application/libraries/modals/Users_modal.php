<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/6/16
 * Time: 2:53 PM
 */

require_once 'templates/Nick.php';

class Users_modal
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