<?php

class Fiberstream_model extends CI_Model{

public function get_fs() {
            $this->db->select('gm_fiberstream.*,gm_router.nama,gm_router.cid,gm_router.status');
            $this->db->from('gm_router');
			$this->db->join('gm_fiberstream','gm_fiberstream.cid = gm_router.cid');
			$this->db->order_by("bukti_pembayaran", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
       	    return $response;
    }
	
public function bcinvoice() {
            $this->db->select('*');
            $this->db->from('gm_router');
			$this->db->where("produk","FIBERSTREAM");
			$this->db->order_by("nama", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        	
			foreach ($response as $item)
			{
			$bulan = date("M");
			$tahun = date("Y");
			$data = array(
			
            'cid' => $item['cid'],
			'invoice_tahun' => $tahun,
			'invoice_bulan' => $bulan,
			'status_pembayaran' => "0",
			'bukti_pembayaran' => "",	
			);				
			$this->db->insert('gm_fiberstream', $data);
			}
			$this->session->set_flashdata('success', 'Broadcast invoice sukses.');
		
    }
	
public function get($cid) {

        if ($cid) {
            $query = $this->db->get_where('gm_fiberstream', array('cid' => $cid));
            $response = $query->result_array();
        }
        return $response;
    }
public function getcid() {

        	$this->db->select('*');
            $this->db->from('gm_router');
			$this->db->where('cid !=', 'NULL');
			$this->db->order_by("cid", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
			return $response; 
    }
	
public function simpan_invoice() {
		$tgl_inv_ex = explode(" " , $this->input->post('tanggal_invoice')); 
		$bulan = date("M", strtotime($tgl_inv_ex[0]));
		$tahun = date("Y", strtotime($tgl_inv_ex[1]));
        $data = array(
			
            'cid' => $this->input->post('cid'),
			'invoice_tahun' => $tahun,
			'invoice_bulan' => $bulan,
			'status_pembayaran' => "0",
			'bukti_pembayaran' => "",	
        );				
		$this->db->insert('gm_fiberstream', $data);
		$this->session->set_flashdata('success', 'Invoice berhasil ditambahkan');
	}
	
public function simpan_resi() {
		  $foto = "";
		  
        if (isset($_FILES['foto']) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
			if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
			{
				$cid_resi = $this->input->post('cid_resi');
				$data_resi = $this->db->get_where('gm_fiberstream',['cid' => $cid_resi])->row_array();
				$data_cid = $this->db->get_where('gm_router',['cid' => $data_resi['cid']])->row_array();
			}
			else
			{
				$data_resi = $this->db->get_where('gm_fiberstream',['cid' => $this->session->userdata('ses_cid')])->row_array();
				$data_cid = $this->db->get_where('gm_router',['cid' => $data_resi['cid']])->row_array();
			}
			//$data_resi = $this->db->get_where('gm_fiberstream',['cid' => $this->session->userdata('ses_cid')])->row_array();
			//$data_cid = $this->db->get_where('gm_router',['cid' => $data_resi['cid']])->row_array();
			if($data_resi['bukti_pembayaran'] != NULL) {
			unlink('./static/fiberstream/' .$data_resi['bukti_pembayaran']);
            }
			$config['upload_path']       = './static/fiberstream';
            $config['allowed_types']     = 'gif|jpg|png|jpeg|bmp';
            $config['max_filename']      = 40;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $foto = $this->upload->data('file_name');
            }
        }
		$this->telegram_lib->senddoc("./static/fiberstream/".$foto,"Resi INV ".$data_resi['invoice_bulan']." ".$data_resi['invoice_tahun']." - [".$data_cid['cid']."] ".$data_cid['nama']);
		
		
        $data = array(
            'bukti_pembayaran' => $foto,
        );
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{
		$this->db->where('cid', $cid_resi);
		}
		else
		{
		$this->db->where('cid', $this->session->userdata('ses_cid'));
		}
        return $this->db->update('gm_fiberstream', $data);
    }
	
	

public function abort($id) {

        if ($id) {
			$data = array(
			'status_pembayaran' => "0",
        );
            $this->db->where('id', $id);
            return $this->db->update('gm_fiberstream', $data);
        }
    }

public function aprrove($id) {

        if ($id) {
			$data = array(
			'status_pembayaran' => "1",
        );
            $this->db->where('id', $id);
            return $this->db->update('gm_fiberstream', $data);
        }
    }
	
public function reject($id) {

        if ($id) {
			$data = array(
			'status_pembayaran' => "2",
        );
            $this->db->where('id', $id);
            return $this->db->update('gm_fiberstream', $data);
        }
    }
	
//END FUNGSI	
}

