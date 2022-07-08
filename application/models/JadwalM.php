<?php
// extends class Model
class JadwalM extends CI_Model{

///////////////////////// CRUD API  /////////////////////////

  // response jika field ada yang kosong
  public function empty_response(){
    $response['status']=502;
    $response['error']=true;
    $response['message']='Field tidak boleh kosong';
    return $response;
  }

  // function untuk insert data ke tabel tbjadwal
  public function add_jadwal($id_mapel, $id_kelas, $nip, $waktu){
    if(empty($id_mapel) || empty($id_kelas) || empty($nip) || empty($waktu) ){
      return $this->empty_response();
    }else{
      $data = array(
        "id_mapel"=>$id_mapel,
        "id_kelas"=>$id_kelas,
        "nip"=>$nip,
        "waktu"=>$waktu
      );
      $insert = $this->db->insert("tbjadwal", $data);
      if($insert){
        $response['status']=200;
        $response['error']=false;
        $response['message']='Data jadwal ditambahkan.';
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data jadwal gagal ditambahkan.';
        return $response;
      }
    }
  }

  // mengambil semua data jadwal
  public function all_jadwal(){
    $all = $this->db->get("tbjadwal")->result();
    $response['status']=200;
    $response['error']=false;
    $response['jadwal']=$all;
    return $response;
  }

  // mengambil data jadwal
  public function the_jadwal($id_jadwal){
    if($id_jadwal == ''){
      $all = $this->db->get("tbjadwal")->result();
      $response['status']=200;
      $response['error']=false;
      $response['jadwal']=$all;
      return $response;
    }else{
      $where = array(
        "id_jadwal"=>$id_jadwal
      );
      $this->db->where($where);
      $theid = $this->db->get("tbjadwal")->result();
      if($theid){
        $response['status']=200;
        $response['error']=false;
        $response['jadwal']=$theid;
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data jadwal gagal ditampilkan.';
        return $response;
      }
    }
  }

  // mengambil data jadwal siswa tertentu
  public function mahasiswa_jadwal($nis){
    if($nis == ''){
      return $this->empty_response();
    }else{
      $this->db->select('tbmapel.nama_mapel as nama_mapel, tbjadwal.waktu as waktu, tbguru.nama_dosen as nama_dosen');
      $this->db->group_by('nama_mapel');
      $this->db->from('tbjadwal');
      $this->db->join('tbkelas', 'tbkelas.id_kelas = tbjadwal.id_kelas');
      $this->db->join('tbsiswa', 'tbsiswa.id_kelas = tbjadwal.id_kelas');
      $this->db->join('tbguru', 'tbguru.nip = tbjadwal.nip');
      $this->db->join('tbmapel', 'tbmapel.id_mapel = tbjadwal.id_mapel');
      $this->db->where('tbsiswa.nis', $nis);
      $theid = $this->db->get()->result();
      if($theid){
        return $theid;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data jadwal gagal ditampilkan.';
        return $response;
      }
    }
  }

  
  // hapus data jadwal
  public function delete_jadwal($id_jadwal){
    if($id_jadwal == ''){
      return $this->empty_response();
    }else{
      $where = array(
        "id_jadwal"=>$id_jadwal
      );
      $this->db->where($where);
      $delete = $this->db->delete("tbjadwal");
      if($delete){
        $response['status']=200;
        $response['error']=false;
        $response['message']='Data jadwal dihapus.';
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data jadwal gagal dihapus.';
        return $response;
      }
    }
  }

  // update jadwal
  public function update_jadwal($id_jadwal, $id_mapel, $id_kelas, $nip, $waktu){
    if($id_jadwal == '' || empty($id_mapel) || empty($id_kelas) || empty($nip) || empty($waktu) ){
      return $this->empty_response();
    }else{
      $where = array(
        "id_jadwal"=>$id_jadwal
      );
      $set = array(
        "id_mapel"=>$id_mapel,
        "id_kelas"=>$id_kelas,
        "nip"=>$nip,
        "waktu"=>$waktu
      );
      $this->db->where($where);
      $update = $this->db->update("tbjadwal",$set);
      if($update){
        $response['status']=200;
        $response['error']=false;
        $response['message']='Data jadwal diubah.';
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data jadwal gagal diubah.';
        return $response;
      }
    }
  }

///////////////////////// CRUD WEB  /////////////////////////


  // menampilkan jadwal berdasarkan nip
  public function tampil_jadwal($nip){
    $this->db->select('tbjadwal.id_jadwal as id_jadwal, tbjadwal.waktu as waktu, tbkelas.nama_kelas as nama_kelas, tbmapel.nama_mapel as nama_mapel');
    $this->db->order_by('waktu', 'ASC');
    $this->db->from('tbjadwal');
    $this->db->join('tbkelas', 'tbkelas.id_kelas = tbjadwal.id_kelas');
    $this->db->join('tbguru', 'tbguru.nip = tbjadwal.nip');
    $this->db->join('tbmapel', 'tbmapel.id_mapel = tbjadwal.id_mapel');
    $this->db->where('tbjadwal.nip', $nip);
    $result = $this->db->get();
    return $result->result_array();
  }

  //menampilkan jadwal berdasarkan id_jadwal untuk update
  public function tampil_jadwal_update($id_jadwal){
    $this->db->select('tbjadwal.id_jadwal as id_jadwal, tbjadwal.nip as nip, tbjadwal.waktu as waktu, tbkelas.nama_kelas as nama_kelas, tbmapel.nama_mapel as nama_mapel, tbmapel.id_mapel as id_mapel');
    $this->db->order_by('waktu', 'ASC');
    $this->db->from('tbjadwal');
    $this->db->join('tbkelas', 'tbkelas.id_kelas = tbjadwal.id_kelas');
    $this->db->join('tbguru', 'tbguru.nip = tbjadwal.nip');
    $this->db->join('tbmapel', 'tbmapel.id_mapel = tbjadwal.id_mapel');
    $this->db->where('tbjadwal.id_jadwal', $id_jadwal);
    $result = $this->db->get();
    return $result->result_array();
  }

  // update profil
  public function update_jadwal_web($data, $id_jadwal){
    $this->db->where('id_jadwal', $id_jadwal);
    $this->db->update('tbjadwal', $data);
  }

  //tapil data dashbord
  public function count($nip){    
    $this->db->select('count(nip) as kelas, count(id_mapel) as matkul');
    $this->db->from('tbjadwal');
    $this->db->where('nip',$nip);
    $result = $this->db->get();
    return $result->result_array();
  }

    public function count_mahasiswa($nip){    
    $this->db->select('count(tbsiswa.nama) as mhs');
    $this->db->from('tbjadwal');
    $this->db->join('tbsiswa','tbsiswa.id_kelas = tbjadwal.id_kelas');
    $this->db->where('tbjadwal.nip',$nip);
    $result = $this->db->get();
    return $result->result_array();
  }
}

?>