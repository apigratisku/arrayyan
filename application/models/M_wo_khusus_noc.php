<?php

class M_wo_khusus_noc extends CI_Model {

    public function __construct() {
        $this->load->database();
		$this->load->config('api_bot', true);
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_wo_khusus_noc', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_wo_khusus_noc');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	 public function get_wo($id) {
            $this->db->select('*');
            $this->db->from('blip_wo_khusus_noc');
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
            $query = $this->db->get_where('blip_wo_khusus_noc', array('token' => $id));
            $response = $query->row_array();
        }

        return $response;
    }
	
	
    public function simpan() {
		$token_data = $this->db->get_where('blip_wo_khusus_noc', array('token' =>$this->input->post('token')))->row_array();
		if($token_data > 0){
		return $this->session->set_flashdata('error', 'Error. Duplikat data token!');
		}elseif(empty($this->input->post('id_pelanggan')) && empty($this->input->post('id_bts'))){
		return $this->session->set_flashdata('error', 'Error. Data Pelangann / Data BTS harus diisi (Pilih salah satu)!');
		}else{
		date_default_timezone_set("Asia/Singapore");
		$data = array(
		'token' => $this->input->post('token'),
		'tiket' => $this->input->post('tiket'),
		'id_pelanggan' => $this->input->post('id_pelanggan'),
		'id_bts' => $this->input->post('id_bts'),
		'kendala' => $this->input->post('kendala'),	
		'keterangan' => $this->input->post('keterangan'),
		'action' => $this->input->post('action'),
		'waktu_mulai' => $this->input->post('waktu_mulai'),
		'waktu_selesai' => $this->input->post('waktu_selesai'),	
		'status' => $this->input->post('status'),	
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$insert_db = $this->db->insert('blip_wo_khusus_noc', $data);
		
		if($insert_db){
		$data_pelanggan= $this->db->get_where('blip_pelanggan', array('id' => $this->input->post('id_pelanggan')))->row_array();
		$data_sales= $this->db->get_where('blip_sales', array('id' => $this->input->post('id_sales')))->row_array();
		if($this->input->post('id_pelanggan') != NULL){$lokasi_pekerjaan = $data_pelanggan['nama'];}elseif($this->input->post('id_bts') != NULL){$lokasi_pekerjaan = $this->input->post('id_bts');}
		
		
		//Sent EMAIL	
		$mail_token= "BLiP*123#";
		$mail_tiket= $this->input->post('tiket');
		$mail_to= "frandi.prameiditya@blip.co.id";
		$mail_kendala= $this->input->post('kendala');
		$mail_keterangan= $this->input->post('waktu_mulai');
		$mail_status= $this->input->post('status');
		$mail_lokasi_pekerjaan= $lokasi_pekerjaan;
		$mail_waktu_mulai= $this->input->post('waktu_mulai');	
			
		
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://blipntb.net/blipmail.php");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$data = array(
			'mail_token' =>  "BLiP*123#",
			'mail_tiket' =>  $this->input->post('tiket'),
			'mail_from' => "noc@blipntb.net",
			'mail_to' =>  "baiq.afiqa@blip.co.id",
			'mail_cc1' =>  "frandi.prameiditya@blip.co.id",
			'mail_cc2' =>  "frandi.prameiditya@gmedia.co.id",
			'mail_cc3' =>  "noc.blipntb@gmail.com",
			'mail_kendala' => $this->input->post('kendala'),
			'mail_keterangan' =>  $this->input->post('keterangan'),
			'mail_status' =>  $this->input->post('status'),
			'mail_lokasi_pekerjaan' =>  $lokasi_pekerjaan,
			'mail_waktu_mulai' =>  $this->input->post('waktu_mulai'),	
		);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_exec($curl);
		curl_close($curl);
		
		
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data [NOC] Eskalasi TS",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		
		//Push TG
		if(!empty($this->input->post('notif_tg'))){
		$pesan_tg = "<b>[Open Ticket ".$this->input->post('tiket')."] Gangguan/Maintenance</b>\n";
		$pesan_tg .= "Lokasi Pekerjaan: <b>".$lokasi_pekerjaan."</b>\nKendala: ".$this->input->post('kendala')."\nKeterangan: ".$this->input->post('keterangan')."\nWaktu Start: ".$this->input->post('waktu_mulai')."\n\n";
		$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";
		
		$this->telegram_lib->sendblip("-901753609",$pesan_tg);
		}
		
		
		/*
		if(!empty($this->input->post('notif_wa'))){
		//Push WA
		$pesan_wa = "*[Open Ticket ".$this->input->post('tiket')."] Gangguan/Maintenance*\n";
		$pesan_wa .= "Lokasi Pekerjaan: *".$lokasi_pekerjaan."*\nKendala: ".$this->input->post('kendala')."\nKeterangan: ".$this->input->post('keterangan')."\nWaktu Start: ".$this->input->post('waktu_mulai')."\n\n";
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
		
		/*$data = [
			
			'api_key' => $this->config->item('api_key', 'api_bot'),
			'sender'  => $this->config->item('sender', 'api_bot'),
			'number'  => $this->config->item('number', 'api_bot'),
			'message' => $pesan,
		];
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://wapi.apigratis.my.id/app/api/send-message",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($data))
		);
		
		$response = curl_exec($curl);	
		curl_close($curl);*/
		
		
		
		
		//End Log
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal menambah data.');
		}
		}	
    }
	
	public function get_noc_maintenance() {
		 
		 date_default_timezone_set("Asia/Singapore");
		 $query = $this->db->get_where('blip_wo_khusus_noc', array('status' => "Open"))->result_array();
		 
		 if(isset($query)){
		     $no=1;
			 $response = "<b>Dear All,</b> \nBerikut update list pendingan Maintenance tanggal ".date("d/M/y H:i")." sbb:\n\n";
			 foreach($query as $querydata){
			 $data_pelanggan= $this->db->get_where('blip_pelanggan', array('id' => $querydata['id_pelanggan']))->row_array();
			 if($querydata['id_pelanggan'] != NULL){$lokasi_pekerjaan = $data_pelanggan['nama'];}else{$lokasi_pekerjaan = $querydata['id_bts'];}
			 $response .= $no.". <b>".$lokasi_pekerjaan."</b>\nKendala: ".$querydata['kendala']."\nKeterangan: ".$querydata['keterangan']."\nWaktu Start: ".$querydata['waktu_mulai']."\n\n";
			 
			 $no++;
			 }
			 $response .= "Regards,\n<b>Blippy Assistant</b>";
			 return $response;
		 }
		
    }

    public function timpa($id) {
        date_default_timezone_set("Asia/Singapore");
		$data = array(
		'token' => $this->input->post('token'),
		'tiket' => $this->input->post('tiket'),
		'id_pelanggan' => $this->input->post('id_pelanggan'),
		'kendala' => $this->input->post('kendala'),	
		'keterangan' => $this->input->post('keterangan'),
		'action' => $this->input->post('action'),
		'waktu_mulai' => $this->input->post('waktu_mulai'),
		'waktu_selesai' => $this->input->post('waktu_selesai'),	
		'status' => $this->input->post('status'),	
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),
		);						
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_wo_khusus_noc', $data);			
		
		if($update_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Mengubah data [NOC] Eskalasi TS",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		
		if(!empty($this->input->post('waktu_selesai'))){
		$data_pelanggan= $this->db->get_where('blip_pelanggan', array('id' => $this->input->post('id_pelanggan')))->row_array();
		if($this->input->post('id_pelanggan') != NULL){$lokasi_pekerjaan = $data_pelanggan['nama'];}elseif($this->input->post('id_bts') != NULL){$lokasi_pekerjaan = $this->input->post('id_bts');}
			
			
			//Push TG
			if(!empty($this->input->post('notif_tg'))){
			$pesan_tg = "<b>[Close Ticket ".$this->input->post('tiket')."] Gangguan/Maintenance</b>\n";
			$pesan_tg .= "Lokasi Pekerjaan: <b>".$lokasi_pekerjaan."</b>\nKendala: <b>".$this->input->post('kendala')."</b>\nKeterangan: ".$this->input->post('keterangan')."\nAction: <b>".$this->input->post('action')."</b>\nWaktu Start: ".$this->input->post('waktu_mulai')."\nWaktu Selesai: ".$this->input->post('waktu_selesai')."\n\n";
			$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";
			$this->telegram_lib->sendblip("-901753609",$pesan_tg);
			}
			
			/*
			if(!empty($this->input->post('notif_wa'))){
			//Push WA
			$pesan_wa = "*[Close Ticket ".$this->input->post('tiket')."] Gangguan/Maintenance*\n";
			$pesan_wa .= "Lokasi Pekerjaan: *".$lokasi_pekerjaan."*\nKendala: ".$this->input->post('kendala')."\nKeterangan: ".$this->input->post('keterangan')."\nAction: *".$this->input->post('action')."*\nWaktu Start: ".$this->input->post('waktu_mulai')."\nWaktu Selesai: ".$this->input->post('waktu_selesai')."\n\n";;
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
		*/	
		
			
		}
		
		
		//End Log
		return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal mengubah data.');
		}	
    }

    public function delete($id) {	
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menghapus data [NOC] Eskalasi TS",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
        return $this->db->delete('blip_wo_khusus_noc', array('id' => $id));
    }
	
	public function get_export() {
		$this->db->select('*');
		$this->db->from('blip_wo_khusus_noc');
		//$this->db->where($multipleCIWhere);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
		$response = $query->result_array();
        return $response;
    }

}


