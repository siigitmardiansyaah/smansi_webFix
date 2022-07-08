<?php
require APPPATH . 'libraries/REST_Controller.php';
class Matkul extends REST_Controller{
  // construct
  public function __construct(){
    parent::__construct();
    $this->load->model('MatkulM');
  }

  // method index untuk menampilkan semua data matkul dengan get
  public function index_post(){
    $id_siswa = $this->input->post('id_siswa');
    $response = $this->MatkulM->all_matkul($id_siswa);
    $this->response($response);
  }

  
}

?>