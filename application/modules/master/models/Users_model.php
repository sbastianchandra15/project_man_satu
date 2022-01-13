<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends MY_Model
{

	function get_user($usr,$pwd)
    {
        $sql =' SELECT user_id,nip,`name`,username,`password`,id_user_group,is_active,pic_input,input_time,pic_edit,edit_time,user_level FROM mst_user '.
              ' WHERE username = "'.$usr.'"'.
              ' AND password = "'.$pwd.'" AND is_active = 1 ';
              
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function detail_user($usr,$pwd){
    	$query = $this->db->query("SELECT a.`user_id`, a.nip, a.`name`, a.`username`, a.`id_user_group`, a.`id_user_level`, b.`user_level_code`, a.user_level,
                b.`user_level_name`, c.`name` AS group_name, a.user_app_level, a.user_app_level_sg FROM mst_user a 
                LEFT JOIN mst_user_level b ON a.`id_user_level`=b.`id_user_level`
                LEFT JOIN mst_user_group c ON a.`id_user_group`=c.`id_user_group`
                WHERE a.`is_active`='1' AND a.`username`='".$usr."' AND a.`password`='".$pwd."'")->row();
            	
        return $query;
    }

    function get_user_id(){
        $query = $this->db->query("SELECT IFNULL(MAX(user_id)+1,1) user_id FROM mst_user")->row();
        return $query;
    }

    function aktifitas_user($status){
        if($status=='logged in'){
            $sql = "UPDATE mst_user SET last_login = '".dbnow()."',last_ip = '".$this->input->ip_address()."' 
                    WHERE user_id = '".$this->session->userdata('ses_sangati')['user_id']."'";

            $query = $this->db->query($sql);
        }

        $this->activity_user($status, 'User', 'mst_user');
    }

    function all_user(){
    	return $this->db->get('user')->result();
    }

    function user_all(){
        $sql =  'SELECT a.user_id,a.nip,a.name,a.username,a.password,a.id_user_level,a.is_active,b.user_level_name as user_level_old, a.user_level,a.email 
        FROM mst_user a left join mst_user_level b on a.id_user_level=b.id_user_level
        WHERE a.is_active="1" order by a.user_id desc';
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function act_delete_js(){
        $sql = "UPDATE mst_user SET is_active = '0',pic_edit = '".$this->current_user['user_id']."',edit_time = '".dbnow()."' WHERE user_id = '".$this->input->post('user_id')."'";

        $query = $this->db->query($sql);
        return $query;
    }

    function act_form(){
        
        $data_id    = $this->get_user_id();
        $user_id    = $data_id->user_id;

        $nip        = $this->security->xss_clean($this->db->escape_str($this->input->post('nip')));
        $name       = $this->security->xss_clean($this->db->escape_str($this->input->post('name')));
        $username   = $this->security->xss_clean($this->db->escape_str($this->input->post('username')));
        $password1  = $this->security->xss_clean($this->db->escape_str($this->input->post('password1')));
        $users_group= $this->security->xss_clean($this->db->escape_str($this->input->post('users_group')));
        $user_level = $this->security->xss_clean($this->db->escape_str($this->input->post('user_level')));
        $email      = $this->security->xss_clean($this->db->escape_str($this->input->post('email')));
        $id_user_level = 0;

        $sql = "INSERT INTO mst_user (nip,`name`,username,`password`,email,id_user_group,id_user_level,user_level,is_active,pic_input,input_time)VALUES
            ('".$nip."','".$name."','".$username."','".$password1."','".$email."','".$users_group."','".$id_user_level."','".$user_level."','1','".$this->current_user['user_id']."','".dbnow()."')";
        // test($sql,1);
        // $sql = "INSERT INTO mst_user (nip,`name`,username,`password`,id_user_group,id_user_level,is_active,pic_input,input_time) VALUES 
        //     ('".$nip."','".$name."','".$username."','".$password1."','".$users_group."','".$user_level."','1','".$this->current_user['user_id']."','".dbnow()."');";

        foreach ($this->input->post('lang') as $key => $value) {
            $sql_user_group = "INSERT INTO mst_user_group_permissions (user_id,id_user_group) VALUES ('".$user_id."','".$value."')";
            $query = $this->db->query($sql_user_group);
        }

        $query = $this->db->query($sql);
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }

    }

    function data_user($id){
        $query = $this->db->query("SELECT user_id,nip,`name`,username,`password`,id_user_level,id_user_group as user_group,email,user_level FROM mst_user WHERE user_id='".$id."'")->row();
        return $query;
    }

    function act_edit(){
        
        $user_id        = $this->security->xss_clean($this->db->escape_str($this->input->post('user_id')));
        if($this->security->xss_clean($this->db->escape_str($this->input->post('id_user_level')))==''){
            $id_user_level  = 0;
        }else{
            $id_user_level  = $this->security->xss_clean($this->db->escape_str($this->input->post('id_user_level')));
        }
        

        $sql    = "UPDATE mst_user
                    SET nip = '".$this->security->xss_clean($this->db->escape_str($this->input->post('nip')))."',
                      `name` = '".$this->security->xss_clean($this->db->escape_str($this->input->post('name')))."',
                      username = '".$this->security->xss_clean($this->db->escape_str($this->input->post('username')))."',
                      `password` = '".$this->security->xss_clean($this->db->escape_str($this->input->post('password1')))."',
                      id_user_level = '".$id_user_level."',
                      user_level = '".$this->security->xss_clean($this->db->escape_str($this->input->post('user_level')))."',
                      email = '".$this->security->xss_clean($this->db->escape_str($this->input->post('email')))."',
                      pic_edit = '".$this->current_user['user_id']."',
                      edit_time = '".dbnow()."'
                    WHERE user_id = '".$this->security->xss_clean($this->db->escape_str($this->input->post('user_id')))."'";
        $query = $this->db->query($sql);

        $del_cp = $this->delete_permission_group($user_id);

        if($this->input->post('lang')!=''){
            foreach ($this->input->post('lang') as $key => $value) {
                $sql_user_group = "INSERT INTO mst_user_group_permissions (user_id,id_user_group) VALUES ('".$user_id."','".$value."')";
                $query = $this->db->query($sql_user_group);
            }
        }
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function act_permission(){
        $menu_id    = $this->security->xss_clean($this->db->escape_str($this->input->post('menu_id')));
        $user_id    = $this->security->xss_clean($this->db->escape_str($this->input->post('user_id')));
        $company_id = $this->security->xss_clean($this->db->escape_str($this->input->post('company_id')));
        //test($company_id,0);
        $delete = $this->delete_permission($user_id);
        $del_cp = $this->delete_permission_cp($user_id);
        // test($del_cp,1);
        if($delete=='true' && isset($menu_id)){
            foreach ($menu_id as $key => $value) {
                $this->insert_permission($user_id,$value);
            }
        }

        if($del_cp=='true' && isset($company_id)){
            foreach ($company_id as $key => $value) {
                $this->insert_permission_cp($user_id,$value);
            }
        }
    }

    function delete_permission($id){
        $sql    = "DELETE FROM mst_menu_permissions WHERE user_id = '".$id."'";
        $query  = $this->db->query($sql);

        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function delete_permission_cp($id){
        $sql    = "DELETE FROM mst_user_company WHERE user_id = '".$id."'";

        $query  = $this->db->query($sql);

        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function delete_permission_group($id){
        $sql    = "DELETE FROM mst_user_group_permissions WHERE user_id = '".$id."'";
        $query  = $this->db->query($sql);

        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function insert_permission($user_id,$menu_id){
        $sql    = "INSERT INTO mst_menu_permissions (user_id,menu_id) VALUES ('".$user_id."','".$menu_id."')";
        $query  = $this->db->query($sql);
        return $query;
    }

    function insert_permission_cp($user_id,$company_id){
        $sql    = "INSERT INTO mst_user_company (company_id,user_id) VALUES ('".$company_id."','".$user_id."')";
        $query  = $this->db->query($sql);
        return $query;
    }

    function act_password(){
        $sql    = "UPDATE mst_user
                    SET username = '".$this->security->xss_clean($this->db->escape_str($this->input->post('username')))."',
                      `password` = '".$this->security->xss_clean($this->db->escape_str($this->input->post('password1')))."',
                      pic_edit = '".$this->current_user['user_id']."',
                      edit_time = '".dbnow()."'
                    WHERE user_id = '".$this->security->xss_clean($this->db->escape_str($this->input->post('user_id')))."'";
        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function permission_user_group($id){
        $sql    = "SELECT a.id_user_group, a.name,b.user_id FROM mst_user_group a 
                    LEFT JOIN mst_user_group_permissions b ON a.id_user_group=b.id_user_group AND b.user_id='".$id."'  ORDER BY id_user_group";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function permission_user_group_login($id){
        $sql    = "SELECT a.user_id,a.id_user_group,b.name FROM mst_user_group_permissions a LEFT JOIN mst_user_group b ON a.id_user_group=b.id_user_group 
        WHERE a.user_id='".$id."'";
        $query = $this->db->query($sql)->result();
        return $query;
    }
}	