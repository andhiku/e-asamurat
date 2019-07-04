<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_arsip extends CI_Model {

	/**
	 * Menghitung Data Rak
	 *
	 * @return Array
	 **/
	public function count_rak($lemari=0)
	{
		$query = $this->db->query("SELECT * FROM tb_rak WHERE no_lemari = '{$lemari}'");
		return (!$query->num_rows()) ? '-' : $query->num_rows();
	}

	/**
	 * Menghitung Data Album
	 *
	 * @return Array
	 **/
	public function count_album($lemari=0, $rak=0, $doc = '')
	{
		if(!$rak) :
			$query = $this->db->query("SELECT * FROM tb_album WHERE no_lemari = '{$lemari}' AND document = '{$doc}'");
		else :
			$query = $this->db->query("SELECT * FROM tb_album WHERE no_rak = '{$rak}' AND document = '{$doc}'");
		endif;
		return (!$query->num_rows()) ? '-' : $query->num_rows();
	}

	/**
	 * Menghitung Data Buku
	 *
	 * @return Array
	 **/
	public function count_buku($lemari=0, $rak=0, $album=0)
	{
		if(!$rak AND !$album) :
			$query = $this->db->query("SELECT * FROM tb_simpan_buku WHERE no_lemari = '{$lemari}'");
		elseif(!$lemari AND !$album) :
			$query = $this->db->query("SELECT * FROM tb_simpan_buku WHERE no_rak = '{$rak}'");
		elseif(!$lemari AND !$rak) :
			$query = $this->db->query("SELECT * FROM tb_simpan_buku WHERE no_album = '{$album}'");
		endif;
		return (!$query->num_rows()) ? '-' : $query->num_rows();
	}

	/**
	 * Menghitung Data Warkha
	 *
	 * @return Array
	 **/
	public function count_warkah($lemari=0, $rak=0, $album=0)
	{
		if(!$rak AND !$album) :
			$query = $this->db->query("SELECT * FROM tb_simpan_warkah WHERE no_lemari = '{$lemari}'");
		elseif(!$lemari AND !$album) :
			$query = $this->db->query("SELECT * FROM tb_simpan_warkah WHERE no_rak = '{$rak}'");
		elseif(!$lemari AND !$rak) :
			$query = $this->db->query("SELECT * FROM tb_simpan_warkah WHERE no_album = '{$album}'");
		endif;
		return (!$query->num_rows()) ? '-' : $query->num_rows();
	}

	/* MAX NAME AREA*/
	public function max_name_lemari()
	{
		$query = $this->db->query("SELECT MAX(nama_lemari) as nama_lemari FROM tb_lemari")->row();
		return $query->nama_lemari;
	}
	public function max_name_rak($lemari=0)
	{
		$query = $this->db->query("SELECT MAX(nama_rak) as nama_rak FROM tb_rak WHERE no_lemari = '{$lemari}'")->row();
		return $query->nama_rak;
	}
	public function max_name_album($rak=0, $doc = '')
	{
		$query = $this->db->query("SELECT MAX(nama_album) as nama_album FROM tb_album WHERE no_rak = '{$rak}' AND document = '{$doc}'")->row();
		return $query->nama_album;
	}
	public function max_album()
	{
		$query = $this->db->query("SELECT MAX(no_album) as no_album FROM tb_album")->row();
		return $query->no_album;
	}
}

/* End of file M_arsip.php */
/* Location: ./application/modules/setting/models/M_arsip.php */