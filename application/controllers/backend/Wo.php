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
class Wo extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->config('api_bot', true);

        //if (!$this->session->userdata('masuk')) {
        //   redirect('/login', 'refresh');
        //}
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
		$this->load->model('m_kpi_induk');
		$this->load->model('m_media');
		$this->load->model('m_sales');
		$this->load->model('m_level');
		$this->load->model('m_produk');
		$this->load->model('m_layanan');
		$this->load->model('m_data_pelanggan');
    }

    public function index() {
        if (!file_exists(APPPATH.'views/backend/wo/index.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6' || $this->session->userdata('ses_admin')=='7' || $this->session->userdata('ses_admin')=='8'){
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		
        $data['menu']  = 'wo';
        $data['title'] = 'Data WO';
        $data['items'] = $this->m_wo->get();
       
		$this->load->view('backend/header', $data);
		$this->load->view('backend/wo/index', $data); 
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }
	public function detail($id) {
        if (!file_exists(APPPATH.'views/backend/wo/detail.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6' || $this->session->userdata('ses_admin')=='7' || $this->session->userdata('ses_admin')=='8'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_pelanggan'] = $this->m_data_pelanggan->get();
		$data['items_kpi'] = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
        $data['menu']  = 'wo';
        $data['title'] = 'Data WO';
        $data['item']  = $this->m_wo->get($id);
		$data['item_pelanggan']  = $this->m_data_pelanggan->get($id);

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
		$this->load->view('backend/wo/detail', $data); 
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }
	
	function get_pelanggan($cid){
        $cid=$this->input->post('cid');
        $data=$this->m_wo->get_pelanggan($cid);
        echo json_encode($data);
    }


    public function tambah() {
        if (!file_exists(APPPATH.'views/backend/wo/input.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['items_pelanggan'] = $this->m_data_pelanggan->get();
		$data['items_survey'] = $this->m_wo->get();
		$data['items_kpi'] = $this->m_kpi->get();
		$data['items_kpi_induk'] = $this->m_kpi_induk->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
		
        $data['menu']  = 'wo';
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
        $this->load->view('backend/wo/input', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }

    public function simpan() {
        if (!file_exists(APPPATH.'views/backend/wo/input.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
		$this->m_wo->simpan();
		redirect('manage/wo', 'refresh');
		}else{
		show_404();
		}
    }

    public function ubah($id) {
        if (!file_exists(APPPATH.'views/backend/wo/input.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_kpi']  = $this->m_kpi->get();
		$data['items_kpi_induk'] = $this->m_kpi_induk->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
        $data['menu']  = 'wo';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->m_wo->get($id);

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
        $this->load->view('backend/wo/input', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	
	public function existing($id) {
        if (!file_exists(APPPATH.'views/backend/wo/input_existing.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_pelanggan'] = $this->m_data_pelanggan->get();
		$data['items_kpi'] = $this->m_kpi->get();
		$data['items_kpi_induk'] = $this->m_kpi_induk->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
        $data['menu']  = 'wo';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->m_data_pelanggan->get($id);
		$data['item_pelanggan']  = $this->m_data_pelanggan->get($id);
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
        $this->load->view('backend/wo/input_existing', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	public function survey($id) {
        if (!file_exists(APPPATH.'views/backend/wo/input_existing.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_pelanggan'] = $this->m_data_pelanggan->get();
		$data['items_kpi'] = $this->m_kpi->get();
		$data['items_kpi_induk'] = $this->m_kpi_induk->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
        $data['menu']  = 'wo';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->m_wo->get($id);
		$data['item_pelanggan']  = $this->m_data_pelanggan->get();

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
        $this->load->view('backend/wo/input_survey', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }

    public function timpa($id) {
        if (!file_exists(APPPATH.'views/backend/wo/input.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='4'){

        $this->m_wo->timpa($id);
		redirect('manage/wo');
		}else{
		show_404();
		}
    }
	
	
    public function hapus($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
        if ($this->m_wo->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/wo');
		}else{
		show_404();
		}
    }
	public function batalkan($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
        if ($this->m_wo->batalkan($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil membatalkan WO.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal membatalkan WO.');
        }

        redirect('manage/wo');
		}else{
		show_404();
		}
    }
	public function selesaikan($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
        if ($this->m_wo->selesaikan($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil Selesaikan WO.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal Selesaikan WO.');
        }

        redirect('manage/wo');
		}else{
		show_404();
		}
    }
	
	public function wo_reminder() {
		$this->load->database();
		$wo_wa = $this->m_wo->get_wo_proses_wa();
		$wo_tg = $this->m_wo->get_wo_proses_tg();
		/*
		$data = [
			'api_key' => $this->config->item('api_key', 'api_bot'),
			'sender'  => $this->config->item('sender', 'api_bot'),
			'number'  => $this->config->item('number', 'api_bot'),
			'message' => $wo,
		];
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://wapi.apigratis.my.id/app/api/send-message",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($data))
		);
		
		$response = curl_exec($curl);
		
		curl_close($curl);
		*/
		
		/*$headers = array(
				'Content-Type:application/json'
		);
		$fields = [
				'id'  => $this->config->item('number', 'api_bot'),
				'message' => $wo_wa,
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
		*/
		$this->telegram_lib->sendblip("-901753609",$wo_tg);
		
		if ($response) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Push notifikasi berhasil.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Push notifikasi GAGAL.');
        }
		redirect('manage/wo');
    }
	
	public function export() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
		date_default_timezone_set("Asia/Singapore");
		$fileName = "Data All WO -".date("Y-m-d H:i:s")."-by-".$this->session->userdata('ses_nama').".xlsx";  
		$xls = $this->m_wo->get_export();
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
		$sheet->setCellValue('A1', "Data All Work Order");
		$sheet->mergeCells('A1:K1'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
					
		$sheet->setCellValue('A2', "Tanggal Export: ".$tanggal);
		$sheet->mergeCells('A2:K2'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A2')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		
		$sheet->setCellValue('A3', "Export by: ".$user_exe);
		$sheet->mergeCells('A3:K3'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A3')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		
		
		$sheet->setCellValue('A6', 'No');
		$sheet->setCellValue('B6', 'Cabang');
		$sheet->setCellValue('C6', 'Brand');
		$sheet->setCellValue('D6', 'CID');
		$sheet->setCellValue('E6', 'SID');
		$sheet->setCellValue('F6', 'Nama Pelanggan');
		$sheet->setCellValue('G6', 'Area');    
		$sheet->setCellValue('H6', 'Divisi Sales');
		$sheet->setCellValue('I6', 'Sales');
		$sheet->setCellValue('J6', 'Segment');
		$sheet->setCellValue('K6', 'Sub Segment');		
		$sheet->setCellValue('L6', 'Alamat');   
		$sheet->setCellValue('M6', 'Kordinat');
		$sheet->setCellValue('N6', 'Email');
		$sheet->setCellValue('O6', 'Kontak PIC');
		$sheet->setCellValue('P6', 'PIC');
		$sheet->setCellValue('Q6', 'Lastmile');
		$sheet->setCellValue('R6', 'Produk');
		$sheet->setCellValue('S6', 'Bandwidth');
		$sheet->setCellValue('T6', 'Aplikasi');
		$sheet->setCellValue('U6', 'Service');
		$sheet->setCellValue('V6', 'Klasifikasi Pelanggan');
		$sheet->setCellValue('W6', 'Tanggal Req Sales');
		$sheet->setCellValue('X6', 'Tanggal Req Teknis');
		$sheet->setCellValue('Y6', 'Tanggal Pekerjaan Teknis');
		$sheet->setCellValue('Z6', 'Tanggal Report Teknis');
		$sheet->setCellValue('AA6', 'Tanggal Terbit BAA');
		$sheet->setCellValue('AB6', 'Tanggal Req OB');
		$sheet->setCellValue('AC6', 'Tanggal OB');
		$sheet->setCellValue('AD6', 'Tanggal Terbit Invoice');
		$sheet->setCellValue('AE6', 'Biaya OTC');
		$sheet->setCellValue('AF6', 'Biaya Langganan');
		$sheet->setCellValue('AG6', 'Biaya Partner');
		$sheet->setCellValue('AH6', 'Biaya CB');
		$sheet->setCellValue('AI6', 'Net Profit');
		$sheet->setCellValue('AJ6', 'Status Pelanggan');
		$sheet->setCellValue('AK6', 'Keterangan');
		
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
		$sheet->getColumnDimension('N')->setAutoSize(true);
		$sheet->getColumnDimension('O')->setAutoSize(true);
		$sheet->getColumnDimension('P')->setAutoSize(true);
		$sheet->getColumnDimension('Q')->setAutoSize(true);
		$sheet->getColumnDimension('R')->setAutoSize(true);
		$sheet->getColumnDimension('S')->setAutoSize(true);
		$sheet->getColumnDimension('T')->setAutoSize(true);
		$sheet->getColumnDimension('U')->setAutoSize(true);
		$sheet->getColumnDimension('V')->setAutoSize(true);
		$sheet->getColumnDimension('W')->setAutoSize(true);
		$sheet->getColumnDimension('X')->setAutoSize(true);
		$sheet->getColumnDimension('Y')->setAutoSize(true);
		$sheet->getColumnDimension('Z')->setAutoSize(true);
		$sheet->getColumnDimension('AA')->setAutoSize(true);
		$sheet->getColumnDimension('AB')->setAutoSize(true);
		$sheet->getColumnDimension('AC')->setAutoSize(true);
		$sheet->getColumnDimension('AD')->setAutoSize(true);
		$sheet->getColumnDimension('AE')->setAutoSize(true);
		$sheet->getColumnDimension('AF')->setAutoSize(true);
		$sheet->getColumnDimension('AG')->setAutoSize(true);
		$sheet->getColumnDimension('AH')->setAutoSize(true);
		$sheet->getColumnDimension('AI')->setAutoSize(true);
		$sheet->getColumnDimension('AJ')->setAutoSize(true);
		$sheet->getColumnDimension('AK')->setAutoSize(true);
		
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
		$sheet->getStyle('N6')->applyFromArray($header);
		$sheet->getStyle('O6')->applyFromArray($header);
		$sheet->getStyle('P6')->applyFromArray($header);
		$sheet->getStyle('Q6')->applyFromArray($header);
		$sheet->getStyle('R6')->applyFromArray($header);
		$sheet->getStyle('S6')->applyFromArray($header);
		$sheet->getStyle('T6')->applyFromArray($header);
		$sheet->getStyle('U6')->applyFromArray($header);
		$sheet->getStyle('V6')->applyFromArray($header);
		$sheet->getStyle('W6')->applyFromArray($header);
		$sheet->getStyle('X6')->applyFromArray($header);
		$sheet->getStyle('Y6')->applyFromArray($header);
		$sheet->getStyle('Z6')->applyFromArray($header);
		$sheet->getStyle('AA6')->applyFromArray($header);
		$sheet->getStyle('AB6')->applyFromArray($header);
		$sheet->getStyle('AC6')->applyFromArray($header);
		$sheet->getStyle('AD6')->applyFromArray($header);
		$sheet->getStyle('AE6')->applyFromArray($header);
		$sheet->getStyle('AF6')->applyFromArray($header);
		$sheet->getStyle('AG6')->applyFromArray($header);
		$sheet->getStyle('AH6')->applyFromArray($header);
		$sheet->getStyle('AI6')->applyFromArray($header);
		$sheet->getStyle('AJ6')->applyFromArray($header);
		$sheet->getStyle('AK6')->applyFromArray($header);

		$rows = 7;
		$no = 1;
		foreach ($xls as $data){
		$this->load->database();
		
		
		if($data['status_pelanggan'] == "0"){$status_pelanggan = "Tidak Aktif";}elseif($data['status_pelanggan'] == "1"){$status_pelanggan = "Aktif";}elseif($data['status_pelanggan'] == "2"){$status_pelanggan = "Isolir";}else{$status_pelanggan = "Dismantle";}
		if($data['admin_biaya_netprofit'] == 0){
		$klasifikasi_pelanggan = "-";
		}elseif($data['admin_biaya_netprofit'] < 2000000){
		$klasifikasi_pelanggan = "REGULER";
		}elseif($data['admin_biaya_netprofit'] <= 5000000){
		$klasifikasi_pelanggan = "GOLD";
		}elseif($data['admin_biaya_netprofit'] < 10000000){
		$klasifikasi_pelanggan = "PLATINUM";
		}else{
		$klasifikasi_pelanggan = "PRIORITAS";
		}
		
		
		
		$admin_sales = $this->db->get_where('blip_sales', array('id' => $data['admin_sales']))->row_array();
		$media = $this->db->get_where('blip_mediaaccess', array('id' => $data['media']))->row_array();
		$produk = $this->db->get_where('blip_produk', array('id' => $data['produk']))->row_array();
		
		$sheet->setCellValue('A' . $rows, $no);
		$sheet->setCellValue('B' . $rows, $data['region']);
		$sheet->setCellValue('C' . $rows, $data['brand']);
		$sheet->setCellValue('D' . $rows, $data['cid']);
		$sheet->setCellValue('E' . $rows, $data['sid']);
		$sheet->setCellValue('F' . $rows, $data['nama']);
		$sheet->setCellValue('G' . $rows, $data['area']);
		$sheet->setCellValue('H' . $rows, $data['admin_divisi']);
		$sheet->setCellValue('I' . $rows, $admin_sales['nama']);
		$sheet->setCellValue('J' . $rows, $data['admin_segment']);
		$sheet->setCellValue('K' . $rows, $data['admin_subsegment']);
		$sheet->setCellValue('L' . $rows, $data['admin_alamat']);
		$sheet->setCellValue('M' . $rows, $data['kordinat']);
		$sheet->setCellValue('N' . $rows, $data['email']);
		$sheet->setCellValue('O' . $rows, $data['kontak']);
		$sheet->setCellValue('P' . $rows, $data['pic']);
		$sheet->setCellValue('Q' . $rows, $media['media']);
		$sheet->setCellValue('R' . $rows, $produk['produk']);
		$sheet->setCellValue('S' . $rows, $data['bandwidth']);
		
		$sheet->setCellValue('T' . $rows, "-");
		$sheet->setCellValue('U' . $rows, "-");
		$sheet->setCellValue('V' . $rows, $klasifikasi_pelanggan);

		$sheet->setCellValue('W' . $rows, $data['tgl_req_sales']);
		$sheet->setCellValue('X' . $rows, $data['tgl_req_teknis']);
		$sheet->setCellValue('Y' . $rows, $data['tgl_aktivasi_teknis']);
		$sheet->setCellValue('Z' . $rows, $data['tgl_report_teknis']);
		$sheet->setCellValue('AA' . $rows, $data['tgl_terbit_baa']);
		$sheet->setCellValue('AB' . $rows, $data['tgl_req_ob']);
		$sheet->setCellValue('AC' . $rows, $data['tgl_start_ob']);
		$sheet->setCellValue('AD' . $rows, $data['tgl_terbit_inv']);
		$sheet->setCellValue('AE' . $rows, $data['admin_biaya_otc']);
		$sheet->setCellValue('AF' . $rows, $data['admin_biaya_mtc']);

		$sheet->setCellValue('AG' . $rows, $data['admin_biaya_partner']);
		$sheet->setCellValue('AH' . $rows, $data['admin_biaya_cb']);
		$sheet->setCellValue('AI' . $rows, $data['admin_biaya_netprofit']);
		$sheet->setCellValue('AJ' . $rows, $status_pelanggan);
		$sheet->setCellValue('AK' . $rows, $data['keterangan']);
			
			$sheet->getStyle('A'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('B'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('C'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('D'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('E'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('F'.$rows.':AK'.$rows)->applyFromArray($horizontalLeft);
			$sheet->getStyle('G'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('H'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('I'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('J'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('K'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('L'.$rows.':AK'.$rows)->applyFromArray($horizontalLeft);
			$sheet->getStyle('M'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('N'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('O'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('P'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('Q'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('R'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('S'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('T'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('U'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('V'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('W'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('X'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('Y'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('Z'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AA'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AB'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AC'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AD'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AE'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AF'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AG'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AH'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AI'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AJ'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AK'.$rows.':AK'.$rows)->applyFromArray($horizontalCenter);
			
			$rows++;
			$no++;
		} 
		
		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/wo_reguler";
		$writer = new Xlsx($spreadsheet);
		$writer->save($filelocation."/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/upload/".$fileName); 
		redirect(base_url('xdark/doc/wo_reguler/').$fileName);
		
		}else{
		show_404();
		}
	}

}
}