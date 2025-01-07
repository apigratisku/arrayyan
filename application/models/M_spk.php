<?php

class M_spk extends CI_Model {

    public function __construct() {
        $this->load->database();
		$this->load->config('api_bot', true);
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_spk', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_spk');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function get_spk($id) {
            $this->db->select('*');
            $this->db->from('blip_spk');
			//$this->db->limit(1, 1);
			$this->db->where("id_pelanggan", $id);
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        return $response;
    }
	
	public function get_token($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_spk', array('token' => $id));
            $response = $query->row_array();
        }

        return $response;
    }
	
	
    public function simpan() {
		$spk_data = $this->db->get_where('blip_spk', array('token' =>$this->input->post('token')))->row_array();
		if($spk_data > 0){
		return $this->session->set_flashdata('error', 'Error. Duplikat data token!');
		}
		else{
		date_default_timezone_set("Asia/Singapore");
		$data = array(
		'token' => $this->input->post('token'),
		'id_petugas' => $this->input->post('id_petugas'),
		'id_pelanggan' => $this->input->post('id_pelanggan'),
		'id_bts' => $this->input->post('id_bts'),
		'id_survey' => $this->input->post('id_survey'),
		'kegiatan' => $this->input->post('kegiatan'),	
		'sub_kegiatan' => $this->input->post('sub_kegiatan'),	
		'waktu_mulai' => $this->input->post('waktu_mulai'),
		'waktu_selesai' => $this->input->post('waktu_selesai'),			
		'status' => $this->input->post('status'),
		'keterangan' => $this->input->post('keterangan'),
		'link_dokumentasi' => $this->input->post('link_dokumentasi'),
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$insert_db = $this->db->insert('blip_spk', $data);
		
		if($insert_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data SPK",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $this->input->post('id_pelanggan')))->row_array();
		$petugas = $this->db->get_where('gm_operator', array('id' => $this->input->post('id_petugas')))->row_array();
		if($this->input->post('id_pelanggan') != NULL){$lokasi_pekerjaan = $pelanggan['nama'];}elseif($this->input->post('id_survey') != NULL){$lokasi_pekerjaan = $this->input->post('id_survey');}elseif($this->input->post('id_bts') != NULL){$lokasi_pekerjaan = $this->input->post('id_bts');}
			
			//Push TG
			if(!empty($this->input->post('notif_tg'))){
			$pesan_tg = "<b>Surat Perintah Kerja</b>\n\n";
			$pesan_tg .= "Lokasi Pekerjaan: <b>".$lokasi_pekerjaan."</b>\nKegiatan: ".$this->input->post('kegiatan')."\nDetail Kegiatan: ".$this->input->post('sub_kegiatan')."\nWaktu Mulai: ".$this->input->post('waktu_mulai')."\nPetugas: <b>".$petugas['nama']."</b>\n\nKonfirmasi melalui link berikut jika pekerjaan telah selesai\nhttps://arrayyan.web.id/manage/spk/".$this->input->post('token')."/konfirmasi\n\n";
			$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";
			
			$this->telegram_lib->sendblip("-901753609",$pesan_tg);
			}
			
			if(!empty($this->input->post('notif_wa'))){
			//Push WA			
			$pesan_wa = "*Surat Perintah Kerja*\n\n";
			$pesan_wa .= "Lokasi Pekerjaan: *".$lokasi_pekerjaan."*\nKegiatan: ".$this->input->post('kegiatan')."\nDetail Kegiatan: ".$this->input->post('sub_kegiatan')."\nWaktu Mulai: ".$this->input->post('waktu_mulai')."\nPetugas: *".$petugas['nama']."*\n\nKonfirmasi melalui link berikut jika pekerjaan telah selesai\nhttps://arrayyan.web.id/manage/spk/".$this->input->post('token')."/konfirmasi\n\n";
			$pesan_wa .= "Regards,\n*Blippy Assistant*";
			
			
			$headers = array(
					'Content-Type:application/json'
			);
			$fields = [
					'id'  => $this->config->item('number', 'api_bot'),
					'message' => $pesan_wa,
				];
			/////////////////////get jobs/////////////////
			$api_path="http://103.255.242.7:3000/send-group-message";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_path);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
			$featuredJobs = curl_exec($ch);
	
			  if(curl_errno($ch)) {    
				  echo 'Curl error: ' . curl_error($ch);  
	
				  exit();  
			  } else {    
				  // check the HTTP status code of the request
					$resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if ($resultStatus != 200) {
						echo stripslashes($featuredJobs);
						die('Request failed: HTTP status code: ' . $resultStatus);
	
					}
				
				 $featured_jobs_array=(array)json_decode($featuredJobs);
			  }
			}
			
			
		
		//End Log
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal menambah data.');
		}
		}	
    }

    public function timpa($id) {
        date_default_timezone_set("Asia/Singapore");
		$data = array(
		'id_petugas' => $this->input->post('id_petugas'),
		'id_pelanggan' => $this->input->post('id_pelanggan'),
		'id_bts' => $this->input->post('id_bts'),
		'id_survey' => $this->input->post('id_survey'),
		'kegiatan' => $this->input->post('kegiatan'),	
		'sub_kegiatan' => $this->input->post('sub_kegiatan'),
		'waktu_mulai' => $this->input->post('waktu_mulai'),	
		'waktu_selesai' => $this->input->post('waktu_selesai'),	
		'status' => $this->input->post('status'),
		'keterangan' => $this->input->post('keterangan'),
		'link_dokumentasi' => $this->input->post('link_dokumentasi'),
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_spk', $data);			
		
		if($update_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Mengubah data SPK",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal mengubah data.');
		}	
    }
	
	public function konfirmasi_simpan() {
	
	
	
        date_default_timezone_set("Asia/Singapore");
		
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Konfirmasi SPK id ".$this->input->post('id_konfirmasi'),
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		$id_konfirmasi = $this->db->get_where('blip_spk', array('id' => $this->input->post('id_konfirmasi')))->row_array();
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $id_konfirmasi['id_pelanggan']))->row_array();
		$petugas = $this->db->get_where('gm_operator', array('id' => $id_konfirmasi['id_petugas']))->row_array();
		if($id_konfirmasi['id_pelanggan'] != NULL){$lokasi_pekerjaan = $pelanggan['nama']; }elseif($id_konfirmasi['id_survey'] != NULL){$lokasi_pekerjaan = $id_konfirmasi['id_survey'];}elseif($id_konfirmasi['id_bts'] != NULL){$lokasi_pekerjaan = $id_konfirmasi['id_bts'];}
		if(empty($id_konfirmasi['keterangan'])){$keterangan = "Ticket Closed"; }else{$keterangan = $id_konfirmasi['keterangan']; }
		
		/*
		//Push WA
		
		$pesan_wa = "*Konfirmasi Status Pekerjaan*\n\n";
		$pesan_wa .= "Lokasi Pekerjaan: *".$lokasi_pekerjaan."*\nKegiatan: ".$id_konfirmasi['kegiatan']."\nDetail Kegiatan: ".$id_konfirmasi['sub_kegiatan']."\nWaktu Mulai: ".$id_konfirmasi['waktu_mulai']."\nWaktu Selesai: ".date("Y-m-d H:i")."\nPetugas: *".$petugas['nama']."*\nStatus Pekerjaan: ".$id_konfirmasi['status']."\nKeterangan: ".$keterangan."\n\n";
		$pesan_wa .= "Regards,\n*Blippy Assistant*";
		
		$headers = array(
				'Content-Type:application/json'
		);
		$fields = [
				'id'  => $this->config->item('number', 'api_bot'),
				'message' => $pesan_wa,
			];
		/////////////////////get jobs/////////////////
		$api_path="http://103.255.242.7:3000/send-group-message";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_path);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
		$featuredJobs = curl_exec($ch);

		  if(curl_errno($ch)) {    
			  echo 'Curl error: ' . curl_error($ch);  

			  exit();  
		  } else {    
			  // check the HTTP status code of the request
				$resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if ($resultStatus != 200) {
					echo stripslashes($featuredJobs);
					die('Request failed: HTTP status code: ' . $resultStatus);

				}
			
			 $featured_jobs_array=(array)json_decode($featuredJobs);
		  }
		  */
		
		$pesan_tg = "<b>Konfirmasi Status Pekerjaan</b>\n\n";
		$pesan_tg .= "Lokasi Pekerjaan: <b>".$lokasi_pekerjaan."</b>\nKegiatan: ".$id_konfirmasi['kegiatan']."\nDetail Kegiatan: ".$id_konfirmasi['sub_kegiatan']."\nWaktu Mulai: ".$id_konfirmasi['waktu_mulai']."\nWaktu Selesai: ".date("Y-m-d H:i")."\nPetugas: <b>".$petugas['nama']."</b>\nStatus Pekerjaan: ".$id_konfirmasi['status']."\nKeterangan: ".$keterangan."\n\n";
		$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";
		$this->telegram_lib->sendblip("-901753609",$pesan_tg);
		
		$data = array(
		'waktu_selesai' => date("Y-m-d H:i"),	
		'status' => $this->input->post('status'),
		'keterangan' => $this->input->post('keterangan'),
		);				
		$this->db->where('id', $this->input->post('id_konfirmasi'));
		$update_konfirm = $this->db->update('blip_spk', $data);
		if($update_konfirm){
		$this->session->unset_userdata('success');
        return $this->session->set_flashdata('success', 'Konfirmasi berhasil.');
		}else{
		$this->session->unset_userdata('error');
        return $this->session->set_flashdata('error', 'Konfirmasi GAGAL !!!');
		}				
    }
	
    public function delete($id) {	
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menghapus data SPK",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
        return $this->db->delete('blip_spk', array('id' => $id));
    }
	
	
	//Sent Whatsapp - Data SPK //Push WA
	public function resend_spk($id,$wa) {
        //Push WA
		$id_konfirmasi = $this->db->get_where('blip_spk', array('id' => $id))->row_array();
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $id_konfirmasi['id_pelanggan']))->row_array();
		$petugas = $this->db->get_where('gm_operator', array('id' => $id_konfirmasi['id_petugas']))->row_array();
		if($id_konfirmasi['id_pelanggan'] != NULL){$lokasi_pekerjaan = $pelanggan['nama']; }elseif($id_konfirmasi['id_survey'] != NULL){$lokasi_pekerjaan = $id_konfirmasi['id_survey'];}elseif($id_konfirmasi['id_bts'] != NULL){$lokasi_pekerjaan = $id_konfirmasi['id_bts'];}
		if(empty($id_konfirmasi['keterangan'])){$keterangan = "Ticket Closed"; }else{$keterangan = $id_konfirmasi['keterangan']; }
		
		$pesan = "*Konfirmasi Status Pekerjaan*\n\n";
		$pesan .= "Lokasi Pekerjaan: *".$lokasi_pekerjaan."*\nKegiatan: ".$id_konfirmasi['kegiatan']."\nDetail Kegiatan: ".$id_konfirmasi['sub_kegiatan']."\nWaktu Mulai: ".$id_konfirmasi['waktu_mulai']."\nWaktu Selesai: ".date("Y-m-d H:i")."\nPetugas: *".$petugas['nama']."*\nStatus Pekerjaan: ".$id_konfirmasi['status']."\nKeterangan: ".$keterangan."\n\nKonfirmasi melalui link berikut jika pekerjaan telah selesai\nhttps://arrayyan.web.id/manage/spk/".$id_konfirmasi['token']."/konfirmasi\n\n";
		$pesan .= "Regards,\n*Blippy Assistant*";
		
		return $pesan;
    }
	
	
	public function get_export() {
		$this->db->select('*');
		$this->db->from('blip_spk');
		//$this->db->where($multipleCIWhere);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
		$response = $query->result_array();
        return $response;
    }

}
