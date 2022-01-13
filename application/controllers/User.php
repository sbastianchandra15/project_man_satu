<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
    }


	function index(){
		if ($this->current_user['loginuser'] == 0){
			$username 		= $this->security->xss_clean($this->db->escape_str($this->input->post('username')));
			$password		= $this->security->xss_clean($this->db->escape_str($this->input->post('password')));

			$this->form_validation->set_rules('username','Username');
            $this->form_validation->set_rules('password','Password');

			if ($username == '' ){
                $this->load->view('login');
            }else{
            	$usr_result = $this->users_model->get_user($username,$password);
                $row = $this->users_model->detail_user($username,$password);

                if ($usr_result > 0){
                    
                  	$session_data = array('user_id'        => $row->user_id,
                                            'company_id'   => $this->input->post('company_id'),
                                            'company_name' => $cp->company_name,
                                            'company_code' => $cp->company_code,
                                            'logo'         => $cp->logo,
                                            'nip'          => $row->nip,
                                            'name'         => $row->name,
                                            'user_group'   => $row->id_user_group,
                                            'user_level'   => $row->id_user_level,
                                            'user_level_new'=>$row->user_level,
                                            'user_level_name'=>$row->user_level_name,
                                            'user_app_level' =>$user_app_level,
                                            'loginuser'    => TRUE,
                                            'menu'         => $this->menu_model->get_akses_menu($row->user_id),
                                            'submenu'      => $this->menu_model->get_akses_submenu($row->user_id),
                                            'user_permission_group' => $this->users_model->permission_user_group_login($row->user_id)
                                        );
                  	
                    $this->session->sess_expiration_on_close = 'true';
                    $this->session->set_userdata('ses', $session_data);

                    redirect('welcome');

                }else{
                	$this->session->set_flashdata('msg','<div class="alert alert-danger text-center"><font size="2">Username Atau Password Anda salah</font></div>');
                    redirect($_SERVER['HTTP_REFERER']);
                    redirect('login');
                }
            } 
		}else{
            redirect('welcome');
		}
	}

	function logout() {
        $this->session->unset_userdata('ses');
        $this->load->view('login');
    }
}
