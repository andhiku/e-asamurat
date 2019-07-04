<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_backup extends CI_Model {

	/**
	 * Menampilkna Data DOkumen pad fitur ekspor excel
	 *
	 * @return Query
	 **/
	public function dokumen()
	{
		$query= $this->db->query("SELECT tb_buku_tanah.*, tb_hak_milik.*, tb_kecamatan.*, tb_desa.* FROM tb_buku_tanah JOIN tb_hak_milik ON tb_buku_tanah.id_hak = tb_hak_milik.id_hak JOIN tb_kecamatan ON tb_buku_tanah.id_kecamatan = tb_kecamatan.id_kecamatan JOIN tb_desa ON tb_buku_tanah.id_desa = tb_desa.id_desa")->result();
		return $query;
	}

	/**
	 * Menampilkan Data buku keluar
	 *
	 * @return Query
	 **/
	public function buku_keluar(Array $data)
	{

		$this->db->join('tb_buku_tanah', 'tb_pinjam_buku.id_bencana = tb_buku_tanah.id_bencana');
		$this->db->join('tb_desa', 'tb_buku_tanah.id_desa = tb_desa.id_desa');
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');
		$this->db->join('tb_kecamatan', 'tb_buku_tanah.id_kecamatan = tb_kecamatan.id_kecamatan');
		$this->db->join('tb_users', 'tb_pinjam_buku.username = tb_users.username');

		if ($data['id_hak'] != '') $this->db->where('tb_buku_tanah.id_hak', $data['id_hak']);
		if ($data['no_hakbuku'] != '') $this->db->where('tb_buku_tanah.no_hakbuku', $data['no_hakbuku']);
		if ($data['id_desa'] != '') $this->db->where('tb_buku_tanah.id_desa', $data['id_desa']);
		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['thn'] != '') $this->db->where('tb_buku_tanah.tahun', $data['thn']);

		if ($data['bln'] != '') $this->db->where('tb_pinjam_buku.bulan', $data['bln']);
		if ($data['thn_pinjam'] != '') $this->db->where('tb_pinjam_buku.tahun', $data['thn_pinjam']);

		$this->db->order_by('tb_buku_tanah.id_bencana', 'desc');
		$query = $this->db->get('tb_pinjam_buku');
		return $query->result();
	}

	/**
	 * Menampilkan Data Warkah Keluar
	 *
	 * @return Query
	 **/
	public function warkah_keluar(Array $data)
	{
		$this->db->join('tb_warkah', 'tb_pinjam_warkah.id_warkah = tb_warkah.id_warkah');
		$this->db->join('tb_buku_tanah', 'tb_warkah.id_bencana = tb_buku_tanah.id_bencana');
		$this->db->join('tb_users', 'tb_pinjam_warkah.username = tb_users.username');
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');

		if ($data['id_hak'] != '') $this->db->where('tb_buku_tanah.id_hak', $data['id_hak']);
		if ($data['no_hakbuku'] != '') $this->db->where('tb_buku_tanah.no_hakbuku', $data['no_hakbuku']);
		if ($data['id_desa'] != '') $this->db->where('tb_buku_tanah.id_desa', $data['id_desa']);
		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['thn'] != '') $this->db->where('tb_buku_tanah.tahun', $data['thn']);

		if ($data['bln'] != '') $this->db->where('tb_pinjam_warkah.bulan', $data['bln']);
		if ($data['thn_pinjam'] != '') $this->db->where('tb_pinjam_warkah.tahun', $data['thn_pinjam']);

		$this->db->order_by('tb_buku_tanah.id_bencana', 'desc');
		$query = $this->db->get('tb_pinjam_warkah');
		return $query->result();
	}

	/**
	 * Menampilkan Data Kecamatan
	 *
	 * @return string
	 **/
	public function kecamatan()
	{
		$query = $this->db->query("SELECT * FROM tb_kecamatan")->result();
		return $query;
	}

	/**
	 * Menghitung luas per kecamatan
	 *
	 * @return Integer
	 **/
	public function luas_kecamatan($id_kecamatan=0)
	{
		$query = $this->db->query("SELECT luas FROM tb_buku_tanah WHERE id_kecamatan = '{$id_kecamatan}'")->result();
		$luas = 0;
		foreach($query as $row) :
			$luas += $row->luas;
		endforeach;
		return $luas;
	}

	/**
	 * Menampilkan Data Desa by kecamatan
	 *
	 * @param Integer
	 * @return string
	 **/
	public function desa()
	{
		$query = $this->db->query("SELECT * FROM tb_desa")->result();
		return $query;
	}

	/**
	 * Menghitung luas per kecamatan
	 *
	 * @return Integer
	 **/
	public function luas_desa($id_desa=0)
	{
		$query = $this->db->query("SELECT luas FROM tb_buku_tanah WHERE id_desa = '{$id_desa}'")->result();
		$luas = 0;
		foreach($query as $row) :
			$luas += $row->luas;
		endforeach;
		return $luas;
	}
}

/* End of file M_backup.php */
/* Location: ./application/modules/apps/models/M_backup.php */