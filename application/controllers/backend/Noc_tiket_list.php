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
class Noc_tiket_list extends CI_Controller {

    public function __construct() {
        parent::__construct();

        
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
		$this->load->model('m_noc_tiket_list');
		$this->load->model('m_noc_tiket_case_klasifikasi');
		$this->load->model('m_noc_tiket_case_subklasifikasi');
		$this->load->model('m_noc_tiket_noc_hd');
		$this->load->model('m_noc_tiket_noc_ipcore');
		$this->load->model('m_noc_tiket_eskalasi');	
    }

    public function index() {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_list/index.php')) {
            show_404();
        }
		if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		
        $data['menu']  = 'noc_tiket_list';
        $data['title'] = 'Data Tiketing';
        $data['items'] = $this->m_noc_tiket_list->get();
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
       
		$this->load->view('backend/header', $data);
		if($this->agent->is_mobile()) {
		$this->load->view('backend/noc_tiket_list/index_mobile', $data);
		}else{
		$this->load->view('backend/noc_tiket_list/index', $data); 
		}
        $this->load->view('backend/footer');
    }
	
	public function do_filter() {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_list/filter.php')) {
            show_404();
        }
		if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }
		$data_filter = $this->m_noc_tiket_list->do_filter();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		
        $data['menu']  = 'noc_tiket_list';
        $data['title'] = 'Data Tiketing';
        $data['items'] = $data_filter;
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
       
		$this->load->view('backend/header', $data);
		if($this->agent->is_mobile()) {
		$this->load->view('backend/noc_tiket_list/filter_mobile', $data);
		}else{
		$this->load->view('backend/noc_tiket_list/filter', $data); 
		}
        $this->load->view('backend/footer');
    }

    public function tambah() {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_list/input.php')) {
            show_404();
        }
		if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['tb_pop'] = $this->m_data_pelanggan->get_pop();
		$data['tb_pelanggan']  = $this->m_data_pelanggan->get();
		$data['tb_case_klasifikasi']  = $this->m_noc_tiket_case_klasifikasi->get();
		$data['tb_case_subklasifikasi']  = $this->m_noc_tiket_case_subklasifikasi->get();
		$data['tb_noc_hd']  = $this->m_noc_tiket_noc_hd->get();
		$data['tb_noc_ipcore']  = $this->m_noc_tiket_noc_ipcore->get();
		$data['tb_eskalasi']  = $this->m_noc_tiket_eskalasi->get();
		$data['item']  = $this->m_noc_tiket_list->get();
        $data['menu']  = 'noc_tiket_list';
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
        $this->load->view('backend/noc_tiket_list/input', $data);
        $this->load->view('backend/footer', $footer);
    }

    public function simpan() {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_list/input.php')) {
            show_404();
        }
		if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }
		
		$this->m_noc_tiket_list->simpan();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();		
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['tb_pop'] = $this->m_data_pelanggan->get_pop();
		$data['tb_pelanggan']  = $this->m_data_pelanggan->get();
		$data['tb_case_klasifikasi']  = $this->m_noc_tiket_case_klasifikasi->get();
		$data['tb_case_subklasifikasi']  = $this->m_noc_tiket_case_subklasifikasi->get();
		$data['tb_noc_hd']  = $this->m_noc_tiket_noc_hd->get();
		$data['tb_noc_ipcore']  = $this->m_noc_tiket_noc_ipcore->get();
		$data['tb_eskalasi']  = $this->m_noc_tiket_eskalasi->get();
		
        $data['menu']  = 'noc_tiket_list';
        $data['title'] = 'Tambah Data';
		$this->load->view('backend/header', $data);
        $this->load->view('backend/noc_tiket_list/input', $data);
        $this->load->view('backend/footer');
    }
	
	public function detil($id) {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_list/show.php')) {
            show_404();
        }
		if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		
        $data['menu']  = 'noc_tiket_list';
        $data['title'] = 'Detail Data';
        $data['item']  = $this->m_noc_tiket_list->get($id);

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
        $this->load->view('backend/noc_tiket_list/show', $data);
        $this->load->view('backend/footer', $footer);
    }
    public function ubah($id) {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_list/input.php')) {
            show_404();
        }
		if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		
        $data['menu']  = 'noc_tiket_list';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->m_noc_tiket_list->get($id);
		$data['tb_pop'] = $this->m_data_pelanggan->get_pop();
		$data['tb_pelanggan']  = $this->m_data_pelanggan->get();
		$data['tb_case_klasifikasi']  = $this->m_noc_tiket_case_klasifikasi->get();
		$data['tb_case_subklasifikasi']  = $this->m_noc_tiket_case_subklasifikasi->get();
		$data['tb_noc_hd']  = $this->m_noc_tiket_noc_hd->get();
		$data['tb_noc_ipcore']  = $this->m_noc_tiket_noc_ipcore->get();
		$data['tb_eskalasi']  = $this->m_noc_tiket_eskalasi->get();
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
        $this->load->view('backend/noc_tiket_list/input', $data);
        $this->load->view('backend/footer', $footer);
    }

    public function timpa($id) {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_list/input.php')) {
            show_404();
        }
		if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }

        $this->m_noc_tiket_list->timpa($id);
		redirect('manage/noc_tiket_list');
    }
	
	
    public function hapus($id) {
		if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }
        if ($this->m_noc_tiket_list->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/noc_tiket_list');
    }
	
	public function import() {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_list/import.php')) {
            show_404();
        }
		if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['tb_pop'] = $this->m_data_pelanggan->get_pop();
		$data['tb_pelanggan']  = $this->m_data_pelanggan->get();
		$data['tb_case_klasifikasi']  = $this->m_noc_tiket_case_klasifikasi->get();
		$data['tb_case_subklasifikasi']  = $this->m_noc_tiket_case_subklasifikasi->get();
		$data['tb_noc_hd']  = $this->m_noc_tiket_noc_hd->get();
		$data['tb_noc_ipcore']  = $this->m_noc_tiket_noc_ipcore->get();
		$data['tb_eskalasi']  = $this->m_noc_tiket_eskalasi->get();
		$data['item']  = $this->m_noc_tiket_list->get();
        $data['menu']  = 'noc_tiket_list';
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
        $this->load->view('backend/noc_tiket_list/import', $data);
        $this->load->view('backend/footer', $footer);
    }
	
	
	public function kirim_report() {
        $items = $this->m_noc_tiket_list->getEXPORT();
        $tanggal = date('d-m-Y');
 
        $pdf = new TCPDF('L', 'mm', array(900,200), true, 'UTF-8', false);
        $pdf->AddPage('L', array(900,200));
        $pdf->SetFont('', 'B', 20);
        $pdf->Cell(900, 0, "Daily Report NOC Helpdesk - ".$tanggal, 0, 1, 'L');
        $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
        $pdf->Ln(10);
        $pdf->SetFont('', 'B', 10);
		$pdf->Cell(15, 8, "No", 1, 0, 'C');
		$pdf->Cell(30, 8, "Tiket", 1, 0, 'C');
        $pdf->Cell(70, 8, "Customer", 1, 0, 'C');
        $pdf->Cell(30, 8, "POP", 1, 0, 'C');
        $pdf->Cell(55, 8, "Case", 1, 0, 'C');
        $pdf->Cell(55, 8, "Case Klasifikasi", 1, 0, 'C');
		$pdf->Cell(55, 8, "Sub Klasifikasi", 1, 0, 'C');
		$pdf->Cell(40, 8, "Tgl.Open", 1, 0, 'C');
		$pdf->Cell(27, 8, "Eskalasi NOC", 1, 0, 'C');
		$pdf->Cell(27, 8, "Handle By", 1, 0, 'C');
		$pdf->Cell(27, 8, "Eskalasi Akhir", 1, 0, 'C');
		$pdf->Cell(150, 8, "Problem", 1, 0, 'C');
		$pdf->Cell(150, 8, "Action", 1, 0, 'C');
		$pdf->Cell(20, 8, "Status", 1, 0, 'C');
		$pdf->Cell(40, 8, "Tgl.Close", 1, 0, 'C');
        $pdf->Cell(55, 8, "Durasi Tiket", 1, 1, 'C');
		
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

		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/noc/daily";
		$fileNL = $filelocation."/Daily Report NOC Helpdesk - ".$tanggal.".pdf";
        $pdf->Output($fileNL, 'F'); 
		
		//Tiket Filter
		$case_total = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d")))->num_rows();
		$case_solved = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d"), 'status' => "Solved"))->num_rows();
		$case_pending = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d"), 'status' => "Pending"))->num_rows();
		$case_scheduled = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d"), 'status' => "Scheduled"))->num_rows();
		$case_monitoring = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d"), 'status' => "Monitoring"))->num_rows();
		$case_progress = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d"), 'status' => "Progress"))->num_rows();

		$this->telegram_lib->sendblip_doc("-1001499615009",$_SERVER['DOCUMENT_ROOT']."/xdark/doc/noc/daily/Daily Report NOC Helpdesk - ".$tanggal.".pdf","\n\nTotal Case: <b>".$case_total."</b>\nSolved: <b>".$case_solved."</b>\nPending: <b>".$case_pending."</b>\nMonitoring: <b>".$case_monitoring."</b>\nScheduled: <b>".$case_scheduled."</b>\nProgress: <b>".$case_progress."</b>\n\nRegards,\n<b>NOC Area NTB</b>");
		
		redirect('manage/noc_tiket_list');
    }
 
    private function addRow($pdf, $no, $item) {
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $item['customers']))->row_array();
		$case_klasifikasi = $this->db->get_where('blip_tiket_case_klasifikasi', array('id' => $item['case_klasifikasi']))->row_array();
		$case_subklasifikasi = $this->db->get_where('blip_tiket_case_subklasifikasi', array('id' => $item['case_subklasifikasi']))->row_array();
		//$ipcore = $this->db->get_where('blip_tiket_noc_ipcore', array('id' => $item['noc_ip_core']))->row_array();
		$hd = $this->db->get_where('blip_tiket_noc_hd', array('id' => $item['noc_hd_duty']))->row_array();
		$eskalasi_akhir = $this->db->get_where('blip_tiket_eskalasi', array('id' => $item['eskalasi_akhir']))->row_array();
		
		$pdf->Cell(15, 8, $no, 1, 0, 'C');
        $pdf->Cell(30, 8, $item['tiket'], 1, 0, 'C');
        $pdf->Cell(70, 8, $pelanggan['nama'], 1, 0, '');
        $pdf->Cell(30, 8, $item['pop'], 1, 0, 'C');
        $pdf->Cell(55, 8, $item['case_gangguan'], 1, 0, 'C');
		$pdf->Cell(55, 8, $case_klasifikasi['nama'], 1, 0, 'C');
		$pdf->Cell(55, 8, $case_subklasifikasi['nama'], 1, 0, 'C');
		$pdf->Cell(40, 8, $item['tgl_open']." ".$item['jam_open'], 1, 0, 'C');
		$pdf->Cell(27, 8, $item['eskalasi_noc'], 1, 0, 'C');
		$pdf->Cell(27, 8, $hd['nama'], 1, 0, 'C');
		$pdf->Cell(27, 8, $eskalasi_akhir['nama'], 1, 0, 'C');
		$pdf->Cell(150, 8, $item['problem'], 1, 0, 'C');
		$pdf->Cell(150, 8, $item['action'], 1, 0, 'C');
		$pdf->Cell(20, 8, $item['status'], 1, 0, 'C');
		$pdf->Cell(40, 8, $item['tgl_close_sla']." ".$item['jam_close_sla'], 1, 0, 'C');
        $pdf->Cell(55, 8, $item['durasi_sla']." menit", 1, 1, 'C');
    }
	
	
	public function export_pdf() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){
        $items = $this->m_noc_tiket_list->getDATA($this->input->post('tgl_a'),$this->input->post('tgl_b'));
        $tanggal = date('d-m-Y');
 
        $pdf = new TCPDF('L', 'mm', array(900,200), true, 'UTF-8', false);
        $pdf->AddPage('L', array(900,200));
        $pdf->SetFont('', 'B', 20);
        $pdf->Cell(900, 0, "Daily Report NOC Helpdesk - ".$tanggal, 0, 1, 'L');
        $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
        $pdf->Ln(10);
        $pdf->SetFont('', 'B', 10);
		$pdf->Cell(15, 8, "No", 1, 0, 'C');
		$pdf->Cell(30, 8, "Tiket", 1, 0, 'C');
        $pdf->Cell(70, 8, "Customer", 1, 0, 'C');
        $pdf->Cell(30, 8, "POP", 1, 0, 'C');
        $pdf->Cell(55, 8, "Case", 1, 0, 'C');
        $pdf->Cell(55, 8, "Case Klasifikasi", 1, 0, 'C');
		$pdf->Cell(55, 8, "Sub Klasifikasi", 1, 0, 'C');
		$pdf->Cell(40, 8, "Tgl.Open", 1, 0, 'C');
		$pdf->Cell(27, 8, "Eskalasi NOC", 1, 0, 'C');
		$pdf->Cell(27, 8, "Handle By", 1, 0, 'C');
		$pdf->Cell(27, 8, "Eskalasi Akhir", 1, 0, 'C');
		$pdf->Cell(150, 8, "Problem", 1, 0, 'C');
		$pdf->Cell(150, 8, "Action", 1, 0, 'C');
		$pdf->Cell(20, 8, "Status", 1, 0, 'C');
		$pdf->Cell(40, 8, "Tgl.Close", 1, 0, 'C');
        $pdf->Cell(55, 8, "Durasi Solving", 1, 1, 'C');
		
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

		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/noc/daily";
		$fileNL = $filelocation."/Daily Report NOC Helpdesk - ".$tanggal.".pdf";
        $pdf->Output($fileNL, 'F'); 
		
		//Tiket Filter
		$case_total = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d")))->num_rows();
		$case_solved = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d"), 'status' => "Solved"))->num_rows();
		$case_pending = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d"), 'status' => "Pending"))->num_rows();
		$case_scheduled = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d"), 'status' => "Scheduled"))->num_rows();
		$case_monitoring = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d"), 'status' => "Monitoring"))->num_rows();
		$case_progress = $this->db->get_where('blip_tiket_list', array('tgl_open' => date("Y-m-d"), 'status' => "Progress"))->num_rows();
		
		$fileName  = "Daily Report NOC Helpdesk - ".$tanggal.".pdf";
		redirect(base_url('xdark/doc/noc/daily/').$fileName);
		}
    }
	
	
	public function export_xls() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){
		date_default_timezone_set("Asia/Singapore");
		$tanggal = date('d-m-Y');
		$fileName = "Report NOC Helpdesk - ".$tanggal.".xlsx";  
		$xls = $this->m_noc_tiket_list->getDATA($this->input->post('tgl_a'),$this->input->post('tgl_b'));
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
		$sheet->setCellValue('A1', "Report NOC Helpdesk - ".$tanggal);
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
		$sheet->setCellValue('B6', 'Tiket');
		$sheet->setCellValue('C6', 'Customer');
		$sheet->setCellValue('D6', 'POP');
		$sheet->setCellValue('E6', 'Case');
		$sheet->setCellValue('F6', 'Case Klasifikasi');
		$sheet->setCellValue('G6', 'Sub Klasifikasi');    
		$sheet->setCellValue('H6', 'Tgl Open');
		$sheet->setCellValue('I6', 'Jam Open');
		$sheet->setCellValue('J6', 'Eskalasi NOC');
		$sheet->setCellValue('K6', 'NOC IP Core');
		$sheet->setCellValue('L6', 'Handle By');
		$sheet->setCellValue('M6', 'Eskalasi Akhir');
		$sheet->setCellValue('N6', 'Problem');
		$sheet->setCellValue('O6', 'Action');
		$sheet->setCellValue('P6', 'Status');
		$sheet->setCellValue('Q6', 'Tgl Close');
		$sheet->setCellValue('R6', 'Jam Close');
		$sheet->setCellValue('S6', 'Tgl Close SLA');
		$sheet->setCellValue('T6', 'Jam Close SLA');
		$sheet->setCellValue('U6', 'PIC');
		$sheet->setCellValue('V6', 'Durasi Stop Clock NOC');
		$sheet->setCellValue('W6', 'Durasi Solving');
		
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

		$rows = 7;
		$no = 1;
		foreach ($xls->result_array() as $item){
		$this->load->database();
		
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $item['customers']))->row_array();
		$case_klasifikasi = $this->db->get_where('blip_tiket_case_klasifikasi', array('id' => $item['case_klasifikasi']))->row_array();
		$case_subklasifikasi = $this->db->get_where('blip_tiket_case_subklasifikasi', array('id' => $item['case_subklasifikasi']))->row_array();
		$ipcore = $this->db->get_where('blip_tiket_noc_ipcore', array('id' => $item['noc_ip_core']))->row_array();
		$hd = $this->db->get_where('blip_tiket_noc_hd', array('id' => $item['noc_hd_duty']))->row_array();
		$eskalasi_akhir = $this->db->get_where('blip_tiket_eskalasi', array('id' => $item['eskalasi_akhir']))->row_array();
		
		
		$sheet->setCellValue('A' . $rows, $no);
		$sheet->setCellValue('B' . $rows, $item['tiket']);
		$sheet->setCellValue('C' . $rows, $pelanggan['nama']);
		$sheet->setCellValue('D' . $rows, $item['pop']);
		$sheet->setCellValue('E' . $rows, $item['case_gangguan']);
		$sheet->setCellValue('F' . $rows, $case_klasifikasi['nama']);
		$sheet->setCellValue('G' . $rows, $case_subklasifikasi['nama']);
		$sheet->setCellValue('H' . $rows, $item['tgl_open']);
		$sheet->setCellValue('I' . $rows, $item['jam_open']);
		$sheet->setCellValue('J' . $rows, $item['eskalasi_noc']);
		$sheet->setCellValue('K' . $rows, $ipcore['nama']);
		$sheet->setCellValue('L' . $rows, $hd['nama']);
		$sheet->setCellValue('M' . $rows, $eskalasi_akhir['nama']);
		$sheet->setCellValue('N' . $rows, $item['problem']);
		$sheet->setCellValue('O' . $rows, $item['action']);
		$sheet->setCellValue('P' . $rows, $item['status']);
		$sheet->setCellValue('Q' . $rows, $item['tgl_close']);
		$sheet->setCellValue('R' . $rows, $item['jam_close']);
		$sheet->setCellValue('S' . $rows, $item['tgl_close_sla']);
		$sheet->setCellValue('T' . $rows, $item['jam_close_sla']);
		$sheet->setCellValue('U' . $rows, $item['pic']);
		$sheet->setCellValue('V' . $rows, $item['durasi']." Menit");
		$sheet->setCellValue('W' . $rows, $item['durasi_sla']." Menit");
		
			
			$sheet->getStyle('A'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('B'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('C'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('D'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('E'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('F'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('G'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('H'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('I'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('J'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('K'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('L'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('M'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('N'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('O'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('P'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('Q'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('R'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('S'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('T'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('U'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('V'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('W'.$rows.':W'.$rows)->applyFromArray($horizontalCenter);
			
			$rows++;
			$no++;
		} 
		
		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/noc/daily";
		$writer = new Xlsx($spreadsheet);
		$writer->save($filelocation."/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/upload/".$fileName); 
		redirect(base_url('xdark/doc/noc/daily/').$fileName);
		
		}else{
		show_404();
		}
	}
	
	

}
}