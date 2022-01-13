<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class MY_Controller extends CI_Controller 
{
  public function cekLogin(){
      // Jika belum ada session username maka 
      // redirect ke halaman auth/login
      if (!$this->session->userdata('username')) {
        redirect('auth/login');
      }
    }
 
    public function isMenu(){
      $this->load->model("menu_model");
      // Mengambil data session
      $akses    = $this->menu_model->permission_menu($this->current_user['user_id'],$this->session->userdata('ses_menu')['active_submenu']);
      //test($akses,1);
      //$userData = $this->getUserData();
   
      // Jika level user bukan administrator
      // maka redirect ke halaman 404
      if ($akses !== 1){
        $this->session->set_flashdata('alert','Anda Tidak Boleh Masuk ke dalam halaman ini. Harap Hubungi admin IT. Terimakasih.');
        redirect('welcome');
      }
    }
 
}
?>