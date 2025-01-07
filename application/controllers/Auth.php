<?php

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
		$this->load->model('operator_model');
		$this->load->library('user_agent');
		$this->load->library('secure');
    }

    public function index() {
        if (!file_exists(APPPATH.'views/backend/login.php')) {
            show_404();
        }

        $this->load->view('backend/login');
		
    }
	public function twofatoken($crypted_token) {
	
		//Decrypt index ID
		$token = $this->secure->decrypt_url($crypted_token);
		$data_login  = $this->operator_model->auth_operator($token);
		$data['item']  = $data_login->row_array();
        $this->load->view('backend/2fatoken',$data);		
    }
	public function token() {
		
		$data_login  = $this->operator_model->auth_operator($this->input->post('email'));
		$data_verify = $data_login->row_array();
		if($data_login->num_rows() > 0){
			if($this->input->post('token') == $data_verify['token']){
			$this->session->unset_userdata('success');
			$this->session->set_flashdata('success', 'Login berhasil');
			$this->session->set_userdata('masuk',TRUE);
			$this->session->set_userdata('ses_id',$data_verify['id']);
			$this->session->set_userdata('ses_userid',$data_verify['email']);
			$this->session->set_userdata('ses_admin',$data_verify['admin']);
			$this->session->set_userdata('ses_foto',$data_verify['foto']);
			$this->session->set_userdata('ses_nama',$data_verify['nama']);
			
			//Log Aktifitas
			$this->load->database();
			$log = array(
				'aktifitas' => "Berhasil login ke halaman user dengan 2 Faktor Token",
				'history_waktu' => date("Y-m-d H:i"),
				'history_iduser' => $data_verify['id'],
			);				
			$this->db->insert('blip_log_user', $log);
			//End Log
			
			//Redirect Manage Admin
			redirect('/manage', 'refresh');
			}else {
			$this->session->unset_userdata('error');
			$this->session->set_flashdata('error', 'Kode 2 Faktor token salah. Silahkan masukan kode token dengan benar. ');
			echo "<script>javascript:history.go(-1);</script>";
			}
			
		} else {
			$this->session->unset_userdata('error');
			$this->session->set_flashdata('error', 'Data tidak ditemukan atau akun anda tidak terdaftar !');
			redirect('/login', 'refresh');
		}
			
    }


    public function login() {
		date_default_timezone_set("Asia/Singapore");
        $userid     = strip_tags($this->input->post('userid'));
		$password   = strip_tags($this->input->post('password'));
		

		$cek_operator=$this->operator_model->auth_operator($userid);
		$data=$cek_operator->row_array();
        if($cek_operator->num_rows() > 0){ 
				
                
				if (password_verify($password, $data['password'])) 
				{
				$data_login=$this->operator_model->auth_operator($data['email'])->row_array();
				$token = rand(100000,999999);
				$data_db = array(
				'token' => $token,
				'history_waktu' => date("Y-m-d H:i"),
				);	
				$this->db->where('id', $data_login['id']);
				$set_db = $this->db->update('gm_operator', $data_db);	
				
				
				if(isset($set_db)){
				//Sent token WA
				$id_login = $this->db->get_where('gm_operator', array('id' => $data['id']))->row_array();
				$pesan_wa = "*Verifikasi Sign-In*\n\n";
				$pesan_wa .= "Dear ".$id_login['nama'].",\n\nVerifikasi Kode: *".$id_login['token']."*\n\n";
				$pesan_wa .= "Regards,\n*Blippy Assistant*";
				$pesan_tg = "<b>Verifikasi Sign-In</b>\n\n";
				$pesan_tg .= "Dear ".$id_login['nama'].",\n\nVerifikasi Kode: <b>".$id_login['token']."</b>\n\n";
				$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";
				
				//Sent to Telegram
				  $this->telegram_lib->sendblip($data['telegram'],$pesan_tg);
				  
				/*
				//Sent to Whatsapp
				$headers = array(
				'Content-Type:application/json'
				);
				$fields = [
						'number'  => $data['no_wa'],
						'message' => $pesan_wa,
					];
				/////////////////////get jobs/////////////////
				$api_path="http://103.255.242.7:3000/send-message";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $api_path);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
				$featuredJobs = curl_exec($ch);
		
				 // if(curl_errno($ch)) {    
				//	  echo 'Curl error: ' . curl_error($ch);  
		
				//	  exit();  
				 // } else {    
					  // check the HTTP status code of the request
						$resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
						//if ($resultStatus != 200) {
						//	echo stripslashes($featuredJobs);
						//	die('Request failed: HTTP status code: ' . $resultStatus);
		
						//}
					
					 $featured_jobs_array=(array)json_decode($featuredJobs);
				//  }
				 */ 
				  
				
				//Enkripsi index ID
				$token = $id_login['email'];
			    $crypted_token = $this->secure->encrypt_url($token);
								
				$this->session->set_flashdata('success', 'Masukan kode token yang telah di kirim ke Whatsapp dan Telegram anda.');
				redirect('/'.$crypted_token.'/twofatoken', 'refresh');
				}
			}
				
				/*
                $this->session->set_userdata('masuk',TRUE);
                $this->session->set_userdata('ses_id',$data['id']);
                $this->session->set_userdata('ses_userid',$data['email']);
				$this->session->set_userdata('ses_admin',$data['admin']);
				$this->session->set_userdata('ses_foto',$data['foto']);
				$this->session->set_userdata('ses_nama',$data['nama']);
				
				//Log Aktifitas
				$this->load->database();
				$log = array(
					'aktifitas' => "Berhasil login ke halaman user",
					'history_waktu' => date("Y-m-d H:i"),
					'history_iduser' => $data['id'],
				);				
				$this->db->insert('blip_log_user', $log);
				//End Log
				
				$this->session->unset_userdata('success');
				$this->session->unset_userdata('error');
				$this->session->set_flashdata('success', 'Login berhasil');
				$this->load->view('backend/login');
				echo"<meta http-equiv=\"refresh\" content=\"2; url=".base_url('/manage')."\">";
				
				} 
				else
				{
				//Log Aktifitas
				$this->load->database();
				$log = array(
					'aktifitas' => "Gagal login ke halaman user",
					'history_waktu' => date("Y-m-d H:i"),
					'history_iduser' => $data['id'],
				);				
				$this->db->insert('blip_log_user', $log);
				//End Log
				$this->session->unset_userdata('success');
				$this->session->unset_userdata('error');
				$this->session->set_flashdata('error', 'Terjadi kesalahan login user atau password !');
				redirect('/login', 'refresh');
				}
				*/
		}
		else
		{
		$this->session->unset_userdata('success');
		$this->session->unset_userdata('error');
		$this->session->set_flashdata('error', 'Terjadi kesalahan login user atau password !');
		redirect('/login', 'refresh');
		}
    }

    public function logout() {
		date_default_timezone_set("Asia/Singapore");
		//Log Aktifitas
		$this->load->database();
		$log = array(
			'aktifitas' => "Logout",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
        $this->session->unset_userdata('masuk');
		$this->session->sess_destroy();
        redirect('/login', 'refresh');
    }

}
