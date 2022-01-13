<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_api extends CI_Controller {

	function __construct(){
        parent::__construct();
        
    }

    function get_items_by_supplier(){
        $this->load->model('master/items_model');
        $data = array(); 

        $start      = $this->input->get('start');
        $length     = $this->input->get('length');
        $search     = $this->input->get('search');
        $id         = $this->input->get('id');
        $request_id = $this->input->get('request_id');
        // test($start.' '.$length.' '.$search['value'].' '.$id.' '.$request_id,1);

        $list = $this->items_model->get_all_items($start,$length,$search['value'],$id,$request_id);
        if(is_for($list)){
            foreach ($list as $row) {
                $data[] = array(
                    'items_id'      => $row->items_id,
                    'items_code'    => $row->items_code,
                    'items_name'    => $row->items_name,
                    'items_price'   => $row->items_price,
                    'qty_request'   => $row->qty_request,
                    'qty_pr'        => $row->qty_pr,
                    'sisa'          => $row->sisa
                );
            }
        }     

        if ($search['value']) {
            $total   = $this->items_model->get_count_display($start,$length,$search['value'],$id,$request_id);
        }else {
            $total   = $this->items_model->get_count($id,$request_id);
        }
        // $display = $this->item_model->get_count_display($start,$length,$search['value']);
        // jsout(array('success'=>1, 'aaData'=>$data));
        jsout(array('success'=>1, 'aaData'=>$data,'iTotalRecords'=>$total,'iTotalDisplayRecords'=>$total));

    }

    function get_all_items(){
        $this->load->model('master/items_model');

        $start  = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search');
        // $id     = $this->input->get('id');
        //test($start.' '.$length.' '.$search['value'],1);

        $list = $this->items_model->all_items($start,$length,$search['value']);
        if(is_for($list)){
            foreach ($list as $row) {
                $data[] = array(
                    'items_id'      => $row->items_id,
                    'items_code'    => $row->items_code,
                    'items_name'    => $row->items_name
                );
            }
        }     

        if ($search['value']) {
            $total   = $this->items_model->all_items_count($start,$length,$search['value']);
        }else {
            $total   = $this->items_model->items_count();
        }
        // $display = $this->item_model->get_count_display($start,$length,$search['value']);
        // jsout(array('success'=>1, 'aaData'=>$data));
        jsout(array('success'=>1, 'aaData'=>$data,'iTotalRecords'=>$total,'iTotalDisplayRecords'=>$total));

    }
	

}
?>