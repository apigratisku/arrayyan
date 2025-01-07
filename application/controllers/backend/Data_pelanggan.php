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
class Data_pelanggan extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->library('secure');

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
		$this->load->model('bts_model');
		$this->load->model('m_vas_data');
		$this->load->model('m_vas_spec');
		$this->load->model('m_spk');
		$this->load->model('m_wo_khusus_admin');
		$this->load->model('m_wo_khusus_noc');
    }
	
    public function index() {
        if (!file_exists(APPPATH.'views/backend/router/index.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6' || $this->session->userdata('ses_admin')=='7' || $this->session->userdata('ses_admin')=='8'){
		$data['total_revenue'] = $this->m_data_pelanggan->count_revenue();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
        $data['menu']  = 'data_pelanggan';
        $data['title'] = 'Data Pelanggan';
        $data['items'] = $this->m_data_pelanggan->get();

		$this->load->view('backend/header', $data);
		$this->load->view('backend/data_pelanggan/index', $data); 
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }
	
	public function tambah() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
        $data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'data_pelanggan';
        $data['title'] = 'Tambah Data';
		$getidrouter = $this->m_data_pelanggan->get();
		$data['te_items'] = $this->m_data_pelanggan->te();
		$data['dr_items'] = $this->m_data_pelanggan->get_distribusi();
		$data['odp_items'] = $this->mapping_model->get_ntb();
		$data['pop_items'] = $this->m_data_pelanggan->get_pop();
		$data['bts_items'] = $this->m_data_pelanggan->get_bts();
        $data['item']  = $this->m_data_pelanggan->get();
		$data['items_layanan']  = $this->m_layanan->get();
		$data['items_kpi']  = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();

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
        $this->load->view('backend/data_pelanggan/input', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		redirect('logout');
		}
    }

    public function simpan() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
		$this->m_data_pelanggan->simpan();
		$data['menu']  = 'data_pelanggan';
		$data['title'] = 'Tambah Router';
		redirect('manage/data_pelanggan');
		}else{
		redirect('logout');
		} 
    }

    public function ubah($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'data_pelanggan';
        $data['title'] = 'Ubah Data';
		$getidrouter = $this->m_data_pelanggan->get($id);
		$data['te_items'] = $this->m_data_pelanggan->te();
		$data['dr_items'] = $this->m_data_pelanggan->get_distribusi();
		$data['odp_items'] = $this->mapping_model->get_ntb();
		$data['pop_items'] = $this->m_data_pelanggan->get_pop();
		$data['bts_items'] = $this->m_data_pelanggan->get_bts();
        $data['item']  = $this->m_data_pelanggan->get($id);
		$data['items_layanan']  = $this->m_layanan->get($id);
		$data['items_kpi']  = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
		$data['items_wo']  = $this->m_wo->get_wo($id);

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
        $this->load->view('backend/data_pelanggan/input', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		redirect('logout');
		} 
    }
	
	public function layanan_tambah($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'data_pelanggan';
        $data['title'] = 'Tambah Data Layanan';

		$data['item']  = $this->m_data_pelanggan->get($id);
		$data['items_kpi']  = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
		$data['items_bts'] = $this->bts_model->get();
		$data['items_odp'] = $this->mapping_model->get();
		$data['te_items'] = $this->m_data_pelanggan->te();
		$data['dr_items'] = $this->m_data_pelanggan->get_distribusi();

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
        $this->load->view('backend/data_pelanggan/input_layanan', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		redirect('logout');
		}
    }
	public function layanan_ubah($id,$pelanggan) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'data_pelanggan';
        $data['title'] = 'Ubah Data Layanan';
		
        $data['item']  = $this->m_layanan->get_layanan($id);
		$data['items_pelanggan']  = $this->m_data_pelanggan->get($pelanggan);
		$data['items_kpi']  = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
		$data['items_bts'] = $this->bts_model->get();
		$data['items_odp'] = $this->mapping_model->get();
		$data['te_items'] = $this->m_data_pelanggan->te();
		$data['dr_items'] = $this->m_data_pelanggan->get_distribusi();

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
        $this->load->view('backend/data_pelanggan/input_layanan', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		redirect('logout');
		}
    }
	
	public function layanan_timpa($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5'){
			if($this->m_layanan->layanan_timpa($id)){
			echo "<script>javascript:history.go(-1);</script>";
			}else{
			redirect('manage/data_pelanggan'); 
			}
		//redirect('manage/data_pelanggan'); 
		}else{
		redirect('logout');
		}
    }
	public function layanan_simpan() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5'){
        	if($this->m_layanan->layanan_simpan()){
			echo "<script>javascript:history.go(-1);</script>";
			}else{
			redirect('manage/data_pelanggan'); 
			}
		//redirect('manage/data_pelanggan/'); 
		}else{
		redirect('logout');
		} 
    }
	public function layanan_hapus($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5'){
       		if($this->m_layanan->layanan_hapus($id)){
			redirect('manage/data_pelanggan');
			}else{
			redirect('manage/data_pelanggan');
			}
		redirect('manage/data_pelanggan');
		}else{
		redirect('logout');
		}
    }

    public function timpa($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5'){ 
        $this->m_data_pelanggan->timpa($id);
		redirect('manage/data_pelanggan');
		}else{
		redirect('logout');
		}
    }
	
	
    public function hapus($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){ 
        if ($this->m_data_pelanggan->delete($id)) {
            redirect('manage/data_pelanggan');
        } else {
            redirect('manage/data_pelanggan');
        }
 
		}else{
		redirect('logout');
		}
    }
	
	public function detil($id) {
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
        $data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'data_pelanggan';
        $data['title'] = 'Ubah Data';
		$getidrouter = $this->m_data_pelanggan->get($id);
		$data['te_items'] = $this->m_data_pelanggan->te();
		$data['dr_items'] = $this->m_data_pelanggan->get_distribusi();
		$data['odp_items'] = $this->mapping_model->get_ntb();
		$data['pop_items'] = $this->m_data_pelanggan->get_pop();
		$data['bts_items'] = $this->m_data_pelanggan->get_bts();
        $data['item']  = $this->m_data_pelanggan->get($id);
		$data['items_layanan']  = $this->m_layanan->get($id);
		$data['items_kpi']  = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
		$data['items_bts'] = $this->bts_model->get();
		$data['items_odp'] = $this->mapping_model->get();
		$data['items_wo']  = $this->m_wo->get_wo($id);
		$data['items_perangkat']  = $this->m_vas_data->get_perangkat($id);
		$data['items_wo_khusus_admin']  = $this->m_wo_khusus_admin->get_wo($id);
		$data['items_spk']  = $this->m_spk->get_spk($id);
		$data['items_sch']  = $this->scheduler_model->get_sch($id);
		$data['items_noc']  = $this->m_wo_khusus_noc->get_wo($id);
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
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6' || $this->session->userdata('ses_admin')=='7' || $this->session->userdata('ses_admin')=='8'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/data_pelanggan/show', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	
	public function hotspot($id) {
        $data['item']  = $this->m_data_pelanggan->get($id);
		$id_session =  $this->uri->segment(5);
		$this->mikrotik_model->hs_remove($id,$id_session);
        redirect('manage/router/'.$id);
    }
	public function restart($id) {
        $data['item']  = $this->m_data_pelanggan->get($id);
		$this->mikrotik_model->restart($id);
       if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4'){ redirect('manage/router/'); } else { redirect('manage/router/'.$this->session->userdata('idrouter')); }
    }	
	public function backup($id) {
        $data['item']  = $this->m_data_pelanggan->get($id);
		$this->mikrotik_model->backup($id);
        redirect('manage/router/'.$id);
    }
	
	public function tambah_temporer() {
		$this->m_data_pelanggan->simpan_temporer();
        redirect('manage/router');
    }
	public function get_bw($id) {
	   $this->fiberstream_model->get_bw($id);
    }
	
	public function migrasi() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){ 
        $this->m_data_pelanggan->migrasi();
		redirect('manage/data_pelanggan');
		}else{
		redirect('logout');
		}
    }
	
	
	
	public function export() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='6' || $this->session->userdata('ses_admin')=='7'){
		date_default_timezone_set("Asia/Singapore");
		$fileName = "Data All Pelanggan-".date("Y-m-d H:i:s")."-by-".$this->session->userdata('ses_nama').".xlsx";  
		$xls = $this->m_data_pelanggan->get_export($this->input->post('region'),$this->input->post('brand'),$this->input->post('area'),$this->input->post('tahun'),$this->input->post('status_pelanggan'));
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
		$sheet->setCellValue('A1', "Data All Pelanggan");
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
		$sheet->setCellValue('AL6', 'POP');
		$sheet->setCellValue('AM6', 'BTS');
		$sheet->setCellValue('AN6', 'Klasifikasi Service');
		
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
		$sheet->getColumnDimension('AL')->setAutoSize(true);
		$sheet->getColumnDimension('AM')->setAutoSize(true);
		$sheet->getColumnDimension('AN')->setAutoSize(true);
		
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
		$sheet->getStyle('AL6')->applyFromArray($header);
		$sheet->getStyle('AM6')->applyFromArray($header);
		$sheet->getStyle('AN6')->applyFromArray($header);

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
		
	   if($data['klasifikasi_service'] == "0"){
	   $blip_service = "Bandwidth Only";
	   }elseif($data['klasifikasi_service'] == "1"){
	   $blip_service = "Manage Only";
	   }elseif($data['klasifikasi_service'] == "2"){
	   $blip_service = "Manage Service";
	   }
		
		
		
		$admin_sales = $this->db->get_where('blip_sales', array('id' => $data['admin_sales']))->row_array();
		$blip_layanan = $this->db->get_where('blip_layanan', array('id_pelanggan' => $data['id']))->row_array();
		$media = $this->db->get_where('blip_mediaaccess', array('id' => $blip_layanan['id_media']))->row_array();
		$produk = $this->db->get_where('blip_produk', array('id' => $blip_layanan['id_produk']))->row_array();
		$bts = $this->db->get_where('gm_te', array('id' => $blip_layanan['id_te']))->row_array();
		
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
		$sheet->setCellValue('S' . $rows, $blip_layanan['id_bandwidth']);
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
		$sheet->setCellValue('AL' . $rows, $data['pop']);
		$sheet->setCellValue('AM' . $rows, $bts['nama']);
		$sheet->setCellValue('AN' . $rows, $blip_service);
		
			
			$sheet->getStyle('A'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('B'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('C'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('D'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('E'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('F'.$rows.':AN'.$rows)->applyFromArray($horizontalLeft);
			$sheet->getStyle('G'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('H'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('I'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('J'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('K'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('L'.$rows.':AN'.$rows)->applyFromArray($horizontalLeft);
			$sheet->getStyle('M'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('N'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('O'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('P'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('Q'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('R'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('S'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('T'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('U'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('V'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('W'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('X'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('Y'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('Z'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AA'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AB'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AC'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AD'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AE'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AF'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AG'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AH'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AI'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AJ'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AK'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AL'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AM'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('AN'.$rows.':AN'.$rows)->applyFromArray($horizontalCenter);
			
			$rows++;
			$no++;
		} 
		
		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/pelanggan";
		$writer = new Xlsx($spreadsheet);
		$writer->save($filelocation."/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/upload/".$fileName); 
		redirect(base_url('xdark/doc/pelanggan/').$fileName);
		
		}else{
		show_404();
		}
	}
	
	
	public function whatsapp($layanan,$id_pelanggan) {
		$this->load->database();
		$noc_aktivasi = $this->m_data_pelanggan->get_data_layanan_wa($layanan,$id_pelanggan);
		
		
		if ($noc_aktivasi) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Data terkirim ke Whatsapp Group.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Data GAGAL terkirim ke Whatsapp Group');
        }
		redirect('manage/data_pelanggan/'.$id_pelanggan);
    }
	
	public function telegram($layanan,$id_pelanggan) {
		$this->load->database();
		$noc_aktivasi = $this->m_data_pelanggan->get_data_layanan_tg($layanan,$id_pelanggan);
		
		
		if ($noc_aktivasi) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Data terkirim ke Telegram Group.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Data GAGAL terkirim ke Telegram Group');
        }
		redirect('manage/data_pelanggan/'.$id_pelanggan);
    }
}
}