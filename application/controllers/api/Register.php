<?php
require APPPATH . 'libraries/REST_Controller.php';
header("Content-Type: application/json; charset=UTF-8");

class Register extends REST_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_m');
    }

    function register_post()
    {
            $nis = $this->input->post('nis');
            $nama = $this->input->post('nama');
            $device = $this->input->post('device_id');
            $password = md5($this->input->post('password'));

            if($nis == null || $nama == null || $device == null || $password == null){
                $this->response(array('status' => 'fail', 'message' => 'Kolom Tidak Boleh Kosong','kode'=> 2));
            }else{
                $data = $this->login_m->register($nis, $nama, $device, $password);
                if($data == null){
                    $this->response(array('status' => 'fail', 'message' => 'nis Tidak Terdaftar','kode'=> 2));
                } else if($data) {
                    $this->response(array(
                        'status' => 'success',
                        'message' => 'Register Berhasil',
                        'kode'=> 1,
                        'data_register' => $data
                    ));
                }
            }
    }
}
