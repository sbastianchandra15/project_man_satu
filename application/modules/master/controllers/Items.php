<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->session->set_userdata('ses_menu', array('active_menu' => 'Master', 'active_submenu' => 'master/items'));  
        $this->isMenu();
        $this->load->model('master/items_model');
    }


	function index(){
        $data['data_items']     = $this->items_model->get_items();
        $this->template->load('body', 'master/items/items_view',$data);
	}

    function form(){
        $this->load->model('master/master_model');
        $data['data_items_kind']     = $this->master_model->get_items_kind();
        $data['data_items_unit']     = $this->master_model->get_items_unit();
        $data['data_category']       = $this->master_model->get_category();
        $data['data_authorized']     = $this->master_model->get_dept_authorized();   
        $this->template->load('body', 'master/items/items_form',$data);
    }

    function form_act(){
        $save   = $this->items_model->act_form();
        jsout(array('success' => true, 'status' => $save ));
    }

    function delete($id){
        $delete = $this->items_model->act_delete($id);
        //test($delete,1);
        if($delete === true){
            $data['message'] = 'message';
            redirect('master/items',$data);
        }
    }

    function delete_js(){
        $delete = $this->items_model->act_delete_js();
        //test($delete,1);
        jsout(array('success' => true, 'status' => $delete ));
    }

    function edit($id){
        $this->load->model('master/master_model');
        $data['data_items_kind'] = $this->master_model->get_items_kind();
        $data['data_items_unit'] = $this->master_model->get_items_unit();
        $data['data_category']       = $this->master_model->get_category();
        $data['data_authorized']     = $this->master_model->get_dept_authorized();   
        $data['data_user']       = $this->items_model->detail_items($id);
        $this->template->load('body', 'master/items/items_edit', $data);
    }

    function edit_act(){
        $update   = $this->items_model->act_edit();
        jsout(array('success' => true, 'status' => $update ));
    }

    function form_act_in_pr(){
        $save   = $this->items_model->act_form_in_pr();
        jsout(array('success' => true, 'status' => $save ));
    }

}
?>