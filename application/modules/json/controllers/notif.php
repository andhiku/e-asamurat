<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Generate Api Notification
 *
 * @access http://example_root/api
 * @package API - Class Notif.php
 * @author https://facebook.com/muh.azzain
 **/

class Notif extends CI_Controller {
	public function __construct( $id = 0)
	{
		parent::__construct();
		if ( ! $this->session->userdata('login') ) :
			redirect(site_url('login'));
			return;
		endif;
		$this->load->library(array('session','table'));
		$this->load->model(array());
		$this->load->helper(array('form','url','html'));
	}
	
	public function index()
	{

	}

	public function get($id = 0)
	{
		if(!$this->mtrash->get($id))
		{
			$data = array('status' => false, );
		} else {
			$get = $this->mtrash->get($id);
			$data = array(
				'status' => true,
				'pesan' => "<strong>{$get->nama_lengkap}</strong> memerlukan persetujuan anda untuk menghapus data " . trash($get->jenis_delete) . ".</p><hr>",
				'table' => $this->_get_buku_tanah($id) . "<hr>", 
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data, JSON_PRETTY_PRINT));
	}

	/**
	 * Menyutujui tindakan
	 *
	 * @return String (JSON)
	 **/
	public function setujui($id = 0) 
	{
		$this->trash->delete($id,'all');
		$this->output->set_content_type('application/json')->set_output(json_encode(array('status' => true)));
	}

	private function _get_buku_tanah($id = 0)
	{
		// get data from model trash
		$data = $this->mtrash->get($id);

		// set template table
		$template = array(
		        'table_open' => '<table width="100%">'
		);

		$this->table->set_template($template);

		//set Heading column
		$this->table->add_row(
			array('data' => '<strong>Jenis Hak</strong>', 'width' => '100'), 
			array('data' => ':', 'width' => '50','class' => 'text-center'), 
			array('data' => $this->bpn->hak($data->id_hak), 'width' => 200),
			array('data' => '', 'width' => 50),
			array('data' => '<strong>No 208</strong>', 'width' => '100'),
			array('data' => ':', 'width' => '50','class' => 'text-center'), 
			array('data' => $data->no208, 'width' => 200),
			array('data' => '', 'width' => 50)
		);

		$this->table->add_row(
			array('data' => '<strong>Nomor Hak</strong>', 'width' => '100'), 
			array('data' => ':', 'width' => '50','class' => 'text-center'), 
			array('data' => $data->no_hakbuku),
			array('data' => '', 'width' => 50),
			array('data' => '<strong>Tahun</strong>', 'width' => '100'),
			array('data' => ':', 'width' => '50','class' => 'text-center'), 
			array('data' => $data->tahun),
			array('data' => '', 'width' => 50)
		);

		$this->table->add_row(
			array('data' => '<strong>Kecamatan</strong>', 'width' => '100'), 
			array('data' => ':', 'width' => '50','class' => 'text-center'), 
			array('data' => $this->bpn->kecamatan($data->id_kecamatan)),
			array('data' => '', 'width' => 50),
			array('data' => '<strong>Luas</strong>', 'width' => '100'),
			array('data' => ':', 'width' => '50','class' => 'text-center'), 
			array('data' => $data->luas . "\nM<sup>3</sup>"),
			array('data' => '', 'width' => 50)
		);

		$this->table->add_row(
			array('data' => '<strong>Desa</strong>', 'width' => '100'), 
			array('data' => ':', 'width' => '50','class' => 'text-center'), 
			array('data' => $this->bpn->desa($data->id_desa)),
			array('data' => '', 'width' => 50),
			array('data' => '<strong>Status</strong>', 'width' => '100'),
			array('data' => ':', 'width' => '50','class' => 'text-center'), 
			array('data' => ($data->status_buku=='Y') ? 'Aktif' : 'Mati'),
			array('data' => '', 'width' => 50)
		);

		$this->table->add_row(
			array('data' => '<strong>Pemilik Awal</strong>', 'width' => '100'), 
			array('data' => ':', 'width' => '50','class' => 'text-center'), 
			array('data' => (!$data->pemilik_awal) ? '-' : $data->pemilik_awal),
			array('data' => '', 'width' => 50),
			array('data' => '<strong><small>Catatan Buku Tanah</small>', 'width' => '100'),
			array('data' => ':', 'width' => '50','class' => 'text-center'), 
			array('data' => (!$data->catatan_buku) ? '-' : $data->catatan_buku),
			array('data' => '', 'width' => 50)
		);

		return $this->table->generate();
	}

}

/* End of file Notif.php */
/* Location: ./application/modules/json/controllers/Notif.php */