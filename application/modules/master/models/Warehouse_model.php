<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Warehouse_model extends CI_Model
{

	function get_warehouse()
    {
        $sql ='SELECT warehouse_id,warehouse_name,address,telp,city,is_active FROM mst_warehouse WHERE is_active="1" ORDER BY warehouse_id DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function act_form(){
        $periode = date('Y').date('m');

        $name           = $this->security->xss_clean($this->db->escape_str($this->input->post('name')));
        $address        = $this->security->xss_clean($this->db->escape_str($this->input->post('address')));
        $city           = $this->security->xss_clean($this->db->escape_str($this->input->post('city')));
        $telp           = $this->security->xss_clean($this->db->escape_str($this->input->post('telp')));
        $info           = $this->security->xss_clean($this->db->escape_str($this->input->post('info')));

        $sql    = "INSERT INTO mst_warehouse (warehouse_name,address,telp,city,remarks,is_active,pic_input,input_time)VALUES 
                ('".$name."','".$address."','".$telp."','".$city."','".$info."','1','".$this->current_user['user_id']."','".dbnow()."')";

        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function act_delete_js(){
        $sql = "UPDATE mst_warehouse SET is_active='0', pic_edit = '".$this->current_user['user_id']."', edit_time = '".dbnow()."' where warehouse_id = '".$this->input->post('warehouse_id')."'";
        //test($sql,1);
        $query = $this->db->query($sql);
        return $query;
    }

    function detail_warehouse($id){
        $query = $this->db->query("SELECT warehouse_id,warehouse_name,address,telp,city,remarks FROM mst_warehouse WHERE warehouse_id='".$id."'")->row();
        return $query;
    }

    function act_edit(){
        $sql    = "UPDATE mst_warehouse
                    SET warehouse_name = '".$this->security->xss_clean($this->db->escape_str($this->input->post('name')))."',
                      address = '".$this->security->xss_clean($this->db->escape_str($this->input->post('address')))."',
                      telp = '".$this->security->xss_clean($this->db->escape_str($this->input->post('telp')))."',
                      city = '".$this->security->xss_clean($this->db->escape_str($this->input->post('city')))."',
                      remarks = '".$this->security->xss_clean($this->db->escape_str($this->input->post('info')))."',
                      pic_edit = '".$this->current_user['user_id']."',
                      edit_time = '".dbnow()."'
                    WHERE warehouse_id = '".$this->security->xss_clean($this->db->escape_str($this->input->post('warehouse_id')))."'";
        //test($sql,1);
        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

}	