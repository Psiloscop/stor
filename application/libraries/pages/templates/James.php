<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/5/16
 * Time: 12:36 PM
 */

class James
{
    private $CI;

    private $path;
    private $template_data;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->path = 'templates/james/';
    }

    public function init_template(array $data, $init_pagination = TRUE)
    {
        if($init_pagination)
        {
            $this->CI->load->library('pagination');

            $this->CI->pagination->initialize(array(
                'total_rows' => $data['row_count'],

                'base_url' => $data['pagination']['pagination_url'],
                'cur_page' => $data['pagination']['current_page'],
                'per_page' => $data['pagination']['per_page'],
                'uri_segment' => $data['pagination']['uri_segment'],

                'reuse_query_string' => TRUE,

                'full_tag_open' => '<ul class="pagination">',
                'full_tag_close' => '</ul>',
                'first_tag_open' => '<li>',
                'first_tag_close' => '</li>',
                'last_tag_open' => '<li>',
                'last_tag_close' => '</li>',
                'next_tag_open' => '<li>',
                'next_tag_close' => '</li>',
                'prev_tag_open' => '<li>',
                'prev_tag_close' => '</li>',
                'num_tag_open' => '<li>',
                'num_tag_close' => '</li>',

                'cur_tag_open' => '<li class="active"><a href="#">',
                'cur_tag_close' => '</a></li>',

                'first_link' => 'В начало',
                'last_link' => 'В конец'
            ));
        }

        $this->template_data = $data;
    }

    public function get_content()
    {
        $this->CI->load->view($this->path.'Main_view', $this->template_data);
    }

    public function get_table()
    {
        $this->CI->load->view($this->path.'Table_view', $this->template_data);
    }

    public function get_table_row($get_html_directly = FALSE)
    {
        return $this->CI->load->view($this->path.'Table_row_view', $this->template_data, $get_html_directly);
    }
}