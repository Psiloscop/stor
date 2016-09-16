<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 8/31/16
 * Time: 8:32 PM
 */

class Avn_api
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();

        $this->CI->load->model(array(
            'api/Avn_parser',
            'api/Auth_data_generator',
            'admin/data/Students_data_model'
        ));
    }

    public function get_students($semester)
    {
        $page = 1;
        $students = NULL;
        $registered_count = 0;

        do
        {
            $response = json_decode(
                file_get_contents('http://avn.kstu.kg/lms/Services/LibraryHandler.aspx?q=getstudents&idSem='.$semester.'&page='.$page), TRUE
            );

            $students = $response['Students'];
            $page_count = $response['TotalPages'];
            $student_count = $response['StudentsCount'];

            unset($response);

            for($index = 0; $index < $student_count; $index++)
            {
                $students[$index] = $this->CI->Avn_parser->parse_student_data($students[$index]);

                $student_id = $this->CI->Students_data_model->get_student_id($students[$index]['AVN_id']);

                if($student_id !== NULL)
                {
//                    $this->CI->Students_data_model->update_student($students[$index], $student_id);

                    unset($students[$index]);
                }
                else
                {
                    $this->CI->Auth_data_generator->get_auth_data($students[$index]);
                }
            }

            if(!empty($students))
            {
                $this->CI->Students_data_model->insert_students($students);

                $registered_count += count($students);
            }

            unset($students);

            $page++;
        }
        while($page <= $page_count);

        return $registered_count;
    }

    public function get_student_photo($AVN_id)
    {
        $photo_name = $AVN_id.'.png';

        $student_photo = json_decode(
            file_get_contents('http://avn.kstu.kg/lms/Services/LibraryHandler.aspx?q=getstudentphoto&idStud='.$AVN_id), TRUE
        );

        if($student_photo['PhotoBase64'] != NULL)
        {
            file_put_contents(
                PHOTO_DIRECTORY.$photo_name,
                base64_decode($student_photo['PhotoBase64'])
            );

            $this->CI->Students_data_model->add_student_photo($AVN_id, $photo_name);

            return $photo_name;
        }
        else
        {
            return NULL;
        }
    }
}