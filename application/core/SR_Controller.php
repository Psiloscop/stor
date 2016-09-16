<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SR_Controller extends CI_Controller
{
    protected function validate_data($validation_rules)
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules($validation_rules);

        return $this->form_validation->run();
    }

    protected function get_validated_data($validation_rules)
    {
        $validated_data = array();

        foreach($validation_rules as $vr)
        {
            $validated_data[$vr['field']] = $this->input->post($vr['field']);
        }

        return $validated_data;
    }

    protected function get_validation_errors($validation_rules)
    {
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $errors = array();

        foreach($validation_rules as $vr)
        {
            $errors[$vr['field']] = form_error($vr['field']);
        }

        return $errors;
    }

    protected function check_user()
    {
        $this->CI =& get_instance();

        if(!$this->get_user())
        {
            redirect(site_url().'/Login');
        }
    }

    protected function get_user_type()
    {
        $session = $this->CI->session->userdata('user_data');

        return $session['usertype'];
    }

    private function get_user()
    {
        $success = TRUE;

        $session = $this->CI->session->userdata('user_data');

        $this->CI->session->unset_userdata('user_data');

        if(empty($session))
        {
            $success = FALSE;
        }
        else
        {
            $waiting_time = '00:30:00';

            $current_datetime = strtotime(date("Y-m-d H:i:s"));
            $registered_datetime = strtotime($session['reg_time']);

            if(($current_datetime - $registered_datetime) >= strtotime($waiting_time))
            {
                $success = FALSE;
            }
            else
            {
                $session['datetime'] = date("Y-m-d H:i:s");

                $this->CI->session->set_userdata(array('user_data' => $session));
            }
        }

        return $success;
    }
}