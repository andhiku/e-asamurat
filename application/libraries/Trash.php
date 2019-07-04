<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Fungsi untuk menhapus
 *
 * @package Trash BPN
 * @author Emilio Andi Kriswanto <emilio.andhy@gmail.com>
 **/

class Trash
{
	protected $ci;

	// property tash
	public $id_bencana = 0;
	public $delete = 'all';

	// property session data
	private $username;
	private $level_akses;

	public function __construct()
	{
        $this->ci =& get_instance();
        $this->ci->load->model('mtrash');

        // initialize session data 
		$session = $this->ci->session->userdata('login');
		$this->username = $session['username'];
		$this->level_akses = $session['level_akses'];
	}

	/**
	 * Set pilihan penghapusana
	 *
	 * @return Bolean
	 **/
	public function delete($id = 0, $delete = 'all')
	{
		$this->ci->mtrash->insert($id, $this->delete);

        // initialize trash data
        $this->id_bencana = $id;
        $this->delete = $delete;

        // silahkan dipilih
        if($this->level_akses == 'super_admin')
        {
			switch ($this->delete) 
			{
				case 'all':
						$this->_all();
					break;
				
				default:
					return false;
					break;
			}
		}
	}

	/**
	 * Menghapus Dokumen Buku Tanah
	 *
	 * @return Bolean
	 **/
	private function _all()
	{
		
		$row = $this->ci->db->query("SELECT tb_buku_tanah.*, tb_warkah.* FROM tb_buku_tanah JOIN tb_warkah ON tb_buku_tanah.no208 = tb_warkah.no208 WHERE tb_buku_tanah.id_bencana = '{$this->id_bencana}'")->row();
		// Hapus File Dokumen
		$data_file_buku = $this->ci->db->query("SELECT * FROM tb_file_buku WHERE id_bencana = '{$this->id_bencana}'")->result();
		foreach($data_file_buku as $row) :
			@unlink("./assets/files/{$row->nama_file}");
		endforeach;
		$data_file_warkah = $this->ci->db->query("SELECT * FROM tb_file_warkah WHERE id_warkah = '{$row->id_warkah}'")->result();
		foreach($data_file_warkah as $row) :
			@unlink("./assets/files/{$row->nama_file}");
		endforeach;
		// Hapus Semua File
		$tables1 = array('tb_buku_tanah', 'tb_file_buku','tb_simpan_buku', 'tb_pinjam_buku','tb_history', 'tb_tong_sampah');
		$this->ci->db->where('id_bencana', $this->id_bencana);
		$this->ci->db->delete($tables1);
		$tables2 = array('tb_warkah', 'tb_file_warkah','tb_simpan_warkah', 'tb_pinjam_warkah');
		$this->ci->db->where('id_warkah', $row->id_warkah);
		$this->ci->db->delete($tables2);
	}

}

/* End of file Trash.php */
/* Location: ./application/libraries/Trash.php */
