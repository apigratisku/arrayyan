<?php

class Generate extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('operator_model');
		$this->load->model('member_model');
		$this->load->model('keahlian_model');
		$this->load->model('tukang_model');
		$this->load->model('tukang_alamat_model');
		$this->load->model('tukang_keahlian_model');
		$this->load->model('tukang_sertifikat_model');
		$this->load->model('toko_model');
		$this->load->model('pekerjaan_model');
		$this->load->model('pekerjaan_tukang_model');

		// patch1
		$this->load->model('sertifikat_model');

		// patch3
		$this->load->model('berita_model');
	}

	public function index() {
		$generate_operator          = $this->operator_model->generate();
		$generate_member            = $this->member_model->generate();
		$generate_keahlian          = $this->keahlian_model->generate();
		$generate_tukang            = $this->tukang_model->generate();
		$generate_tukang_alamat     = $this->tukang_alamat_model->generate();
		$generate_tukang_keahlian   = $this->tukang_keahlian_model->generate();
		$generate_tukang_sertifikat = $this->tukang_sertifikat_model->generate();
		$generate_toko              = $this->toko_model->generate();
		$generate_pekerjaan         = $this->pekerjaan_model->generate();
		$generate_pekerjaan_tukang  = $this->pekerjaan_tukang_model->generate();

		if ($generate_operator && $generate_member && $generate_keahlian && $generate_tukang && $generate_tukang_alamat && $generate_tukang_keahlian && $generate_tukang_sertifikat && $generate_toko && $generate_pekerjaan && $generate_pekerjaan_tukang) {
			echo 'success';
		} else {
			echo 'error!';
		}
	}

	public function patch1() {
		$generate_sertifikat = $this->sertifikat_model->generate();
		$rollback_tukang_sertifikat = $this->tukang_sertifikat_model->rollback();
		$generate_tukang_sertifikat = $this->tukang_sertifikat_model->generate();

		if ($generate_sertifikat && $rollback_tukang_sertifikat && $generate_tukang_sertifikat) {
			echo 'success';
		} else {
			echo 'error!';
		}
	}

	public function patch2() {
		$this->db->trans_start();
		$this->db->query("ALTER TABLE tukang MODIFY no_hp VARCHAR(12)");
		$this->db->query("ALTER TABLE tukang ADD tgl_daftar DATE");
		$this->db->query("UPDATE tukang SET tgl_daftar='2018-11-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 10");
		$this->db->query("UPDATE tukang SET tgl_daftar='2018-12-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 24");
		$this->db->query("UPDATE tukang SET tgl_daftar='2019-01-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 36");
		$this->db->query("UPDATE tukang SET tgl_daftar='2019-02-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 50");
		$this->db->query("UPDATE tukang SET tgl_daftar='2019-03-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 28");
		$this->db->query("UPDATE tukang SET tgl_daftar='2019-04-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 24");
		$this->db->query("UPDATE tukang SET tgl_daftar='2019-05-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 35");
		$this->db->query("UPDATE tukang SET tgl_daftar='2019-06-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 20");
		$this->db->query("UPDATE tukang SET tgl_daftar='2019-07-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 40");
		$this->db->query("UPDATE tukang SET tgl_daftar='2019-08-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 15");
		$this->db->query("UPDATE tukang SET tgl_daftar='2019-09-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 36");
		$this->db->query("UPDATE tukang SET tgl_daftar='2019-10-01' WHERE tgl_daftar IS NULL ORDER BY id ASC LIMIT 46");
		$query = $this->db->trans_complete();

		if ($query) {
			echo 'success';
		} else {
			echo 'error!';
		}
	}

	public function patch3() {
		$generate_berita = $this->berita_model->generate();

		if ($generate_berita) {
			echo 'success';
		} else {
			echo 'error!';
		}
	}

	public function patch4() {
		$query = $this->db->query("ALTER TABLE berita MODIFY foto VARCHAR(40)");

		if ($query) {
			echo 'success';
		} else {
			echo 'error!';
		}
	}

	public function rollback() {
		$this->db->trans_start();
		$this->db->query("DROP TABLE IF EXISTS pekerjaan_tukang");
		$this->db->query("DROP TABLE IF EXISTS pekerjaan");
		$this->db->query("DROP TABLE IF EXISTS toko");
		$this->db->query("DROP TABLE IF EXISTS tukang_alamat");
		$this->db->query("DROP TABLE IF EXISTS tukang_keahlian");
		$this->db->query("DROP TABLE IF EXISTS tukang_sertifikat");
		$this->db->query("DROP TABLE IF EXISTS tukang");
		$this->db->query("DROP TABLE IF EXISTS sertifikat");
		$this->db->query("DROP TABLE IF EXISTS keahlian");
		$this->db->query("DROP TABLE IF EXISTS member");
		$this->db->query("DROP TABLE IF EXISTS operator");
		$this->db->query("DROP TABLE IF EXISTS berita");
		$query = $this->db->trans_complete();

		if ($query) {
			echo 'success';
		} else {
			echo 'error!';
		}
	}

}
