<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items_category extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->session->set_userdata('ses_menu', array('active_menu' => 'Master', 'active_submenu' => 'master/items_category'));  
        $this->isMenu();
        $this->load->model('master/items_category_model');
    }


	function index(){
        $data['data_category']     = $this->items_category_model->get_category();
        $this->template->load('body', 'master/items_category/items_category_view',$data);
	}

    function form(){
        $this->template->load('body', 'master/items_category/items_category_form');
    }

    function form_act(){
        $save   = $this->items_category_model->act_form();
        jsout(array('success' => true, 'status' => $save ));
    }

    function delete_js(){
        $delete = $this->items_category_model->act_delete_js();
        //test($delete,1);
        jsout(array('success' => true, 'status' => $delete ));
    }

    function edit($id){
        $data['data_category']       = $this->items_category_model->detail_category($id);
        $this->template->load('body', 'master/items_category/items_category_edit', $data);
    }

    function edit_act(){
        $update   = $this->items_category_model->act_edit();
        jsout(array('success' => true, 'status' => $update ));
    }

}
?>