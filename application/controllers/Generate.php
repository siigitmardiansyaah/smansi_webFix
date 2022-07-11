<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate extends CI_Controller {
    public function __construct()
    {
		parent::__construct();
		$this->load->model('JadwalM');
		$this->load->model('QrM');
		$this->load->library('ciqrcode');
	}
    
	public function index()
	{
		if (!empty($this->session->file)) {
			unlink($_SERVER['DOCUMENT_ROOT'].'/sensasiq/assets/qrimg/'.$this->session->file);
			$this->session->unset_userdata('file');

		}
		$this->session->set_flashdata('activemenu','generate'); // Untuk active sidebar dinamis
 	   	$data['jadwal'] = $this->JadwalM->tampil_jadwal($this->session->nip);
 	   	$this->load->view('generate', $data);
	}

	public function generated(){		
		$id_jadwal = $this->input->post('id_jadwal');
		if (!empty($id_jadwal)) {
			$this->db->trans_start();			
        	$data['datajadwal'] = $this->db->query("SELECT tbjadwal.id_jadwal as id_jadwal, tbjadwal.nip as nip, tbjadwal.waktu as waktu, tbkelas.nama_kelas as nama_kelas, tbmapel.nama_mapel as nama_mapel, tbmapel.id_mapel as id_mapel
			FROM tbjadwal
			JOIN tbkelas ON tbkelas.id_kelas = tbjadwal.id_kelas
			JOIN tbguru ON tbguru.nip = tbjadwal.nip
			JOIN tbmapel ON tbmapel.id_mapel = tbjadwal.id_mapel
			WHERE tbjadwal.id_jadwal = $id_jadwal ORDER BY waktu ASC")->result_array();

			$maxIDQR = $this->db->query("SELECT * FROM tbqr order by id_qr DESC")->row();
			$id_qrnew = $maxIDQR->id_qr + 1;

        	foreach ($data as $dataJadwal) :
		      $datainsert = array(
		        "nip" => $dataJadwal[0]['nip'],
		        "qr"  => $qrRaw = $dataJadwal[0]['id_jadwal']."-".$id_qrnew."-".$dataJadwal[0]['nama_kelas']."-".$dataJadwal[0]['nip']."-".time()
		      );
		    endforeach;
			$this->db->trans_complete();						

		    $lokasiFileQr = $_SERVER['DOCUMENT_ROOT'].'/smansi_web/assets/qrimg/';
			$file_name = $qrRaw.".png";
			$tempdir = $lokasiFileQr.$file_name;
			QRcode::png($qrRaw,$tempdir,QR_ECLEVEL_H,15,0);
			$this->QrM->generateQr($datainsert);
			$infoQr = array(
				"fileQr"	=> $file_name,
				"qr"		=> $qrRaw,
			);	
			$this->session->set_userdata('file', $file_name);					
			$this->load->view('generated', $infoQr);
		} else {				
			redirect('generate');
		}
	}

	// public function generated_refresh($qr){			
	// 	$data = array(
	// 		"nip"	=>	$this->session->nip,
	// 		"qr"	=>	$qr
	// 	);

	// 	$dataQr['dataQr'] = $this->QrM->updateQr($data);			
	// 	foreach ($dataQr as $datanya) :
	// 	    $dataku = array(
	// 	        "nip" => $datanya[0]['nip'],
	// 	        "qr"  => $qrRaw = $datanya[0]['qr'],		        
	// 	    );
	// 	endforeach;
	// 	$lokasiFileQr = $_SERVER['DOCUMENT_ROOT'].'/sensasiq/assets/qrimg/';		
	// 	$file_name = $qrRaw.".png";
	// 	$tempdir = $lokasiFileQr.$file_name;
	// 	QRcode::png($qrRaw,$tempdir,QR_ECLEVEL_H,15,0);
	// 	$infoQr = array(
	// 		"fileQr"	=> $file_name,
	// 		"qr"		=> $qrRaw,
	// 	);
	// 	$session['file'] = $file_name;
	// 	$this->session->set_userdata($session);
	// 	$this->load->view('generated_qr_img', $infoQr);
	// }
	
}