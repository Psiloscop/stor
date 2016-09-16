<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/6/16
 * Time: 9:41 PM
 */

class Main extends SR_Controller
{
    private $basic_menu_url;

    public function __construct()
    {
        parent::__construct();
        parent::check_user();
    }

    public function index()
    {
        switch(parent::get_user_type())
        {
            case 'admin':
                $this->main_admin_page();
                break;
            case 'librarian':
                $this->main_librarian_page();
                break;
        }
    }

    private function main_admin_page()
    {
        $this->basic_menu_url = site_url().'/';

        $page_id = 'main';
        $page_name = 'Главная страница';

        $this->load->library('pages/Main_page');
        $this->load->model('admin/pages/wraps/Main_admin_wrap_model');

        $this->Main_admin_wrap_model->init_wrap($page_name, $this->basic_menu_url);

        $wrap = $this->Main_admin_wrap_model->get_wrap();

        $this->main_page
            ->init_page($wrap)
            ->get_page();
    }

    private function main_librarian_page()
    {
        $this->basic_menu_url = site_url().'/';

        $page_id = 'main';
        $page_name = 'Главная страница';

        $this->load->library('pages/Main_page');
        $this->load->model('librarian/pages/wraps/Main_librarian_wrap_model');

        $this->Main_librarian_wrap_model->init_wrap($page_name, $this->basic_menu_url);

        $wrap = $this->Main_librarian_wrap_model->get_wrap();

        $this->main_page
            ->init_page($wrap)
            ->get_page();
    }
}