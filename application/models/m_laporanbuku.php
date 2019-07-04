<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporanbuku extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	function bukuAktif($id,$tahun)
	{
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');
		$this->db->where('tb_buku_tanah.id_hak',$id);
		$this->db->where('tb_buku_tanah.tahun',$tahun);
		$this->db->where('tb_buku_tanah.status_buku','Y');
		$query = $this->db->get('tb_buku_tanah');
		return $query->num_rows();
	}
	function bukuMati($id,$tahun)
	{
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');
		$this->db->where('tb_buku_tanah.id_hak',$id);
		$this->db->where('tb_buku_tanah.tahun',$tahun);
		$this->db->where('tb_buku_tanah.status_buku','N');
		$query = $this->db->get('tb_buku_tanah');
		return $query->num_rows();
	}
	function bukuAktif_All($id)
	{
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');
		$this->db->where('tb_buku_tanah.id_hak',$id);
		$this->db->where('tb_buku_tanah.status_buku','Y');
		$query = $this->db->get('tb_buku_tanah');
		return $query->num_rows();
	}
	function bukuMati_All($id)
	{
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');
		$this->db->where('tb_buku_tanah.id_hak',$id);
		$this->db->where('tb_buku_tanah.status_buku','N');
		$query = $this->db->get('tb_buku_tanah');
		return $query->num_rows();
	}
	function bukuLuas($id,$tahun)
	{
		$this->db->where('id_hak',$id);
		$this->db->where('tahun',$tahun);
		$this->db->select_sum('luas');
		$query = $this->db->get('tb_buku_tanah');
		return $query->result();
	}
	function bukuLuas_All($id)
	{
		$this->db->where('id_hak',$id);
		$this->db->select_sum('luas');
		$query = $this->db->get('tb_buku_tanah');
		return $query->result();
	}
	function jenisHakNum()
	{
		$query = $this->db->get('tb_hak_milik');
		return $query->num_rows();
	}
}

/* End of file m_laporanbuku.php */
/* Location: ./application/models/m_laporanbuku.php */