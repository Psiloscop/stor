<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/10/16
 * Time: 12:30 PM
 */

class Students extends SR_Controller
{
    private $page_id;
    private $page_name;

    private $basic_menu_url;
    private $basic_content_url;

    public function __construct()
    {
        parent::__construct();
        parent::check_user();

        if(parent::get_user_type() === 'librarian')
        {
            redirect(base_url());
        }

        $this->page_id = 'students';
        $this->page_name = 'Студенты AVN';

        $this->basic_menu_url = site_url().'/';
        $this->basic_content_url = site_url().'/students/';
    }

    public function index()
    {
        $this->load->library('pages/Students_page');
        $this->load->model(array(
            'admin/pages/wraps/Main_admin_wrap_model',
            'admin/pages/Students_page_model'
        ));

        $db_params = array();
        $content_params = array(
            'page_id' => $this->page_id,
            'basic_content_url' => $this->basic_content_url
        );

        $this->Main_admin_wrap_model->init_wrap($this->page_name, $this->basic_menu_url);
        $this->Students_page_model->init_content($content_params, $db_params);

        $wrap = $this->Main_admin_wrap_model->get_wrap();
        $content = $this->Students_page_model->get_content();

        for($index = 0, $count = count($wrap['navigation']['menus']); $index < $count; $index++)
        {
            $wrap['navigation']['menus'][$index]['selected'] =
                ($wrap['navigation']['menus'][$index]['page_id'] === $this->page_id) ? TRUE : FALSE;
        }

        $wrap['header']['js_files'] = array(
            base_url(JS_DIRECTORY.'modal_getter.js'),
            base_url(JS_DIRECTORY.'modal_form_john.js'),
            base_url(JS_DIRECTORY.'student_getter.js')
        );

        $this->students_page
            ->init_page($wrap, $content)
            ->get_page();
    }

    public function modal()
    {
        if($this->input->is_ajax_request())
        {
            $content_params = array(
                'basic_content_url' => $this->basic_content_url,
            );

            $this->load->library('modals/Students_modal');
            $this->load->model('admin/modals/Students_modal_model');

            $this->Students_modal_model->init_content($content_params);

            $content = $this->Students_modal_model->get_content();

            $this->students_modal
                ->init_modal($content)
                ->get_modal();
        }
        else
        {
            redirect(site_url());
        }
    }


    public function get_students()
    {
        $this->load->model(array(
            'api/Avn_api',
            'admin/data/Downloading_journal_model'
        ));

        $student_count = 0;
        $semester_count = 10;

        for($current_semester = 1; $current_semester <= $semester_count; $current_semester++)
        {
            $student_count += $this->Avn_api->get_students($current_semester);

            echo json_encode(array(
                'current' => $current_semester,
                'amount' => $semester_count,
                'count' => $student_count
            ));

            ob_flush();
            flush();
        }

        $this->Downloading_journal_model->add_download_info($student_count);
    }
}