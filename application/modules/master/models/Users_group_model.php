<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_group_model extends CI_Model
{

	function get_user_group()
    {
        $sql =' SELECT id_user_group,`name` FROM mst_user_group ';
        $query = $this->db->query($sql);
        return $query->result();
    }
}	
?>