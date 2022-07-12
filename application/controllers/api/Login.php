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
    function index_post()
    {
            $nis = $this->input->post('nis');
            $device = $this->input->post('device_id');
            $password = md5($this->input->post('password'));
            $response = $this->login_m->login($nis,$password,$device);
            $this->response($response);
    }

}
