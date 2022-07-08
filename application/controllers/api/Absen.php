<?php
require APPPATH . 'libraries/REST_Controller.php';
class Absen extends REST_Controller{
  // construct
  public function __construct(){
    parent::__construct();
    $this->load->model('AbsenM');
  }

  // method index untuk menampilkan semua data absen dengan get
  public function index_post(){
    $id_siswa = $this->input->post('id_siswa');
    $id_mapel = $this->input->post('id_mapel');
    $response = $this->AbsenM->all_absen($id_siswa,$id_mapel);
    $this->response($response);
  }

  // untuk menambah absen menggunakan method post
  public function add_post(){
    $response = $this->AbsenM->add_absen(
        $this->post('id_jadwal'),
        $this->post('id_qr'),
        $this->post('id_siswa'),
        $this->post('long_gps'),
        $this->post('lang_gps')
      );
    $this->response($response);
  }

  // cek apakah sudah absen
  public function cekabsen_post(){
    $response = $this->AbsenM->cek_absen(
        $this->post('nis'),
        $this->post('id_qr'),
        $this->post('id_jadwal')
      );
    $this->response($response);
  }
}

?>