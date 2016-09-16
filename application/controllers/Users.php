<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/3/16
 * Time: 7:48 PM
 */

class Users extends SR_Controller
{
    private $page_id;
    private $page_name;

    private $basic_menu_url;
    private $basic_content_url;

    private $validation_rules;

    private $row_limit;
    private $pagination_segment;

    public function __construct()
    {
        parent::__construct();
        parent::check_user();

        $this->page_id = 'users';
        $this->page_name = 'Пользователи системы';

        $this->basic_menu_url = site_url().'/';
        $this->basic_content_url = site_url().'/users/';

        $this->validation_rules = array(
            array(
                'field' => 'FIO',
                'label' => 'ФИО',
                'rules' => 'required|max_length[50]'
            ),
            array(
                'field' => 'username',
                'label' => 'Псевдоним',
                'rules' => 'required|max_length[15]'
            ),
            array(
                'field' => 'password',
                'label' => 'Пароль',
                'rules' => 'required|max_length[15]'
            ),
            array(
                'field' => 'usertype',
                'label' => 'Право',
                'rules' => 'required|in_list[librarian,admin,both]'
            )
        );

        $this->row_limit = 10;
        $this->pagination_segment = 3;
    }

    public function index()
    {
        $this->load->library('pages/Users_page');
        $this->load->model(array(
            'admin/pages/wraps/Main_admin_wrap_model',
            'admin/pages/Users_page_model'
        ));

        if(parent::get_user_type() === 'librarian')
        {
            redirect(base_url());
        }

        $db_params = array(
            'pagination' => array(
                'limit' => $this->row_limit,
                'offset' => 0
            )
        );
        $content_params = array(
            'page_id' => $this->page_id,
            'basic_content_url' => $this->basic_content_url
        );

        $this->Main_admin_wrap_model->init_wrap($this->page_name, $this->basic_menu_url);
        $this->Users_page_model->init_content($content_params, $db_params);

        $wrap = $this->Main_admin_wrap_model->get_wrap();
        $content = $this->Users_page_model->get_content();

        for($index = 0, $count = count($wrap['navigation']['menus']); $index < $count; $index++)
        {
            $wrap['navigation']['menus'][$index]['selected'] =
                ($wrap['navigation']['menus'][$index]['page_id'] === $this->page_id) ? TRUE : FALSE;
        }

        $wrap['header']['js_files'] = array(
            base_url(JS_DIRECTORY.'modal_getter.js'),
            base_url(JS_DIRECTORY.'modal_form_john.js'),
            base_url(JS_DIRECTORY.'row_getter.js'),
            base_url(JS_DIRECTORY.'row_form.js'),
            base_url(JS_DIRECTORY.'pagination.js'),
            base_url(JS_DIRECTORY.'deletion.js')
        );

        $content['pagination'] = array(
            'per_page' => $this->row_limit,
            'uri_segment' => $this->pagination_segment,
            'current_page' => 0,
            'pagination_url' => $this->basic_content_url.'page'

        );

        $this->users_page
            ->init_page($wrap, $content)
            ->get_page();
    }


    public function page()
    {
        if($this->input->is_ajax_request())
        {
            $this->load->library('pages/Users_page');
            $this->load->model('admin/pages/Users_page_model');

            $db_params = array(
                'pagination' => array(
                    'limit' => $this->row_limit,
                    'offset' => $this->uri->segment($this->pagination_segment, 0)
                )
            );
            $content_params = array(
                'page_id' => $this->page_id,
                'basic_content_url' => $this->basic_content_url
            );

            $this->Users_page_model->init_content($content_params, $db_params);

            $content = $this->Users_page_model->get_content();

            $content['pagination'] = array(
                'per_page' => $this->row_limit,
                'uri_segment' => $this->pagination_segment,
                'current_page' => $this->uri->segment($this->pagination_segment, 0),
                'pagination_url' => $this->basic_content_url.'page'

            );

            $this->users_page
                ->init_page_content($content)
                ->get_page_table();
        }
        else
        {
            redirect(site_url());
        }
    }

    public function modal()
    {
        if($this->input->is_ajax_request())
        {
            $content_params = array(
                'basic_content_url' => $this->basic_content_url,
            );

            $this->load->library('modals/Users_modal');
            $this->load->model('admin/modals/Users_modal_model');

            $this->Users_modal_model->init_content($content_params);

            $content = $this->Users_modal_model->get_content();

            $this->users_modal
                ->init_modal($content)
                ->get_modal();
        }
        else
        {
            redirect(site_url());
        }
    }

    public function row($user_id, $cancel_editing = NULL)
    {
        if($this->input->is_ajax_request())
        {
            if($cancel_editing)
            {
                $result = array(
                    'success' => TRUE,
                    'html' => $this->get_html_row($user_id)
                );

                echo json_encode($result);

                return;
            }

            $content_params = array(
                'basic_content_url' => $this->basic_content_url,
            );

            $this->load->library('rows/Users_row');
            $this->load->model('admin/rows/Users_row_model');

            $this->Users_row_model->init_content($content_params, $user_id);

            $content = $this->Users_row_model->get_content();

            $this->users_row
                ->init_row($content)
                ->get_row();
        }
        else
        {
            redirect(site_url());
        }
    }

    public function message($message_id, $user_id = NULL)
    {
        $result = array();

        switch($message_id)
        {
            case 'del':
                $this->load->model('admin/data/Users_data_model');

                $user_data = $this->Users_data_model->get_user_data($user_id);

                $result['message'] = 'Вы действительно хотите удалить пользователя '.$user_data['FIO'].' из системы StoR?';
                $result['url'] = $this->basic_content_url.'del_user/'.$user_id;

                echo json_encode($result);

                break;
        }
    }


    public function add_user()
    {
        if($this->input->is_ajax_request())
        {
            $validation_result = parent::validate_data($this->validation_rules);

            if($validation_result)
            {
                $this->load->model('admin/data/Users_data_model');

                $user_data = parent::get_validated_data($this->validation_rules);

                $user_id = $this->Users_data_model->add_user($user_data);

                $result = array(
                    'success' => TRUE,
                    'html' => $this->get_html_row($user_id)
                );
            }
            else
            {
                $result = array(
                    'success' => FALSE,
                    'errors' => parent::get_validation_errors($this->validation_rules)
                );
            }

            echo json_encode($result);
        }
        else
        {
            redirect(site_url());
        }
    }

    public function edit_user($user_id)
    {
        if($this->input->is_ajax_request())
        {
            $validation_result = parent::validate_data($this->validation_rules);

            if($validation_result)
            {
                $this->load->model('admin/data/Users_data_model');

                $user_data = parent::get_validated_data($this->validation_rules);

                $this->Users_data_model->update_user($user_id, $user_data);

                $result = array(
                    'success' => TRUE,
                    'html' => $this->get_html_row($user_id)
                );
            }
            else
            {
                $result = array(
                    'success' => FALSE,
                    'errors' => parent::get_validation_errors($this->validation_rules)
                );
            }

            echo json_encode($result);
        }
        else
        {
            redirect(site_url());
        }
    }

    public function del_user($user_id)
    {
        if($this->input->is_ajax_request())
        {
            $this->load->model('admin/data/Users_data_model');

            $user_data = $this->session->userdata('user_data');

            $result = array();

            if($user_data['id'] != $user_id)
            {
                $this->Users_data_model->del_user($user_id);

                $result['success'] = TRUE;
                $result['message'] = 'Пользователь удалён';
            }
            else
            {
                $result['success'] = FALSE;
                $result['message'] = 'Вы не можете удалить своего пользователя';
            }

            echo json_encode($result);
        }
        else
        {
            redirect(site_url());
        }
    }

    private function get_html_row($user_id)
    {
        $this->load->library('pages/Users_page');
        $this->load->model('admin/pages/Users_page_model');

        $db_params = array(
            'filter' => array('id' => $user_id)
        );
        $content_params = array(
            'page_id' => $this->page_id,
            'basic_content_url' => $this->basic_content_url
        );

        $this->Users_page_model->init_content($content_params, $db_params);

        $content = $this->Users_page_model->get_content();

        return $this->users_page->init_page_content($content, FALSE)->get_page_table_row(TRUE);
    }
}