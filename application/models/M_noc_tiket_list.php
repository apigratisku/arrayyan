<?php

class M_noc_tiket_list extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_tiket_list', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_tiket_list');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function do_filter() {
		$pelanggan = $this->input->post('pelanggan');
		$tgl_a = $this->input->post('tgl_a');
		$tgl_b = $this->input->post('tgl_b');
		$this->db->select('*');
		$this->db->from('blip_tiket_list');
		$this->db->where("customers",$pelanggan);
		$this->db->where("DATE_FORMAT(tgl_open,'%Y-%m-%d') >='$tgl_a'");
		$this->db->where("DATE_FORMAT(tgl_close_sla,'%Y-%m-%d') <='$tgl_b'");
		
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		//$query = $this->db->get_where('blip_tiket_list', array('customers' => $pelanggan));
		$response = $query->result_array(); 
        return $response;
    }
	
	public function getEXPORT() {
            $this->db->select('*');
            $this->db->from('blip_tiket_list');
			$this->db->where("tgl_open", date("Y-m-d"));
			$this->db->order_by("id", "desc");
            return $this->db->get();
    }
	
	public function getDATA($tgl_a,$tgl_b){
	$this->db->select('*');
	$this->db->from('blip_tiket_list');
	$this->db->where("DATE_FORMAT(tgl_open,'%Y-%m-%d') >='$tgl_a'");
    $this->db->where("DATE_FORMAT(tgl_open,'%Y-%m-%d') <='$tgl_b'");
	$this->db->order_by("id", "desc");
	$response = $this->db->get();
	return $response;
	}

	function weekOfMonth($date) {
		//Get the first day of the month.
		$firstOfMonth = strtotime(date("Y-m-01", $date));
		//Apply above formula.
		return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
	}
		
	function weekOfYear($date) {
			$weekOfYear = intval(date("W", $date));
			if (date('n', $date) == "1" && $weekOfYear > 51) {
				// It's the last week of the previos year.
				return 0;
			}
			else if (date('n', $date) == "12" && $weekOfYear == 1) {
				// It's the first week of the next year.
				return 53;
			}
			else {
				// It's a "normal" week.
				return $weekOfYear;
			}
	}
	

	
    public function simpan() {
		if(!empty($this->input->post('waktu_mulai'))){
		$datestart_explode = explode(" ",$this->input->post('waktu_mulai')); 
		$datetime_open = DateTime::createFromFormat('Y-m-d', $datestart_explode[0]);	
		$tgl_open = $datetime_open->format('Y-m-d');
		$jam_open = $datestart_explode[1];
		}else{
		$date_start_explode = "";
		$tgl_open = "";
		$jam_open = ""; 
		}
		
		
		if(!empty($this->input->post('waktu_close_sla'))){
		$datestart_explode_sla = explode(" ",$this->input->post('waktu_close_sla')); 
		$datetime_close_sla = DateTime::createFromFormat('Y-m-d', $datestart_explode_sla[0]);	
		$tgl_close_sla = $datetime_close_sla->format('Y-m-d');
		$jam_close_sla = $datestart_explode_sla[1];
		}else{
		$tgl_close_sla = "";
		$jam_close_sla = ""; 
		}
		
		
		
		if(!empty($this->input->post('waktu_close'))){
		$dateclose_explode = explode(" ",$this->input->post('waktu_close')); 
		$datetime_close = DateTime::createFromFormat('Y-m-d', $dateclose_explode[0]);
		$tgl_close = $datetime_close->format('Y-m-d');
		$jam_close=$dateclose_explode[1];
		
		
		
		//Hitung Durasi 
		$awal  = strtotime($this->input->post('waktu_mulai'));
		$akhir = strtotime($this->input->post('waktu_close'));
		//$awal  = strtotime('2017-08-10 10:05:25');
		//$akhir = strtotime('2017-08-11 11:07:33');
		$diff  = $akhir - $awal;
		
		$jam   = floor($diff / (60 * 60));
		$menit = $diff - ( $jam * (60 * 60) );
		$detik = $diff % 60;
		$str_jam = $jam * 60;
		$str_menit = floor( $menit / 60 );
		$str_durasi = $str_jam+$str_menit;
		//echo 'Waktu tinggal: ' . $jam .  ' jam, ' . floor( $menit / 60 ) . ' menit, ' . $detik . ' detik';
		
		
		}else{
		$date_close_explode = "";
		$tgl_close = "";
		$jam_close = "";
		$durasi = "";
		}
		
		//Hitung Durasi SLA
		$awal_sla  = strtotime($this->input->post('waktu_mulai'));
		$akhir_sla = strtotime($this->input->post('waktu_close_sla'));

		$diff_sla = $akhir_sla - $awal_sla;
		
		$jam_sla   = floor($diff_sla / (60 * 60));
		$menit_sla = $diff_sla - ( $jam_sla * (60 * 60) );
		$detik_sla = $diff_sla % 60;
		$str_jam_sla = $jam_sla * 60;
		$str_menit_sla = floor( $menit_sla / 60 );
		$str_durasi_sla = $str_jam_sla+$str_menit_sla;

		
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $this->input->post('customers')))->row_array();
		
		// Getting the new formatted datetime 
		//echo $datetime->format('d/m/Y');
		
		//Cek Office Hours
		$storeSchedule = [
			'Sun' => ['00:00 AM' => '00:00 AM'],
			'Mon' => ['08:00 AM' => '05:00 PM'],
			'Tue' => ['08:00 AM' => '05:00 PM'],
			'Wed' => ['08:00 AM' => '05:00 PM'],
			'Thu' => ['08:00 AM' => '05:00 PM'],
			'Fri' => ['08:00 AM' => '05:00 PM'],
			'Sat' => ['00:00 AM' => '00:00 AM'],
		];
		
		// current or user supplied UNIX timestamp
		$timestamp = time();
		
		// default status
		$jam_kerja = 'Non Office Hour';
		
		// get current time object
		$currentTime = (new DateTime())->setTimestamp($timestamp);
		
		// loop through time ranges for current day
		foreach ($storeSchedule[date('D', $timestamp)] as $startTime => $endTime) {
		
			// create time objects from start/end times
			$startTime = DateTime::createFromFormat('h:i A', $startTime);
			$endTime   = DateTime::createFromFormat('h:i A', $endTime);
		
			// check if current time is within a range
			if (($startTime < $currentTime) && ($currentTime < $endTime)) {
				$jam_kerja = 'Office Hour';
				break;
			}
		}
		//echo $datetime_open->format('Y-m-d');
		//End
		$value= $datetime_open->format('Y-m-d');
		$array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/APIHariLibur_V2/main/calendar.json"),true);

		//check tanggal merah berdasarkan libur nasional
		if(isset($array[$value]) && $array[$value]["holiday"])
			:		echo"tanggal merah\n";
					 print_r($array[$value]);
			
				//check tanggal merah berdasarkan hari minggu
				elseif(
			date("D",strtotime($value))==="Sun")
			:		$hari = "Hari Libur";
		
			//bukan tanggal merah
			else:
					$hari = "Hari Kerja";
			endif;
			
		//Token
		$token = md5(getrandmax()."".date('H:i'));
		$tiket = "#".date("YmdHi");
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $this->input->post('customers')))->row_array();
		if(!empty($pelanggan['pic'])){$pic = $pelanggan['pic'];}else{$pic="-";}
		if(!empty($pelanggan['kontak'])){$kontak = $pelanggan['kontak'];}else{$kontak="-";}
			
		//Sent EMAIL
		if(!empty($this->input->post('notif_email'))){	
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://apigratis.my.id/blipmail.php");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
			$data_email = array(
			'mail_token' =>  "BLiPNTB2024!",
			'mail_tiket' =>  $tiket,
			'mail_from' => "noc.blip@apigratis.my.id",
			'mail_to' =>  "baiq.afiqa@blip.co.id",
			//'mail_to' =>  "adhitya.mataram@gmail.com",
			//'mail_cc1' =>  "adhitya.mataram@gmail.com",
			//'mail_cc2' =>  "frandi.prameiditya@gmedia.co.id",
			'mail_cc1' =>  "noc.blipntb@gmail.com",
			'mail_cc2' =>  "fawas.zikrillah@blip.co.id",
			'mail_bcc' =>  "adhit.bisnis@gmail.com",
			'mail_case_gangguan' => $this->input->post('case_gangguan'),
			'mail_problem' =>  $this->input->post('problem'),
			'mail_pic' =>  $pic,
			'mail_kontak' =>  $kontak,
			'mail_status' =>  $this->input->post('status'),
			'mail_customer' =>  $pelanggan['nama'],
			'mail_waktu_mulai' =>  $this->input->post('waktu_mulai'),	
			);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_email));
			curl_exec($curl);
			curl_close($curl);	
		}
		
		//Sent Telegram
		if(!empty($this->input->post('notif_tg'))){
			$pesan_tg = "<b>[Open Ticket ".$tiket."] Gangguan/Maintenance</b>\n";
			$pesan_tg .= "Customer: <b>".$pelanggan['nama']."</b>\nCase Gangguan: ".$this->input->post('case_gangguan')."\nProblem: ".$this->input->post('problem')."\nPIC: ".$pic."\nKontak: ".$kontak."\nWaktu Start: ".$this->input->post('waktu_mulai')."\n\n";
			$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";
			$this->telegram_lib->sendblip("-901753609",$pesan_tg);
		}
		
		
		$data = array(
		'token' => $token,
		'tiket' => $tiket,
		'tahun' => $datetime_open->format('Y'),
		'bulan' => $datetime_open->format('m'),
		'week' => "",
		'pop' => $pelanggan['pop'],
		'customers' => $this->input->post('customers'),
		'case_gangguan' => $this->input->post('case_gangguan'),
		'case_klasifikasi' => $this->input->post('case_klasifikasi'),
		'case_subklasifikasi' => $this->input->post('case_subklasifikasi'),
		'tgl_open' => $tgl_open,
		'jam_open' => $jam_open,
		'eskalasi_noc' => $this->input->post('eskalasi_noc'),
		'noc_ip_core' => $this->input->post('noc_ip_core'),
		'noc_hd_duty' => $this->input->post('noc_hd_duty'),
		'eskalasi_akhir' => $this->input->post('eskalasi_akhir'),
		'problem' => $this->input->post('problem'),
		'action' => $this->input->post('action'),
		'status' => $this->input->post('status'),
		'tgl_close' => $tgl_close,
		'jam_close' => $jam_close,
		'tgl_close_sla' => $tgl_close_sla,
		'jam_close_sla' => $jam_close_sla,
		'durasi_sla' => $str_durasi_sla,
		'pic' => $this->input->post('pic'),
		'durasi' => $str_durasi,
		'waktu_mulai_case' => $jam_kerja,
		'waktu_close_case' => $jam_kerja,
		'ket_mulai' => $hari,
		'ket_selesai' => $hari,
		);				
		$insert_db = $this->db->insert('blip_tiket_list', $data);
		
		if($insert_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data tiket list",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal menambah data.');
		}	
    }

    public function timpa($id) {
       date_default_timezone_set("Asia/Singapore");
	   
		if(!empty($this->input->post('waktu_mulai'))){
		$datestart_explode = explode(" ",$this->input->post('waktu_mulai')); 
		$datetime_open = DateTime::createFromFormat('Y-m-d', $datestart_explode[0]);	
		$tgl_open = $datetime_open->format('Y-m-d');
		$jam_open = $datestart_explode[1];
		}else{
		$date_start_explode = "";
		$tgl_open = "";
		$jam_open = ""; 
		}
		
		
		if(!empty($this->input->post('waktu_close_sla'))){
		$datestart_explode_sla = explode(" ",$this->input->post('waktu_close_sla')); 
		$datetime_close_sla = DateTime::createFromFormat('Y-m-d', $datestart_explode_sla[0]);	
		$tgl_close_sla = $datetime_close_sla->format('Y-m-d');
		$jam_close_sla = $datestart_explode_sla[1];
		}else{
		$tgl_close_sla = "";
		$jam_close_sla = ""; 
		}
		
		if(!empty($this->input->post('waktu_close'))){
		$dateclose_explode = explode(" ",$this->input->post('waktu_close')); 
		$datetime_close = DateTime::createFromFormat('Y-m-d', $dateclose_explode[0]);
			if(!empty($datetime_close)){
			$tgl_close = $datetime_close->format('Y-m-d');
			$jam_close=$dateclose_explode[1];
			}
		
		
		//Hitung Durasi 
		$awal  = strtotime($this->input->post('waktu_mulai'));
		$akhir = strtotime($this->input->post('waktu_close'));
		//$awal  = strtotime('2017-08-10 10:05:25');
		//$akhir = strtotime('2017-08-11 11:07:33');
		$diff  = $akhir - $awal;
		
		$jam   = floor($diff / (60 * 60));
		$menit = $diff - ( $jam * (60 * 60) );
		$detik = $diff % 60;
		$str_jam = $jam * 60;
		$str_menit = floor( $menit / 60 );
		$str_durasi = $str_jam+$str_menit;
		//echo 'Waktu tinggal: ' . $jam .  ' jam, ' . floor( $menit / 60 ) . ' menit, ' . $detik . ' detik';
		
		
		
		}else{
		$date_close_explode = "";
		$tgl_close = "";
		$jam_close = "";
		$durasi = "";
		}
		
		//Hitung Durasi SLA
		$awal_sla  = strtotime($this->input->post('waktu_mulai'));
		$akhir_sla = strtotime($this->input->post('waktu_close_sla'));

		$diff_sla = $akhir_sla - $awal_sla;
		
		$jam_sla   = floor($diff_sla / (60 * 60));
		$menit_sla = $diff_sla - ( $jam_sla * (60 * 60) );
		$detik_sla = $diff_sla % 60;
		$str_jam_sla = $jam_sla * 60;
		$str_menit_sla = floor( $menit_sla / 60 );
		$str_durasi_sla = $str_jam_sla+$str_menit_sla;
		
		
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $this->input->post('customers')))->row_array();
		
		// Getting the new formatted datetime 
		//echo $datetime->format('d/m/Y');
		
		//Cek Office Hours
		$storeSchedule = [
			'Sun' => ['00:00 AM' => '00:00 AM'],
			'Mon' => ['08:00 AM' => '05:00 PM'],
			'Tue' => ['08:00 AM' => '05:00 PM'],
			'Wed' => ['08:00 AM' => '05:00 PM'],
			'Thu' => ['08:00 AM' => '05:00 PM'],
			'Fri' => ['08:00 AM' => '05:00 PM'],
			'Sat' => ['00:00 AM' => '00:00 AM'],
		];
		
		// current or user supplied UNIX timestamp
		$timestamp = time();
		
		// default status
		$jam_kerja = 'Non Office Hour';
		
		// get current time object
		$currentTime = (new DateTime())->setTimestamp($timestamp);
		
		// loop through time ranges for current day
		foreach ($storeSchedule[date('D', $timestamp)] as $startTime => $endTime) {
		
			// create time objects from start/end times
			$startTime = DateTime::createFromFormat('h:i A', $startTime);
			$endTime   = DateTime::createFromFormat('h:i A', $endTime);
		
			// check if current time is within a range
			if (($startTime < $currentTime) && ($currentTime < $endTime)) {
				$jam_kerja = 'Office Hour';
				break;
			}
		}
		//echo $datetime_open->format('Y-m-d');
		//End
		$value= $datetime_open->format('Y-m-d');
		$array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/APIHariLibur_V2/main/calendar.json"),true);

		//check tanggal merah berdasarkan libur nasional
		if(isset($array[$value]) && $array[$value]["holiday"])
			:		echo"tanggal merah\n";
					 print_r($array[$value]);
			
				//check tanggal merah berdasarkan hari minggu
				elseif(
			date("D",strtotime($value))==="Sun")
			:		$hari = "Hari Libur";
		
			//bukan tanggal merah
			else:
					$hari = "Hari Kerja";
			endif;
		/*
		//Token
		$token = md5(getrandmax()."".date('H:i'));
		$tiket = "#".date("YmdHi");
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $this->input->post('customers')))->row_array();
		if(!empty($pelanggan['pic'])){$pic = $pelanggan['pic'];}else{$pic="-";}
		if(!empty($pelanggan['kontak'])){$kontak = $pelanggan['kontak'];}else{$kontak="-";}
		*/
		
	//Token
		$data_tiket = $this->db->get_where('blip_tiket_list', array('id' => $id))->row_array();
		$tiket = $data_tiket['tiket'];
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $this->input->post('customers')))->row_array();
		if(!empty($pelanggan['pic'])){$pic = $pelanggan['pic'];}else{$pic="-";}
		if(!empty($pelanggan['kontak'])){$kontak = $pelanggan['kontak'];}else{$kontak="-";}
			
		//Sent EMAIL
		if(!empty($this->input->post('notif_email'))){	
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://apigratis.my.id/blipmail.php");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
			$data_email = array(
			'mail_token' =>  "BLiPNTB2024!",
			'mail_tiket' =>  $tiket,
			'mail_from' => "noc.blip@apigratis.my.id",
			'mail_to' =>  "baiq.afiqa@blip.co.id",
			//'mail_to' =>  "adhitya.mataram@gmail.com",
			//'mail_cc1' =>  "adhitya.mataram@gmail.com",
			//'mail_cc2' =>  "frandi.prameiditya@gmedia.co.id",
			'mail_cc1' =>  "noc.blipntb@gmail.com",
			'mail_cc2' =>  "fawas.zikrillah@blip.co.id",
			'mail_bcc' =>  "adhit.bisnis@gmail.com",
			'mail_case_gangguan' => $this->input->post('case_gangguan'),
			'mail_problem' =>  $this->input->post('problem'),
			'mail_pic' =>  $pic,
			'mail_kontak' =>  $kontak,
			'mail_status' =>  $this->input->post('status'),
			'mail_customer' =>  $pelanggan['nama'],
			'mail_waktu_mulai' =>  $this->input->post('waktu_mulai'),	
			);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_email));
			curl_exec($curl);
			curl_close($curl);		
		}
		
		//Sent Telegram
		if(!empty($this->input->post('notif_tg'))){
			$pesan_tg = "<b>[Open Ticket ".$tiket."] Gangguan/Maintenance</b>\n";
			$pesan_tg .= "Customer: <b>".$pelanggan['nama']."</b>\nCase Gangguan: ".$this->input->post('case_gangguan')."\nProblem: ".$this->input->post('problem')."\nPIC: ".$pic."\nKontak: ".$kontak."\nWaktu Start: ".$this->input->post('waktu_mulai')."\n\n";
			$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";
			$this->telegram_lib->sendblip("-901753609",$pesan_tg);
		}
			 
     $data = array(
		'tahun' => $datetime_open->format('Y'),
		'bulan' => $datetime_open->format('m'),
		'week' => "",
		'pop' => $pelanggan['pop'],
		'customers' => $this->input->post('customers'),
		'case_gangguan' => $this->input->post('case_gangguan'),
		'case_klasifikasi' => $this->input->post('case_klasifikasi'),
		'case_subklasifikasi' => $this->input->post('case_subklasifikasi'),
		'tgl_open' => $tgl_open,
		'jam_open' => $jam_open,
		'eskalasi_noc' => $this->input->post('eskalasi_noc'),
		'noc_ip_core' => $this->input->post('noc_ip_core'),
		'noc_hd_duty' => $this->input->post('noc_hd_duty'),
		'eskalasi_akhir' => $this->input->post('eskalasi_akhir'),
		'problem' => $this->input->post('problem'),
		'action' => $this->input->post('action'),
		'status' => $this->input->post('status'),
		'tgl_close' => $tgl_close,
		'jam_close' => $jam_close,
		'tgl_close_sla' => $tgl_close_sla,
		'jam_close_sla' => $jam_close_sla,
		'durasi_sla' => $str_durasi_sla,
		'pic' => $this->input->post('pic'),
		'durasi' => $str_durasi,
		'waktu_mulai_case' => $jam_kerja,
		'waktu_close_case' => $jam_kerja,
		'ket_mulai' => $hari,
		'ket_selesai' => $hari,
		);					
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_tiket_list', $data);			
		
		if($update_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data tiket list",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success','Berhasil mengubah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal mengubah data.');
		}	
    }
	
    public function delete($id) {
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menghapus data tiket list",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log	
        return $this->db->delete('blip_tiket_list', array('id' => $id));
    }

}
