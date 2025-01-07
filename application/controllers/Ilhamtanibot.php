<?php
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Ilhamtanibot extends CI_Controller {
    function __construct(){
        parent::__construct();
	
    }
 
	function index()
	{
		$telegram = new Telegram('2053857043:AAFMA5okXov8k5e5OMyMM3LThKv0KQDId68');
		$private = $telegram->getData();
		$chat_id = $telegram->ChatID();
		$msg_id = $telegram->MessageID();
        $TOKEN = "2053857043:AAFMA5okXov8k5e5OMyMM3LThKv0KQDId68";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];
        $kordinat = explode(" ", $message);
		
        if (strpos($message, "/id") === 0) 
		{
        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=ID Telegram: ".$chatID."&parse_mode=HTML");
        }
		
		//Limit Access ChatID
			elseif (strpos($message, "/server1_adamart_start") === 0) 
			{
				if($chatID == "250170651" || $chatID == "-1001717426993" || $chatID =="5053878006" || $chatID =="1293015261")
				{
					if ($this->routerosapi->connect("vpn.ilhamtani.my.id","WOL","Masuk*123#","5521"))
					{
						$this->routerosapi->write("/system/script/print",false);			
						$this->routerosapi->write("=.proplist=.id", false);		
						$this->routerosapi->write("?name=WOL_SERVER");				
						$API_SC = $this->routerosapi->read();
						foreach ($API_SC as $script)
						{
							$id_script = $script['.id'];
						}
						$this->routerosapi->write('/system/script/run',false);
						$this->routerosapi->write("=number=".$id_script);
						$this->routerosapi->read();
						file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Proses menyalakan komputer. . . . . . .&parse_mode=HTML");
					}
					else
					{
						file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Gagal membuka koneksi API&parse_mode=HTML");
					}
				}
				else
				{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Anda tidak memiliki akses !!!&parse_mode=HTML");
				}	
			}
			elseif (strpos($message, "/server2_adamart_start") === 0) 
			{
				if($chatID == "250170651" || $chatID == "-1001717426993" || $chatID =="5053878006" || $chatID =="1293015261")
				{
					if ($this->routerosapi->connect("vpn.ilhamtani.my.id","WOL","Masuk*123#","5522"))
					{
						$this->routerosapi->write("/system/script/print",false);			
						$this->routerosapi->write("=.proplist=.id", false);		
						$this->routerosapi->write("?name=WOL_SERVER2");				
						$API_SC = $this->routerosapi->read();
						foreach ($API_SC as $script)
						{
							$id_script = $script['.id'];
						}
						$this->routerosapi->write('/system/script/run',false);
						$this->routerosapi->write("=number=".$id_script);
						$this->routerosapi->read();
						file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Proses menyalakan komputer. . . . . . .&parse_mode=HTML");
					}
					else
					{
						file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Gagal membuka koneksi API&parse_mode=HTML");
					}
				}
				else
				{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Anda tidak memiliki akses !!!&parse_mode=HTML");
				}	
			}
			elseif (strpos($message, "/client_start") === 0) 
			{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Perintah dalam proses pengembangan.&parse_mode=HTML");
			}
			elseif (strpos($message, "/server_ilhamtani_start") === 0) 
			{
				if($chatID == "250170651" || $chatID == "-1001717426993" || $chatID =="5053878006" || $chatID =="1293015261")
				{
					if ($this->routerosapi->connect("vpn.ilhamtani.my.id","WOL","Masuk*123#","5523"))
					{
						$this->routerosapi->write("/system/script/print",false);			
						$this->routerosapi->write("=.proplist=.id", false);		
						$this->routerosapi->write("?name=WOL_SERVER");				
						$API_SC = $this->routerosapi->read();
						foreach ($API_SC as $script)
						{
							$id_script = $script['.id'];
						}
						$this->routerosapi->write('/system/script/run',false);
						$this->routerosapi->write("=number=".$id_script);
						$this->routerosapi->read();
						file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Proses menyalakan komputer. . . . . . .&parse_mode=HTML");
					}
					else
					{
						file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Gagal membuka koneksi API&parse_mode=HTML");
					}
				}
				else
				{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Anda tidak memiliki akses !!!&parse_mode=HTML");
				}	
			}elseif (strpos($message, "/server_bima_start") === 0) 
			{
				if($chatID == "250170651" || $chatID == "-1001717426993" || $chatID =="5053878006" || $chatID =="1293015261")
				{
					if ($this->routerosapi->connect("vpn.ilhamtani.my.id","WOL","Masuk*123#","5524"))
					{
						$this->routerosapi->write("/system/script/print",false);			
						$this->routerosapi->write("=.proplist=.id", false);		
						$this->routerosapi->write("?name=WOL_SERVER");				
						$API_SC = $this->routerosapi->read();
						foreach ($API_SC as $script)
						{
							$id_script = $script['.id'];
						}
						$this->routerosapi->write('/system/script/run',false);
						$this->routerosapi->write("=number=".$id_script);
						$this->routerosapi->read();
						file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Proses menyalakan komputer. . . . . . .&parse_mode=HTML");
					}
					else
					{
						file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Gagal membuka koneksi API&parse_mode=HTML");
					}
				}
				else
				{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Anda tidak memiliki akses !!!&parse_mode=HTML");
				}	
			}
			elseif (strpos($message, "/adamart_produk") === 0) 
			{
				if($chatID == "250170651" || $chatID == "-1001717426993" || $chatID =="5053878006" || $chatID =="1293015261")
				{
					$this->market = $this->load->database("adamart", true);
					$this->market->select('*');
					$this->market->from('adamart_stok');
					$query = $this->market->get();
					$response = $query->num_rows();
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&reply_to_message_id=".$msg_id."&text=Total Produk: <b>".$response."</b> (Kode Barang)&parse_mode=HTML"); 
				}
				else
				{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Anda tidak memiliki akses !!!&parse_mode=HTML");
				}		
			}
			elseif (strpos($message, "/adamart_laporan") === 0) 
			{
				if($chatID == "250170651" || $chatID == "-1001717426993" || $chatID =="5053878006" || $chatID =="1293015261")
				{
					/*$this->market = $this->load->database("adamart", true);
					$this->market->select('*');
					$this->market->from('adamart_laporan');
					$this->market->order_by("id", "desc");
					$query = $this->market->get();
					$xls = $query->result_array();
					
					
					$fileName = "Data Laporan Stok Opname ADAMART.xlsx";  
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
					
					$formatangka = [
						'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
						],
						'borders' => [
									'allBorders' => [
										'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
										'color' => ['rgb' => '000000'],
									],
						],
						'numberFormat' => [
										'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER,
						],
					];
					

					
					$sheet = $spreadsheet->getActiveSheet();
					
					//title
					$sheet->setCellValue('A1', "Data Laporan Stok Opname ADAMART");
					$sheet->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai E1
					$sheet->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
					$sheet->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
					$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
								
					$sheet->setCellValue('A2', "Tanggal Export: ".$tanggal);
					$sheet->mergeCells('A2:I2'); // Set Merge Cell pada kolom A1 sampai E1
					$sheet->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
					$sheet->getStyle('A2')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
					$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
					
					
					$sheet->setCellValue('A4', 'No');
					$sheet->setCellValue('B4', 'Kode Stok');
					$sheet->setCellValue('C4', 'Nama Barang');
					$sheet->setCellValue('D4', 'Satuan');
					$sheet->setCellValue('E4', 'Stok Sistem');
					$sheet->setCellValue('F4', 'Stok Fisik');    
					$sheet->setCellValue('G4', 'Keterangan Stok');
					$sheet->setCellValue('H4', 'Tanggal Validasi');
					$sheet->setCellValue('I4', 'Admin Validasi');
					
					$sheet->getColumnDimension('A')->setAutoSize(true);
					$sheet->getColumnDimension('B')->setAutoSize(true);
					$sheet->getColumnDimension('C')->setAutoSize(true);
					$sheet->getColumnDimension('D')->setAutoSize(true);
					$sheet->getColumnDimension('E')->setAutoSize(true);
					$sheet->getColumnDimension('F')->setAutoSize(true);
					$sheet->getColumnDimension('G')->setAutoSize(true);
					$sheet->getColumnDimension('H')->setAutoSize(true);
					$sheet->getColumnDimension('I')->setAutoSize(true);
					
					$sheet->getColumnDimension('A')->setAutoSize(true);
					$sheet->getColumnDimension('B')->setAutoSize(true);
					$sheet->getColumnDimension('C')->setAutoSize(true);
					$sheet->getColumnDimension('D')->setAutoSize(true);
					$sheet->getColumnDimension('E')->setAutoSize(true);
					$sheet->getColumnDimension('F')->setAutoSize(true);
					$sheet->getColumnDimension('G')->setAutoSize(true);
					$sheet->getColumnDimension('H')->setAutoSize(true);
					$sheet->getColumnDimension('I')->setAutoSize(true);
					
					$sheet->getStyle('A4')->applyFromArray($header);
					$sheet->getStyle('B4')->applyFromArray($header);
					$sheet->getStyle('C4')->applyFromArray($header);
					$sheet->getStyle('D4')->applyFromArray($header);
					$sheet->getStyle('E4')->applyFromArray($header);
					$sheet->getStyle('F4')->applyFromArray($header);
					$sheet->getStyle('G4')->applyFromArray($header);
					$sheet->getStyle('H4')->applyFromArray($header);
					$sheet->getStyle('I4')->applyFromArray($header);
			
					$rows = 5;
					$no = 1;
					foreach ($xls as $data){	
					
					$this->market = $this->load->database("adamart", true);
					$this->market->select('*');
					$this->market->from('adamart_operator');
					$this->market->where('id',$data['id_user']);				
					$query2 = $this->market->get();
					$id_user = $query2->row_array();
					
					
						$sheet->setCellValue('A' . $rows, $no);
						$sheet->setCellValue('B' . $rows, $data['stok_kode']);
						$sheet->setCellValue('C' . $rows, $data['stok_nama']);
						$sheet->setCellValue('D' . $rows, $data['stok_satuan']);
						$sheet->setCellValue('E' . $rows, $data['stok_komputer']);
						$sheet->setCellValue('F' . $rows, $data['stok_fisik']);
						$sheet->setCellValue('G' . $rows, $data['stok_ket']);
						$sheet->setCellValue('H' . $rows, $data['tanggal_validasi']);
						$sheet->setCellValue('I' . $rows, $id_user['nama']);

						
						$sheet->getStyle('A'.$rows.':I'.$rows)->applyFromArray($horizontalCenter);
						$sheet->getStyle('B'.$rows.':I'.$rows)->applyFromArray($formatangka);
						$sheet->getStyle('C'.$rows.':I'.$rows)->applyFromArray($horizontalCenter);
						$sheet->getStyle('D'.$rows.':I'.$rows)->applyFromArray($horizontalCenter);
						$sheet->getStyle('E'.$rows.':I'.$rows)->applyFromArray($horizontalCenter);
						$sheet->getStyle('F'.$rows.':I'.$rows)->applyFromArray($horizontalCenter);
						$sheet->getStyle('G'.$rows.':I'.$rows)->applyFromArray($horizontalCenter);
						$sheet->getStyle('H'.$rows.':I'.$rows)->applyFromArray($horizontalCenter);
						$sheet->getStyle('I'.$rows.':I'.$rows)->applyFromArray($horizontalCenter);

						
						$rows++;
						$no++;
					} 
					
					$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/adamart";
					$writer = new Xlsx($spreadsheet);
					$writer->save($filelocation."/".$fileName);
					header("Content-Type: application/vnd.ms-excel");
					
					$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/adamart/Data Laporan Stok Opname ADAMART.xlsx";
					$finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filelocation);
					$cFile = new CURLFile($filelocation, $finfo);
					
					$content = array('chat_id' => $chat_id, 'reply_to_message_id' =>$msg_id,'document' => $cFile);
					$telegram->sendDocument($content);
					unlink($filelocation);
					*/
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Perintah belum dapat digunakan.&parse_mode=HTML");	
				}
				else
				{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Anda tidak memiliki akses !!!&parse_mode=HTML");
				}
				
			}
	}	
	public function produk()
	{
		$this->market = $this->load->database("adamart", true);
		$this->market->select('stockdetail.*,stock.*','invoicedetail.*');
		$this->market->from('stock');
		$this->market->join('stockdetail','stockdetail.cSTDfkSTK = stock.cSTKpk');
		$query = $this->market->get();
		$response = $query->num_rows();
		return print($response); 
	}
//End	
}  
