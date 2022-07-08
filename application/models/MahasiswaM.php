<?php
// extends class Model
class MahasiswaM extends CI_Model{

  // response jika field ada yang kosong
  public function empty_response(){
    $response['status']=502;
    $response['error']=true;
    $response['message']='Field tidak boleh kosong';
    return $response;
  }

  // mengambil data mahasiswa
  public function the_mahasiswa($nis){
    if($nis == ''){
      $all = $this->db->get("tbsiswa")->result();
      $response['status']=200;
      $response['error']=false;
      $response['mahasiswa']=$all;
      return $response;
    }else{
      $where = array(
        "id_siswa"=>$nis
      );
      $this->db->where($where);
      $theid = $this->db->get("tbsiswa")->result();
      if($theid){
        $response['status']=200;
        $response['error']=false;
        $response['mahasiswa']=$theid;
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data mahasiswa gagal ditampilkan.';
        return $response;
      }
    }
  }



  // update password mahasiswa
  public function update_mahasiswa($nis,$nama, $password){
    if(empty($nis) || empty($password)){
      return $this->empty_response();
    }else{
      $where = array(
        "id_siswa"=>$nis
      );
      if($nama != null){
        $set = array(
          "nama" => $nama,
          "password"=>$password
        );
      }else{
        $set = array(
          "password"=>$password
        );
      }
      $this->db->where($where);
      $update = $this->db->update("tbsiswa",$set);
      if($update){
        $response['status']=200;
        $response['error']=false;
        $response['message']='Data mahasiswa diubah.';
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data mahasiswa gagal diubah.';
        return $response;
      }
    }
  }
}

?>