<?php

class M_firewall_filter extends CI_Model {

    public function __construct() {
	
        $this->load->database();
		$this->load->library('secure');
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_firewall', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_firewall');
			//$this->db->limit(1, 1500);
			//$this->db->where("ip", "116.139.137.201");
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function get_ix() {

		$this->db->select('*');
		$this->db->from('blip_torch_ix');
		$this->db->where('isp !=', 'NULL');
		$this->db->order_by("rx", "desc");
		$this->db->limit(200, 1);
		$query = $this->db->get();
		$arr = json_encode($query->result_array());
      	return $arr;
    }
	
	public function index_ix() {
            $this->db->select('*');
            $this->db->from('blip_torch_ix');
			$this->db->order_by("rx", "desc");
			$this->db->limit(200, 1);
            $query = $this->db->get();
            $response = $query->result_array();
        	return $response;
    }
	
	public function get_torch_ix($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_torch_ix', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_torch_ix');
			$this->db->where("xcek", "0");
			$this->db->order_by("rx", "asc");
			$this->db->limit(1, 0);
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	

	public function get_torch_iix($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_torch_iix', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_torch_iix');
			//$this->db->limit(1, 1500);
			//$this->db->where("ip", "116.139.137.201");
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function get_torch_content($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_torch_content', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_torch_content');
			//$this->db->limit(1, 1500);
			//$this->db->where("ip", "116.139.137.201");
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
    public function import($id) {
		$teid = $this->db->get_where('gm_te', array('id' => $id))->row_array();
		
		$te_ip = $this->secure->decrypt_url($teid['ip']);
		$te_user = $this->secure->decrypt_url($teid['user']);
		$te_pass = $this->secure->decrypt_url($teid['pass']);
		$te_port = $teid['port'];
		
        if ($this->routerosapi->connect($te_ip,$te_user,$te_pass,$te_port)){
		$this->routerosapi->write('/ip/firewall/address-list/print', false);	
		$this->routerosapi->write("=.proplist=list", false);
		$this->routerosapi->write("=.proplist=address", false);					
		$this->routerosapi->write("?list=attacker");		
		$addr = $this->routerosapi->read();
			foreach($addr as $getaddr){
			$firewall = $this->db->get_where('blip_firewall', array('ip' => $getaddr['address'], 'source' => $id))->num_rows();
				if($firewall == 0){
				$data = array(
					'ip' => $getaddr['address'],
					'source' => $id,
				);				
				$insert_firewall = $this->db->insert('blip_firewall', $data);
				}
			}
		return $this->session->set_flashdata('success','Data firewall address berhasil ditambahkan !');
		}else{
		return $this->session->set_flashdata('error', 'Login gagal. Pastikan hostname, username dan password benar sudah !');
		}
    }
	
	public function syncdata() {
		$data_ip = $this->get();
			foreach($data_ip as $ipaddr){
				if(empty($ipaddr['country'])){
				$ip = $ipaddr['ip'];
				$ch = curl_init('http://ipwhois.app/json/'.$ip);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$json = curl_exec($ch);
				curl_close($ch);
				// Decode JSON response
				$details = json_decode($json, true);
				$data = array(
					'country' => $details['country'],
					'country_capital' => $details['country_capital'],
					'region' => $details['region'],
					'city' => $details['city'],
					'latitude' => $details['latitude'],
					'longitude' => $details['longitude'],
					'asn' => $details['asn'],
					'isp' => $details['isp'],
					'timezone' => $details['timezone'],
				);				
				$this->db->where('id', $ipaddr['id']);
				$update_db = $this->db->update('blip_firewall', $data);
				}
			}
			echo $this->session->set_flashdata('success','Data firewall berhasil di sinkronisasi');
    }
	public function syncdata_ix() {
		$data_ip = $this->get_torch_ix();
			foreach($data_ip as $ipaddr){
				if(empty($ipaddr['xcek'])){
				$ip = $ipaddr['ip'];
				$ch = curl_init('http://ipwhois.app/json/'.$ip);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$json = curl_exec($ch);
				curl_close($ch);
				// Decode JSON response
				$details = json_decode($json, true);
				$data = array(
					'country' => $details['country'],
					'country_capital' => $details['country_capital'],
					'region' => $details['region'],
					'city' => $details['city'],
					'latitude' => $details['latitude'],
					'longitude' => $details['longitude'],
					'asn' => $details['asn'],
					'isp' => $details['isp'],
					'timezone' => $details['timezone'],
					'xcek' => "1",
				);				
				$this->db->where('id', $ipaddr['id']);
				$this->db->update('blip_torch_ix', $data);
				}
			}
			return print("Data IX berhasil di sinkronisasi ".$ipaddr['ip']." - ".$ipaddr['xcek']);
    }
	public function syncdata_iix() {
		$data_ip = $this->get_torch_iix();
			foreach($data_ip as $ipaddr){
				if(empty($ipaddr['country'])){
				$ip = $ipaddr['ip'];
				$ch = curl_init('http://ipwhois.app/json/'.$ip);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$json = curl_exec($ch);
				curl_close($ch);
				// Decode JSON response
				$details = json_decode($json, true);
				$data = array(
					'country' => $details['country'],
					'country_capital' => $details['country_capital'],
					'region' => $details['region'],
					'city' => $details['city'],
					'latitude' => $details['latitude'],
					'longitude' => $details['longitude'],
					'asn' => $details['asn'],
					'isp' => $details['isp'],
					'timezone' => $details['timezone'],
				);				
				$this->db->where('id', $ipaddr['id']);
				$update_db = $this->db->update('blip_torch_iix', $data);
				}
			}
			echo $this->session->set_flashdata('success','Data IIX berhasil di sinkronisasi');
    }
	public function syncdata_content() {
		$data_ip = $this->get_torch_content();
			foreach($data_ip as $ipaddr){
				if(empty($ipaddr['country'])){
				$ip = $ipaddr['ip'];
				$ch = curl_init('http://ipwhois.app/json/'.$ip);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$json = curl_exec($ch);
				curl_close($ch);
				// Decode JSON response
				$details = json_decode($json, true);
				$data = array(
					'country' => $details['country'],
					'country_capital' => $details['country_capital'],
					'region' => $details['region'],
					'city' => $details['city'],
					'latitude' => $details['latitude'],
					'longitude' => $details['longitude'],
					'asn' => $details['asn'],
					'isp' => $details['isp'],
					'timezone' => $details['timezone'],
				);				
				$this->db->where('id', $ipaddr['id']);
				$update_db = $this->db->update('blip_torch_content', $data);
				}
			}
			echo $this->session->set_flashdata('success','Data Content berhasil di sinkronisasi');
    }

}