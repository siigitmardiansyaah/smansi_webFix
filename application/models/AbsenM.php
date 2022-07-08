<?php
date_default_timezone_set("Asia/Bangkok");
// extends class Model
class AbsenM extends CI_Model{

  // response jika field ada yang kosong
  public function empty_response(){
    $response['status']=502;
    $response['error']=true;
    $response['message']='Field tidak boleh kosong';
    return $response;
  }

  // function untuk insert data ke tabel tbabsen
  public function add_absen($id_jadwal, $id_qr, $id_siswa,$long_gps,$lan_gps){
    $long_smk = -6.253025502633878 *  0.0174532925;
    $lang_smk = 107.06103869673028 *  0.0174532925;
    $long_gps_d = $long_gps *  0.0174532925;
    $lang_gps_d = $lan_gps *  0.0174532925;
    $x = ($long_smk - $long_gps_d) * cos(($lang_smk-$lang_gps_d)/2);
    $y = ($lang_smk - $lang_gps_d);
    $jarak = sqrt(($x * $x) + ($y * $y)) * 6371;
		$banding = floor($jarak * 1000);
    if($banding > 5)
    {
      $response['status']=502;
      $response['error']=true;
      $response['message']='Jarak anda terlalu jauh untuk absen';
      return $response;
    }else{
      $query1 = $this->db->query("SELECT * FROM tbjadwal where id_jadwal = $id_jadwal")->row();
      $hari = date('l',strtotime($query1->waktu));
      $jam_mulai =date('H:i:s',strtotime($query1->waktu));
      $jam_selesai1 = date('H:i:s',strtotime($jam_mulai.'+1 hour'.'+30 minutes'));
      $hari_ini = date('l');
      $jam_sekarang = date('H:i:s');
      $query = $this->db->query("SELECT * from tbabsen where id_jadwal = $id_jadwal AND id_qr = $id_qr AND id_siswa = $id_siswa")->num_rows();
      if($query > 0)
      {
      $response['status']=502;
      $response['error']=true;
      $response['message']='Anda Sudah Absen Sebelumnya';
      return $response;
      }else{
        if($hari_ini == $hari && $jam_sekarang >= $jam_mulai && $jam_sekarang <= $jam_selesai1)
        {
          $data = array(
            "id_jadwal"=>$id_jadwal,
            "id_qr"=>$id_qr,
            "id_siswa"=>$id_siswa,
            "waktu_absen" =>date('Y-m-d h:i:s'),
            "keterangan" => 'Hadir'
          );
          $insert = $this->db->insert("tbabsen", $data);
          if($insert){
            $response['status']=200;
            $response['error']=false;
            $response['message']='Data absen ditambahkan.';
            return $response;
          }else{
            $response['status']=502;
            $response['error']=true;
            $response['message']='Data absen gagal ditambahkan.';
            return $response;
          }
        }else if($hari_ini != $hari){
          $response['status']=502;
          $response['error']=true;
          $response['message']='Anda Absen di beda hari dengan mata pelajaran';
        }else if($jam_sekarang <= $jam_mulai && $jam_sekarang >= $jam_selesai1){
          $response['status']=502;
          $response['error']=true;
          $response['message']='Anda Belum Memasuki Jam Absen / Sudah Melewati Jam Absen';
        }
      }
    }
  }

  // mengambil semua data absen
  public function all_absen($id_siswa,$id_mapel){
    $this->db->select("a.keterangan, DATE_FORMAT(a.waktu_absen, '%W, %H:%i') as waktu_absen");
    $this->db->join("tbjadwal b",'a.id_jadwal = b.id_jadwal');
    $this->db->join("tbqr c","a.id_qr = c.id_qr");
    $this->db->join("tbsiswa d",'a.id_siswa = d.id_siswa');
    $this->db->where("b.id_mapel",$id_mapel);
    $this->db->where("a.id_siswa",$id_siswa);
    $all = $this->db->get("tbabsen a")->result();
    $response['status']=200;
    $response['error']=false;
    $response['absen']=$all;
    return $response;
  }

  // mengambil data absen berdasarkan id_absen tertentu
  public function the_absen($id_absen){
    if($id_absen == ''){
      $all = $this->db->get("tbabsen")->result();
      $response['status']=200;
      $response['error']=false;
      $response['absen']=$all;
      return $response;
    }else{
      $where = array(
        "id_absen"=>$id_absen
      );
      $this->db->where($where);
      $theid = $this->db->get("tbabsen")->result();
      if($theid){
        $response['status']=200;
        $response['error']=false;
        $response['absen']=$theid;
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data absen gagal ditampilkan.';
        return $response;
      }
    }
  }


  // mengambil data absen berdasarkan nis tertentu
  public function riwayat_absen($nis){
    if($nis == ''){
      return $this->empty_response();
    }else{
      $this->db->select('tbabsen.waktu_absen_absen as waktu, tbmapel.nama_mapel as nama_mapel, tbguru.nama_dosen as nama_dosen');
      $this->db->from('tbjadwal');
      $this->db->join('tbmapel','tbmapel.id_mapel = tbjadwal.id_mapel');
      $this->db->join('tbguru', 'tbguru.nip = tbjadwal.nip');
      $this->db->join('tbkelas','tbkelas.id_kelas = tbjadwal.id_kelas');
      $this->db->join('tbabsen','tbabsen.id_jadwal = tbjadwal.id_jadwal');
      $this->db->join('tbsiswa', 'tbsiswa.nis = tbabsen.id_siswa');
      $this->db->join('tbqr', 'tbqr.id_qr = tbabsen.id_qr');
      $this->db->where('tbabsen.id_siswa', $nis);
      $theid = $this->db->get()->result();
      if($theid){
        return $theid;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data absen gagal ditampilkan.';
        return $response;
      }
    }
  }

  // cek apakah sudah absen
  public function cek_absen($nis, $id_qr, $id_jadwal){
    if(empty($nis) || empty($id_qr) || empty($id_jadwal)){
      return $this->empty_response();
    }else{
      $where = array(
        "nis"=>$nis,
        "id_qr"=>$id_qr,
        "id_jadwal"=>$id_jadwal
      );
      $this->db->where($where);
      $theid = $this->db->get("tbabsen")->result();
      if($theid){
        $response['status']=200;
        $response['error']=false;
        $response['absen']=$theid;
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data absen gagal ditampilkan.';
        return $response;
      }
    }
  }

  
  // hapus data absen
  public function delete_absen($id_absen){
    if($id_absen == ''){
      return $this->empty_response();
    }else{
      $where = array(
        "id_absen"=>$id_absen
      );
      $this->db->where($where);
      $delete = $this->db->delete("tbabsen");
      if($delete){
        $response['status']=200;
        $response['error']=false;
        $response['message']='Data absen dihapus.';
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data absen gagal dihapus.';
        return $response;
      }
    }
  }

  // update absen
  public function update_absen($id_absen, $id_jadwal, $id_qr, $nis, $waktu){
    if( empty($id_absen) || empty($id_jadwal) || $id_qr == '' || empty($nis) || empty($waktu) ){
      return $this->empty_response();
    }else{
      $where = array(
        "id_absen"=>$id_absen
      );
      $set = array(
        "id_jadwal"=>$id_jadwal,
        "id_qr"=>$id_qr,
        "nis"=>$nis,
        "waktu"=>$waktu
      );
      $this->db->where($where);
      $update = $this->db->update("tbabsen",$set);
      if($update){
        $response['status']=200;
        $response['error']=false;
        $response['message']='Data absen diubah.';
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data absen gagal diubah.';
        return $response;
      }
    }
  }

  //riwayat generate qr
   public function tampil_riwayat($nip){    
    $this->db->select('tbmapel.nama_mapel, tbabsen.waktu_absen, tbkelas.nama_kelas');
    $this->db->from('tbjadwal');
    $this->db->group_by('tbabsen.id_qr');    
    $this->db->join('tbmapel','tbmapel.id_mapel = tbjadwal.id_mapel');
    $this->db->join('tbkelas','tbkelas.id_kelas = tbjadwal.id_kelas');
    $this->db->join('tbabsen','tbabsen.id_jadwal = tbjadwal.id_jadwal');
    $this->db->where('tbjadwal.nip',$nip);
    $result = $this->db->get();
    return $result->result_array();
  }

  public function riwayat_generate($nip){
    $this->db->select('tbjadwal.nip as nip,tbmapel.nama_mapel as matkul, tbabsen.waktu_absen as waktu');
    $this->db->from('tbjadwal');      
    $this->db->group_by('tbabsen.id_qr');
    $this->db->order_by('tbabsen.id_absen','desc');
    $this->db->join('tbmapel','tbmapel.id_mapel = tbjadwal.id_mapel');
    $this->db->join('tbkelas','tbkelas.id_kelas = tbjadwal.id_kelas');
    $this->db->join('tbabsen','tbabsen.id_jadwal = tbjadwal.id_jadwal');
    $this->db->where('tbjadwal.nip',$nip);
    $result = $this->db->limit(5,0)->get();
    return $result->result_array();
  }

  //tampil data rekapitulasi
  public function tampil_rekapitulasi($nip){
    $this->db->select('tbabsen.id_absen as id,tbabsen.waktu_absen as waktu,tbsiswa.nis as nis,tbsiswa.nama as nama, tbmapel.nama_mapel as matkul, tbkelas.nama_kelas as kelas');
    $this->db->from('tbabsen');          
    $this->db->join('tbjadwal','tbabsen.id_jadwal = tbjadwal.id_jadwal');    
    $this->db->join('tbkelas','tbkelas.id_kelas = tbjadwal.id_kelas');  
    $this->db->join('tbmapel','tbmapel.id_mapel = tbjadwal.id_mapel');
    $this->db->join('tbsiswa','tbsiswa.nis = tbabsen.id_siswa'); 
    $this->db->where('tbjadwal.nip',$nip);
    $result = $this->db->get();
    return $result->result_array();
  }

  public function info_kelas($nip){
    $this->db->select('tbjadwal.id_kelas as id,tbkelas.nama_kelas as kelas');
    $this->db->from('tbabsen');
    $this->db->group_by('tbkelas.nama_kelas');          
    $this->db->join('tbjadwal','tbabsen.id_jadwal = tbjadwal.id_jadwal');    
    $this->db->join('tbkelas','tbkelas.id_kelas = tbjadwal.id_kelas');  
    $this->db->join('tbmapel','tbmapel.id_mapel = tbjadwal.id_mapel');
    $this->db->join('tbsiswa','tbsiswa.nis = tbabsen.id_siswa'); 
    $this->db->where('tbjadwal.nip',$nip);
    $result = $this->db->get();
    return $result->result_array();
  }

   public function cetak_rekapitulasi($kelas){
    if( empty($kelas)){
      return $this->empty_response();
    }else{
    $this->db->select('tbabsen.id_absen as id,tbabsen.waktu_absen as waktu,tbsiswa.nis as nis,tbsiswa.nama as nama, tbmapel.nama_mapel as matkul, tbkelas.nama_kelas as kelas');
    $this->db->from('tbabsen');          
    $this->db->join('tbjadwal','tbabsen.id_jadwal = tbjadwal.id_jadwal');    
    $this->db->join('tbkelas','tbkelas.id_kelas = tbjadwal.id_kelas');  
    $this->db->join('tbmapel','tbmapel.id_mapel = tbjadwal.id_mapel');
    $this->db->join('tbsiswa','tbsiswa.nis = tbabsen.id_siswa'); 
    $this->db->where('tbjadwal.id_kelas',$kelas);
    $this->db->where('tbjadwal.nip',$this->session->nip);
    $result = $this->db->get();
    return $result->result_array();
    }
  }
}

?>