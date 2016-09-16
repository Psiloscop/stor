<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 8/31/16
 * Time: 8:54 PM
 */

class Countries_data_model extends CI_Model
{
    public function get_country_id($country_name, $search_by_code = FALSE)
    {
        $this->db->select('cnt.id');

        $search_by_code
            ? $this->db->where('cnt.code', $country_name)
            : $this->db->like('cnt.country', mb_substr(trim($country_name), 0, 4), 'both');

        $country_id = $this->db->get('countries AS cnt')->row_array();

        if(!isset($country_id['id']))
        {
            $country_id['id'] = $this->db
                ->select('cnt.id')
                ->where('cnt.country', 'Unknown')
                ->get('countries AS cnt')->row_array()['id'];

            if(!isset($country_id['id']))
            {
                $this->db->insert('countries', array('code' => '--', 'citizenship' => 'Unknown'));
                
                $country_id['id'] = $this->db->insert_id();
            }
        }

        return $country_id['id'];
    }
}