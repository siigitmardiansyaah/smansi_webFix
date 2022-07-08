<?php
require APPPATH . 'libraries/REST_Controller.php';
header("Content-Type: application/json; charset=UTF-8");

class Login extends REST_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_m');
    }

    // method index untuk menampilkan semua data mahasiswa dengan get
    function login_post()
    {
        // Get the post data
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $nis = $this->input->post('nis');
            $device = $this->input->post('device_id');
            $password = md5($this->input->post('password'));

            if ($nis == null || $password == null) {
                $this->response(array('status' => 'fail', 'message' => 'Kolom Tidak Boleh Kosong','kode'=> 2));
            } else {
                $data = $this->login_m->login($nis);
                if ($data == null) {
                    $this->response(array('status' => 'fail', 'message' => 'nis Tidak Terdaftar','kode'=> 2));
                } else {
                    if ($data->device_id != $device) {
                        $this->response(array('status' => 'fail', 'message' => 'Anda Login Di Device Yang Berbeda','kode'=> 2));
                    } else if ($data->password == $password && $data->device_id == $device) {
                        $this->response(array(
                            'status' => 'success',
                            'message' => 'Login Berhasil',
                            'kode'=> 1,
                            'data_login' => [
                                'id_siswa' => $data->id_siswa,
                                'nis' => $data->nis,
                                'nama' => $data->nama,
                                'device_id' => $data->device_id,
                                'id_kelas' => $data->id_kelas
                            ]
                        ));
                    } else {
                        $this->response(array('status' => 'fail', 'message' => 'Password Salah','kode'=> 2));
                    }
                }
            }
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Method Not Allowed', 502));
        }
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
