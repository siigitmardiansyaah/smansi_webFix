<?php
// extends class Model
class MatkulM extends CI_Model{

  // response jika field ada yang kosong
  public function empty_response(){
    $response['status']=502;
    $response['error']=true;
    $response['message']='Field tidak boleh kosong';
    return $response;
  }

  // mengambil semua data matkul
  public function all_matkul($id_siswa){
    $this->db->select("a.id_mapel,d.nama_mapel, c.nama_kelas, DATE_FORMAT(a.waktu, '%W,%H:%i') as waktu");
    $this->db->join('tbsiswa b','a.id_siswa = b. id_siswa');
    $this->db->join('tbkelas c','a.id_kelas = c.id_kelas');
    $this->db->join('tbmapel d','a.id_mapel = d.id_mapel');
    $all = $this->db->get("tbjadwal_siswa a")->result();
    $response['status']=200;
    $response['error']=false;
    $response['matkul']=$all;
    return $response;
  }

}

?>