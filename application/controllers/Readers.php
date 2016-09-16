<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 7/10/16
 * Time: 12:30 PM
 */

class Readers extends SR_Controller
{
    private $page_id;
    private $page_name;

    private $basic_menu_url;
    private $basic_content_url;

    private $validation_rules;

    public function __construct()
    {
        parent::__construct();
        parent::check_user();

        if(parent::get_user_type() === 'admin')
        {
            redirect(base_url());
        }

        $this->page_id = 'readers';
        $this->page_name = 'Читатели ИРБИС64';

        $this->basic_menu_url = site_url().'/';
        $this->basic_content_url = site_url().'/readers/';

        $this->validation_rules = array(
            array(
                'field' => 'number',
                'label' => 'Номер читательского билета',
                'rules' => array('required', 'max_length[10]',array('check_reader_number', function($reader_number){
                    $this->load->model('api/Irbis_functions');

                    $reader_data = $this->Irbis_functions->get_reader_data($reader_number);

                    if($reader_data != NULL)
                    {
                        $this->form_validation->set_message(
                            'check_reader_number',
                            'Читательский номер '.$reader_number.' занят другим читателем'
                        );

                        return FALSE;
                    }

                    return TRUE;
                }))
            )
        );
    }

    public function index()
    {
        $this->load->library('pages/Readers_page');
        $this->load->model(array(
            'librarian/pages/wraps/Main_librarian_wrap_model',
            'librarian/pages/Readers_page_model'
        ));

        $db_params = array();
        $content_params = array(
            'page_id' => $this->page_id,
            'basic_content_url' => $this->basic_content_url
        );

        $this->Main_librarian_wrap_model->init_wrap($this->page_name, $this->basic_menu_url);
        $this->Readers_page_model->init_content($content_params, $db_params);

        $wrap = $this->Main_librarian_wrap_model->get_wrap();
        $content = $this->Readers_page_model->get_content();

        for($index = 0, $count = count($wrap['navigation']['menus']); $index < $count; $index++)
        {
            $wrap['navigation']['menus'][$index]['selected'] =
                ($wrap['navigation']['menus'][$index]['page_id'] === $this->page_id) ? TRUE : FALSE;
        }

        $wrap['header']['js_files'] = array(
            base_url(JS_DIRECTORY.'modal_getter.js'),
            base_url(JS_DIRECTORY.'modal_form_harry.js'),
            base_url(JS_DIRECTORY.'typeahead.js'),
            base_url(JS_DIRECTORY.'reader_searcher.js'),
            base_url(JS_DIRECTORY.'action_executer.js')
        );

        $wrap['header']['css_files'] = array(
            base_url(CSS_DIRECTORY.'typeahead.css'),
            base_url(CSS_DIRECTORY.'ajax_sign.css')
        );

        $this->readers_page
            ->init_page($wrap, $content)
            ->get_page();
    }


    public function register_reader_modal($reader_id)
    {
        if($this->input->is_ajax_request())
        {
            $content_params = array(
                'basic_content_url' => $this->basic_content_url,
                'reader_id' => $reader_id
            );

            $this->load->library('modals/Register_reader_modal');
            $this->load->model('librarian/modals/Register_reader_modal_model');

            $this->Register_reader_modal_model->init_content($content_params);

            $content = $this->Register_reader_modal_model->get_content();

            $this->register_reader_modal
                ->init_modal($content)
                ->get_modal();
        }
        else
        {
            redirect(site_url());
        }
    }

    public function change_reader_number_modal($reader_id)
    {
        if($this->input->is_ajax_request())
        {
            $content_params = array(
                'basic_content_url' => $this->basic_content_url,
                'reader_id' => $reader_id
            );

            $this->load->library('modals/Change_reader_number_modal');
            $this->load->model('librarian/modals/Change_reader_number_modal_model');

            $this->Change_reader_number_modal_model->init_content($content_params);

            $content = $this->Change_reader_number_modal_model->get_content();

            $this->change_reader_number_modal
                ->init_modal($content)
                ->get_modal();
        }
        else
        {
            redirect(site_url());
        }
    }


    public function search_readers()
    {
        if($this->input->is_ajax_request())
        {
            $this->load->model('librarian/data/Readers_data_model');

            $query = $this->input->post('query');

            $reader_count = $this->Readers_data_model->get_reader_count($query);

            if($reader_count == 0)
            {
                echo json_encode(array(
                    'type' => 'search_result',
                    'html' => ''
                ));
            }
            else if($reader_count > 1)
            {
                $this->load->library('search_results/Readers_search_result');
                $this->load->model('librarian/search_results/Reader_search_result_model');

                $this->Reader_search_result_model->init_content($query);

                $content = $this->Reader_search_result_model->get_content();

                for($index = 0, $count = count($content['data']); $index < $count; $index++)
                {
                    $content['data'][$index]['FIO'] = mb_strtoupper($content['data'][$index]['FIO']);

                    $content['data'][$index]['url'] = $this->basic_content_url.'get_reader_data/'.$content['data'][$index]['id'];
                }

                $html = $this->readers_search_result
                    ->init_search_result($content)
                    ->get_search_result();

                echo json_encode(array(
                    'type' => 'search_result',
                    'html' => $html
                ));
            }
            else
            {
                echo json_encode(array(
                    'type' => 'reader_info',
                    'html' => $this->get_reader_data($query, FALSE, TRUE)
                ));
            }
        }
        else
        {
            redirect(site_url());
        }
    }

    public function get_reader_data($reader_id, $by_id = TRUE, $return = FALSE)
    {
        $this->load->library('info_tables/Reader_info_table');
        $this->load->model('librarian/info_tables/Reader_info_table_model');

        $content_params = array(
            'basic_content_url' => $this->basic_content_url
        );

        $db_params = array(
            'query_string' => $reader_id,
            'by_id' => $by_id
        );

        try
        {
            $this->Reader_info_table_model->init_content($content_params, $db_params);

            $content = $this->Reader_info_table_model->get_content();

            if($content['data']['photo'] == NULL)
            {
                $this->load->model('api/Avn_api');

                $photo_name = $this->Avn_api->get_student_photo($content['data']['AVN_id'])
                    ?? 'no-image-available.png';

                $content['data']['photo'] = $photo_name;
            }

            $content['data']['photo'] = base_url(PHOTO_FOLDER.$content['data']['photo'] );

            $html = $this->reader_info_table
                ->init_info_table($content)
                ->get_info_table();
        }
        catch(Irbis_exception $e)
        {
            http_response_code(500);

            exit($e->getMessage());
        }

        if($return)
        {
            return $html;
        }

        echo json_encode(array(
            'type' => 'reader_info',
            'html' => $html
        ));

        return NULL;
    }

    public function register_reader($reader_id)
    {
        if($this->input->is_ajax_request())
        {
            $validation_result = parent::validate_data($this->validation_rules);

            if($validation_result)
            {
                $this->load->model('librarian/data/Readers_data_model');

                $reader_number = $this->input->post('number');

                try
                {
                    $this->Readers_data_model->register_reader_to_irbis($reader_id, $reader_number);
                }
                catch(Irbis_exception $e)
                {
                    http_response_code(500);

                    exit($e->getMessage());
                }

                $result = array(
                    'success' => TRUE,
                    'html' => $this->get_reader_data($reader_id, TRUE, TRUE)
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

    public function update_reader($reader_id)
    {
        if($this->input->is_ajax_request())
        {
            $this->load->model('librarian/data/Readers_data_model');

            try
            {
                $this->Readers_data_model->update_reader_to_irbis($reader_id);
            }
            catch(Irbis_exception $e)
            {
                http_response_code(500);

                exit($e->getMessage());
            }

            $result = array(
                'success' => TRUE,
                'message' => 'Читатель перерегистирован',
                'class' => 'reader_section',
                'html' => $this->get_reader_data($reader_id, TRUE, TRUE)
            );

            echo json_encode($result);
        }
        else
        {
            redirect(site_url());
        }
    }

    public function change_reader_number($reader_id)
    {
        if($this->input->is_ajax_request())
        {
            $validation_result = parent::validate_data($this->validation_rules);

            if($validation_result)
            {
                $this->load->model('librarian/data/Readers_data_model');

                $reader_number = $this->input->post('number');

                try
                {
                    $this->Readers_data_model->change_reader_number($reader_id, $reader_number);
                }
                catch(Irbis_exception $e)
                {
                    http_response_code(500);

                    exit($e->getMessage());
                }

                $result = array(
                    'success' => TRUE,
                    'html' => $this->get_reader_data($reader_id, TRUE, TRUE)
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
}