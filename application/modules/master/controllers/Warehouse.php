<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->session->set_userdata('ses_menu', array('active_menu' => 'Master', 'active_submenu' => 'master/warehouse'));  
        $this->isMenu();
        $this->load->model('master/warehouse_model');
    }


	function index(){
        $data['data_warehouse']     = $this->warehouse_model->get_warehouse();
        $this->template->load('body', 'master/warehouse/warehouse_view',$data);
	}

    function form(){
        $this->template->load('body', 'master/warehouse/warehouse_form');
    }

    function form_act(){
        $save   = $this->warehouse_model->act_form();
        jsout(array('success' => true, 'status' => $save ));
    }

    function delete_js(){
        $delete = $this->warehouse_model->act_delete_js();
        //test($delete,1);
        jsout(array('success' => true, 'status' => $delete ));
    }

    function edit($id){
        $data['data_warehouse']       = $this->warehouse_model->detail_warehouse($id);
        $this->template->load('body', 'master/warehouse/warehouse_edit', $data);
    }

    function edit_act(){
        $update   = $this->warehouse_model->act_edit();
        jsout(array('success' => true, 'status' => $update ));
    }

}
?>