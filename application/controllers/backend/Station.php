<?php
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Station extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }

		$this->load->library('TCPDF');
		$this->load->library('user_agent');
		
		$this->load->model('bts_model');
        $this->load->model('operator_model');
		$this->load->model('station_model');
		$this->load->model('lokalan_model');	
		$this->load->model('router_model');
		$this->load->model('scheduler_model');
		$this->load->model('mikrotik_model');
		$this->load->model('lokalan_model');
		$this->load->model('mapping_model');
		$this->load->model('fiberstream_model');
		$this->load->model('maintenance_model');
		$this->load->model('telegram_model');
		$this->load->model('m_baddebt');
		$this->load->model('m_wo');
		$this->load->model('m_kpi');
		$this->load->model('m_media');
		$this->load->model('m_sales');
		$this->load->model('m_level');
		$this->load->model('m_produk');
		$this->load->model('m_layanan');
		$this->load->model('m_data_pelanggan');
		$this->load->model('m_station');
    }
	
     public function index() {
        if (!file_exists(APPPATH.'views/backend/station/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();

        $data['menu']  = 'bts';
        $data['title'] = 'Data BTS';
        $data['items'] = $this->station_model->get();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6')
		{ 

			$this->load->view('backend/header', $data);
			if($this->agent->is_mobile()){
			$this->load->view('backend/station/index_mobile', $data); 
			}else{
			$this->load->view('backend/station/index', $data); 
			}
			$this->load->view('backend/footer');
		}
		else 
		{
		show_404(); 
		} 
        
    }

	public function tambah() {
        if (!file_exists(APPPATH.'views/backend/station/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();

        $data['menu']  = 'station';
        $data['title'] = 'Tambah Data';

        $footer['scripts'] = "
            $('#konten').summernote({
                height: 300,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['undo', 'redo']],
                    ['insert', ['link']]
                ]
            });
        ";
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
		$this->load->view('backend/header', $data);
        $this->load->view('backend/station/input', $data);
        $this->load->view('backend/footer', $footer);
		}
		else{
		show_404();
		}
    }

    public function simpan() {
        if (!file_exists(APPPATH.'views/backend/station/input.php')) {
            show_404();
        }
		
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
        if ($this->m_station->simpan()) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menambah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menambah data.');
        }
		redirect('manage/station');
		}else{
		show_404();
		}
        
    }
	public function reloadall() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){  
		$this->m_station->reloadall();

        redirect('manage/station/');
		}else{
		show_404();
		}
    }
	public function refresh($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){  
		$this->m_station->refresh($id);

        redirect('manage/station/');
		}else{
		show_404();
		}
    }

	public function station() {
			if (!file_exists(APPPATH.'views/backend/station/index.php')) {
            show_404();
        }

        $data['menu']  = 'station';
        $data['title'] = 'Station Pelanggan';
        $data['items'] = $this->station_model->get();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='5')
		{ 
			if($this->agent->is_mobile()) 
			{ 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/station/station', $data); 
			} 
			else 
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/station/station', $data); 
			} 
		
		}
		
        $this->load->view('backend/footer');

    }

 public function hapus($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
        if ($this->m_station->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/station'); }
    }
	
	public function backup($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
        $this->m_station->backup($id);
        redirect('manage/station'); 
		}
    }
	
	private function addRow($pdf, $no, $item) {
		
		$pdf->Cell(15, 8, $no, 1, 0, 'C');
		$pdf->Cell(70, 8, $item['identity'], 1, 0, 'C');
        $pdf->Cell(55, 8, $item['mac_eth'], 1, 0, 'C');
        $pdf->Cell(55, 8, $item['model'], 1, 0, 'C');
        $pdf->Cell(55, 8, $item['serial_number'], 1, 0, 'C');
        $pdf->Cell(55, 8, $item['version'], 1, 0, 'C');
		$pdf->Cell(55, 8, $item['ipaddr'], 1, 0, 'C');
		$pdf->Cell(20, 8, $item['port'], 1, 0, 'C');
		$pdf->Cell(27, 8, $item['jarak'], 1, 0, 'C');
		$pdf->Cell(27, 8, $item['sinyal'], 1, 0, 'C');
		$pdf->Cell(27, 8, $item['ccq'], 1, 0, 'C');
		$pdf->Cell(55, 8, $item['kualitas'], 1, 0, 'C');
		$pdf->Cell(55, 8, $item['waktu'], 1, 1, 'C');
    }
	
	public function export_pdf() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){
        $items = $this->m_station->getDATA($this->input->post('kualitas'));
        $tanggal = date('d-m-Y');
 
        $pdf = new TCPDF('L', 'mm', array(350,600), true, 'UTF-8', false);
        $pdf->AddPage('L', array(350,600));
        $pdf->SetFont('', 'B', 20);
        $pdf->Cell(350, 0, "Reporting Pengecekan Kualitas Signal Wireless Station - ".$tanggal, 0, 1, 'L');
        $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
        $pdf->Ln(10);
        $pdf->SetFont('', 'B', 10);
		$pdf->Cell(15, 8, "No", 1, 0, 'C');
		$pdf->Cell(70, 8, "Identity", 1, 0, 'C');
        $pdf->Cell(55, 8, "Mac Eth", 1, 0, 'C');
        $pdf->Cell(55, 8, "Model", 1, 0, 'C');
        $pdf->Cell(55, 8, "SN", 1, 0, 'C');
        $pdf->Cell(55, 8, "Version", 1, 0, 'C');
		$pdf->Cell(55, 8, "IP Addr", 1, 0, 'C');
		$pdf->Cell(20, 8, "Port", 1, 0, 'C');
		$pdf->Cell(27, 8, "Jarak", 1, 0, 'C');
		$pdf->Cell(27, 8, "Signal", 1, 0, 'C');
		$pdf->Cell(27, 8, "CCQ (%)", 1, 0, 'C');
		$pdf->Cell(55, 8, "Kualitas", 1, 0, 'C');
		$pdf->Cell(55, 8, "Waktu", 1, 1, 'C');

		
        $pdf->SetFont('', '', 10);
		$no = 1;
        foreach($items->result_array() as $k => $item) {
            $this->addRow($pdf, $k+1, $item);
			$no++;
        }
		
		$pdf->SetAutoPageBreak(true, 0);
		$pdf->Cell(350, 0, "", 0, 1, 'L');
		$pdf->Cell(350, 0, "", 0, 1, 'L');
		$pdf->Cell(350, 0, "Regards,", 0, 1, 'L');
		$pdf->Cell(350, 0, "NOC Area NTB", 0, 1, 'L');

		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/station";
		$fileNL = $filelocation."/Reporting Pengecekan Kualitas Signal Wireless Station - ".$tanggal.".pdf";
        $pdf->Output($fileNL, 'F'); 

		
		$fileName  = "Reporting Pengecekan Kualitas Signal Wireless Station - ".$tanggal.".pdf";
		redirect(base_url('xdark/doc/station/').$fileName);
		}
    }
	
	public function export_xls() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){
		date_default_timezone_set("Asia/Singapore");
		$tanggal = date('d-m-Y');
		$fileName = "Reporting Pengecekan Kualitas Signal Wireless Station - ".$tanggal.".xlsx";  
		$xls = $this->m_station->getDATA($this->input->post('kualitas'));
		$user_exe = $this->session->userdata('ses_nama');
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
		//horizontal left
		$horizontalLeft = [
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
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
		$sheet->setCellValue('A1', "Reporting Pengecekan Kualitas Signal Wireless Station - ".$tanggal);
		$sheet->mergeCells('A1:J1'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
					
		$sheet->setCellValue('A2', "Tanggal Export: ".$tanggal);
		$sheet->mergeCells('A2:J2'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A2')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		
		$sheet->setCellValue('A3', "Export by: ".$user_exe);
		$sheet->mergeCells('A3:J3'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A3')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		
		
		$sheet->setCellValue('A6', 'No');
		$sheet->setCellValue('B6', 'Identity');
		$sheet->setCellValue('C6', 'Mac Eth');
		$sheet->setCellValue('D6', 'Model');
		$sheet->setCellValue('E6', 'SN');
		$sheet->setCellValue('F6', 'Version');
		$sheet->setCellValue('G6', 'IP Addr');    
		$sheet->setCellValue('H6', 'Port');
		$sheet->setCellValue('I6', 'Jarak');
		$sheet->setCellValue('J6', 'Signal');
		$sheet->setCellValue('K6', 'CCQ (%)');
		$sheet->setCellValue('L6', 'Kualitas');
		$sheet->setCellValue('M6', 'Waktu');

		
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
		$sheet->getColumnDimension('L')->setAutoSize(true);
		$sheet->getColumnDimension('M')->setAutoSize(true);
		
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
		$sheet->getStyle('L6')->applyFromArray($header);
		$sheet->getStyle('M6')->applyFromArray($header);


		$rows = 7;
		$no = 1;
		foreach ($xls->result_array() as $item){
		
		$sheet->setCellValue('A' . $rows, $no);
		$sheet->setCellValue('B' . $rows, $item['identity']);
		$sheet->setCellValue('C' . $rows, $item['mac_eth']);
		$sheet->setCellValue('D' . $rows, $item['model']);
		$sheet->setCellValue('E' . $rows, $item['serial_number']);
		$sheet->setCellValue('F' . $rows, $item['version']);
		$sheet->setCellValue('G' . $rows, $item['ipaddr']);
		$sheet->setCellValue('H' . $rows, $item['port']);
		$sheet->setCellValue('I' . $rows, $item['jarak']);
		$sheet->setCellValue('J' . $rows, $item['sinyal']);
		$sheet->setCellValue('K' . $rows, $item['ccq']);
		$sheet->setCellValue('L' . $rows, $item['kualitas']);
		$sheet->setCellValue('M' . $rows, $item['waktu']);
				
			
			$sheet->getStyle('A'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('B'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('C'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('D'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('E'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('F'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('G'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('H'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('I'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('J'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('K'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('L'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('M'.$rows.':M'.$rows)->applyFromArray($horizontalCenter);
			
			$rows++;
			$no++;
		} 
		
		$filelocation = $_SERVER['DOCUMENT_ROOT']."xdark/doc/station/";
		$writer = new Xlsx($spreadsheet);
		$writer->save($filelocation."/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/upload/".$fileName); 
		redirect(base_url('xdark/doc/station/').$fileName);
		
		}else{
		show_404();
		}
	}
	
	public function kirim_report() {
        $items = $this->m_station->getDATA("all");
        $tanggal = date('d-m-Y');
 
        $pdf = new TCPDF('L', 'mm', array(600,500), true, 'UTF-8', false);
        $pdf->AddPage('L', array(600,500));
        $pdf->SetFont('', 'B', 20);
        $pdf->Cell(600, 0, "Reporting Pengecekan Kualitas Signal Wireless Station - ".$tanggal, 0, 1, 'L');
        $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
        $pdf->Ln(10);
        $pdf->SetFont('', 'B', 10);
		$pdf->Cell(15, 8, "No", 1, 0, 'C');
		$pdf->Cell(70, 8, "Identity", 1, 0, 'C');
        $pdf->Cell(55, 8, "Mac Eth", 1, 0, 'C');
        $pdf->Cell(55, 8, "Model", 1, 0, 'C');
        $pdf->Cell(55, 8, "SN", 1, 0, 'C');
        $pdf->Cell(55, 8, "Version", 1, 0, 'C');
		$pdf->Cell(55, 8, "IP Addr", 1, 0, 'C');
		$pdf->Cell(20, 8, "Port", 1, 0, 'C');
		$pdf->Cell(27, 8, "Jarak", 1, 0, 'C');
		$pdf->Cell(27, 8, "Signal", 1, 0, 'C');
		$pdf->Cell(27, 8, "CCQ (%)", 1, 0, 'C');
		$pdf->Cell(55, 8, "Kualitas", 1, 0, 'C');
		$pdf->Cell(55, 8, "Waktu", 1, 1, 'C');
		
        $pdf->SetFont('', '', 10);
		$no = 1;
        foreach($items->result_array() as $k => $item) {
            $this->addRow($pdf, $k+1, $item);
			$no++;
        }
		
		$pdf->SetAutoPageBreak(true, 0);
		$pdf->Cell(900, 0, "", 0, 1, 'L');
		$pdf->Cell(900, 0, "", 0, 1, 'L');
		$pdf->Cell(900, 0, "Regards,", 0, 1, 'L');
		$pdf->Cell(900, 0, "NOC Area NTB", 0, 1, 'L');

		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/station/";
		$fileNL = $filelocation."/Reporting Pengecekan Kualitas Signal Wireless Station - ".$tanggal.".pdf";
        $pdf->Output($fileNL, 'F'); 
		
		//Tiket Filter
		$radio_total = $this->db->get('blip_radio_station')->num_rows();
		$signal_bagus = $this->db->get_where('blip_radio_station', array('kualitas' => 'Baik'))->num_rows();
		$signal_optimasi = $this->db->get_where('blip_radio_station', array('kualitas' => 'Diperlukan Optimasi'))->num_rows();
		$signal_buruk = $this->db->get_where('blip_radio_station', array('kualitas' => 'Buruk'))->num_rows();

		$this->telegram_lib->sendblip_doc("-901753609",$_SERVER['DOCUMENT_ROOT']."/xdark/doc/station/Reporting Pengecekan Kualitas Signal Wireless Station - ".$tanggal.".pdf","\n\nTotal Station Radio: <b>[".$radio_total."]</b>\n<b>[".$signal_bagus."]</b> Baik\n<b>[".$signal_optimasi."}</b> Diperlukan Optimasi\n<b>[".$signal_buruk."]</b> Buruk\n\nRegards,\n<b>NOC Area NTB</b>");
		//$this->telegram_lib->sendblip_doc("250170651",$_SERVER['DOCUMENT_ROOT']."/xdark/doc/station/Reporting Pengecekan Kualitas Signal Wireless Station - ".$tanggal.".pdf","\n\nTotal Wireless Station Radio: <b>[".$radio_total."]</b>\n<b>[".$signal_bagus."]</b> Baik\n<b>[".$signal_optimasi."}</b> Diperlukan Optimasi\n<b>[".$signal_buruk."]</b> Buruk\n\nRegards,\n<b>NOC Area NTB</b>");
		
		redirect('manage/station');
    }

}
