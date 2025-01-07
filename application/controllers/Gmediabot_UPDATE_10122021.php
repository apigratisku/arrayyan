<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Gmediabot extends CI_Controller {
    function __construct(){
        parent::__construct();
		$this->load->model('mapping_model');
		$this->load->model('fiberstream_model');
		$this->load->model('mikrotik_model');
		$this->load->model('OLT_model');
		$this->load->model('telegram_model');
    }
 
    function index(){
		
        $TOKEN = "1117257670:AAHlAgCIfzL3DTe4xnI8ygVdVVpr2z9JDls";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
		$fname = $update["message"]["chat"]["first_name"];
		$lname = $update["message"]["chat"]["last_name"];
        $message = $update["message"]["text"];
        $msgdata = explode(" ", $message);
		$msgcount = count($msgdata);
		$fullname = "$fname $lname";
			
		if (strpos($message, "/start") === 0) {
		file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Hai kak <b>".$fname." ".$lname."</b>. Selamat datang di layanan Gmedia NTB bot. Silahkan kakak klik /register untuk melakukan registrasi. Terima kasih&parse_mode=HTML");
		}
		elseif (strpos($message, "/id") === 0) {
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Hai kak ".$fname." ".$lname.". ID Telegram: ".$chatID.".&parse_mode=HTML");
		}
		elseif (strpos($message, "/register") === 0) {	
			$telegram_user = $this->telegram_model->get($chatID);
			if($telegram_user['id_user'] != NULL)
			{
				if($telegram_user['status'] == "0") 
				{file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Hai kak <b>".$fname." ".$lname."</b>, ID kakak <b>$chatID</b> sedang menunggu approval dari admin.")."&parse_mode=HTML");}			
				elseif($telegram_user['status'] == "1") 
				{file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Hai kak <b>".$fname." ".$lname."</b>, ID kakak <b>$chatID</b> sudah terdaftar di Area $telegram_user[id_area] dengan status <b>Aktif</b>.")."&parse_mode=HTML");} 
				else 
				{file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Hai kak <b>".$fname." ".$lname."</b>, ID kakak <b>$chatID</b> sudah terdaftar di Area $telegram_user[id_area] dengan status <b>Tidak Aktif</b>.")."&parse_mode=HTML");}
			}
			else
			{
			$this->load->database();
			$this->telegram_model->simpan_temp($chatID,$fullname);
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Hi kak <b>".$fname." ".$lname."</b>, Registrasi berhasil. \nMohon menunggu approval admin agar dapat mengakses bot GMmediaNTB. Terima kasih")."&parse_mode=HTML");
			}
		}
		else
		{
		
		//MULAI SYNTAX DENGAN AKSES TERDAFTAR
		//Limit Access Super Admin
		if($chatID == "250170651")
		{
			if (strpos($message, "/gmlist") === 0) {	

				$telegram_user = $this->telegram_model->get();
				$telegram_count = $this->telegram_model->count();
				$datauser = "";
				foreach($telegram_user as $user)
				{
				if($user['status'] == "0"){$status = "Menunggu Approval";} elseif($user['status'] == "1") {$status = "Aktif";} else {$status = "Tidak Aktif";}
				$datauser .= urlencode("ID: <b>".$user['id_user']."</b>\nNama: ".$user['id_nama']."\nArea: ".$user['id_area']."\nStatus: <b>".$status."</b>\n\n");
				}
				
				$reply_msg = urlencode("List Data User Telegram:\n\n").$datauser.urlencode("\nTotal Data: ".$telegram_count);
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
			}
			elseif (strpos($message, "/gmakses") === 0) {	
				if($msgdata[1] == NULL || $msgdata[2] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan sesuai format berikut.")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /gmakses 250170651 NTB 0")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /gmakses 250170651 NTB 1")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /gmakses 250170651 NTB 2")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Keterangan 0 (nonaktif),1 (aktif) dan 2 (suspend)")."&parse_mode=HTML");
				}
				else
				{
					$telegram_user = $this->telegram_model->get($msgdata[1]);
					$telegram_akses = $this->telegram_model->timpa($msgdata[1],$msgdata[2]);
					if($telegram_user['id_user'] == NULL)
					{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("ID $msgdata[1] belum terdaftar.")."&parse_mode=HTML");
					}
					else
					{
					$this->load->database();
					$this->telegram_model->timpa($msgdata[1],$msgdata[2],$msgdata[3]);
					if($msgdata[3] == "1") {$status = "diaktifkan";$status2 = "Aktif";} else {$status = "nonaktifkan";$status2 = "Nonaktif";}
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("ID $msgdata[1] sukses di $status.")."&parse_mode=HTML");
					
					if($status2 == "Aktif") {file_get_contents($apiURL."/sendmessage?chat_id=".$msgdata[1]."&text=".urlencode("Hai kak <b>".$telegram_user['id_nama']."</b>, Selamat ID kakak telah <b>".$status2."</b> dan terdaftar di Area $msgdata[2]")."&parse_mode=HTML");}
					else{file_get_contents($apiURL."/sendmessage?chat_id=".$msgdata[1]."&text=".urlencode("Hai kak <b>".$telegram_user['id_nama']."</b>, Saat ini ID kakak dalam status <b>".$status2."</b>. Silahkan hubungi admin untuk informasi lebih lanjut. Terima kasih")."&parse_mode=HTML");}
					}
				}
			}
		}
		//Limit Access ChatID
		elseif($chatID == "250170651" || $chatID == "-1001499615009" || $chatID == "-469036792")
		{
			//Mapping Lastmile FO
			if (strpos($message, "/mapping") === 0) {
				if($msgdata[1] == NULL || $msgdata[2] == NULL || $msgdata[3] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan kordinat mapping anda.")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /mapping -8.361846 116.141454 Capel")."&parse_mode=HTML");
				}
				else
				{
				$mapping = $this->mapping_model->mapping_fs_new($msgdata[1],$msgdata[2]);
				$result_mapping = explode(" ", $mapping);
				date_default_timezone_set("Asia/Singapore");
				$date_now = date("M/d/Y");
				
					if($result_mapping[2] == "Pemenang")
					{
							//Explode data Capel
							$capel = "";
							for($msgcapel=3; $msgcapel <= $msgcount;)
							{
							
								$capel .= "$msgdata[$msgcapel] ";
								$msgcapel++;
							}
						
							if($result_mapping[1] > 350)
							{
							
							$this->load->database();
							$data_capel = array(
								'media' => "FO",
								'odp' => $result_mapping[0],
								'jarak' => $result_mapping[1],
								'lat' => $msgdata[1],
								'long' => $msgdata[2],
								'capel' => $capel,
								'site' => $result_mapping[2],
								'status' => "Tidak tercover",
								'date' => $date_now,
							);
							
							$this->db->insert('gm_mapping_capel', $data_capel);
							$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nTanggal Survey: $date_now\r\nOSP: <b>".$result_mapping[2]."</b>\r\nHasil Mapping: <b>Tidak tercover</b>. Perkiraan jarak tarikan <b>".$result_mapping[1]."</b> Meter dari ODP terdekat <b>".$result_mapping[0]."</b>.");
							file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
							
							}
							else
							{
							$this->load->database();
							$data_capel = array(
								'media' => "FO",
								'odp' => $result_mapping[0],
								'jarak' => $result_mapping[1],
								'lat' => $msgdata[1],
								'long' => $msgdata[2],
								'capel' => $capel,
								'site' => $result_mapping[2],
								'status' => "Tercover",
								'date' => $date_now,
							);
							
							$this->db->insert('gm_mapping_capel', $data_capel);
							$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nTanggal Survey: $date_now\r\nOSP: <b>".$result_mapping[2]."</b>\r\nHasil Mapping: Tercover ODP <b>".$result_mapping[0]."</b> dengan jarak perkiraan <b>".$result_mapping[1]."</b> Meter.");
							file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
							}	
					}
					else
					{
							//Explode data Capel
							$capel = "";
							for($msgcapel=3; $msgcapel <= $msgcount;)
							{
							
								$capel .= "$msgdata[$msgcapel] ";
								$msgcapel++;
							}
						
							if($result_mapping[1] > 1000)
							{
							
							$this->load->database();
							$data_capel = array(
								'media' => "FO",
								'odp' => $result_mapping[0],
								'jarak' => $result_mapping[1],
								'lat' => $msgdata[1],
								'long' => $msgdata[2],
								'capel' => $capel,
								'site' => $result_mapping[2],
								'status' => "Tidak tercover",
								'date' => $date_now,
							);
							
							$this->db->insert('gm_mapping_capel', $data_capel);
							$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nTanggal Survey: $date_now\r\nOSP: <b>".$result_mapping[2]."</b>\r\nHasil Mapping: <b>Tidak tercover</b>. Perkiraan jarak tarikan <b>".$result_mapping[1]."</b> Meter dari ODP terdekat <b>".$result_mapping[0]."</b>.");
							file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
							
							}
							else
							{
							$this->load->database();
							$data_capel = array(
								'media' => "FO",
								'odp' => $result_mapping[0],
								'jarak' => $result_mapping[1],
								'lat' => $msgdata[1],
								'long' => $msgdata[2],
								'capel' => $capel,
								'site' => $result_mapping[2],
								'status' => "Tercover",
								'date' => $date_now,
							);
							
							$this->db->insert('gm_mapping_capel', $data_capel);
							$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nTanggal Survey: $date_now\r\nOSP: <b>".$result_mapping[2]."</b>\r\nHasil Mapping: Tercover ODP <b>".$result_mapping[0]."</b> dengan jarak perkiraan <b>".$result_mapping[1]."</b> Meter.");
							file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
							}
					}
					
					//End Site
				}
			
			}
			
			//Linkplanner WE
			elseif (strpos($message, "/linkplanner") === 0) {
				if($msgdata[1] == NULL || $msgdata[2] == NULL || $msgdata[3] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan kordinat mapping anda.")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /linkplanner lat long OK/NOK 15 Trawangan - Capel")."&parse_mode=HTML");
				}
				else
				{
					//Explode data Capel
					$capel = "";
					for($msgcapel=6; $msgcapel <= $msgcount;)
					{
					
						$capel .= "$msgdata[$msgcapel] ";
						$msgcapel++;
					}
					$capel = "$msgdata[7] $msgdata[8] $msgdata[9]";
					$mapping = $this->mapping_model->mapping_we($msgdata[1],$msgdata[2],$msgdata[3],$msgdata[4],$msgdata[5],$capel);
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Data mapping WE tersimpan.")."&parse_mode=HTML");	
				}
			
			}
			
			//Get Data FS Total
			elseif (strpos($message, "/fs_total") === 0) {
				$fs_total = $this->fiberstream_model->count();
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Total Fiberstream: <b>".$fs_total."</b>&parse_mode=HTML");
			}
			
			//Get Data FS Isolir
			elseif (strpos($message, "/fs_isolir_list") === 0) {
				$fs_isolir = $this->fiberstream_model->count_isolir();
				$fs_detail = $this->fiberstream_model->count_isolir_list();
				$fsdetails = "";
				foreach($fs_detail as $fsdetail){$fsdetails .= urlencode($fsdetail['cid']." - ".$fsdetail['nama']."\n");}
				$reply_msg = urlencode("List Isolir Pelanggan:\n").$fsdetails.urlencode("\nTotal Isolir Fiberstream: ".$fs_isolir);
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
			}			
			
			//FS Add Isolir
			elseif (strpos($message, "/fs_isolir_add") === 0) {
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan CID pelanggan")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /fs_isolir_add 0306211805")."&parse_mode=HTML");
				}
				else
				{
				date_default_timezone_set("Asia/Singapore");
				$fs_isolir_add = $this->fiberstream_model->isolir_tg($msgdata[1]);
				}
			}
			
			//FS Open Isolir
			elseif (strpos($message, "/fs_isolir_open") === 0) {
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan CID pelanggan")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /fs_isolir_open 0306211805")."&parse_mode=HTML");
				}
				else
				{
				date_default_timezone_set("Asia/Singapore");
				$this->fiberstream_model->approve_tg($msgdata[1]);
				}	
			}
			
			//FS Isolir List
			elseif (strpos($message, "/fs_list") === 0) {
				
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan keyword nama pelanggan")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /fs_list nyoman")."&parse_mode=HTML");
				}
				else
				{
					$fs_detail = $this->fiberstream_model->get_client($msgdata[1]);
					$get_client_count = $this->fiberstream_model->get_client_count($msgdata[1]);
					$fsdetails = "";
					foreach($fs_detail as $fsdetail){$fsdetails .= urlencode($fsdetail['cid']." - ".$fsdetail['nama']."\n");}
					$reply_msg = urlencode("Hasil Pencarian Keyword:\n").$fsdetails.urlencode("\nTotal Data: ".$get_client_count);
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
				}
			}
			
			//Get data FS All
			elseif (strpos($message, "/fs_all") === 0) {

					$fs_detail = $this->fiberstream_model->get_client_all();
					$get_client_count = $this->fiberstream_model->get_client_count_all();
					$fsdetails = "";
					foreach($fs_detail as $fsdetail){$fsdetails .= urlencode($fsdetail['cid']." - ".$fsdetail['nama']."\n");}
					$reply_msg = urlencode("List Data Pelanggan:\n").$fsdetails.urlencode("\nTotal Data: ".$get_client_count);
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
			}
			//Get Fata BW Customer
			elseif (strpos($message, "/bw") === 0) {
				
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan nama pelanggan")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /bw gede")."&parse_mode=HTML");
				}
				else
				{
					$reply_msg = $this->mikrotik_model->get_bw($msgdata[1]);
					if($reply_msg == NULL)
					{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Data tidak ditemukan.&parse_mode=HTML");
					}
					else
					{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
					}
				}
			}			
		}
			
		
		//Limit Access ChatID PUBLIK
		elseif($chatID == "250170651" || $chatID == "1548182373" || $chatID == "302511033" || $chatID == "-1001499615009")
		{
			if (strpos($message, "/dcs") === 0) {
				if($msgdata[1] == NULL || $msgdata[2] == NULL || $msgdata[3] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan kordinat mapping anda.")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /dcs -8.361846 116.141454 Capel")."&parse_mode=HTML");
				}
				else
				{
				$mapping = $this->mapping_model->mapping_fs_new($msgdata[1],$msgdata[2]);
				$result_mapping = explode(" ", $mapping);
				date_default_timezone_set("Asia/Singapore");
				$date_now = date("M/d/Y");
				
					if($result_mapping[2] == "Pemenang")
					{
							//Explode data Capel
							$capel = "";
							for($msgcapel=3; $msgcapel <= $msgcount;)
							{
							
								$capel .= "$msgdata[$msgcapel] ";
								$msgcapel++;
							}
						
							if($result_mapping[1] > 350)
							{
							
							$this->load->database();
							$data_capel = array(
								'media' => "FO",
								'odp' => $result_mapping[0],
								'jarak' => $result_mapping[1],
								'lat' => $msgdata[1],
								'long' => $msgdata[2],
								'capel' => $capel,
								'site' => $result_mapping[2],
								'status' => "Tidak tercover",
								'date' => $date_now,
							);
							
							$this->db->insert('gm_mapping_capel', $data_capel);
							$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nTanggal Survey: $date_now\r\nOSP: <b>".$result_mapping[2]."</b>\r\nHasil Mapping: <b>Tidak tercover</b>. Perkiraan jarak tarikan <b>".$result_mapping[1]."</b> Meter dari ODP terdekat <b>".$result_mapping[0]."</b>.");
							file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
							
							}
							else
							{
							$this->load->database();
							$data_capel = array(
								'media' => "FO",
								'odp' => $result_mapping[0],
								'jarak' => $result_mapping[1],
								'lat' => $msgdata[1],
								'long' => $msgdata[2],
								'capel' => $capel,
								'site' => $result_mapping[2],
								'status' => "Tercover",
								'date' => $date_now,
							);
							
							$this->db->insert('gm_mapping_capel', $data_capel);
							$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nTanggal Survey: $date_now\r\nOSP: <b>".$result_mapping[2]."</b>\r\nHasil Mapping: Tercover ODP <b>".$result_mapping[0]."</b> dengan jarak perkiraan <b>".$result_mapping[1]."</b> Meter.");
							file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
							}	
					}
					else
					{
							//Explode data Capel
							$capel = "";
							for($msgcapel=3; $msgcapel <= $msgcount;)
							{
							
								$capel .= "$msgdata[$msgcapel] ";
								$msgcapel++;
							}
						
							if($result_mapping[1] > 1000)
							{
							
							$this->load->database();
							$data_capel = array(
								'media' => "FO",
								'odp' => $result_mapping[0],
								'jarak' => $result_mapping[1],
								'lat' => $msgdata[1],
								'long' => $msgdata[2],
								'capel' => $capel,
								'site' => $result_mapping[2],
								'status' => "Tidak tercover",
								'date' => $date_now,
							);
							
							$this->db->insert('gm_mapping_capel', $data_capel);
							$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nTanggal Survey: $date_now\r\nOSP: <b>".$result_mapping[2]."</b>\r\nHasil Mapping: <b>Tidak tercover</b>. Perkiraan jarak tarikan <b>".$result_mapping[1]."</b> Meter dari ODP terdekat <b>".$result_mapping[0]."</b>.");
							file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
							
							}
							else
							{
							$this->load->database();
							$data_capel = array(
								'media' => "FO",
								'odp' => $result_mapping[0],
								'jarak' => $result_mapping[1],
								'lat' => $msgdata[1],
								'long' => $msgdata[2],
								'capel' => $capel,
								'site' => $result_mapping[2],
								'status' => "Tercover",
								'date' => $date_now,
							);
							
							$this->db->insert('gm_mapping_capel', $data_capel);
							$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nTanggal Survey: $date_now\r\nOSP: <b>".$result_mapping[2]."</b>\r\nHasil Mapping: Tercover ODP <b>".$result_mapping[0]."</b> dengan jarak perkiraan <b>".$result_mapping[1]."</b> Meter.");
							file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
							}
					}
					
					//End Site
				}
			
			}
		}
		else
		{
			if(isset($chatID)) {file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML"); }
		}
		//END SYNTAX DENGAN AKSES TERDAFTAR
		}		
		//End All
}

























public function fs_isolir() {
//$fs_isolir = $this->fiberstream_model->count_isolir();
$fs_detail = $this->fiberstream_model->count_isolir_list();
$fsdetails = "";
	foreach($fs_detail as $fsdetail)
	{
	$fsdetails .= $fsdetail['cid']."<br>";
	}
echo $fsdetails;
}

public function web_gpon_olt($id) {
		$this->OLT_model->get_result($id);
    }
public function fs_client_all() {	
	$fs_detail = $this->fiberstream_model->get_client_all();
	$fsdetails = "";
	foreach($fs_detail as $fsdetail){$fsdetails .= $fsdetail['cid']." - ".$fsdetail['nama']."<br>";}
	echo $fsdetails;
	}
//END SCRIPT
}  