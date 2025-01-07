<?php

class M_wo_khusus_admin extends CI_Model {

    public function __construct() {
        $this->load->database();
		$this->load->config('api_bot', true);
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_wo_khusus_admin', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_wo_khusus_admin');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	 public function get_wo($id) {
            $this->db->select('*');
            $this->db->from('blip_wo_khusus_admin');
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
            $query = $this->db->get_where('blip_wo_khusus_admin', array('token' => $id));
            $response = $query->row_array();
        }

        return $response;
    }
	
	
    public function simpan() {
		$spk_data = $this->db->get_where('blip_wo_khusus_admin', array('token' =>$this->input->post('token')))->row_array();
		if($spk_data > 0){
		//return $this->session->set_flashdata('error', 'Error. Duplikat data token!');
		}
		else{
		date_default_timezone_set("Asia/Singapore");
		$data = array(
		'token' => $this->input->post('token'),
		'id_pelanggan' => $this->input->post('id_pelanggan'),
		'id_sales' => $this->input->post('id_sales'),
		'kegiatan' => $this->input->post('kegiatan'),	
		'sub_kegiatan' => $this->input->post('sub_kegiatan'),	
		'tgl_req_sales' => $this->input->post('tgl_req_sales'),		
		'link_dokumentasi' => $this->input->post('link_dokumentasi'),	
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$insert_db = $this->db->insert('blip_wo_khusus_admin', $data);
		
		if($insert_db){
		//Sent Email
		$data_pelanggan= $this->db->get_where('blip_pelanggan', array('id' => $this->input->post('id_pelanggan')))->row_array();
		$data_sales= $this->db->get_where('blip_sales', array('id' => $this->input->post('id_sales')))->row_array();
		
		//EMAIL
		/*$this->load->library('email');
        $fromName="Admin NTB";
        $to='support.mataram@blip.co.id';
		$cc=array("baiq.afiqa@blip.co.id","marketing.mataram@blip.co.id");
		//$to='frandi.prameiditya@blip.co.id';
		//$cc=array("frandi.prameiditya@blip.co.id");
        $subject='Request - '.$this->input->post('kegiatan').' - '.$this->input->post('sub_kegiatan').' - '.$data_pelanggan['nama'];
        $message='
		Dear Team Support, <br>
		
		Mohon bantuannya untuk dapat diproses kegiatan sesuai request berikut: <br><br>
		<table class="table table-striped table-bordered" style="font-size:14px" width="90%">
                    <tbody>
                        <tr>
                            <td>
                               <b>Nama Pelanggan</b>
                            </td><td>:</td><td>
                                 '.$data_pelanggan['nama'].'
                            </td>
                        </tr> <tr>
                            <td>
                               <b>Sales</b>
                            </td><td>:</td><td>
                                 '.$data_sales['nama'].'
                            </td>
                        </tr><tr>
                            <td>
                                <b>CID</b>
                            </td><td>:</td><td>
                            '.$data_pelanggan['cid'].'
                            </td>
                        </tr><tr>
                            <td>
                                <b>SID</b>
                            </td><td>:</td><td>
                               '.$data_pelanggan['sid'].'
                            </td>
                        </tr><tr>
                            <td>
                                <b>Kegiatan</b>
                            </td><td>:</td><td>
                              '.$this->input->post('kegiatan').'
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Sub Kegiatan</b>
                            </td><td>:</td><td>
                               '.$this->input->post('sub_kegiatan').'
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tanggal Req Sales</b>
                            </td><td>:</td><td>
                               '.$this->input->post('tgl_req_sales').' Wita
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>PIC</b>
                            </td><td>:</td><td>
                               '.$data_pelanggan['pic'].' - '.$data_pelanggan['kontak'].'
                            </td>
                        </tr>
                    </tbody>
                </table>
				<br>
				Demikian informasi yang disampaikan.<br>
				Terima Kasih.
		';
        $from ="blip.ntb@gmail.com";
        $this->email->from($from, $fromName);
        $this->email->to($to);
		$this->email->cc($cc);
        $this->email->subject($subject);
        $this->email->message($message);

			if($this->email->send())
			{
				echo "Mail Sent Successfully";
			}
			else
			{
				echo "Failed to send email";
				show_error($this->email->print_debugger());             
			}
		*/
		
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data [Admin] WO Khusus",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		
		//Push TG
		if(!empty($this->input->post('notif_tg'))){
		$pesan_tg = "<b>Request WO Khusus by Sales</b>\n\n";
		$pesan_tg .= "Lokasi Pekerjaan: <b>".$data_pelanggan['nama']."</b>\nKegiatan: ".$this->input->post('kegiatan')."\nDetail Kegiatan: ".$this->input->post('sub_kegiatan')."\nTgl. Req Sales: ".$this->input->post('tgl_req_sales')."\nSales: <b>".$data_sales['nama']."</b>\n\n";
		$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";
		$this->telegram_lib->sendblip("-901753609",$pesan_tg);
		}
		
		
		/*
		if(!empty($this->input->post('notif_wa'))){
		//Push WA
		$pesan_wa = "*Request WO Khusus by Sales*\n\n";
		$pesan_wa .= "Lokasi Pekerjaan: *".$data_pelanggan['nama']."*\nKegiatan: ".$this->input->post('kegiatan')."\nDetail Kegiatan: ".$this->input->post('sub_kegiatan')."\nTgl. Req Sales: ".$this->input->post('tgl_req_sales')."\nSales: *".$data_sales['nama']."*\n\n";
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
		'token' => $this->input->post('token'),
		'id_pelanggan' => $this->input->post('id_pelanggan'),
		'id_sales' => $this->input->post('id_sales'),
		'kegiatan' => $this->input->post('kegiatan'),	
		'sub_kegiatan' => $this->input->post('sub_kegiatan'),	
		'tgl_req_sales' => $this->input->post('tgl_req_sales'),		
		'link_dokumentasi' => $this->input->post('link_dokumentasi'),	
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),
		);			
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_wo_khusus_admin', $data);			
		
		if($update_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Mengubah data [Admin] WO Khusus",
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

    public function delete($id) {	
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menghapus data [Admin] WO Khusus",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
        return $this->db->delete('blip_wo_khusus_admin', array('id' => $id));
    }
	
	public function get_export() {
		$this->db->select('*');
		$this->db->from('blip_wo_khusus_admin');
		//$this->db->where($multipleCIWhere);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
		$response = $query->result_array();
        return $response;
    }

}
