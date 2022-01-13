<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project_model extends CI_Model
{

	function get_project()
    {
        $sql ='SELECT project_id,project_name,project_location FROM mst_project where is_active=1 ORDER BY project_id DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function project_budget(){
        $sql = "SELECT a.project_id,a.project_name,a.project_location FROM db_master.mst_project a 
                    WHERE a.project_id IN (SELECT project_id FROM db_finance.trn_budget_plan_01 WHERE tbp_status='1') OR a.project_id IN ('1')";
        return $this->db->query($sql)->result();
    }

    function act_form(){
        $periode = date('Y').date('m');

        $name           = $this->security->xss_clean($this->db->escape_str($this->input->post('name')));
        $location       = $this->security->xss_clean($this->db->escape_str($this->input->post('location')));
        $info           = $this->security->xss_clean($this->db->escape_str($this->input->post('info')));

        $sql    = "INSERT INTO mst_project (project_name,project_location,project_info,pic_input,input_time,is_active) VALUES 
                ('".$name."','".$location."','".$info."','".$this->current_user['user_id']."','".dbnow()."',1)";

        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function act_delete_js(){
        $sql = "UPDATE mst_project SET is_active='0', pic_edit = '".$this->current_user['user_id']."', edit_time = '".dbnow()."' WHERE project_id = '".$this->input->post('project_id')."'";
        //test($sql,1);
        $query = $this->db->query($sql);
        return $query;
    }

    function detail_project($id){
        $query = $this->db->query("SELECT project_id,project_name,project_location,project_info FROM mst_project WHERE project_id='".$id."'")->row();
        return $query;
    }

    function act_edit(){
        $sql    = "UPDATE mst_project
                    SET 
                      project_name = '".$this->security->xss_clean($this->db->escape_str($this->input->post('name')))."',
                      project_location = '".$this->security->xss_clean($this->db->escape_str($this->input->post('location')))."',
                      project_info = '".$this->security->xss_clean($this->db->escape_str($this->input->post('info')))."',
                      pic_edit = '".$this->current_user['user_id']."',
                      edit_time = '".dbnow()."'
                    WHERE project_id = '".$this->security->xss_clean($this->db->escape_str($this->input->post('project_id')))."'";
        //test($sql,1);
        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

}	