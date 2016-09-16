<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 9/12/16
 * Time: 4:26 PM
 */

require_once 'Irbis_api.php';

class Irbis_functions extends CI_Model
{
    private $Irbis_api;

    public function __construct()
    {
        parent::__construct();

        $this->Irbis_api = new Irbis_api();
    }

    public function get_reader_data($reader_number)
    {
        $reader_mfn = $this->Irbis_api->get_mfns('RI='.$reader_number, 0, 1, '');

        if(isset($reader_mfn[0]))
        {
            $reader_data = $this->Irbis_api->get_record($reader_mfn[0], 0, '');

            return $reader_data;
        }

        return NULL;
    }

    public function register_reader(array $reader_data, $new_reader_number)
    {
        $reader_data = $this->convert_stor_reader_data($reader_data, $new_reader_number);

        array_unshift($reader_data, '0#0');

        return $this->Irbis_api->set_record($reader_data);
    }

    public function update_reader($reader_number)
    {
        $old_reader_data = $this->get_reader_data($reader_number);

        $new_reader_data = $this->convert_irbis_reader_data($old_reader_data);

        array_push($new_reader_data, '52#'.date('Ymd').'^CStoR');

        return $this->Irbis_api->set_record($new_reader_data);
    }

    public function change_reader_number(array $new_reader_data, $new_reader_number)
    {
        $old_reader_number = $new_reader_data['number'];

        $old_reader_data = $this->get_reader_data($old_reader_number);

        $old_reader_data[24] = $new_reader_number;
        $old_reader_data[30] = $new_reader_number;

        $new_reader_data = $this->convert_irbis_reader_data($old_reader_data);

        return $this->Irbis_api->set_record($new_reader_data);
    }

    private function convert_irbis_reader_data(array $irbis_reader_data)
    {
        $converted_data = array();

        $converter = function($sub_fields) {
            $converted_fields = '';

            foreach($sub_fields as $key => $value)
            {
                $converted_fields .= ($key !== '#') ? '^'.$key.$value : $value;
            }

            return $converted_fields;
        };

        foreach($irbis_reader_data as $field_id => $field_data)
        {
            if($field_id === 'mfn')
            {
                $converted_data[] = $field_data.'#32';

                continue;
            }

            if($field_id === 'version')
            {
                $converted_data[] = '0#'.$field_data;

                continue;
            }

            if(is_array($field_data))
            {
                if(isset($field_data[0]) && is_array($field_data[0]))
                {
                    foreach($field_data as $sub_field_data)
                    {
                        $converted_data[] = $field_id.'#'.$converter($sub_field_data);
                    }
                }
                else
                {
                    $converted_data[] = $field_id.'#'.$converter($field_data);
                }
            }
            else
            {
                $converted_data[] = $field_id.'#'.$field_data;
            }
        }

        return $converted_data;
    }

    private function convert_stor_reader_data(array $stor_reader_data, $reader_number)
    {
        if(stristr($stor_reader_data['study_form'], 'очн'))
        {
            $stor_reader_data['study_form'] = 'д/о';
        }
        else if(stristr($stor_reader_data['study_form'], 'заочн') ||
            stristr($stor_reader_data['study_form'], 'дистанцион'))
        {
            $stor_reader_data['study_form'] = 'з/о';
        }

        $date = date('Ymd');
        $year = date('Y');

        $converted_data = array(
            '920#RDRU',
            '50#студент',
            '907#^A'.$date.'^BStoR',
            '31#^A'.$date.'^BStoR',
            '10#'.$stor_reader_data['last_name'],
            '11#'.$stor_reader_data['first_name'],
            '23#'.$stor_reader_data['gender'],
            '25#'.$stor_reader_data['code'],
            '30#'.$reader_number,
            '24#'.$reader_number,
            '51#'.$date.'^CStoR',
            '90#^0'.$year.'/'.(intval($year) + 1).
            '^A'.$stor_reader_data['faculty'].
            '^E'.$stor_reader_data['study_group'].
            '^P'.$stor_reader_data['payment_form'].
            '^O'.$stor_reader_data['study_form']
        );

        if($stor_reader_data['birth_date'] != NULL)
        {
            $converted_data[] = '21#'.$stor_reader_data['birth_date'];
        }

        if($stor_reader_data['middle_name'] != NULL)
        {
            $converted_data[] = '12#'.$stor_reader_data['middle_name'];
        }

        return $converted_data;
    }
}