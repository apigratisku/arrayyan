<?php

class Mapping_model extends CI_Model {

    public function __construct() {
        $this->load->database();
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
            $query = $this->db->get('gm_mapping');
            $response = $query->result_array();
        }

        return $response;
    }
	public function get_result() {
		//$this->db->select("(SELECT MIN(jarak) FROM gm_mapping_result) AS jarak_mapping",FALSE);
		//$query = $this->db->get('gm_mapping_result');
		$this->db->select_min('jarak');
		$this->db->order_by('jarak', 'ASC');
		$result = $this->db->get('gm_mapping_result')->row(); 
		$query = $this->db->get_where('gm_mapping_result', array('jarak' => $result->jarak));
        $response = $query->row_array();
		$tarikan_spare = $response['jarak']+75;
		return $response['odp']." ".$tarikan_spare." ".$response['site']; 
    }

    public function simpan() {
        $data = array(
            'odp' => $this->input->post('odp'),
			'lat' => $this->input->post('lat'),
			'long' => $this->input->post('long'),
			'site' => $this->input->post('site'),
        );
        return $this->db->insert('gm_mapping', $data);
    }

    public function timpa($id) {
       $data = array(
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
	
	
	
		
	public function mapping_fs($lat,$long) {
	$this->db->truncate('gm_mapping_result');
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
            'odp' => $kordinat_odp['odp'],
			'jarak' => $jarak,
			'site' => $kordinat_odp['site'],
        );
        
		$this->db->insert('gm_mapping_result', $data);

		}
		//$return_data = $kordinat_odp['odp']." ".$this->get_result();
		return $this->get_result();
		
	}
	
	public function mapping_fs_new($lat,$long,$earthRadius = 6371000)
	{
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
            'odp' => $kordinat_odp['odp'],
			'jarak' => $result_jarak,
			'site' => $kordinat_odp['site'],
        );
        
		$this->db->insert('gm_mapping_result', $data);

		}
		return $this->get_result();
	  
	}
	
	
	public function mapping_we($lat,$long,$status,$tinggi,$bts,$capel) {
	if($status == "OK" || $status == "ok" || $status == "Ok") {$LOS = "Tercover";} else {$LOS = "Tidak Tercover";}
		date_default_timezone_set("Asia/Singapore");
		$date_now = date("M/d/Y");
		$data_capel = array(
						'media' => "WE",
						'odp' => "",
						'jarak' => $tinggi,
						'lat' => $lat,
						'long' => $long,
						'capel' => $capel,
						'site' => $bts,
						'status' => $LOS,
						'date' => $date_now,
					);	
		return $this->db->insert('gm_mapping_capel', $data_capel);
		
	}
	
	
	
	
}
