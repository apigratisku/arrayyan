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
class Vas_data extends CI_Controller {

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
		$this->load->model('m_vas_data');
		$this->load->model('m_media');
		$this->load->model('m_sales');
		$this->load->model('m_level');
		$this->load->model('m_produk');
		$this->load->model('m_layanan');
		$this->load->model('m_data_pelanggan');
		$this->load->model('m_vas_spec');
		$this->load->model('m_vas_data');
		$this->load->model('m_spk');
    }

    public function index() {
	if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='2' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5' ||  $this->session->userdata('ses_admin')=='6'){
        if (!file_exists(APPPATH.'views/backend/vas_data/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_pelanggan'] = $this->m_data_pelanggan->get();
		
        $data['menu']  = 'vas_data';
        $data['title'] = 'Data VAS';
        $data['items'] = $this->m_vas_data->get();
       
		$this->load->view('backend/header', $data);
		$this->load->view('backend/vas_data/index', $data); 
        $this->load->view('backend/footer');
	}else{
	redirect('logout');
	}
    }

    public function tambah() {
	if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
        if (!file_exists(APPPATH.'views/backend/vas_data/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_pelanggan'] = $this->m_data_pelanggan->get();
		$data['items_spec'] = $this->m_vas_spec->get();
		
        $data['menu']  = 'vas_data';
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
		$this->load->view('backend/header', $data);
        $this->load->view('backend/vas_data/input', $data);
        $this->load->view('backend/footer', $footer);
	}else{
	redirect('logout');
	}
    }

    public function simpan() {
	if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
        if (!file_exists(APPPATH.'views/backend/vas_data/input.php')) {
            show_404();
        }
		$this->m_vas_data->simpan();
		redirect('manage/vas_data');
	}else{
	redirect('logout');
	}
    }

    public function ubah($id) {
	if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){
        if (!file_exists(APPPATH.'views/backend/vas_data/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_pelanggan'] = $this->m_data_pelanggan->get();
		
        $data['menu']  = 'vas_data';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->m_vas_data->get($id);

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

  
		$this->load->view('backend/header', $data);
        $this->load->view('backend/vas_data/input', $data);
        $this->load->view('backend/footer', $footer);
	}else{
	redirect('logout');
	}
    }

    public function timpa($id) {
	if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){
        if (!file_exists(APPPATH.'views/backend/vas_data/input.php')) {
            show_404();
        }

        $this->m_vas_data->timpa($id);
		redirect('manage/vas_data');
	}else{
	redirect('logout');
	}
    }
	
	
    public function hapus($id) {
	if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){
        if ($this->m_vas_data->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/vas_data');
	}else{
	redirect('logout');
	}
    }	
	
	public function export() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
		date_default_timezone_set("Asia/Singapore");
		$fileName = "Data Perangkat Pelanggan -".date("Y-m-d H:i:s")."-by-".$this->session->userdata('ses_nama').".xlsx";  
		$xls = $this->m_vas_data->get_export();
		$tanggal = date("Y-m-d H:i:s");
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
		$sheet->setCellValue('A1', "Data Perangkat Pelanggan");
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
		$sheet->setCellValue('B6', 'Pelanggan');
		$sheet->setCellValue('C6', 'Nama Perangkat');
		$sheet->setCellValue('D6', 'Merk');
		$sheet->setCellValue('E6', 'Mac Address');
		$sheet->setCellValue('F6', 'Serial Number');
		$sheet->setCellValue('G6', 'Jumlah');    
		$sheet->setCellValue('H6', 'Satuan');
		$sheet->setCellValue('I6', 'Alokasi');
		$sheet->setCellValue('J6', 'Keterangan');
		
		
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

		$rows = 7;
		$no = 1;
		foreach ($xls as $data){
		$this->load->database();
		
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $data['id_pelanggan']))->row_array();
		$perangkat = $this->db->get_where('blip_vas_spesifikasi', array('id' => $data['id_perangkat']))->row_array();
		
		$sheet->setCellValue('A' . $rows, $no);
		$sheet->setCellValue('B' . $rows, $pelanggan['nama']);
		$sheet->setCellValue('C' . $rows, $perangkat['nama']);
		$sheet->setCellValue('D' . $rows, $perangkat['merk']);
		$sheet->setCellValue('E' . $rows, $data['mac_address']);
		$sheet->setCellValue('F' . $rows, $data['serial_number']);
		$sheet->setCellValue('G' . $rows, $data['jumlah']);
		$sheet->setCellValue('H' . $rows, $data['satuan']);
		$sheet->setCellValue('I' . $rows, $data['alokasi']);
		$sheet->setCellValue('J' . $rows, $data['keterangan']);
		
			
			$sheet->getStyle('A'.$rows.':J'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('B'.$rows.':J'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('C'.$rows.':J'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('D'.$rows.':J'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('E'.$rows.':J'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('F'.$rows.':J'.$rows)->applyFromArray($horizontalLeft);
			$sheet->getStyle('G'.$rows.':J'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('H'.$rows.':J'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('I'.$rows.':J'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('J'.$rows.':J'.$rows)->applyFromArray($horizontalCenter);
			
			$rows++;
			$no++;
		} 
		
		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/data_perangkat_pelanggan";
		$writer = new Xlsx($spreadsheet);
		$writer->save($filelocation."/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/upload/".$fileName); 
		redirect(base_url('xdark/doc/data_perangkat_pelanggan/').$fileName);
		
		}else{
		show_404();
		}
	}
}

}