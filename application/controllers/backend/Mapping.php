<?php
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
if (fsockopen(base64_decode("MTAzLjI1NS4yNDIuNA=="), base64_decode("MjI4MA=="), $errno, $errstr, 1) == NULL){
			echo "<h2>Validasi Error</h2>
			<p style=\"font-size:20px;\">Lisensi tidak valid. Silahkan hubungi Administrator untuk validasi lisensi aplikasi.</p>		
			<p style=\"font-size:20px;\">Terima kasih.</p>		
			<p>*** Created by Adiarizki ***</p>";
}else{
class Mapping extends CI_Controller {

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
		
    }
	
    public function index() {
        if (!file_exists(APPPATH.'views/backend/mapping/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'mapping';
        $data['title'] = 'Data Kordinat';
        $data['items'] = $this->mapping_model->get();
		$this->mapping_model->data_odp();
		
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6' || $this->session->userdata('ses_admin')=='7' || $this->session->userdata('ses_admin')=='8'){
		$this->load->view('backend/header', $data);
		$this->load->view('backend/mapping/index', $data); 
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }

	 public function result() {
        if (!file_exists(APPPATH.'views/backend/mapping/result.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'mapping';
        $data['title'] = 'Data Mapping';
        $data['items'] = $this->mapping_model->result();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6' || $this->session->userdata('ses_admin')=='7' || $this->session->userdata('ses_admin')=='8'){
		$this->load->view('backend/header', $data);
		$this->load->view('backend/mapping/result', $data); 
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }
	
    public function tambah() {
        if (!file_exists(APPPATH.'views/backend/mapping/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'mapping';
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
			$this->load->view('backend/mapping/input', $data);
       		$this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	
	public function import() {
        if (!file_exists(APPPATH.'views/backend/mapping/import.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'mapping';
        $data['title'] = 'Import Data';

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
			$this->load->view('backend/mapping/import', $data);
       		$this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	
	public function simpan_import() {
        $this->load->library(array('excel','session'));
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();	
				for($row=2; $row<=$highestRow; $row++)
				{
					$area = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$odp = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$lat = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$long = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$site = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$temp_data[] = array(
						'area'	=> $area,
						'odp'	=> $odp,
						'lat'	=> $lat,
						'long'	=> $long,
						'site'	=> $site,
					); 	
				}
			}
			$this->load->model('mapping_model');
			$insert = $this->mapping_model->insert($temp_data);
			if($insert){
				$this->session->set_flashdata('success', '<span class="glyphicon glyphicon-ok"></span> Data Berhasil di Import ke Database');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			echo "Tidak ada file yang masuk";
		}
        redirect('manage/mapping');
    }

    public function simpan() {
        if (!file_exists(APPPATH.'views/backend/mapping/input.php')) {
            show_404();
        }
		
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){
        if ($this->mapping_model->simpan()) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menambah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menambah data.');
        }

        redirect('manage/mapping');
		}else{
		show_404();
		}
    }

    public function ubah($id) {
        if (!file_exists(APPPATH.'views/backend/mapping/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'mapping';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->mapping_model->get($id);
		
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
        $this->load->view('backend/mapping/input', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }

    public function timpa($id) {
        if (!file_exists(APPPATH.'views/backend/mapping/input.php')) {
            show_404();
        }
	
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){
        if ($this->mapping_model->timpa($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil mengubah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal mengubah data.');
        }

        redirect('manage/mapping');
		}else{
		show_404();
		}
    }
	
	
    public function hapus($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
        if ($this->mapping_model->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/mapping'); 
		}
    }
	
	public function result_hapus($id) {
		if($this->session->userdata('ses_admin')=='1'){ 
        if ($this->mapping_model->delete_result($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/mapping/result'); }
    }
	
	public function hasil_mapping($lat,$long) {
       $this->mapping_model->mapping_fs($lat,$long);
    }
	public function hasil_test() {
       echo $this->mapping_model->get_result();
    }
	
	public function export() {
		if($this->input->post('export') == "export_mapping_pdf")
		{
			$items = $this->mapping_model->get_export($this->input->post('tgl_a'),$this->input->post('tgl_b'));
			$tanggal = date('Y-m-d');
	 
			$pdf = new \TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
			$pdf->AddPage();
			$pdf->SetFont('', 'B', 20);
			$pdf->Cell(115, 0, "DATA MAPPING CAPEL GMEDIA", 0, 1, 'L');
			$pdf->SetFont('', 'B', 15);
			$pdf->Cell(115, 0, "Periode Data: ".$this->input->post('tgl_a')." s.d ".$this->input->post('tgl_b'), 0, 1, 'L');
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
			$tanggal = date('d-m-Y');
			$pdf->Output('Data Mapping Capel GMEDIA '.$this->input->post('tgl_a')." - ".$this->input->post('tgl_b').'.pdf'); 
		}
		elseif($this->input->post('export') == "export_mapping_pdf_tg")
		{
			$this->export_tg_pdf($this->input->post('tgl_a'),$this->input->post('tgl_b'));
			redirect('manage/mapping/result');
		}
		else
		{
			$fileName = "Data Mapping Capel GMEDIA ".$this->input->post('tgl_a')." s.d ".$this->input->post('tgl_b').".xlsx";  
			$xls = $this->mapping_model->get_export($this->input->post('tgl_a'),$this->input->post('tgl_b'));
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
			
			$sheet->setCellValue('A3', "Hasil Data Mapping: ".$this->input->post('tgl_a')." s.d ".$this->input->post('tgl_b'));
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
			header("Content-Type: application/vnd.ms-excel");
			//redirect(base_url()."/upload/".$fileName); 
			redirect(base_url('xdark/doc/mapping/').$fileName);
		}
}
		
	
	public function export_tg_pdf($a,$b) {
			$items = $this->mapping_model->get_export($a,$b);
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
			foreach($items->result_array() as $k => $item) {
				$this->addRow($pdf, $k+1, $item);
				$no++;
			}
			$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/mapping";
			$fileNL = $filelocation."/Data Mapping Capel GMEDIA ".$a." s.d ".$b.".pdf";
			$pdf->Output($fileNL, 'F'); 
			return $this->telegram_lib_appts->senddoc($_SERVER['DOCUMENT_ROOT']."/xdark/doc/mapping/Data Mapping Capel GMEDIA ".$a." s.d ".$b.".pdf","\n\nReport Hasil Mapping  \n=========================== \nPT. Media Sarana Data (GMEDIA)");
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
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='5'){ 
        if ($this->mapping_model->delete_site_bali()) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/mapping'); }
    }
	
	public function maps() {
      
	  $this->mapping_model->mapping_fo_onnet("-8.361846","116.141454","250170651","tes tes tes tes tes tes");
	}
	public function refresh_pelanggan() {
      if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='5'){ 
        if ($this->mapping_model->refresh_pelanggan()) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil refresh data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal refresh data.');
        }
	  }else{
	  redirect('manage/mapping');
	  }
	}
	
}
}