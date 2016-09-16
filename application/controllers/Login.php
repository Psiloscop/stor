<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function index()
    {
        $user_information = $this->session->userdata('user_data');

        if($this->input->is_ajax_request())
        {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if(!empty($username) && !empty($password))
            {
                $result = $this->set_user($username, $password);
            }
            else
            {
                $result = array(
                    'success' => FALSE,
                    'message' => 'Оба поля должны быть заполнены'
                );
            }

            echo json_encode($result);
        }
        else
        {
            empty($user_information) ? $this->get_authorization_page() : redirect(site_url());
        }
    }

    private function set_user($username, $password)
    {
        $this->load->model('Authorization_model');

        $result = array();

        try
        {
            $result['success'] = TRUE;

            $user = $this->Authorization_model->get_user_data($username, $password);

            $user['reg_time'] = date('Y-m-d H:i:s');

            $this->session->set_userdata(array(
                'user_data' => $user
            ));
        }
        catch(User_auth_exception $exception)
        {
            $result['success'] = FALSE;
            $result['message'] = $exception->getMessage();
        }

        return $result;
    }

    private function get_authorization_page()
    {
        $this->load->library('pages/Authorization_page');

        $this->authorization_page->get_page();
    }
}