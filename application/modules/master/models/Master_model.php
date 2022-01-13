<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_model extends CI_Model
{

	function get_items_kind()
    {
        $sql ='SELECT items_kind_id,items_kind,items_kind_name FROM mst_items_kind';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_user_level()
    {
        $sql ='SELECT  id_user_level,user_level_code,user_level_name FROM mst_user_level';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_user_level_approve()
    {
        $sql ="SELECT  id_user_level,user_level_code,user_level_name FROM mst_user_level WHERE id_user_level IN ('1','5')";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_items_unit()
    {
        $sql ='SELECT items_unit_id,items_unit_name FROM mst_items_unit';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_category()
    {
        $sql ='SELECT items_category_id, items_category_name,remarks,is_active FROM mst_items_category WHERE is_active=1 ORDER BY items_category_id DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_dept_authorized()
    {
        $sql ='SELECT id_user_group,`name` FROM mst_user_group ORDER BY id_user_group desc';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function config($data)
    {
        $sql ='SELECT config_id,config_name,company_id,config_value FROM mst_config WHERE config_name="'.$data.'"';
        $query = $this->db->query($sql);
        return $query->row();
    }
}	
?>