<?php
// extends class Model
class DosenM extends CI_Model{


///////////////////////// CRUD API  /////////////////////////

  // response jika field ada yang kosong
  public function empty_response(){
    $response['status']=502;
    $response['error']=true;
    $response['message']='Field tidak boleh kosong';
    return $response;
  }

  // function untuk insert data ke tabel tbguru
  public function add_dosen($nip, $nama_dosen, $password){
    if(empty($nama_dosen) || empty($nip) || empty($password)){
      return $this->empty_response();
    }else{
      $data = array(
        "nip"=>$nip,
        "nama_dosen"=>$nama_dosen,
        "password"=>$password
      );
      $insert = $this->db->insert("tbguru", $data);
      if($insert){
        $response['status']=200;
        $response['error']=false;
        $response['message']='Data dosen ditambahkan.';
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data dosen gagal ditambahkan.';
        return $response;
      }
    }
  }

  // mengambil semua data dosen
  public function all_dosen(){
    $all = $this->db->get("tbguru")->result();
    $response['status']=200;
    $response['error']=false;
    $response['dosen']=$all;
    return $response;
  }

  // mengambil data dosen tertentu berdasarkan nip
  public function the_dosen($nip){
    if($nip == ''){
      $all = $this->db->get("tbguru")->result();
      $response['status']=200;
      $response['error']=false;
      $response['dosen']=$all;
      return $response;
    }else{
      $where = array(
        "nip"=>$nip
      );
      $this->db->where($where);
      $theid = $this->db->get("tbguru")->result();
      if($theid){
        $response['status']=200;
        $response['error']=false;
        $response['dosen']=$theid;
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data dosen gagal ditampilkan.';
        return $response;
      }
    }
  }

  
  // hapus data dosen
  public function delete_dosen($nip){
    if($nip == ''){
      return $this->empty_response();
    }else{
      $where = array(
        "nip"=>$nip
      );
      $this->db->where($where);
      $delete = $this->db->delete("tbguru");
      if($delete){
        $response['status']=200;
        $response['error']=false;
        $response['message']='Data dosen dihapus.';
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data dosen gagal dihapus.';
        return $response;
      }
    }
  }

  // update dosen
  public function update_dosen($nip, $nama_dosen, $password){
    if($nip == '' || empty($nama_dosen) || empty($password)){
      return $this->empty_response();
    }else{
      $where = array(
        "nip"=>$nip
      );
      $set = array(
        "nama_dosen"=>$nama_dosen,
        "password"=>$password
      );
      $this->db->where($where);
      $update = $this->db->update("tbguru",$set);
      if($update){
        $response['status']=200;
        $response['error']=false;
        $response['message']='Data dosen diubah.';
        return $response;
      }else{
        $response['status']=502;
        $response['error']=true;
        $response['message']='Data dosen gagal diubah.';
        return $response;
      }
    }
  }

///////////////////////// CRUD WEB  /////////////////////////

  // menampilkan data dosen untuk profile page
  public function tampildosen($nip){
    $where = array(
      "nip"=>$nip
    );
    $this->db->where($where);
    $result = $this->db->get('tbguru')->row();
    if($result){
      return $result;
    }
  }

  // update profil
  public function update_profil($data, $nip){
    $this->db->where('nip', $nip);
    $exec = $this->db->update("tbguru", $data);
    if ($exec) {
      $this->session->unset_userdata('nama_dosen');
      $this->session->set_userdata('nama_dosen', $data['nama_dosen']);
    }
  }

}

?>