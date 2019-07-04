<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_warkah extends CI_Model {

	/**
	 * Menampilkan File Buku Tanah
	 *
	 * @return Query
	 **/
	public function file($ID=0, $id_warkah = 0)
	{
		if(!$ID) :
			$query = $this->db->query("SELECT * FROM tb_file_warkah WHERE id_warkah = '{$id_warkah}' ORDER BY mime_type = 'image/jpeg'")->result();
		else :
			$query = $this->db->query("SELECT * FROM tb_file_warkah WHERE id = {$ID}")->row();
		endif;
		return $query;
	}

	/**
	 * Mengecek Keterangan Buku, pada status peminjaman buku
	 *
	 * @return string true/false
	 **/
	public function keterangan($ID=0)
	{
		$query = $this->db->query("SELECT * FROM tb_pinjam_warkah WHERE id_warkah = '{$ID}' AND status_pinjam = 'N'");
		if(!$query->num_rows()) :
			$data = false;
		else :
			$data = true;
		endif;
		return $data;
	}

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	public function get_pinjam($ID=0)
	{
		$query = $this->db->query("SELECT * FROM tb_pinjam_warkah WHERE id_warkah = '{$ID}' AND status_pinjam = 'N'");
		return $query->row();
	}

	/**
	 * menmpilkan Data penyimpanan Warkah Tanah
	 *
	 * @var Object Array
	 **/
	public function storage($ID=0)
	{
		$query = $this->db->query("SELECT * FROM tb_simpan_warkah WHERE id_warkah = '{$ID}'");
		return $query->row();
	}


	/**
	 * Menampilkan Data Peminjaman Warkah Tanah pada Data Paging
	 *
	 * @return Query
	 **/
	public function peminjaman(Array $data, $limit = 20, $offset = 0)
	{
		$this->db->join('tb_warkah', 'tb_pinjam_warkah.id_warkah = tb_warkah.id_warkah');
		$this->db->join('tb_buku_tanah', 'tb_warkah.id_bencana = tb_buku_tanah.id_bencana');
		$this->db->join('tb_users', 'tb_pinjam_warkah.username = tb_users.username');
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');

		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['thn'] != '') $this->db->where('tb_buku_tanah.tahun', $data['thn']);
		if ($data['petugas'] != '') $this->db->where('tb_pinjam_warkah.username', $data['petugas']);
		$this->db->where('tb_pinjam_warkah.tgl_peminjaman <=', $data['to']);
		$this->db->where('tb_pinjam_warkah.tgl_peminjaman >=', $data['from']);
		$query = $this->db->get('tb_pinjam_warkah', $limit, $offset);
		return $query->result();
	}

	/**
	 * menghitung Data Pinjmana Warkah Tanah pada Data Paging
	 *
	 * @return Integer
	 **/
	public function count_peminjaman(Array $data)
	{
		$this->db->join('tb_warkah', 'tb_pinjam_warkah.id_warkah = tb_warkah.id_warkah');
		$this->db->join('tb_buku_tanah', 'tb_warkah.id_bencana = tb_buku_tanah.id_bencana');
		$this->db->join('tb_users', 'tb_pinjam_warkah.username = tb_users.username');
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');

		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['thn'] != '') $this->db->where('tb_buku_tanah.tahun', $data['thn']);
		if ($data['petugas'] != '') $this->db->where('tb_pinjam_warkah.username', $data['petugas']);
		$this->db->where('tb_pinjam_warkah.tgl_peminjaman <=', $data['to']);
		$this->db->where('tb_pinjam_warkah.tgl_peminjaman >=', $data['from']);
		$query = $this->db->get('tb_pinjam_warkah');
		return $query->num_rows();
	}

	/**
	 * menghitung Data Pinjmana Buku Tanah pada Data Paging
	 *
	 * @return Integer
	 **/
	public function laporan_pinjam($bln = 0, $thn = 0)
	{
		$query = $this->db->query("SELECT tb_pinjam_warkah.*, tb_warkah.*, tb_buku_tanah.*, tb_hak_milik.*, tb_users.* FROM tb_pinjam_warkah 
			JOIN tb_warkah ON tb_pinjam_warkah.id_warkah = tb_warkah.id_warkah JOIN tb_buku_tanah ON tb_warkah.id_bencana = tb_buku_tanah.id_bencana JOIN tb_hak_milik ON tb_buku_tanah.id_hak = tb_hak_milik.id_hak JOIN tb_users ON tb_pinjam_warkah.username = tb_users.username WHERE tb_pinjam_warkah.bulan = '{$bln}' AND tb_pinjam_warkah.tahun = '{$thn}'");
		return $query->result();
	}
}

/* End of file M_warkah.php */
/* Location: ./application/modules/apps/models/M_warkah.php */