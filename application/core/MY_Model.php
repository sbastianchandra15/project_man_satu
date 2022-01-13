<?php defined('BASEPATH') || exit('No direct script access allowed');

class MY_Model extends CI_Model {

  function __construct(){
    parent::__construct();
  }


	function activity_user($activity, $module, $table)
	{
		//$db = $this->load->database('master', true);

		$data = array(
			'activity' => $activity,
		  'module' => $module,
			'table' => $table,
			'ip' => $this->input->ip_address(),
			'pic_input' => $this->session->userdata('ses_sangati')['user_id'],
			'input_time' => dbnow()
		);

    //test($data,1);

		$this->db->insert('mst_user_activity', $data);
	}


}
