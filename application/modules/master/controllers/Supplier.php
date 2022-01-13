<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->session->set_userdata('ses_menu', array('active_menu' => 'Master', 'active_submenu' => 'master/supplier'));
        $this->isMenu();
        $this->load->model('master/supplier_model');
    }


    function index(){  
        $data['data_supplier']  = $this->supplier_model->get_supplier();
        $this->template->load('body', 'master/supplier/supplier_view',$data);
    }

    function form(){
        $this->session->unset_userdata('new_supplier');

        $this->load->model('master/items_model');
        $new_supplier = $this->session->userdata('new_supplier');

        if(!$new_supplier){
            $new_supplier = array(
                'name' => false,
                'npwp' => false,
                'siup' => false,
                'address' => false,
                'city' => false,
                'contact1' => false,
                'contact2' => false,
                'contact3' => false,
                'email1' => false,
                'email2' => false,
                'pic_sales' => false,
                'top' => false,
                'info' => false,
                'ppn' => 0,
                'items' => array()
            );
        }else{
            $new_supplier = array(
                'name' => false,
                'npwp' => false,
                'siup' => false,
                'address' => false,
                'city' => false,
                'contact1' => false,
                'contact2' => false,
                'contact3' => false,
                'email1' => false,
                'email2' => false,
                'pic_sales' => false,
                'top' => false,
                'info' => false,
                'ppn' => 0,
                'items' => array()
            );
        }

        $data['kind_supplier']  = $this->supplier_model->kind_supplier();
        $data['data_items']     = $this->items_model->get_items();
        $data['new_supplier']   = $new_supplier;
        $this->template->load('body', 'master/supplier/supplier_form', $data);
    }

    function add_file(){
        // $file_element_name = 'userfile';
        // test($this->input->post('name'),1);
        $new_supplier = $this->session->userdata('new_supplier');

        // $name_file = $new_supplier['name'].'_npwp';
        // test($name_file,1);
        $config['upload_path'] = './file_upload/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png|gif|zip|rar|doc|docx|xls|xlsx|ods|odt|odp';
        // $config['file_name'] = $name_file;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_npwp')) {
            $error = $this->upload->display_errors();
            // test($error,1);
        } else {
            $result = $this->upload->data();
            // test($result,1);
        }   

        // $file_npwp = $name_file;
        // if($file_npwp) $new_supplier['file_npwp'] = $file_npwp;

        // $this->session->set_userdata('new_supplier', $new_supplier);  
    }

    function add_item(){
        // test($_POST['ppn'],1);
        if(!isset($_POST['item_id'])) return;
        $new_supplier = $this->session->userdata('new_supplier');
        $items = $new_supplier['items'];

        $exist = false;
        if($items!=''){
        foreach($items as $key=>$val){
                if($val['item_id'] == $this->input->post('item_id')){
                    $new_supplier['items'][$key] = array(
                        'item_id'       => $this->input->post('item_id'),
                        'item_name'     => $this->input->post('item_name'),
                        'item_price'    => $this->input->post('item_price')
                    );
                    $exist = true;
                    break;
                }
            }
        }

        if(!$exist){
            $new_supplier['items'][] = array(
                    'item_id'         => $this->input->post('item_id'),
                    'item_name'     => $this->input->post('item_name'),
                    'item_price'    => $this->input->post('item_price')
            );
        }


        $name = $this->input->post('name');
        if($name) $new_supplier['name'] = $name;

        $npwp = $this->input->post('npwp');
        if($npwp) $new_supplier['npwp'] = $npwp;

        $siup = $this->input->post('siup');
        if($siup) $new_supplier['siup'] = $siup;

        $address = $this->input->post('address');
        if($address) $new_supplier['address'] = $address;

        $city = $this->input->post('city');
        if($city) $new_supplier['city'] = $city;

        $contact1 = $this->input->post('contact1');
        if($contact1) $new_supplier['contact1'] = $contact1;

        $contact2 = $this->input->post('contact2');
        if($contact2) $new_supplier['contact2'] = $contact2;

        $contact3 = $this->input->post('contact3');
        if($contact3) $new_supplier['contact3'] = $contact3;

        $email1 = $this->input->post('email1');
        if($email1) $new_supplier['email1'] = $email1;

        $email2 = $this->input->post('email2');
        if($email2) $new_supplier['email2'] = $email2;

        $pic_sales = $this->input->post('pic_sales');
        if($pic_sales) $new_supplier['pic_sales'] = $pic_sales;

        $top = $this->input->post('top');
        if($top) $new_supplier['top'] = $top;

        $info = $this->input->post('info');
        if($info) $new_supplier['info'] = $info;

        $ppn = $this->input->post('ppn');
        if($ppn) $new_supplier['ppn'] = $ppn;
        
        $this->session->set_userdata('new_supplier', $new_supplier);        
    }

    function remove_item(){
        if(!isset($_GET['index_id'])) return;
        $index_id = $this->input->get('index_id');
        $new_supplier = $this->session->userdata('new_supplier');

        $items = $new_supplier['items'];

        foreach($items as $key=>$val){
            if($val['item_id'] == $index_id){
                unset($new_supplier['items'][$key]);
                $new_supplier['items'] = array_values($new_supplier['items']);
                break;
            }
        }

        $this->session->set_userdata('new_supplier', $new_supplier);
        jsout(array('success'=>1)); 
    }

    function form_act(){
        $save   = $this->supplier_model->act_form();

        $this->session->unset_userdata('new_supplier');
        jsout(array('success' => true, 'status' => $save ));
    }

    function delete($id){
        $delete = $this->supplier_model->act_delete($id);
        //test($delete,1);
        if($delete === true){
            $data['message'] = 'message';
            redirect('master/items',$data);
        }
    }

    function delete_js(){
        $delete = $this->supplier_model->act_delete_js();
        jsout(array('success' => true, 'status' => $delete ));
    }

    function edit($id){
        $this->session->unset_userdata('new_supplier');
        
        $this->load->model('master/items_model');
        // $this->session->unset_userdata('new_supplier'); 
        $new_supplier = $this->session->userdata('new_supplier');


        $header     = $this->supplier_model->detail_supplier($id);
        $detail     = $this->supplier_model->detail_items_supplier($id);
        $jumlah     = $this->supplier_model->jumlah_items_supplier($id);
        //test($jumlah,1);
        if(!$new_supplier){
            $new_supplier = array(
                'supplier_kind_id' => $header->supplier_kind_id,
                'supplier_id' => $header->supplier_id,
                'name' => $header->supplier_name,
                'npwp' => $header->npwp,
                'siup' => $header->siup,
                'address' => $header->address,
                'city' => $header->city,
                'contact1' => $header->contact1,
                'contact2' => $header->contact2,
                'contact3' => $header->contact3,
                'email1' => $header->email1,
                'email2' => $header->email2,
                'pic_sales' => $header->pic_sales,
                'top' => $header->top,
                'info' => $header->supplier_info,
                'ppn' => $header->is_ppn,
                'file_npwp' => $header->file_npwp
            );
        }

        if($jumlah!=0){
            foreach($detail as $key=>$val){
                $new_supplier['items'][$key] = array(
                    'item_id'           => $val->item_id,
                    'item_name'         => $val->item_name,
                    'item_price'        => number_format($val->items_price,0)
                );
            }
        }else{
            $new_supplier['items'] = array();
        }

        $this->session->set_userdata('new_supplier', $new_supplier);
        $data['new_supplier'] = $new_supplier;
        $data['kind_supplier']  = $this->supplier_model->kind_supplier();
        $data['data_items']     = $this->items_model->get_items();
        $this->template->load('body', 'master/supplier/supplier_edit', $data);
    }

    function edit_act(){
        $update   = $this->supplier_model->act_edit();
        $this->session->unset_userdata('new_supplier');
        jsout(array('success' => true, 'status' => $update ));
    }

    function reset(){
        $this->session->unset_userdata('new_supplier');
        redirect('master/supplier');
    }

    function detail_items_supplier(){
        $sup_id     = $this->input->post('id');
        $result     = $this->supplier_model->detail_items_supplier($sup_id);
        echo json_encode($result);
    }

    function view_popup($id){
        $data['id']     = $id;
        $data['detail'] = $this->supplier_model->detail_items_supplier($id);
        $this->load->view('master/supplier/supplier_detail_popup',$data);
    }

}
?>