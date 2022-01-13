<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Items_model extends CI_Model
{
    function __construct(){
        parent::__construct();

        if($this->current_user['company_id']==1){
            $this->dbpurch = $this->load->database('purchasing_lm',true);
        }elseif($this->current_user['company_id']==2){
            $this->dbpurch = $this->load->database('purchasing_sg',true);
        }
      
    }

	function get_items()
    {
        $sql ='SELECT a.items_id,a.items_code,a.items_name AS items_nama, b.items_unit_name items_unit, a.items_group, a.items_info,c.items_category_name,
            d.name dept_authorized 
            FROM mst_items a 
            LEFT JOIN mst_items_unit b ON b.items_unit_id=a.items_unit 
            LEFT JOIN mst_items_category c ON a.category_items=c.items_category_id
            LEFT JOIN mst_user_group d ON d.id_user_group=a.dept_authorized
            WHERE a.is_active="1" ORDER BY items_id DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function act_form(){
        $periode = date('Y').date('m');

        $get_items_code = $this->get_no_doc($periode);
        $items_code     = $this->input->post('kind').$periode.$get_items_code->nomor_dok;

        $name           = $this->security->xss_clean($this->db->escape_str($this->input->post('name')));
        $code           = $this->security->xss_clean($this->db->escape_str($this->input->post('code')));
        $unit           = $this->security->xss_clean($this->db->escape_str($this->input->post('unit')));
        $group          = $this->security->xss_clean($this->db->escape_str($this->input->post('group')));
        $info           = $this->security->xss_clean($this->db->escape_str($this->input->post('info')));
        $category       = $this->security->xss_clean($this->db->escape_str($this->input->post('category')));
        $dept_authorized= $this->security->xss_clean($this->db->escape_str($this->input->post('dept_authorized')));

        $sql    = "INSERT INTO mst_items (items_code,items_name,items_kind,items_unit,items_group,items_info,category_items,dept_authorized,is_active,pic_input,
                    input_time)VALUES 
                    ('".$items_code."','".$name."','".$code."','".$unit."','".$group."','".$info."','".$category."','".$dept_authorized."','1','".$this->current_user['user_id']."','".dbnow()."')";

        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function act_delete($id){
        $sql = "UPDATE mst_items SET is_active='0', pic_edit = '".$this->current_user['user_id']."', edit_time = '".dbnow()."' WHERE items_id = '".$id."'";
        $query = $this->db->query($sql);
        return $query;
    }

    function act_delete_js(){
        $sql = "UPDATE mst_items SET is_active='0', pic_edit = '".$this->current_user['user_id']."', edit_time = '".dbnow()."' WHERE items_id = '".$this->input->post('items_id')."'";
        //test($sql,1);
        $query = $this->db->query($sql);
        return $query;
    }

    function detail_items($id){
        $query = $this->db->query("SELECT items_id,items_code,items_name as items_nama,items_kind,items_unit,items_group,items_info,category_items,dept_authorized FROM mst_items WHERE items_id='".$id."'")->row();
                
        return $query;
    }

    function act_edit(){

        $get_items_code = $this->detail_items($this->input->post('items_id'));
        $items_code     = $this->input->post('kind').substr($get_items_code->items_code,2,10);

        $sql    = "UPDATE mst_items
                    SET items_code = '".$items_code."',
                      items_kind = '".$this->security->xss_clean($this->db->escape_str($this->input->post('code')))."',
                      items_name = '".$this->security->xss_clean($this->db->escape_str($this->input->post('name')))."',
                      items_unit = '".$this->security->xss_clean($this->db->escape_str($this->input->post('unit')))."',
                      items_group = '".$this->security->xss_clean($this->db->escape_str($this->input->post('group')))."',
                      items_info = '".$this->security->xss_clean($this->db->escape_str($this->input->post('info')))."',
                      category_items = '".$this->security->xss_clean($this->db->escape_str($this->input->post('category')))."',
                      dept_authorized= '".$this->security->xss_clean($this->db->escape_str($this->input->post('dept_authorized')))."',
                      pic_edit = '".$this->current_user['user_id']."',
                      edit_time = '".dbnow()."'
                    WHERE items_id = '".$this->security->xss_clean($this->db->escape_str($this->input->post('items_id')))."'";
        //test($sql,1);
        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function get_no_doc($periode){
        $sql    = "SELECT IFNULL(LPAD(MAX(SUBSTRING(items_code,9,4))+1,4,'0'),'0001') nomor_dok FROM `mst_items` WHERE SUBSTRING(items_code,3,6) = '".$periode."'";
        $query  = $this->db->query($sql)->row();
        return $query;

    }

    function act_form_in_pr(){
        $periode = date('Y').date('m');

        $get_items_code = $this->get_no_doc($periode);
        $items_code     = $this->input->post('kind').$periode.$get_items_code->nomor_dok;

        $name           = $this->security->xss_clean($this->db->escape_str($this->input->post('name')));
        $code           = $this->security->xss_clean($this->db->escape_str($this->input->post('code')));
        $unit           = $this->security->xss_clean($this->db->escape_str($this->input->post('unit')));
        $group          = $this->security->xss_clean($this->db->escape_str($this->input->post('group')));
        $info           = $this->security->xss_clean($this->db->escape_str($this->input->post('info')));
        $category       = $this->security->xss_clean($this->db->escape_str($this->input->post('category')));
        $supplier_id    = $this->security->xss_clean($this->db->escape_str($this->input->post('supplier_id')));
        $price_items    = str_replace(',','',$this->security->xss_clean($this->db->escape_str($this->input->post('price_items'))));

        $q_id          = $this->db->query("SELECT items_id+1 id FROM `mst_items` ORDER BY items_id DESC LIMIT 1")->row();
        //test($query->id,1);

        $sql1    = "INSERT INTO mst_items (items_id,items_code,items_name,items_kind,items_unit,items_group,items_info,category_items,is_active,pic_input,input_time)
                    VALUES 
                  ('".$q_id->id."','".$items_code."','".$name."','".$code."','".$unit."','".$group."','".$info."','".$category."','1','".$this->current_user['user_id']."','".dbnow()."')";
        $query1 = $this->db->query($sql1);

        $sql2    = "INSERT INTO mst_supplier_items (supplier_id,items_id,items_price) VALUES ('".$supplier_id."','".$q_id->id."','".$price_items."')";
        $query2 = $this->db->query($sql2);
        
        if ($query1 === false){
            return "ERROR INSERTT";
        }else{
            return $query1; 
        }
    }

    function get_all_items($start=0,$length=10,$search='',$id,$request_id) {
        $sql = "SELECT c.dept_authorized,a.request_no,a.request_date,b.items_id,b.qty qty_request,c.items_code,c.items_name,IFNULL(SUM(f.qty),0) qty_pr, b.qty-IFNULL(SUM(f.qty),0) sisa,d.items_price
                FROM trn_request_01 a 
                LEFT JOIN trn_request_02 b ON a.request_id=b.request_id
                LEFT JOIN db_master.mst_items c ON b.items_id=c.items_id
                LEFT JOIN db_master.mst_supplier_items d ON c.items_id=d.items_id 
                LEFT JOIN trn_pr_01 e ON e.request_id=a.request_id /*AND e.pr_status<>'New'*/
                LEFT JOIN trn_po_01 g ON e.pr_id=g.pr_id AND g.po_status<>'Forced Closed'
                LEFT JOIN trn_po_02 f ON f.po_id=g.po_id AND f.items_id=b.items_id 
                WHERE a.request_id='".$request_id."' AND d.supplier_id='".$id."' AND b.is_active='1'
                AND (c.items_code LIKE '%".$search."%' OR c.items_name LIKE '%".$search."%')
                GROUP BY b.items_id 
                ORDER BY b.items_id
                LIMIT ".$start.", ".$length." ";
        
        // $sql = "SELECT a.supplier_id, a.supplier_code, a.supplier_name, b.items_id, c.items_code, c.items_name, c.items_kind, b.items_price
        //         FROM mst_supplier a 
        //         LEFT JOIN mst_supplier_items b ON a.supplier_id=b.supplier_id
        //         LEFT JOIN mst_items c ON c.items_id=b.items_id
        //         WHERE a.supplier_id=".$id."
        //         AND a.is_active='1' AND (c.items_code LIKE '%".$search."%' OR c.items_name LIKE '%".$search."%') 
        //         ORDER BY c.items_name ASC
        //         LIMIT ".$start.", ".$length." ";
        $item = $this->dbpurch->query($sql)->result();
        return is_for($item) ? $item : false;
    }

    function get_count($id,$request_id){
        $sql =" SELECT count(a.request_no) total
                FROM trn_request_01 a 
                LEFT JOIN trn_request_02 b ON a.request_id=b.request_id
                LEFT JOIN db_master.mst_items c ON b.items_id=c.items_id
                LEFT JOIN db_master.mst_supplier_items d ON c.items_id=d.items_id 
                LEFT JOIN trn_pr_01 e ON e.request_id=a.request_id /*AND e.pr_status<>'New'*/
                LEFT JOIN trn_po_01 g ON e.pr_id=g.pr_id AND g.po_status<>'Forced Closed'
                LEFT JOIN trn_po_02 f ON f.po_id=g.po_id AND f.items_id=b.items_id 
                WHERE a.request_id='".$request_id."' AND d.supplier_id='".$id."' AND b.is_active='1' 
                GROUP BY b.items_id 
                ORDER BY b.items_id";
        // $sql =" SELECT COUNT(a.supplier_id) total
        //         FROM mst_supplier a 
        //         LEFT JOIN mst_supplier_items b ON a.supplier_id=b.supplier_id
        //         LEFT JOIN mst_items c ON c.items_id=b.items_id
        //         WHERE a.supplier_id=".$id." 
        //         AND a.is_active='1' ";
        $item = $this->dbpurch->query($sql)->row();
        return isset($item->total) ? $item->total : 0;
    }

    function get_count_display($start,$length,$search = false,$id,$request_id) {
        $str = '';
        if ($search) {
            $str = " AND (c.items_code LIKE '%".$search."%' OR c.items_name LIKE '%".$search."%') ";
        }

        $sql = "SELECT count(a.request_no) total
                FROM trn_request_01 a 
                LEFT JOIN trn_request_02 b ON a.request_id=b.request_id
                LEFT JOIN db_master.mst_items c ON b.items_id=c.items_id
                LEFT JOIN db_master.mst_supplier_items d ON c.items_id=d.items_id 
                LEFT JOIN trn_pr_01 e ON e.request_id=a.request_id /*AND e.pr_status<>'New'*/
                LEFT JOIN trn_po_01 g ON e.pr_id=g.pr_id AND g.po_status<>'Forced Closed'
                LEFT JOIN trn_po_02 f ON f.po_id=g.po_id AND f.items_id=b.items_id
                WHERE a.request_id='".$request_id."' AND d.supplier_id='".$id."' AND b.is_active='1' ".$str." 
                GROUP BY b.items_id 
                ORDER BY b.items_id  ";

        // $sql = " SELECT COUNT(a.supplier_id) total
        //         FROM mst_supplier a 
        //         LEFT JOIN mst_supplier_items b ON a.supplier_id=b.supplier_id
        //         LEFT JOIN mst_items c ON c.items_id=b.items_id
        //         WHERE a.supplier_id=".$id." 
        //         AND a.is_active='1' ".$str." ";

        $item = $this->dbpurch->query($sql)->row();
        return isset($item->total) ? $item->total : 0;
    }

    function all_items($start=0,$length=10,$search='') {
        $sql = "SELECT  items_id,items_code,items_name,items_kind,items_info,items_unit,items_group,category_items,is_active FROM mst_items WHERE is_active='1' 
                AND (items_code LIKE '%".$search."%' OR items_name LIKE '%".$search."%') 
                ORDER BY items_name ASC
                LIMIT ".$start.", ".$length." ";
        $item = $this->db->query($sql)->result();
        return is_for($item) ? $item : false;
    }

    function all_items_count($start,$length,$search = false) {
        $str = '';
        if ($search) {
            $str = " AND (items_code LIKE '%".$search."%' OR items_name LIKE '%".$search."%')  ";
        }

        $sql = "SELECT COUNT(items_id) total FROM mst_items WHERE is_active='1' ".$str." ";
        $item = $this->db->query($sql)->row();
        return isset($item->total) ? $item->total : 0;
    }

    function items_count(){
        $sql ="SELECT COUNT(items_id) total FROM mst_items WHERE is_active='1' ";
        $item = $this->db->query($sql)->row();
        return isset($item->total) ? $item->total : 0;
    }


}	