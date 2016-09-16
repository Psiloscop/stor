<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/13/16
 * Time: 9:04 PM
 */

class Api extends CI_Controller
{
    public function check_reader()
    {
        $this->load->model('Stor_api_model');

        $response = array(
            'success' => TRUE,
            'message' => 'Читатель идентифицирован'
        );

        $username = $this->input->post('username');
        $number = $this->input->post('number');

        $is_reader_exist = $this->Stor_api_model->check_reader_existence($username, $number);

        if($is_reader_exist)
        {
            $this->load->model('api/Irbis_functions');

            $irbis_reader_data = $this->Irbis_functions->get_reader_data($number);

            $reg_date = NULL;

            if(isset($irbis_reader_data[52][0]['#']))
            {
                $reg_date = $irbis_reader_data[52][count($irbis_reader_data[52]) - 1]['#'];
            }
            else if(isset($irbis_reader_data[52]['#']))
            {
                $reg_date = $irbis_reader_data[52]['#'];
            }
            else if(isset($irbis_reader_data[51]['#']))
            {
                $reg_date = $irbis_reader_data[51]['#'];
            }

            if($reg_date != NULL)
            {
                $reg_date = substr($reg_date, 0, 4).'-'.substr($reg_date, 4, 2).'-'.substr($reg_date, 6, 2);

                if(strtotime($reg_date) < strtotime(date('Y').'-09-01'))
                {
                    $response['success'] = FALSE;
                    $response['message'] = 'Необходима перерегистрация';
                }
            }
            else
            {
                $response['success'] = FALSE;
                $response['message'] = 'Ошибка определения даты регастрации';
            }
        }
        else
        {
            $response['success'] = FALSE;
            $response['message'] = 'Читатель не найден';
        }

        echo json_encode($response);
    }
}