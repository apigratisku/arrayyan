<?php
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 

class Mapping_model extends CI_Model {

    public function __construct() {
        $this->load->database();
		$this->load->library('TCPDF');
    }
	
	public function count() {
        return $this->db->get('gm_mapping')->num_rows();
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_mapping', array('id' => $id));
            $response = $query->row_array();
        } else {
			$this->db->select('*');
            $this->db->from('gm_mapping');
            $this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function refresh_pelanggan() {
		$sql_odp = $this->db->get('gm_mapping')->result_array();
		foreach($sql_odp as $data_odp){
			$sql_layanan = $this->db->get_where('blip_layanan', array('odp' => $data_odp['id'],'id_status' => "1"))->num_rows();
			$data_update = array(
				'pelanggan' => $sql_layanan,
			);
			$this->db->where('id', $data_odp['id']);
			$this->db->update('gm_mapping', $data_update);
		}
		redirect('manage/mapping');
    }
	public function data_odp() {
		$sql_odp = $this->db->get('gm_mapping')->result_array();
		foreach($sql_odp as $data_odp){
			$sql_layanan = $this->db->get_where('blip_layanan', array('odp' => $data_odp['id'],'id_status' => "1"))->num_rows();
			$data_update = array(
				'pelanggan' => $sql_layanan,
			);
			$this->db->where('id', $data_odp['id']);
			$this->db->update('gm_mapping', $data_update);
		}
    }
	
	public function get_ntb($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_mapping', array('id' => $id,'area' => "NTB"));
            $response = $query->row_array();
        } else {
            $query = $this->db->get_where('gm_mapping', array('area' => "NTB"));
            $response = $query->result_array();
        }

        return $response;
    }
	public function result() {
		$this->db->select('*');
		$this->db->from('gm_mapping_capel');
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		$response = $query->result_array();	
        return $response;
    }
	
	public function delete_result($id) {	
        return $this->db->delete('gm_mapping_capel', array('id' => $id));
    }
	
	public function get_result() {
		//$this->db->select("(SELECT MIN(jarak) FROM gm_mapping_result) AS jarak_mapping",FALSE);
		//$query = $this->db->get('gm_mapping_result');
		$this->db->select_min('jarak');
		$this->db->order_by('jarak', 'ASC');
		$result = $this->db->get('gm_mapping_result')->row(); 
		$query = $this->db->get_where('gm_mapping_result', array('jarak' => $result->jarak));
        $response = $query->row_array();
		$tarikan_spare = $response['jarak']+70;
		return $response['odp']." ".$tarikan_spare." ".$response['site']; 
    }

    public function simpan() {
        $data = array(
			'area' => $this->input->post('area'),
            'odp' => $this->input->post('odp'),
			'lat' => $this->input->post('lat'),
			'long' => $this->input->post('long'),
			'site' => $this->input->post('site'),
        );
        return $this->db->insert('gm_mapping', $data);
    }

    public function timpa($id) {
       $data = array(
	   		'area' => $this->input->post('area'),
            'odp' => $this->input->post('odp'),
			'lat' => $this->input->post('lat'),
			'long' => $this->input->post('long'),
			'site' => $this->input->post('site'),
        );
		
        $this->db->where('id', $id);
        return $this->db->update('gm_mapping', $data);
    }

    public function delete($id) {	
        return $this->db->delete('gm_mapping', array('id' => $id));
    }
	
		
	public function mapping_fs($lat,$long,$chatID) {
	$this->db->truncate('gm_mapping_result');
	$getarea = $this->db->get_where('gm_telegram_user', array('id_user' => $chatID));
    $area = $getarea->row_array();
	$get_kordinat = $this->get();
		function rad($x){ return $x * M_PI / 180; }
		function distHaversine($coord_a, $coord_b){
		# jarak kilometer dimensi (mean radius) bumi
		$R = 6371;
		$coord_a = explode(",",$coord_a);
		$coord_b = explode(",",$coord_b);
		$dLat = rad(($coord_b[0]) - ($coord_a[0]));
		$dLong = rad($coord_b[1] - $coord_a[1]);
		$a = sin($dLat/2) * sin($dLat/2) + cos(rad($coord_a[0])) * cos(rad($coord_b[0])) * sin($dLong/2) * sin($dLong/2);
		$c = 2 * atan2(sqrt($a), sqrt(1-$a));
		$d = $R * $c;
		# hasil akhir dalam satuan kilometer
		return number_format($d, 2, '.', ',');
		}
		foreach($get_kordinat as $kordinat_odp)
		{
		
		## cara penggunaannya
		## contoh ada 2 koordinat (latitude dan longitude)
		$a = $kordinat_odp['lat'].",".$kordinat_odp['long'];
		$b = $lat.",".$long;
		$distance = distHaversine($a, $b);
		$jarak = $distance*1000;
		
		$data = array(
			'area' => $area['id_area'],
            'odp' => $kordinat_odp['odp'],
			'jarak' => $jarak,
			'site' => $kordinat_odp['site'],
        );
        
		$this->db->insert('gm_mapping_result', $data);

		}
		//$return_data = $kordinat_odp['odp']." ".$this->get_result();
		return $this->get_result();
		
	}
	
	public function mapping_fs_new($lat,$long,$chatID,$earthRadius = 6371000)
	{
	$getarea = $this->db->get_where('gm_telegram_user', array('id_user' => $chatID));
    $area = $getarea->row_array();
	  // convert from degrees to radians
	  $this->db->truncate('gm_mapping_result');
	  $get_kordinat = $this->get();
	  foreach($get_kordinat as $kordinat_odp)
		{
		  $latFrom = deg2rad($kordinat_odp['lat']);
		  $lonFrom = deg2rad($kordinat_odp['long']);
		  $latTo = deg2rad($lat);
		  $lonTo = deg2rad($long);
		
		  $lonDelta = $lonTo - $lonFrom;
		  $a = pow(cos($latTo) * sin($lonDelta), 2) +
			pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		  $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
		
		  $angle = atan2(sqrt($a), $b);
		  $jarak = $angle * $earthRadius;
		  $result_jarak = ceil($jarak);
		
		$data = array(
			'area' => $area['id_area'],
            'odp' => $kordinat_odp['odp'],
			'jarak' => $result_jarak,
			'site' => $kordinat_odp['site'],
        );
			if($area['id_area'] == "BALI")
			{
			$this->db->where('area', $area['id_area']);
			$this->db->insert('gm_mapping_result', $data);
			}
			else
			{
			$this->db->insert('gm_mapping_result', $data);
			}
		}
		return $this->get_result();
	  
	}
	
	public function mapping_fo_onnet($klasifikasi,$lat,$long,$chatID,$message,$earthRadius = 6371000)
	{
	//Update data pelanggan ODP
	$this->data_odp();
	//Start proses mapping
	$this->load->model('telegram_model');
	$telegram = new Telegram('1117257670:AAHlAgCIfzL3DTe4xnI8ygVdVVpr2z9JDls');
	$private = $telegram->getData();
	$chat_id = $telegram->ChatID();
	$msg_id = $telegram->MessageID();
	$TOKEN = "1117257670:AAHlAgCIfzL3DTe4xnI8ygVdVVpr2z9JDls";
	$apiURL = "https://api.telegram.org/bot$TOKEN";
     $msgdata = explode(" ", $message);
	 $msgcount = count($msgdata);
	 $getarea = $this->db->get_where('gm_telegram_user', array('id_user' => $chatID));
     $area = $getarea->row_array();
	  // convert from degrees to radians
	  $this->db->truncate('gm_mapping_result');
	  $get_kordinat = $this->get();
	  foreach($get_kordinat as $kordinat_odp)
		{
		  $latFrom = deg2rad($kordinat_odp['lat']);
		  $lonFrom = deg2rad($kordinat_odp['long']);
		  $latTo = deg2rad($lat);
		  $lonTo = deg2rad($long);
		
		  $lonDelta = $lonTo - $lonFrom;
		  $a = pow(cos($latTo) * sin($lonDelta), 2) +
			pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		  $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
		
		  $angle = atan2(sqrt($a), $b);
		  $jarak = $angle * $earthRadius;
		  $result_jarak = ceil($jarak);
		
		$data = array(
			'area' => $area['id_area'],
            'odp' => $kordinat_odp['odp'],
			'jarak' => $result_jarak,
			'site' => $kordinat_odp['site'],
        );		
		$this->db->insert('gm_mapping_result', $data);
		}
		
		//START SENT TO USER
		$mapping = $this->get_result();
		$result_mapping = explode(" ", $mapping);
		date_default_timezone_set("Asia/Singapore");
		$_now = date("Y-m-d");
		$this->load->database();
		$getarea = $this->db->get_where('gm_mapping', array('odp' => $result_mapping[0]));
		$area = $getarea->row_array();
		$odp_slot_idle = 16-$area['pelanggan'];
		if($odp_slot_idle == "0"){$status_odp = "Full";}else{$status_odp = "Ready";}
			if(!empty($result_mapping[2]))
			{
					//Explode data Capel
					$capel = "";
					for($msgcapel=4; $msgcapel <= $msgcount;)
					{
					
						$capel .= "$msgdata[$msgcapel] ";
						$msgcapel++;
					}
				
					if($klasifikasi == "brohot")
					{
					$jarak_ori = $result_mapping[1];
					$jarak_spare = $result_mapping[1]+50;
					if($jarak_spare <=300){$kabel = "1 Core"; $jarak = $jarak_spare; $spare="(Sudah include spare 50 Meter)"; $klasi = "Brohot Starter & Ultra"; $hasil_mapping = "Tercover";} 
					elseif($jarak_spare <=400){$kabel = "2 Core"; $jarak = $jarak_spare; $spare="(Sudah include spare 50 Meter)"; $klasi = "Brohot Starter & Ultra"; $hasil_mapping = "Tercover";} 
					else{$kabel = "Custom"; $jarak = $jarak_ori; $klasi = "Brohot Starter & Ultra"; $hasil_mapping = "Tidak tercover";}
					
					
					$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nKlasifikasi: <b>".$klasi." </b>\r\nArea: <b>".$area['area']." </b>\r\nOSP: <b>".$result_mapping[2]."</b>\r\nTanggal Survey: $_now\r\nHasil Mapping: <b>".$hasil_mapping."</b>. Perkiraan jarak tarikan <b>".$jarak."</b> Meter ".$spare." dari ODP terdekat <b>".$result_mapping[0]."</b>.\r\nKabel FO: <b>".$kabel."</b>\r\n\r\nJumlah Slot: <b>16</b>\r\nTerinstall: <b>".$area['pelanggan']."</b>\r\nIdle: <b>".$odp_slot_idle."</b>\r\nStatus ODP: <b>".$status_odp."</b>\r\n\r\nKordinat ODP: https://www.google.com/maps/place/".$area['lat']."+".$area['long']."\r\nKordinat Capel: https://www.google.com/maps/place/".$msgdata[2]."+".$msgdata[3]."");
								
					}elseif($klasifikasi == "busol"){
					$jarak_ori = $result_mapping[1];
					$jarak_spare = $result_mapping[1]+50;
					if($jarak_spare <=350){$kabel = "2 Core"; $jarak = $jarak_spare; $spare="(Sudah include spare 50 Meter)"; $klasi = "Busol"; $hasil_mapping = "Tercover";} 
					elseif($jarak_spare <=500){$kabel = "6 Core ADSS G652D"; $jarak = $jarak_spare; $spare="(Sudah include spare 50 Meter)";  $klasi = "Busol"; $hasil_mapping = "Tercover";} 
					else{$kabel = "6 Core ADSS G652D (Custom)"; $jarak = $jarak_ori; $spare=""; $klasi = "Busol"; $hasil_mapping = "Tercover";}
					$reply_msg = urlencode("Capel: <b>".$capel." </b>\r\nKlasifikasi: <b>".strtoupper($klasi)." </b>\r\nArea: <b>".$area['area']." </b>\r\nOSP: <b>".$result_mapping[2]."</b>\r\nTanggal Survey: $_now\r\nHasil Mapping: <b>".$hasil_mapping."</b>. Perkiraan jarak tarikan <b>".$jarak."</b> Meter ".$spare." dari ODP terdekat <b>".$result_mapping[0]."</b>.\r\nKabel: <b>".$kabel."</b>\r\n\r\nJumlah Slot: <b>16</b>\r\nTerinstall: <b>".$area['pelanggan']."</b>\r\nIdle: <b>".$odp_slot_idle."</b>\r\nStatus ODP: <b>".$status_odp."</b>\r\n\r\nKordinat ODP: https://www.google.com/maps/place/".$area['lat']."+".$area['long']."\r\nKordinat Capel: https://www.google.com/maps/place/".$msgdata[2]."+".$msgdata[3]."");
					
					}else{
					
					$reply_msg = urlencode("Format mapping tidak sesuai.");
					return file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
					
					}
					
					
					$data_capel = array(
						'area' => $area['area'],
						'media' => "FO",
						'odp' => $result_mapping[0],
						'jarak' => $jarak,
						'lat' => $msgdata[2],
						'long' => $msgdata[3],
						'capel' => $capel,
						'klasifikasi' => strtoupper($klasifikasi),
						'site' => $result_mapping[2],
						'status' => $hasil_mapping,
						'date' => $_now,
					);
					
					$this->db->insert('gm_mapping_capel', $data_capel);
					return file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply_msg."&parse_mode=HTML");
					//End Mapping
			}	  
	}
	
	
	public function mapping_we($lat,$long,$status,$tinggi,$bts,$capel) {
	if($status == "OK" || $status == "ok" || $status == "Ok") {$LOS = "Tercover";} else {$LOS = "Tidak Tercover";}
		date_default_timezone_set("Asia/Singapore");
		$_now = date("Y-m-d");
		$getarea = $this->db->get_where('gm_telegram_user', array('id_user' => $chatID));
    	$area = $getarea->row_array();
		$data_capel = array(
						'area' => "NTB",
						'media' => "WE",
						'odp' => "",
						'jarak' => $tinggi,
						'lat' => $lat,
						'long' => $long,
						'capel' => $capel,
						'klasifikasi' => "BUSOL",
						'site' => $bts,
						'status' => $LOS,
						'date' => $_now,
					);	
		return $this->db->insert('gm_mapping_capel', $data_capel);
		
	}
	
	public function insert($data){
		$insert = $this->db->insert_batch('gm_mapping', $data);
		if($insert){
			return true;
		}
	}
	public function getData(){
		$this->db->select('*');
		return $this->db->get('gm_mapping')->result_array();
	}
	
	public function get_export($tgl_a,$tgl_b){
	$this->db->select('*');
	$this->db->from('gm_mapping_capel');
	$this->db->where("DATE_FORMAT(date,'%Y-%m-%d') >='$tgl_a'");
    $this->db->where("DATE_FORMAT(date,'%Y-%m-%d') <='$tgl_b'");
	//$this->db->where('area',$area);
	$this->db->order_by("date", "desc");
	$response = $this->db->get()->result_array();
	return $response;
	}
	
	public function get_export_tg($tgl_a,$tgl_b,$area){
	$this->db->select('*');
	$this->db->from('gm_mapping_capel');
	$this->db->where("DATE_FORMAT(date,'%Y-%m-%d') >='$tgl_a'");
    $this->db->where("DATE_FORMAT(date,'%Y-%m-%d') <='$tgl_b'");
	$this->db->where('area',$area);
	$this->db->order_by("date", "desc");
	$response = $this->db->get()->result_array();
	return $response;
	}
	
	public function export_tg_pdf($a,$b,$area) {
			$items = $this->get_export_tg($a,$b,$area);
			$tanggal = date('Y-m-d');
	 
			$pdf = new \TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
			$pdf->AddPage();
			$pdf->SetFont('', 'B', 20);
			$pdf->Cell(115, 0, "DATA MAPPING CAPEL GMEDIA", 0, 1, 'L');
			$pdf->SetFont('', 'B', 15);
			$pdf->Cell(115, 0, "Periode Data: ".$a." s.d ".$b, 0, 1, 'L');
			$pdf->SetAutoPageBreak(true, 0);
	 
			// Add Header
			$pdf->Ln(10);
			$pdf->SetFont('', 'B', 10);
			$pdf->Cell(15, 8, "No", 1, 0, 'C');
			$pdf->Cell(15, 8, "Area", 1, 0, 'C');
			$pdf->Cell(50, 8, "Nama Capel", 1, 0, 'L');
			$pdf->Cell(15, 8, "Media", 1, 0, 'C');
			$pdf->Cell(25, 8, "ODP", 1, 0, 'C');
			$pdf->Cell(30, 8, "Latitude", 1, 0, 'C');
			$pdf->Cell(30, 8, "Longtitude", 1, 0, 'C');
			$pdf->Cell(20, 8, "Site", 1, 0, 'C');
			$pdf->Cell(25, 8, "Jarak/Tinggi", 1, 0, 'C');
			$pdf->Cell(25, 8, "Status", 1, 0, 'C');
			$pdf->Cell(25, 8, "Tgl. Survey", 1, 1, 'C');
			$pdf->SetFont('', '', 10);
			$no = 1;
			foreach($items as $k => $item) {
				$this->addRow($pdf, $k+1, $item);
				$no++;
			}
			$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/mapping/";
			$fileNL = $filelocation."Data Mapping Capel GMEDIA ".$a." sd ".$b.".pdf";
			return $pdf->Output($fileNL, 'F'); 	
			//return $this->telegram_lib_appts->senddoc($filelocation."Data Mapping Capel GMEDIA ".$msgdata[1]." sd ".$msgdata[2].".pdf","\n\nReport Hasil Mapping  \n=========================== \nPT. Media Sarana Data (GMEDIA)");	
			
	}
	public function export_tg_xls($a,$b,$area) {
		$fileName = "Data Mapping Capel GMEDIA ".$a." sd ".$b.".xlsx";  
		$xls = $this->get_export_tg($a,$b,$area);
		date_default_timezone_set("Asia/Singapore");
		$tanggal = date("Y-m-d H:i:s");
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		//$spreadsheet->getActiveSheet()->getStyle('A1:J10')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
		$header = [
					'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					],
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['rgb' => '000000'],
						],
					],
					'font' => array('bold' => true),
				];
		//horizontal center
		$horizontalCenter = [
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['rgb' => '000000'],
						],
			],
		];
		$sheet = $spreadsheet->getActiveSheet();
		
		//title
		$sheet->setCellValue('A1', "Data Mapping Capel GMEDIA");
		$sheet->mergeCells('A1:K1'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
					
		$sheet->setCellValue('A2', "Tanggal Export: ".$tanggal);
		$sheet->mergeCells('A2:K2'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A2')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		
		$sheet->setCellValue('A3', "Hasil Data Mapping: ".$a." s.d ".$b);
		$sheet->mergeCells('A3:K3'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A3')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		
		
		$sheet->setCellValue('A6', 'No');
			$sheet->setCellValue('B6', 'Area');
			$sheet->setCellValue('C6', 'Capel');
			$sheet->setCellValue('D6', 'Media');
			$sheet->setCellValue('E6', 'ODP');
			$sheet->setCellValue('F6', 'Jarak');
			$sheet->setCellValue('G6', 'Latitude');    
			$sheet->setCellValue('H6', 'Longtitude');
			$sheet->setCellValue('I6', 'Site');
			$sheet->setCellValue('J6', 'Status');
			$sheet->setCellValue('K6', 'Tgl.Survey');   
			
			$sheet->getColumnDimension('A')->setAutoSize(true);
			$sheet->getColumnDimension('B')->setAutoSize(true);
			$sheet->getColumnDimension('C')->setAutoSize(true);
			$sheet->getColumnDimension('D')->setAutoSize(true);
			$sheet->getColumnDimension('E')->setAutoSize(true);
			$sheet->getColumnDimension('F')->setAutoSize(true);
			$sheet->getColumnDimension('G')->setAutoSize(true);
			$sheet->getColumnDimension('H')->setAutoSize(true);
			$sheet->getColumnDimension('I')->setAutoSize(true);
			$sheet->getColumnDimension('J')->setAutoSize(true);
			$sheet->getColumnDimension('K')->setAutoSize(true);
			
			$sheet->getColumnDimension('A')->setAutoSize(true);
			$sheet->getColumnDimension('B')->setAutoSize(true);
			$sheet->getColumnDimension('C')->setAutoSize(true);
			$sheet->getColumnDimension('D')->setAutoSize(true);
			$sheet->getColumnDimension('E')->setAutoSize(true);
			$sheet->getColumnDimension('F')->setAutoSize(true);
			$sheet->getColumnDimension('G')->setAutoSize(true);
			$sheet->getColumnDimension('H')->setAutoSize(true);
			$sheet->getColumnDimension('I')->setAutoSize(true);
			$sheet->getColumnDimension('J')->setAutoSize(true);
			$sheet->getColumnDimension('K')->setAutoSize(true);
			
			$sheet->getStyle('A6')->applyFromArray($header);
			$sheet->getStyle('B6')->applyFromArray($header);
			$sheet->getStyle('C6')->applyFromArray($header);
			$sheet->getStyle('D6')->applyFromArray($header);
			$sheet->getStyle('E6')->applyFromArray($header);
			$sheet->getStyle('F6')->applyFromArray($header);
			$sheet->getStyle('G6')->applyFromArray($header);
			$sheet->getStyle('H6')->applyFromArray($header);
			$sheet->getStyle('I6')->applyFromArray($header);
			$sheet->getStyle('J6')->applyFromArray($header);
			$sheet->getStyle('K6')->applyFromArray($header);

		$rows = 7;
		$no = 1;
		foreach ($xls as $data){
			$sheet->setCellValue('A' . $rows, $no);
			$sheet->setCellValue('B' . $rows, $data['area']);
			$sheet->setCellValue('C' . $rows, $data['capel']);
			$sheet->setCellValue('D' . $rows, $data['media']);
			$sheet->setCellValue('E' . $rows, $data['odp']);
			$sheet->setCellValue('F' . $rows, $data['jarak']."m");
			$sheet->setCellValue('G' . $rows, $data['lat']);
			$sheet->setCellValue('H' . $rows, $data['long']);
			$sheet->setCellValue('I' . $rows, $data['site']);
			$sheet->setCellValue('J' . $rows, $data['status']);
			$sheet->setCellValue('K' . $rows, $data['date']);
			
			$sheet->getStyle('A'.$rows.':K'.$rows)->applyFromArray($horizontalCenter);
				$sheet->getStyle('B'.$rows.':K'.$rows)->applyFromArray($horizontalCenter);
				$sheet->getStyle('C'.$rows.':K'.$rows)->applyFromArray($horizontalCenter);
				$sheet->getStyle('D'.$rows.':K'.$rows)->applyFromArray($horizontalCenter);
				$sheet->getStyle('E'.$rows.':K'.$rows)->applyFromArray($horizontalCenter);
				$sheet->getStyle('F'.$rows.':K'.$rows)->applyFromArray($horizontalCenter);
				$sheet->getStyle('G'.$rows.':K'.$rows)->applyFromArray($horizontalCenter);
				$sheet->getStyle('H'.$rows.':K'.$rows)->applyFromArray($horizontalCenter);
				$sheet->getStyle('I'.$rows.':K'.$rows)->applyFromArray($horizontalCenter);
				$sheet->getStyle('J'.$rows.':K'.$rows)->applyFromArray($horizontalCenter);
				$sheet->getStyle('K'.$rows.':K'.$rows)->applyFromArray($horizontalCenter);
			
			$rows++;
			$no++;
		} 
		
		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/mapping";
		$writer = new Xlsx($spreadsheet);
		$writer->save($filelocation."/".$fileName);
		return header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url('xdark/doc/mapping/').$fileName);
	}
	 
		private function addRow($pdf, $no, $item) {
			if($item['media'] == "FO") {$ketLL = $item['jarak']."m";} else {if($item['jarak'] <= 5) {$ketLL = "1 Pipa";}elseif($item['jarak'] <= 10) {$ketLL = "2 Pipa";}elseif($item['jarak'] <= 15){$ketLL = "3 Pipa";}elseif($item['jarak'] <= 20){$ketLL = "4 Pipa";}elseif($item['jarak'] <= 25){$ketLL = "5 Pipa";}else{$ketLL = "Tinggi 30m+";}}
			$pdf->Cell(15, 8, $no, 1, 0, 'C');
			$pdf->Cell(15, 8, $item['area'], 1, 0, 'C');
			$pdf->Cell(50, 8, $item['capel'], 1, 0, 'L');
			$pdf->Cell(15, 8, $item['media'], 1, 0, 'C');
			$pdf->Cell(25, 8, $item['odp'], 1, 0, 'C');
			$pdf->Cell(30, 8, $item['lat'], 1, 0, 'C');
			$pdf->Cell(30, 8, $item['long'], 1, 0, 'C');
			$pdf->Cell(20, 8, $item['site'], 1, 0, 'C');
			$pdf->Cell(25, 8, $ketLL, 1, 0, 'C');
			$pdf->Cell(25, 8, $item['status'], 1, 0, 'C');
			$pdf->Cell(25, 8, $item['date'], 1, 1, 'C');
		}
		
	public function delete_site_bali() {	
        return $this->db->delete('gm_mapping', array('area' => "BALI"));
    }
	
	public function maps($earthRadius = 6371000)
	{
	$getarea = $this->db->get_where('gm_telegram_user', array('id_user' => "250170651"));
    $area = $getarea->row_array();
	  // convert from degrees to radians
	  $this->db->truncate('gm_mapping_result');
	  $get_kordinat = $this->get();
	  foreach($get_kordinat as $kordinat_odp)
		{
		  $latFrom = deg2rad($kordinat_odp['lat']);
		  $lonFrom = deg2rad($kordinat_odp['long']);
		  $latTo = deg2rad("-8.361846");
		  $lonTo = deg2rad("116.141454");
		
		  $lonDelta = $lonTo - $lonFrom;
		  $a = pow(cos($latTo) * sin($lonDelta), 2) +
			pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		  $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
		
		  $angle = atan2(sqrt($a), $b);
		  $jarak = $angle * $earthRadius;
		  $result_jarak = ceil($jarak);
		
		$data = array(
			'area' => $area['id_area'],
            'odp' => $kordinat_odp['odp'],
			'jarak' => $result_jarak,
			'site' => $kordinat_odp['site'],
        );
			if($area['id_area'] == "BALI")
			{
			$this->db->where('area', $area['id_area']);
			$this->db->insert('gm_mapping_result', $data);
			}
			else
			{
			$this->db->insert('gm_mapping_result', $data);
			}
		}
		return $this->get_result();
	  
	}
	
	
	
	
}
