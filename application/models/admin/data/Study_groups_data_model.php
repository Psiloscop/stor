<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 8/31/16
 * Time: 9:03 PM
 */

class Study_groups_data_model extends CI_Model
{
    public function get_study_group_id($faculty_name, $study_group_name, $study_form_name)
    {
        $faculty_name = trim($faculty_name);
        $study_group_name = trim($study_group_name);
        $study_form_name = trim($study_form_name);

        $study_group_id = $this->db
            ->select('sg.id')
            ->join('faculties AS fc', 'fc.id = faculty_id', 'left')
            ->join('study_forms AS sf', 'sf.id = study_form_id', 'left')
            ->where('sg.study_group', $study_group_name)
            ->where('fc.faculty', $faculty_name)
            ->where('sf.study_form', $study_form_name)
            ->get('study_groups AS sg')->row_array();

        if(!isset($study_group_id['id']))
        {
            $faculty_id = $this->db
                ->select('fc.id')
                ->where('fc.faculty', $faculty_name)
                ->get('faculties AS fc')->row_array();

            if(!isset($faculty_id['id']))
            {
                $this->db->insert('faculties', array('faculty' => $faculty_name));

                $faculty_id['id'] = $this->db->insert_id();
            }

            $study_form_id = $this->db
                ->select('sf.id')
                ->where('sf.study_form', $study_form_name)
                ->get('study_forms AS sf')->row_array();

            if(!isset($study_form_id['id']))
            {
                $this->db->insert('study_forms', array('study_form' => $study_form_name));

                $study_form_id['id'] = $this->db->insert_id();
            }

            $this->db->insert('study_groups', array(
                'study_group' => $study_group_name,
                'faculty_id' => $faculty_id['id'],
                'study_form_id' => $study_form_id['id'])
            );

            $study_group_id['id'] = $this->db->insert_id();
        }

        return $study_group_id['id'];
    }
}