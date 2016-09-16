<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 8/31/16
 * Time: 8:13 PM
 */

class Avn_parser
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->model(array(
            'admin/data/Countries_data_model',
            'admin/data/Study_groups_data_model'
        ));
    }

    public function parse_student_data(&$student_data)
    {
        $parsed_data = $this->parse_flm($student_data['StudentSnp']);

        $parsed_data['AVN_id'] = $student_data['IdStudent'];
        $parsed_data['gender'] = $this->parse_gender($student_data['IsMale']);
        $parsed_data['birth_date'] = $this->parse_birth_date($student_data['BirthDate']);
        $parsed_data['payment_form'] = $this->parse_payment_form($student_data['IsContract']);
        $parsed_data['citizenship_id'] = $this->parse_citizenship($student_data['CitizenshipName']);
        $parsed_data['study_group_id'] = $this->parse_study_group($student_data['FacultyName'], $student_data['GroupName'],$student_data['FormOfStudy']);

        return $parsed_data;
    }

    private function parse_flm($StudentSnp)
    {
        $flm = preg_split('/\s+/', mb_strtolower($StudentSnp));

        $flm = array_filter($flm, function($element){ return !empty($element); });
        $flm = array_values($flm);

        $parsed_flm = array();

        if($flm[1] === 'уулу' || $flm[1] === 'кызы')
        {
            $flm[0] .= ' '.$flm[1];

            $parsed_flm['first_name'] = $flm[2] ?? 'unknown';
            $parsed_flm['middle_name'] = NULL;
        }
        else
        {
            $parsed_flm['first_name'] = $flm[1];
            $parsed_flm['middle_name'] = isset($flm[2]) ? $flm[2] : NULL;
        }

        $parsed_flm['last_name'] = $flm[0];

        return $parsed_flm;
    }

    private function parse_birth_date($birth_date)
    {
        if(isset($birth_date))
        {
            $date = explode('.', $birth_date);

            return $date[2].'-'.$date[1].'-'.$date[0];
        }
        else
        {
            return NULL;
        }
    }

    private function parse_payment_form($IsContract)
    {
        return ($IsContract) ? 'к' : 'б';
    }

    private function parse_gender($IsMale)
    {
        return ($IsMale == TRUE) ? 'м' : 'ж';
    }

    private function parse_citizenship($country_name)
    {
        return $this->CI->Countries_data_model->get_country_id($country_name);
    }

    private function parse_study_group($faculty_name, $study_group_name, $study_form_name)
    {
        return $this->CI->Study_groups_data_model->get_study_group_id($faculty_name, $study_group_name, $study_form_name);
    }
}