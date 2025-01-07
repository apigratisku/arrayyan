<?php

class M_wo extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

	
	
	public function count_wo_all() {
        return $this->db->get('blip_wo')->num_rows();
    }
	public function count_wo_selesai() {
        return $this->db->get_where('blip_wo', array('status' => "1"))->num_rows();
    }
	public function count_wo_baru() {
        return $this->db->get_where('blip_wo', array('status' => "0"))->num_rows();
    }
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_wo', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_wo');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function wo_scheduler($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_wo', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_wo');
			$this->db->where('status', '0');

			
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function get_wo($id=false) {
        $response = false;

        if ($id) {
			$pel = $this->db->get_where('blip_pelanggan', array('id' => $id))->row_array();
            $query = $this->db->get_where('blip_wo', array('nama' => $pel['nama']));
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function get_wo_proses_wa() {
		
		date_default_timezone_set("Asia/Singapore");
		 
		 $query = $this->db->get_where('blip_wo', array('status' => "0"))->result_array();
		 if(isset($query)){
		     $no=1;
			 $response = "*Dear All,* \nBerikut update list pendingan WO tanggal ".date("d/M/y H:i")." sbb:\n\n";
			 foreach($query as $querydata){
			 $sql_pekerjaan = $this->db->get_where('blip_wo', array('id' => $querydata['id'],'tgl_aktivasi_teknis is not NULL' => NULL))->row_array();
			 $sql_report = $this->db->get_where('blip_wo', array('id' => $querydata['id'],'tgl_report_teknis is not NULL' => NULL))->row_array();
			 
			 if($sql_pekerjaan['tgl_aktivasi_teknis'] != NULL){$status_pekerjaan = "Selesai";}else{$status_pekerjaan = "*Belum dikerjakan*";}
			 if($sql_report['tgl_report_teknis'] != NULL){$status_report = "Selesai";}else{$status_report = "*Belum dikerjakan*";}
			 
			 $request = $this->db->get_where('blip_kpi', array('id' => $querydata['request']))->row_array();
			 $response .= $no.". *".$querydata['nama']."*\nKegiatan: ".$request['kegiatan']."\nStatus Pekerjaan: ".$status_pekerjaan."\nStatus Report: ".$status_report."\nKeterangan: ".$querydata['keterangan']."\n\n";
			 $no++;
			 }
			 $response .= "Regards,\n*Blippy Assistant*";
			 return $response;
		 }
    }
	
	public function get_wo_proses_tg() {
		
		date_default_timezone_set("Asia/Singapore");
		 
		 $query = $this->db->get_where('blip_wo', array('status' => "0"))->result_array();
		 if(isset($query)){
		     $no=1;
			 $response = "<b>Dear All,</b> \nBerikut update list pendingan WO tanggal ".date("d/M/y H:i")." sbb:\n\n";
			 foreach($query as $querydata){
			 $sql_pekerjaan = $this->db->get_where('blip_wo', array('id' => $querydata['id'],'tgl_aktivasi_teknis is not NULL' => NULL))->row_array();
			 $sql_report = $this->db->get_where('blip_wo', array('id' => $querydata['id'],'tgl_report_teknis is not NULL' => NULL))->row_array();
			 
			 if($sql_pekerjaan['tgl_aktivasi_teknis'] != NULL){$status_pekerjaan = "Selesai";}else{$status_pekerjaan = "<b>Belum dikerjakan</b>";}
			 if($sql_report['tgl_report_teknis'] != NULL){$status_report = "Selesai";}else{$status_report = "<b>Belum dikerjakan</b>";}
			 
			 $request = $this->db->get_where('blip_kpi', array('id' => $querydata['request']))->row_array();
			 $response .= $no.". <b>".$querydata['nama']."</b>\nKegiatan: ".$request['kegiatan']."\nStatus Pekerjaan: ".$status_pekerjaan."\nStatus Report: ".$status_report."\nKeterangan: ".$querydata['keterangan']."\n\n";
			 $no++;
			 }
			 $response .= "Regards,\n<b>Blippy Assistant</b>";
			 return $response;
		 }
		
    }
	

	function get_pelanggan($cid){
        $hsl=$this->db->query("SELECT * FROM blip_pelanggan WHERE cid='$cid'");
        if($hsl->num_rows()>0){
            foreach ($hsl->result() as $data) {
                $hasil=array(
                    'cid' => $data->cid,
                    'sid' => $data->sid,
                    'nama' => $data->nama,
                    'bandwidth' => $data->bandwidth,
                    );
            }
        }
        return $hasil;
    }
	
	public function get_export() {
		$this->db->select('*');
		$this->db->from('blip_wo');
		$this->db->order_by("id", "ASC");
		$query = $this->db->get();
		$response = $query->result_array();
        return $response;
    }
	
    public function simpan() {
		date_default_timezone_set("Asia/Singapore");
		if($this->input->post('admin_biaya_mtc') == NULL){$mtc = "";}else{$mtc = $this->input->post('admin_biaya_mtc');}
		if($this->input->post('admin_biaya_partner') == NULL){$partner = "";}else{$partner = $this->input->post('admin_biaya_partner');}
		if($this->input->post('admin_biaya_cb') == NULL){$cb = "";}else{$cb = $this->input->post('admin_biaya_cb');}
		$net_profit = $mtc-$partner-$cb;
		if($this->input->post('status') == "0"){$status_pelanggan = "0";}else{$status_pelanggan =  "1";}
		
		
		//Update Data Pelanggan
		if($this->input->post('request') == "2" || $this->input->post('request') == "3"){
			$update1_pelanggan = array(
			'admin_biaya_otc' => $this->input->post('admin_biaya_otc'),
			'admin_biaya_mtc' => $this->input->post('admin_biaya_mtc'),
			'admin_biaya_partner' => $this->input->post('admin_biaya_partner'),
			'admin_biaya_cb' => $this->input->post('admin_biaya_cb'),
			'admin_biaya_netprofit' => $net_profit,
			'keterangan' => $this->input->post('keterangan'),
			'status_pelanggan' => $status_pelanggan,
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
			);	
			$this->db->where('id', $this->input->post('id_pelanggan'));
			$update1_db_pelanggan = $this->db->update('blip_pelanggan', $update1_pelanggan);
		}
		
		//Update Dismantle Pelanggan
		if($this->input->post('request') == "5"){
			$update2_pelanggan = array(
			'status_pelanggan' => "3",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
			);	
			$this->db->where('id', $this->input->post('id_pelanggan'));
			$update2_db_pelanggan = $this->db->update('blip_pelanggan', $update2_pelanggan);
		}
		
		
		//Random Resource
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    	$passrand = array(); //remember to declare $pass as an array
    	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    	for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $passrand[] = $alphabet[$n];
    	}
    	$id_unik_wo = implode($passrand);
		
	
	   //Attachment Form FB
	   $file_fb = "";  
        if (isset($_FILES['admin_form_langganan']) && is_uploaded_file($_FILES['admin_form_langganan']['tmp_name'])) {
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_form_langganan')) {
                $file_fb = $this->upload->data('file_name');
            }
        }
		 
		//Attachment Form ktp
		$file_ktp = "";  
        if (isset($_FILES['admin_ktp_identitas']) && is_uploaded_file($_FILES['admin_ktp_identitas']['tmp_name'])) {
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_ktp_identitas')) {
                $file_ktp = $this->upload->data('file_name');
            }
        }
		
		//Attachment Form KTP
		$file_npwp = "";  
        if (isset($_FILES['admin_npwp']) && is_uploaded_file($_FILES['admin_npwp']['tmp_name'])) {
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_npwp')) {
                $file_npwp = $this->upload->data('file_name');
            }
        }
		
		//Attachment Form BAA 
        if (isset($_FILES['admin_form_baa']) && is_uploaded_file($_FILES['admin_form_baa']['tmp_name'])) {
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_form_baa')) {
                $file_baa = $this->upload->data('file_name');
            }
        }
		
		
		$data_wo = array(
		'id_unik_wo' => $id_unik_wo,
		'id_pelanggan' => $id_pelanggan,
		'brand' => $this->input->post('brand'),
		'region' => $this->input->post('region'),
		'level' => $this->input->post('level'),
		'produk1' => $this->input->post('produk1'),
		'produk2' => $this->input->post('produk2'),
		'media' => $this->input->post('media'),
		'request' => $this->input->post('sub_request'),
		'nama' => $this->input->post('input_nama_new'),
		'cid' => $this->input->post('cid'),
		'sid' => $this->input->post('sid'),
		'area' => $this->input->post('area'),
		'email' => $this->input->post('email'),
		'kontak' => $this->input->post('kontak'),
		'pic' => $this->input->post('pic'),
		'bandwidth1' => $this->input->post('bandwidth1'),
		'bandwidth2' => $this->input->post('bandwidth2'),
		'kordinat' => $this->input->post('kordinat'),
		'tgl_wo_admin' => $this->input->post('tgl_wo_admin'),
		'tgl_req_sales' => $this->input->post('tgl_req_sales'),
		'tgl_req_teknis' => $this->input->post('tgl_req_teknis'),
		'tgl_aktivasi_teknis' => $this->input->post('tgl_aktivasi_teknis'),
		'tgl_report_teknis' => $this->input->post('tgl_report_teknis'),
		'tgl_terbit_baa' => $this->input->post('tgl_terbit_baa'),
		'tgl_req_ob' => $this->input->post('tgl_req_ob'),
		'tgl_start_ob' => $this->input->post('tgl_start_ob'),
		'tgl_terbit_inv' => $this->input->post('tgl_terbit_inv'),
		'tgl_rfs' => $this->input->post('tgl_rfs'),
		'admin_divisi' => $this->input->post('admin_divisi'),
		'admin_sales' => $this->input->post('admin_sales'),
		'admin_alamat' => $this->input->post('admin_alamat'),
		'admin_segment' => $this->input->post('admin_segment'),
		'admin_subsegment' => $this->input->post('admin_subsegment'),
		'admin_start_kontrak' => $this->input->post('admin_start_kontrak'),
		'admin_end_kontrak' => $this->input->post('admin_end_kontrak'),
		'admin_biaya_otc' => $this->input->post('admin_biaya_otc'),
		'admin_biaya_mtc' => $this->input->post('admin_biaya_mtc'),
		'admin_biaya_partner' => $this->input->post('admin_biaya_partner'),
		'admin_biaya_cb' => $this->input->post('admin_biaya_cb'),
		'admin_biaya_netprofit' => $net_profit,
		'admin_form_langganan' => $file_fb,
		'admin_ktp_identitas' => $file_ktp,
		'admin_npwp' => $file_npwp,
		'admin_form_baa' => $file_baa,
		'keterangan' => $this->input->post('keterangan'),
		'status' => $this->input->post('status'),
		'status_pelanggan' => $status_pelanggan,
		'klasifikasi_service' => $this->input->post('klasifikasi_service'),
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$insert_db = $this->db->insert('blip_wo', $data_wo);
		$last_insert_id = $this->db->insert_id($insert_db);
		if($insert_db){
			//Tambah Pelanggan Baru
			$newcust = $this->db->get_where('blip_kpi', array('id' => $this->input->post('sub_request')))->row_array();
			if($newcust['new_cust'] == "1"){
			if($this->input->post('check_pel') == NULL){	 
			$get_data_wo = $this->db->get_where('blip_wo', array('id_unik_wo' => $id_unik_wo))->row_array();
			$data_pelanggan = array(
			'id_wo' => $get_data_wo['id'],
			'brand' => $this->input->post('brand'),
			'region' => $this->input->post('region'),
			'level' => $this->input->post('level'),
			//'produk' => $this->input->post('produk'),
			'media' => $this->input->post('media'),
			'nama' => $this->input->post('input_nama_new'),
			'cid' => $this->input->post('cid'),
			'sid' => $this->input->post('sid'),
			'area' => $this->input->post('area'),
			'email' => $this->input->post('email'),
			'kontak' => $this->input->post('kontak'),
			'pic' => $this->input->post('pic'),
			//'bandwidth' => $this->input->post('bandwidth'),
			'kordinat' => $this->input->post('kordinat'),
			'tgl_wo_admin' => $this->input->post('tgl_wo_admin'),
			'tgl_req_sales' => $this->input->post('tgl_req_sales'),
			'tgl_req_teknis' => $this->input->post('tgl_req_teknis'),
			'tgl_aktivasi_teknis' => $this->input->post('tgl_aktivasi_teknis'),
			'tgl_report_teknis' => $this->input->post('tgl_report_teknis'),
			'tgl_terbit_baa' => $this->input->post('tgl_terbit_baa'),
			'tgl_req_ob' => $this->input->post('tgl_req_ob'),
			'tgl_start_ob' => $this->input->post('tgl_start_ob'),
			'tgl_terbit_inv' => $this->input->post('tgl_terbit_inv'),
			'tgl_rfs' => $this->input->post('tgl_rfs'),
			'admin_divisi' => $this->input->post('admin_divisi'),
			'admin_sales' => $this->input->post('admin_sales'),
			'admin_alamat' => $this->input->post('admin_alamat'),
			'admin_segment' => $this->input->post('admin_segment'),
			'admin_subsegment' => $this->input->post('admin_subsegment'),
			'admin_start_kontrak' => $this->input->post('admin_start_kontrak'),
			'admin_end_kontrak' => $this->input->post('admin_end_kontrak'),
			'admin_biaya_otc' => $this->input->post('admin_biaya_otc'),
			'admin_biaya_mtc' => $this->input->post('admin_biaya_mtc'),
			'admin_biaya_partner' => $this->input->post('admin_biaya_partner'),
			'admin_biaya_cb' => $this->input->post('admin_biaya_cb'),
			'admin_form_langganan' => $get_data_wo['admin_form_langganan'],
			'admin_ktp_identitas' => $get_data_wo['admin_ktp_identitas'],
			'admin_npwp' => $get_data_wo['admin_npwp'],
			'admin_form_baa' => $get_data_wo['admin_baa'],
			'keterangan' => $this->input->post('keterangan'),
			'status_pelanggan' => $status_pelanggan,
			'klasifikasi_service' => $this->input->post('klasifikasi_service'),
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
			);				
			$insert_pel = $this->db->insert('blip_pelanggan', $data_pelanggan);
				if($insert_pel){
				$get_data_pel = $this->db->get_where('blip_pelanggan', array('id_wo' => $get_data_wo['id']))->row_array();	
				$data_layanan1 = array(
					'id_pelanggan' => $get_data_pel['id'],
					'id_media' => $this->input->post('media'),
					'id_produk' => $this->input->post('produk1'),
					'id_bandwidth' => $this->input->post('bandwidth1'),
					'id_role' => "1",
					'id_status' => "1",
					'history_waktu' => date("Y-m-d H:i"),
					'history_iduser' => $this->session->userdata('ses_id'),
				);
					$insert_layanan1 = $this->db->insert('blip_layanan', $data_layanan1);
						if($insert_layanan1){
							if($this->input->post('produk2') != NULL){
							$get_data_pel2 = $this->db->get_where('blip_pelanggan', array('id_wo' => $get_data_wo['id']))->row_array();	
							$data_layanan2 = array(
								'id_pelanggan' => $get_data_pel2['id'],
								'id_media' => $this->input->post('media'),
								'id_produk' => $this->input->post('produk2'),
								'id_bandwidth' => $this->input->post('bandwidth2'),
								'id_role' => "1",
								'id_status' => "1",
								'history_waktu' => date("Y-m-d H:i"),
								'history_iduser' => $this->session->userdata('ses_id'),
							);
								$this->db->insert('blip_layanan', $data_layanan2);
							}
							//Update id_pelanggan tbl_wo
							
							
							$data_last_id = array(
								'id_pelanggan' => $last_insert_id,
							);
								$this->db->where('id', $get_data_wo['id']);
								$this->db->update('blip_wo', $data_last_id);
						}
				}
			}
			}
			
			
		//Push WA
		if(!empty($this->input->post('cid'))){
		$cid = $this->input->post('cid');
		}else{
		$cid ="-";
		}
		if(!empty($this->input->post('sid'))){
		$sid = $this->input->post('sid');
		}else{
		$sid ="-";
		}
		if(!empty($this->input->post('sub_request'))){
		$data_request = $this->db->get_where('blip_kpi', array('id' => $this->input->post('sub_request')))->row_array();
		$req = $data_request['kegiatan'];
		}else{
		$req ="-";
		}
		if(!empty($this->input->post('bandwidth1'))){
		$bw1 = $this->input->post('bandwidth1')." Mbps";
		}else{
		$bw1 ="-";
		}
		if(!empty($this->input->post('bandwidth2'))){
		$bw2 = $this->input->post('bandwidth2')." Mbps";
		}else{
		$bw2 ="-";
		}
		
		if(!empty($this->input->post('notif_tg'))){
		//Push TG
		if($this->input->post('produk2') == NULL){
		$paket_layanan1 = $this->db->get_where('blip_produk', array('id' => $this->input->post('produk1')))->row_array();
		$paket_layanan2 = $this->db->get_where('blip_produk', array('id' => $this->input->post('produk2')))->row_array();
		$pesan_tg = "<b>WO (Work Order)</b>\n\n";
		$pesan_tg .= "CID: <b>".$cid."</b>\nSID: <b>".$sid."</b>\nPelanggan: <b>".$this->input->post('input_nama_new')."</b>\nRequest: <b>".$req."</b>\nLayanan: <b>".$paket_layanan1['produk']."</b>\nBandwidth: <b>".$bw1."</b>\nRFS: <b>".$this->input->post('tgl_rfs')."</b>\nKeterangan: ".$this->input->post('keterangan')."\n\n";
		$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";	
		}else{
		$paket_layanan1 = $this->db->get_where('blip_produk', array('id' => $this->input->post('produk1')))->row_array();
		$paket_layanan2 = $this->db->get_where('blip_produk', array('id' => $this->input->post('produk2')))->row_array();
		$pesan_tg = "<b>WO (Work Order)</b>\n\n";
		$pesan_tg .= "CID: <b>".$cid."</b>\nSID: <b>".$sid."</b>\nPelanggan: <b>".$this->input->post('input_nama_new')."</b>\nRequest: <b>".$req."</b>\nLayanan 1: <b>".$paket_layanan1['produk']."</b>\nBandwidth Layanan 1: <b>".$bw1."</b>\nLayanan 2: <b>".$paket_layanan1['produk']."</b>\nBandwidth Layanan 2: <b>".$bw2."</b>\nRFS: <b>".$this->input->post('tgl_rfs')."</b>\nKeterangan: ".$this->input->post('keterangan')."\n\n";
		$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";
		}		
		$this->telegram_lib->sendblip("-901753609",$pesan_tg);	
		
		//Push WA
		if($this->input->post('produk2') == NULL){
		$paket_layanan1 = $this->db->get_where('blip_produk', array('id' => $this->input->post('produk1')))->row_array();
		$paket_layanan2 = $this->db->get_where('blip_produk', array('id' => $this->input->post('produk2')))->row_array();
		$pesan_wa = "*WO (Work Order)*\n\n";
		$pesan_wa .= "CID: *".$cid."*\nSID: *".$sid."*\nPelanggan: *".$this->input->post('input_nama_new')."*\nRequest: ".$req."\nLayanan: ".$paket_layanan1['produk']."\nBandwidth: *".$bw1."*\nRFS: ".$this->input->post('tgl_rfs')."\nKeterangan: ".$this->input->post('keterangan')."\n\n";
		$pesan_wa .= "Regards,\n*Blippy Assistant*";
		}else{
		$pesan_wa = "*WO (Work Order)*\n\n";
		$pesan_wa .= "CID: *".$cid."*\nSID: *".$sid."*\nPelanggan: *".$this->input->post('input_nama_new')."*\nRequest: ".$req."\nLayanan 1: *".$paket_layanan1['produk']."*\nBandwidth Layanan 1: *".$bw1."*\nPaket Layanan 2: *".$paket_layanan2['produk']."*\nBandwidth Layanan 2: *".$bw2."*\nRFS: ".$this->input->post('tgl_rfs')."\nKeterangan: ".$this->input->post('keterangan')."\n\n";
		$pesan_wa .= "Regards,\n*Blippy Assistant*";
		}
		}
			
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambah WO baru pelanggan ".$this->input->post('input_nama_new'),
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
     if($this->input->post('status') == "0"){$status_wo =  "0";}else{$status_wo =  "1";}
	 if($status_wo ==  "1"){
	 	if($this->input->post('sub_request') == "9"){
		$status_pelanggan = "3";
		}else{
		$status_pelanggan = "1";
		}
	}else{
	$status_pelanggan = "0";
	}
	
	//Get data WO
	$dataid_wo = $this->get($id);
	
	   //Attachment Form FB
	   $file_fb = "";  
        if (isset($_FILES['admin_form_langganan']) && is_uploaded_file($_FILES['admin_form_langganan']['tmp_name'])) {
			$fb    = $dataid_wo['admin_form_langganan'];
			if(!empty($dataid_wo['admin_form_langganan'])){unlink('./xdark/doc/attachment/' . $fb);}
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_form_langganan')) {
                $file_fb = $this->upload->data('file_name');
            }
        }else{
		$file_fb = $dataid_wo['admin_form_langganan'];
		}
		 
		//Attachment Form ktp
		$file_ktp = "";  
        if (isset($_FILES['admin_ktp_identitas']) && is_uploaded_file($_FILES['admin_ktp_identitas']['tmp_name'])) {
			$ktp    = $dataid_wo['admin_ktp_identitas'];
			if(!empty($dataid_wo['admin_ktp_identitas'])){unlink('./xdark/doc/attachment/' . $ktp);}
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_ktp_identitas')) {
                $file_ktp = $this->upload->data('file_name');
            }
        }else{
		$file_ktp = $dataid_wo['admin_ktp_identitas'];
		}
		
		//Attachment Form NPWP
		$file_npwp = "";  
        if (isset($_FILES['admin_npwp']) && is_uploaded_file($_FILES['admin_npwp']['tmp_name'])) {
			$npwp    = $dataid_wo['admin_npwp'];
			if(!empty($dataid_wo['admin_npwp'])){unlink('./xdark/doc/attachment/' . $npwp);}
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_npwp')) {
                $file_npwp = $this->upload->data('file_name');
            }
        }else{
		$file_npwp = $dataid_wo['admin_npwp'];
		} 
		
		//Attachment Form BAA
		$file_baa = "";  
        if (isset($_FILES['admin_form_baa']) && is_uploaded_file($_FILES['admin_form_baa']['tmp_name'])) {
			$baa    = $dataid_wo['admin_form_baa'];
			if(!empty($dataid_wo['admin_form_baa'])){unlink('./xdark/doc/attachment/' . $baa);}
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_form_baa')) {
                $file_baa = $this->upload->data('file_name');
            }
        }else{
		$file_baa = $dataid_wo['admin_form_baa'];
		} 
	  
	 if($this->input->post('admin_biaya_mtc') == NULL){$mtc = "";}else{$mtc = $this->input->post('admin_biaya_mtc');}
		if($this->input->post('admin_biaya_partner') == NULL){$partner = "";}else{$partner = $this->input->post('admin_biaya_partner');}
		if($this->input->post('admin_biaya_cb') == NULL){$cb = "";}else{$cb = $this->input->post('admin_biaya_cb');}
		$net_profit = $mtc-$partner-$cb;
	   
     $data_wo = array(
		'brand' => $this->input->post('brand'),
		'region' => $this->input->post('region'),
		'level' => $this->input->post('level'),
		'produk1' => $this->input->post('produk1'),
		'produk2' => $this->input->post('produk2'),
		'media' => $this->input->post('media'),
		'request' => $this->input->post('sub_request'),
		'nama' => $this->input->post('input_nama_new'),
		'cid' => $this->input->post('cid'),
		'sid' => $this->input->post('sid'),
		'area' => $this->input->post('area'),
		'email' => $this->input->post('email'),
		'kontak' => $this->input->post('kontak'),
		'pic' => $this->input->post('pic'),
		'bandwidth1' => $this->input->post('bandwidth1'),
		'bandwidth2' => $this->input->post('bandwidth2'),
		'kordinat' => $this->input->post('kordinat'),
		'tgl_wo_admin' => $this->input->post('tgl_wo_admin'),
		'tgl_req_sales' => $this->input->post('tgl_req_sales'),
		'tgl_req_teknis' => $this->input->post('tgl_req_teknis'),
		'tgl_aktivasi_teknis' => $this->input->post('tgl_aktivasi_teknis'),
		'tgl_report_teknis' => $this->input->post('tgl_report_teknis'),
		'tgl_terbit_baa' => $this->input->post('tgl_terbit_baa'),
		'tgl_req_ob' => $this->input->post('tgl_req_ob'),
		'tgl_start_ob' => $this->input->post('tgl_start_ob'),
		'tgl_terbit_inv' => $this->input->post('tgl_terbit_inv'),
		'tgl_rfs' => $this->input->post('tgl_rfs'),
		'admin_divisi' => $this->input->post('admin_divisi'),
		'admin_sales' => $this->input->post('admin_sales'),
		'admin_alamat' => $this->input->post('admin_alamat'),
		'admin_segment' => $this->input->post('admin_segment'),
		'admin_subsegment' => $this->input->post('admin_subsegment'),
		'admin_start_kontrak' => $this->input->post('admin_start_kontrak'),
		'admin_end_kontrak' => $this->input->post('admin_end_kontrak'),
		'admin_biaya_otc' => $this->input->post('admin_biaya_otc'),
		'admin_biaya_mtc' => $this->input->post('admin_biaya_mtc'),
		'admin_biaya_partner' => $this->input->post('admin_biaya_partner'),
		'admin_biaya_cb' => $this->input->post('admin_biaya_cb'),
		'admin_biaya_netprofit' => $net_profit,
		'admin_form_langganan' => $file_fb,
		'admin_ktp_identitas' => $file_ktp,
		'admin_npwp' => $file_npwp,
		'admin_form_baa' => $file_baa,
		'keterangan' => $this->input->post('keterangan'),
		'status' => $this->input->post('status'),
		'status_pelanggan' => $status_pelanggan,
		'klasifikasi_service' => $this->input->post('klasifikasi_service'),
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),
		);		
		$this->db->where('id', $id);
		$update_wo = $this->db->update('blip_wo', $data_wo);			
		if($update_wo){
		
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Mengubah data WO pelanggan ".$this->input->post('input_nama_new'),
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal mengubah data.');	
		}
    }
	
    public function delete($id) {	
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menghapus data WO pelanggan id ".$id,
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
        return $this->db->delete('blip_wo', array('id' => $id));
    }
	public function batalkan($id) {	
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Membatalkan data WO pelanggan id ".$id,
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
        $p1 = $this->db->delete('blip_pelanggan', array('id_wo' => $id));
		if($p1){
		return $this->db->delete('blip_wo', array('id' => $id));
		}
    }
	public function selesaikan($id) {	
        $data_wo = array(
		'status' => "1",
		'status_pelanggan' => "1",
		);
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_wo', $data_wo);
		if($update_db){
			$data_pelanggan = array(	
			'status_pelanggan' => "1",
			'status_layanan' => "1",
			);
			$this->db->where('id_wo', $id);
			$this->db->update('blip_pelanggan', $data_pelanggan);
		}
		
    }

}
