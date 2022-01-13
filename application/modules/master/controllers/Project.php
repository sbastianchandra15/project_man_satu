<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->session->set_userdata('ses_menu', array('active_menu' => 'Master', 'active_submenu' => 'master/project'));  
        $this->isMenu();
        $this->load->model('master/project_model');
    }


	function index(){
        $data['data_project']     = $this->project_model->get_project();
        $this->template->load('body', 'master/project/project_view',$data);
	}

    function form(){
        $this->template->load('body', 'master/project/project_form');
    }

    function form_act(){
        $save   = $this->project_model->act_form();
        jsout(array('success' => true, 'status' => $save ));
    }

    function delete_js(){
        $delete = $this->project_model->act_delete_js();
        //test($delete,1);
        jsout(array('success' => true, 'status' => $delete ));
    }

    function edit($id){
        $data['data_project']       = $this->project_model->detail_project($id);
        $this->template->load('body', 'master/project/project_edit', $data);
    }

    function edit_act(){
        $update   = $this->project_model->act_edit();
        jsout(array('success' => true, 'status' => $update ));
    }

}
?>