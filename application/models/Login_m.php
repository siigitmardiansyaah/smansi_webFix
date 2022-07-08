<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_m extends CI_Model {
    
 function login($nip){
        $this->db->where('nis', $nip); // Untuk menambahkan Where Clause : username='$username'
        $result = $this->db->get('tbsiswa')->row(); // Untuk mengeksekusi dan mengambil data hasil query
        return $result;
    }

    function register($nis, $nama, $device, $password){
        $this->db->where('nis', $nis); // Untuk menambahkan Where Clause : username='$username'
        $result = $this->db->get('tbsiswa')->num_rows(); // Untuk menmengeksekusi dan mengambil data hasil query
        if($result == 1){
            $this->db->where('nis', $nis); // Untuk menambahkan Where Clause : username='$username'
            $this->db->update('tbsiswa', array('nama' => $nama, 'device_id' => $device, 'password' => $password)); // Untuk mengeksekusi dan mengupdate data hasil query
            return true;
        }else{
            return null;
        }
    }
}