<?php
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 

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
		//include APPPATH.'libraries/telegram/Telegram.php';
		$telegram = new Telegram('1117257670:AAHlAgCIfzL3DTe4xnI8ygVdVVpr2z9JDls');
		$private = $telegram->getData();
		$chat_id = $telegram->ChatID();
		$msg_id = $telegram->MessageID();
        $TOKEN = "1117257670:AAHlAgCIfzL3DTe4xnI8ygVdVVpr2z9JDls";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $up = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $up["message"]["chat"]["id"];
		$fname = $up["message"]["chat"]["first_name"];
		$lname = $up["message"]["chat"]["last_name"];
        $message = $up["message"]["text"];
        $msgdata = explode(" ", $message);
		$msgcount = count($msgdata);
		$fullname = "$fname $lname";
		$telegram_user = $this->telegram_model->get($chatID);
			
		if (strpos($message, "/start") === 0) 
		{
		file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Hai kak <b>".$fname." ".$lname."</b>. Selamat datang di layanan Gmedia NTB bot. Silahkan kakak klik /register untuk melakukan registrasi. Terima kasih&parse_mode=HTML");
		}
		elseif (strpos($message, "/id") === 0) 
		{
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Hai kak ".$fname." ".$lname.". ID Telegram: `".$chatID."`.&parse_mode=MARKDOWN");
		}
		elseif (strpos($message, "/emote") === 0) 
		{
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=TESTTTTT".json_decode('"\u2714\u2714\u2705"')."Tanggal ".date("d-M-Y H:i:s")." WITA\n\n&parse_mode=HTML");
		}
		elseif (strpos($message, "/kompi_office") === 0) 
		{
			if ($this->routerosapi->connect("112.78.38.135","noc-mtr","RFd3d76890"))
			{
				$this->routerosapi->write("/system/script/print",false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?name=WOL");				
				$API_SC = $this->routerosapi->read();
				foreach ($API_SC as $script)
				{
					$id_script = $script['.id'];
				}
				$this->routerosapi->write('/system/script/run',false);
				$this->routerosapi->write("=number=".$id_script);
				$this->routerosapi->read();
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Proses menyalakan komputer office. . . . . . .&parse_mode=HTML");
			}
		}
		
		elseif (strpos($message, "/register") === 0) 
		{	
			if(isset($chatID)) {$telegram_user = $this->telegram_model->get($chatID);}
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
		elseif (strpos($message, "/gmlist") === 0)
		{
		//MULAI SYNTAX DENGAN AKSES TERDAFTAR
		//Limit Access Super Admin
			if($telegram_user['id_user'] == "250170651")
			{
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
			else
			{
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		elseif (strpos($message, "/gmakses") === 0) 
		{	
			if($telegram_user['id_user'] == "250170651")
			{
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
			else
			{
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		elseif (strpos($message, "/gmremove") === 0) 
		{	
			if($telegram_user['id_user'] == "250170651")
			{
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan sesuai format berikut.")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /gmremove 5053878006")."&parse_mode=HTML");
				}
				else
				{
					$telegram_user = $this->telegram_model->delete($msgdata[1]);
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("ID $msgdata[1] sukses di hapus.")."&parse_mode=HTML");
				}
			}
			else
			{
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		//Mapping Lastmile FO
		elseif (strpos($message, "/mapping") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				if($msgdata[1] == NULL || $msgdata[2] == NULL || $msgdata[3] == NULL || $msgdata[4] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan kordinat mapping anda.")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /mapping busol -8.361846 116.141454 Capel")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /mapping brohot -8.361846 116.141454 Capel")."&parse_mode=HTML");
				}
				else
				{
				$mapping = $this->mapping_model->mapping_fo_onnet($msgdata[1],$msgdata[2],$msgdata[3],$chatID,$message);
				}				
			}
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		elseif (strpos($message, "/linkplanner") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				if($msgdata[1] == NULL || $msgdata[2] == NULL || $msgdata[3] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan kordinat mapping anda.")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /linkplanner lat long OK/NOK 15 Trawangan - Capel")."&parse_mode=HTML");
				}
				else
				{
					//Explode data Capel
					$capel = "";
					$_now = ("Y-m-d");
					for($msgcapel=8; $msgcapel <= $msgcount;)
					{
					
						$capel .= "$msgdata[$msgcapel] ";
						$msgcapel++;
					}
					$mapping = $this->mapping_model->mapping_we($msgdata[1],$msgdata[2],$msgdata[3],$msgdata[4],$msgdata[5],$capel);
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Data mapping WE tersimpan.")."&parse_mode=HTML");	
				}
			}
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}		
		//Get Data FS Total
		elseif (strpos($message, "/fs_total") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
			$fs_total = $this->fiberstream_model->count();
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Total Fiberstream: <b>".$fs_total."</b>&parse_mode=HTML");
			}
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}	
			//Get Data FS Isolir
		elseif (strpos($message, "/fs_isolir_list") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				$fs_isolir = $this->fiberstream_model->count_isolir();
				$fs_detail = $this->fiberstream_model->count_isolir_list();
				$fsdetails = "";
				foreach($fs_detail as $fsdetail){$fsdetails .= urlencode($fsdetail['cid']." - ".$fsdetail['nama']."\n");}
				$reply_msg = urlencode("List Isolir Pelanggan:\n").$fsdetails.urlencode("\nTotal Isolir Fiberstream: ".$fs_isolir);
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
			}
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}				
		//FS Add Isolir
		elseif (strpos($message, "/fs_isolir_add") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan CID pelanggan")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /fs_isolir_add 0306211805")."&parse_mode=HTML");
				}
				else
				{
				$fs_isolir_add = $this->fiberstream_model->isolir_tg($msgdata[1]);
				}
			}
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		//FS Open Isolir
		elseif (strpos($message, "/fs_isolir_open") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan CID pelanggan")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /fs_isolir_open 0306211805")."&parse_mode=HTML");
				}
				else
				{
				$this->fiberstream_model->approve_tg($msgdata[1]);
				}	
			}
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		//FS Isolir List
		elseif (strpos($message, "/fs_list") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
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
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}	
		//Get data FS All
		elseif (strpos($message, "/fs_all") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				$fs_detail = $this->fiberstream_model->get_client_all();
				$get_client_count = $this->fiberstream_model->get_client_count_all();
				$fsdetails = "";
				foreach($fs_detail as $fsdetail){$fsdetails .= urlencode($fsdetail['cid']." - ".$fsdetail['nama']."\n");}
				$reply_msg = urlencode("List Data Pelanggan:\n").$fsdetails.urlencode("\nTotal Data: ".$get_client_count);
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
			}
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		//Get Data BW Customer
		elseif (strpos($message, "/bw") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
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
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		//Get Data PON [Redaman]
		elseif (strpos($message, "/fo_redaman") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan nama pelanggan")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /fo_redaman gede")."&parse_mode=HTML");
				}
				else
				{
					$reply_msg = $this->fiberstream_model->get_fo_redaman($msgdata[1]);
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
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		//Get Data PON [Profile]
		elseif (strpos($message, "/fo_profile") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan nama pelanggan")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /fo_redaman gede")."&parse_mode=HTML");
				}
				else
				{
					$reply_msg = $this->fiberstream_model->get_fo_profile($msgdata[1]);
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
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		//Get Data PON [Pon Onu MNG]
		elseif (strpos($message, "/fo_mng") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan nama pelanggan")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /fo_redaman gede")."&parse_mode=HTML");
				}
				else
				{
					$reply_msg = $this->fiberstream_model->get_fo_mng($msgdata[1]);
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
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		//Get Data PON [Restart ONU]
		elseif (strpos($message, "/fo_restart") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan nama pelanggan")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /fo_redaman gede")."&parse_mode=HTML");
				}
				else
				{
					$reply_msg = $this->fiberstream_model->get_fo_restart($msgdata[1]);
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
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		//Get Data status PON
		elseif (strpos($message, "/status") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				if($msgdata[1] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan nama pelanggan")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /fo_redaman gede")."&parse_mode=HTML");
				}
				else
				{
					$reply_msg = $this->fiberstream_model->get_status($msgdata[1]);
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
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		elseif (strpos($message, "/exportpdf") === 0) 
		{	
			if($telegram_user['id_user'] != NULL)
			{
				if($msgdata[1] == NULL || $msgdata[2] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Format Syntax /exportpdf tanggal_awal tanggal_akhir")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /exportpdf 2021-12-01 2021-12-30")."&parse_mode=HTML");
				}
				else
				{
					$this->mapping_model->export_tg_pdf($msgdata[1],$msgdata[2],$telegram_user['id_area']);
					$chat_id = $telegram->ChatID();
					$msg_id = $telegram->MessageID();
					$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/mapping/Data Mapping Capel GMEDIA ".$msgdata[1]." sd ".$msgdata[2].".pdf";
					$finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filelocation);
					$cFile = new CURLFile($filelocation, $finfo);
					
					$content = array('chat_id' => $chat_id, 'reply_to_message_id' =>$msg_id,'document' => $cFile);
					$telegram->sendDocument($content);
					unlink($filelocation);
				}
			}
			else
			{
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		elseif (strpos($message, "/exportxls") === 0) 
		{	
			if($telegram_user['id_user'] != NULL)
			{
				if($msgdata[1] == NULL || $msgdata[2] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Format Syntax /exportxls tanggal_awal tanggal_akhir")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /exportxls 2021-12-01 2021-12-30")."&parse_mode=HTML");
				}
				else
				{
					$this->mapping_model->export_tg_xls($msgdata[1],$msgdata[2],$telegram_user['id_area']);
					$chat_id = $telegram->ChatID();
					$msg_id = $telegram->MessageID();
					$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/mapping/Data Mapping Capel GMEDIA ".$msgdata[1]." sd ".$msgdata[2].".xlsx";
					$finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filelocation);
					$cFile = new CURLFile($filelocation, $finfo);
					
					$content = array('chat_id' => $chat_id, 'reply_to_message_id' =>$msg_id,'document' => $cFile);
					$telegram->sendDocument($content);
					unlink($filelocation);
				}
			}
			else
			{
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		//Get Data Daily Report
		elseif (strpos($message, "/dailyreport") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['id_area'] == "NTB" && $telegram_user['status'] == "1")
			{
				
				date_default_timezone_set("Asia/Singapore");
				$this->load->helper(array('form', 'url'));
				$daily  = $this->db->get_where('blip_mondevice', array('status' => "down"))->result_array();
				$message_report = "";
				foreach($daily as $repdaily){
				$message_report .= json_decode('"\u27a1"')." Device: <b>".$repdaily['device']."</b>\n".json_decode('"\u27a1"')." Waktu Down: ".$repdaily['waktu_down']."\n".json_decode('"\u27a1"')." Status: <b>".$repdaily['status']."</b>\n\n";
				}
				
				if($message_report == NULL){
				$message = "<b>Tidak ada data down</b>";
				}else{
				$message = $message_report;
				}
				$this->telegram_lib_noc->sendmsg("".json_decode('"\u270F\u270F\u270F"')." <b>DAILY REPORT</b> ".json_decode('"\u270F\u270F\u270F"')."\n<pre>".$message."</pre>".json_decode('"\u270F\u270F\u270F"')." <b>DAILY REPORT</b> ".json_decode('"\u270F\u270F\u270F"'));	
			}
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");
			}
		}
		//Limit Access ChatID PUBLIK (BALI etc)
		elseif (strpos($message, "/dcs") === 0) 
		{
			if($telegram_user['id_user'] != NULL && $telegram_user['status'] == "1")
			{
				if($msgdata[1] == NULL || $msgdata[2] == NULL || $msgdata[3] == NULL)
				{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Silahkan masukan kordinat mapping anda.")."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Contoh: /dcs -8.361846 116.141454 Capel")."&parse_mode=HTML");
				}
				else
				{
				$mapping = $this->mapping_model->mapping_fs_new($msgdata[1],$msgdata[2],$chatID);
				$result_mapping = explode(" ", $mapping);
				_default_timezone_set("Asia/Singapore");
				$_now = ("Y-m-d");
	
							//Explode data Capel
							$capel = "";
							for($msgcapel=3; $msgcapel <= $msgcount;)
							{
							
								$capel .= "$msgdata[$msgcapel] ";
								$msgcapel++;
							}
						
							if($result_mapping[1] > 501)
							{
							
							$this->load->database();
							$getarea = $this->db->get_where('gm_mapping', array('odp' => $result_mapping[0]));
							$area = $getarea->row_array();
							$data_capel = array(
								'area' => $area['area'],
								'media' => "FO",
								'odp' => $result_mapping[0],
								'jarak' => $result_mapping[1],
								'lat' => $msgdata[1],
								'long' => $msgdata[2],
								'capel' => $capel,
								'site' => $result_mapping[2],
								'status' => "Tidak tercover",
								'' => $_now,
							);
							
							$this->db->insert('gm_mapping_capel', $data_capel);
							$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nArea: <b>".$area['area']." </b>\r\nOSP: <b>".$result_mapping[2]."</b>\r\nTanggal Survey: $_now\r\nHasil Mapping: <b>Tidak tercover</b>. Perkiraan jarak tarikan <b>".$result_mapping[1]."</b> Meter dari ODP terdekat <b>".$result_mapping[0]."</b>.");
							file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
							
							}
							else
							{
							$this->load->database();
							$getarea = $this->db->get_where('gm_mapping', array('odp' => $result_mapping[0]));
							$area = $getarea->row_array();
							$data_capel = array(
								'area' => $area['area'],
								'media' => "FO",
								'odp' => $result_mapping[0],
								'jarak' => $result_mapping[1],
								'lat' => $msgdata[1],
								'long' => $msgdata[2],
								'capel' => $capel,
								'site' => $result_mapping[2],
								'status' => "Tercover",
								'' => $_now,
							);
							
							$this->db->insert('gm_mapping_capel', $data_capel);
							$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nArea: <b>".$area['area']." </b>\r\nOSP: <b>".$result_mapping[2]."</b>\r\nTanggal Survey: $_now\r\nHasil Mapping: Tercover ODP <b>".$result_mapping[0]."</b> dengan jarak perkiraan <b>".$result_mapping[1]."</b> Meter.");
							file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
							}
				//End Site		
				}
			}
			else
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML");	
			}
		}			
		//ENDIF & END AKSES BOT	
		else
		{
			$this->load->database();
			if(isset($chatID)) 
			{
				$telegram_user = $this->telegram_model->get($chatID);
				if($telegram_user['id_user'] != NULL && $telegram_user['status'] == "0")
				{file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Hai kak <b>".$fname." ".$lname."</b>, ID kakak <b>$chatID</b> sedang menunggu approval dari admin.")."&parse_mode=HTML");}
				elseif($telegram_user['id_user'] != NULL && $telegram_user['status'] == "2")
				{file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("Hai kak <b>".$fname." ".$lname."</b>, ID kakak <b>$chatID</b> sudah terdaftar di Area $telegram_user[id_area] dengan status <b>Tidak Aktif</b>.")."&parse_mode=HTML");}
				//else
				//{
				//file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Maaf anda tidak memiliki akses.</b>&parse_mode=HTML"); 
				//}
			}
		}
		
	}
	//END SYNTAX DENGAN AKSES TERDAFTAR

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

public function xlsx() {
		$this->mapping_model->export_tg_xls("2021-12-01","2021-12-05","NTB");
    }
public function fs_client_all() {	
	$fs_detail = $this->fiberstream_model->get_client_all();
	$fsdetails = "";
	foreach($fs_detail as $fsdetail){$fsdetails .= $fsdetail['cid']." - ".$fsdetail['nama']."<br>";}
	echo $fsdetails;
	}
	
public function gmakses_web($id) {	
		$TOKEN = "1117257670:AAHlAgCIfzL3DTe4xnI8ygVdVVpr2z9JDls";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
		$this->load->database();
		$telegram_user = $this->telegram_model->get($id);
		$this->telegram_model->timpa($id,$this->input->post('area'),$this->input->post('status'));
		if($this->input->post('status') == "1") {$status = "diaktifkan";$status2 = "Aktif";} else {$status = "nonaktifkan";$status2 = "Nonaktif";}
		file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".urlencode("ID $msgdata[1] sukses di $status.")."&parse_mode=HTML");
		
		if($status2 == "Aktif") {file_get_contents($apiURL."/sendmessage?chat_id=".$id."&text=".urlencode("Hai kak <b>".$telegram_user['id_nama']."</b>, Selamat ID kakak telah <b>".$status2."</b> dan terdaftar di Area ".$this->input->post('area')."")."&parse_mode=HTML");}
		else{file_get_contents($apiURL."/sendmessage?chat_id=".$id."&text=".urlencode("Hai kak <b>".$telegram_user['id_nama']."</b>, Saat ini ID kakak dalam status <b>".$status2."</b>. Silahkan hubungi admin untuk informasi lebih lanjut. Terima kasih")."&parse_mode=HTML");}
		
		$this->session->set_flashdata('success', 'Berhasil up data.');
		redirect('manage/bot_tg_user'); 
	}	
	
//END SCRIPT

}  




