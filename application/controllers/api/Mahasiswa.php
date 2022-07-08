<?php
require APPPATH . 'libraries/REST_Controller.php';
class Mahasiswa extends REST_Controller{
  // construct
  public function __construct(){
    parent::__construct();
    $this->load->model('MahasiswaM');
  }

  // hapus data mahasiswa menggunakan method delete
  public function index_post(){
    $response = $this->MahasiswaM->the_mahasiswa(
        $this->post('id_siswa')
      );
    $this->response($response);
  }

  // update data mahasiswa menggunakan method put
  public function index_put(){
    $response = $this->MahasiswaM->update_mahasiswa(
        $this->put('id_siswa'),
        $this->put('nama'),
        md5($this->put('password'))
      );
    $this->response($response);
  }

}

?>