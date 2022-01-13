<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Items_category_model extends CI_Model
{

	function get_category()
    {
        $sql ='SELECT   items_category_id, items_category_name,remarks,is_active FROM mst_items_category WHERE is_active=1 ORDER BY items_category_id DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function act_form(){
        $name           = $this->security->xss_clean($this->db->escape_str($this->input->post('name')));
        $info           = $this->security->xss_clean($this->db->escape_str($this->input->post('info')));

        $sql    = "INSERT INTO mst_items_category (items_category_name,remarks,is_active,pic_input,input_time)VALUES('".$name."','".$info."','1','".$this->current_user['user_id']."','".dbnow()."')";

        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function act_delete_js(){
        $sql = "UPDATE mst_items_category SET is_active='0', pic_edit = '".$this->current_user['user_id']."', edit_time = '".dbnow()."' WHERE items_category_id = '".$this->input->post('items_category_id')."'";
        //test($sql,1);
        $query = $this->db->query($sql);
        return $query;
    }

    function detail_category($id){
        $query = $this->db->query("SELECT items_category_id,items_category_name,remarks,is_active FROM mst_items_category WHERE items_category_id='".$id."'")->row();
        return $query;
    }

    function act_edit(){
        $sql    = "UPDATE mst_items_category SET
                    items_category_name = '".$this->security->xss_clean($this->db->escape_str($this->input->post('name')))."' , 
                    remarks = '".$this->security->xss_clean($this->db->escape_str($this->input->post('info')))."' , 
                    pic_edit = '".$this->current_user['user_id']."' , 
                    edit_time = '".dbnow()."'
                    WHERE
                    items_category_id = '".$this->security->xss_clean($this->db->escape_str($this->input->post('items_category_id')))."'";
        //test($sql,1);
        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

}	