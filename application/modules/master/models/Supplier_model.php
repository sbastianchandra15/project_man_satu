<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier_model extends CI_Model
{

    function get_supplier()
    {
        $sql ='SELECT a.supplier_id,a.supplier_code,a.supplier_kind_id,b.kind_name,a.supplier_name,a.address, a.contact1,a.contact2,a.supplier_info,a.file_npwp 
FROM mst_supplier a left join mst_supplier_kind b on a.supplier_kind_id=b.supplier_kind_id WHERE a.is_active="1" order by a.supplier_id desc';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function act_form(){
        $new_supplier   = $this->session->userdata('new_supplier');

        $tahun          = date('Y');
        $data_id        = $this->get_supplier_id();
        $supplier_id    = $data_id->supplier_id;
        $data_no        = $this->get_nomor_dok($tahun);
        $nomor_dok      = $data_no->nomor_dok;
        $supplier_code  = 'SP'.$tahun.$nomor_dok;

        if($this->input->post('top')!=''){
            $top = $this->input->post('top');
        }else{
            $top = 0;
        }

        if($this->input->post('ppn')!=''){
            $ppn = $this->input->post('ppn');
        }else{
            $ppn = 0;
        }

        $supplier_kind_id= $this->security->xss_clean($this->db->escape_str($this->input->post('supplier_kind_id')));
        $name       = $this->security->xss_clean($this->db->escape_str($this->input->post('name')));
        $npwp       = $this->security->xss_clean($this->db->escape_str($this->input->post('npwp')));
        $siup       = $this->security->xss_clean($this->db->escape_str($this->input->post('siup')));
        $address    = $this->security->xss_clean($this->db->escape_str($this->input->post('address')));
        $city       = $this->security->xss_clean($this->db->escape_str($this->input->post('city')));
        $contact1   = $this->security->xss_clean($this->db->escape_str($this->input->post('contact1')));
        $contact2   = $this->security->xss_clean($this->db->escape_str($this->input->post('contact2')));
        $contact3   = $this->security->xss_clean($this->db->escape_str($this->input->post('contact3')));
        $email1     = $this->security->xss_clean($this->db->escape_str($this->input->post('email1')));
        $email2     = $this->security->xss_clean($this->db->escape_str($this->input->post('email2')));
        $pic_sales  = $this->security->xss_clean($this->db->escape_str($this->input->post('pic_sales')));
        $info       = $this->security->xss_clean($this->db->escape_str($this->input->post('info')));
        $file_npwp  = $this->security->xss_clean($this->db->escape_str($this->input->post('file_npwp')));
        
        $sql    = "INSERT INTO mst_supplier (supplier_id,supplier_code,supplier_kind_id,supplier_name,npwp,siup,address,city,contact1,contact2,contact3,email1,email2,pic_sales,top,supplier_info,
             is_ppn,is_active,pic_input,input_time,file_npwp) VALUES 
             ('".$supplier_id."','".$supplier_code."','".$supplier_kind_id."','".$name."','".$npwp."','".$siup."','".$address."','".$city."','".$contact1."','".$contact2."','".$contact3."','".$email1."','".$email2."','".$pic_sales."',
             '".$top."','".$info."','".$ppn."','1','".$this->current_user['user_id']."','".dbnow()."','".$file_npwp."')";

        if(isset($new_supplier['items'])){
            $items          = $new_supplier['items'];
            foreach ($items as $key => $value) {
                $item_price     = str_replace(',','',$this->security->xss_clean($this->db->escape_str($value['item_price'])));
                $sql_detail     = "INSERT INTO mst_supplier_items (supplier_id,items_id,items_price) VALUES ('".$supplier_id."','".$this->security->xss_clean($this->db->escape_str($value['item_id']))."','".$item_price."')";
                $query          = $this->db->query($sql_detail);
            }
        }
        
        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function act_delete($id){
        $sql = "UPDATE mst_supplier SET pic_edit = '".$this->current_user['user_id']."', edit_time = '".dbnow()."' WHERE supplier_id = '".$id."'";
        $query = $this->db->query($sql);
        return $query;
    }

    function act_delete_js(){
        $sql = "UPDATE mst_supplier SET is_active='0', pic_edit = '".$this->current_user['user_id']."', edit_time = '".dbnow()."' WHERE supplier_id = '".$this->input->post('supplier_id')."'";
        $query = $this->db->query($sql);
        return $query;
    }

    function detail_supplier($id){
        $query = $this->db->query("SELECT supplier_id,supplier_code,supplier_kind_id,supplier_name,npwp,siup,address,city,contact1,contact2,contact3,email1,email2,pic_sales,top,
                                    supplier_info,is_ppn,file_npwp FROM mst_supplier WHERE supplier_id='".$id."'")->row();
                
        return $query;
    }

    function detail_items_supplier($id){
        $query = $this->db->query("SELECT a.items_id item_id,b.items_name item_name,a.items_price FROM mst_supplier_items a,mst_items b WHERE a.supplier_id='".$id."' AND a.items_id=b.items_id")->result();
                
        return $query;
    }

    function jumlah_items_supplier($id){
        $query = $this->db->query("SELECT a.items_id item_id,b.items_name item_name,a.items_price FROM mst_supplier_items a,mst_items b WHERE a.supplier_id='".$id."' AND a.items_id=b.items_id")->num_rows();
                
        return $query;
    }

    function get_supplier_id(){
        $query = $this->db->query("SELECT IFNULL(MAX(supplier_id)+1,1) supplier_id FROM mst_supplier")->row();
        return $query;
    }

    function get_nomor_dok($tahun){
        $query = $this->db->query("SELECT IFNULL(LPAD(MAX(SUBSTRING(supplier_code,7,5))+1,5,'0'),'00001') nomor_dok FROM mst_supplier WHERE SUBSTR(supplier_code,3,4)='".$tahun."'")->row();
        return $query;
    }

    function act_edit(){
        $new_supplier = $this->session->userdata('new_supplier');
        
        if($this->input->post('ppn')!=''){
            $ppn = $this->input->post('ppn');
        }else{
            $ppn = 0;
        }
        
        $sql    = "UPDATE mst_supplier
                    SET supplier_name = '".$this->security->xss_clean($this->db->escape_str($this->input->post('name')))."',
                      supplier_kind_id = '".$this->security->xss_clean($this->db->escape_str($this->input->post('supplier_kind_id')))."',
                      npwp = '".$this->security->xss_clean($this->db->escape_str($this->input->post('npwp')))."',
                      siup = '".$this->security->xss_clean($this->db->escape_str($this->input->post('siup')))."',
                      address = '".$this->security->xss_clean($this->db->escape_str($this->input->post('address')))."',
                      city = '".$this->security->xss_clean($this->db->escape_str($this->input->post('city')))."',
                      contact1 = '".$this->security->xss_clean($this->db->escape_str($this->input->post('contact1')))."',
                      contact2 = '".$this->security->xss_clean($this->db->escape_str($this->input->post('contact2')))."',
                      contact3 = '".$this->security->xss_clean($this->db->escape_str($this->input->post('contact3')))."',
                      email1 = '".$this->security->xss_clean($this->db->escape_str($this->input->post('email1')))."',
                      email2 = '".$this->security->xss_clean($this->db->escape_str($this->input->post('email2')))."',
                      pic_sales = '".$this->security->xss_clean($this->db->escape_str($this->input->post('pic_sales')))."',
                      top = '".$this->security->xss_clean($this->db->escape_str($this->input->post('top')))."' ,
                      supplier_info = '".$this->security->xss_clean($this->db->escape_str($this->input->post('info')))."',
                      is_ppn = '".$ppn."',
                      pic_edit = '".$this->current_user['user_id']."',
                      edit_time = '".dbnow()."'";
        if($this->input->post('file_npwp')!=''){
            $sql   .= ", file_npwp = '".$this->security->xss_clean($this->db->escape_str($this->input->post('file_npwp')))."'";
        }
        $sql   .= " WHERE supplier_id = '".$this->security->xss_clean($this->db->escape_str($this->input->post('supplier_id')))."'";

        $delete = "DELETE FROM mst_supplier_items WHERE supplier_id = '".$this->security->xss_clean($this->db->escape_str($this->input->post('supplier_id')))."'";
        $query = $this->db->query($delete);

        if(isset($new_supplier['items'])){
            $items          = $new_supplier['items'];
            foreach ($items as $key => $value) {
                $item_price     = str_replace(',','',$value['item_price']);
                $sql_detail     = "INSERT INTO mst_supplier_items (supplier_id,items_id,items_price) VALUES ('".$this->security->xss_clean($this->db->escape_str($this->input->post('supplier_id')))."','".$this->security->xss_clean($this->db->escape_str($value['item_id']))."','".$item_price."')";
                $query          = $this->db->query($sql_detail);
            }
        }
        
        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function kind_supplier(){
        $sql ='SELECT   supplier_kind_id,kind_name FROM mst_supplier_kind WHERE is_active=1';
        $query = $this->db->query($sql);
        return $query->result();
    }

}   