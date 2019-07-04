<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informasi extends CI_Controller {

	private $name_user;
	private $username;

	public function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('login') ) :
			redirect(site_url('login'));
			return;
		endif;
		$data_session = $this->session->userdata('login');
		$this->name_user = $data_session['nama_lengkap'];
		$this->username = $data_session['username'];
		$this->load->library(array('session'));
		$this->load->model(array('m_apps'));
		$this->load->helper(array('form','url','html'));
	}

	public function index()
	{
	    $where = array(
	      'id_jenis' => $this->input->get('jenisbencana'), 
	      'id_desa' => $this->input->get('desa'),
//	      'no_hakbuku' => $this->input->get('nohak'),
//	      'no208' => $this->input->get('no208'),
	      'tanggal' => $this->input->get('tanggal'),
//	      'storage' => $this->input->get('storage'),
//	      'pemilik' => $this->input->get('pemilik'),
//	      'status' => $this->input->get('status')
	    );

        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $config = pagination_list();
        $config['base_url'] = site_url("informasi?jenisbencana={$where['id_jenis']}&tanggal={$where['tanggal']}&desa={$where['id_desa']}");
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->count($where);
        $this->pagination->initialize($config);
        
		$data = array(
			'title' => 'Informasi Data Bencana Belum Tersimpan'.DEFAULT_TITLE, 
			'data' => $this->filtered($where, $config['per_page'], $page),
			'per_page' => $config['per_page'],
			'total_page' => $config['total_rows']
		);
		$this->template->view('v_informasi', $data);
	}

	/**
	 * Menghitung Jumlah Data Yang belo tersimpan
	 *
	 * @return Integer
	 **/
	private function count( Array $data)
	{

	//	$this->db->join('tb_desa', 'tb_buku_tanah.id_desa = tb_desa.id_desa');
		$this->db->join('tb_jenisbencana', 'tb_bencana.id_jenis = tb_jenisbencana.id_jenis');
//		$this->db->join('tb_simpan_buku', 'tb_buku_tanah.id_bencana = tb_simpan_buku.id_bencana');

//		if($data['storage']=='belum') :
//			$this->db->where('tb_simpan_buku.no_lemari', 0);	
//			$this->db->where('tb_simpan_buku.no_rak', 0);	
//			$this->db->where('tb_simpan_buku.no_album', 0);	
//			$this->db->where('tb_simpan_buku.no_halaman', 0);
//		elseif($data['storage']=='sudah') :
//			$this->db->where('tb_simpan_buku.no_lemari !=', 0);	
//			$this->db->where('tb_simpan_buku.no_rak !=', 0);	
//			$this->db->where('tb_simpan_buku.no_album !=', 0);	
//			$this->db->where('tb_simpan_buku.no_halaman !=', 0);
//		endif;

		if ($data['id_jenis'] != '') $this->db->where('tb_bencana.id_jenis', $data['id_jenis']);
//		if ($data['no_hakbuku'] != '') $this->db->where('tb_buku_tanah.no_hakbuku', $data['no_hakbuku']);
		if ($data['id_desa'] != '') $this->db->where('tb_bencana.id_desa', $data['id_desa']);
//		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['tanggal'] != '') $this->db->where('tb_bencana.tanggal', $data['tanggal']);
//		if ($data['pemilik'] != '') $this->db->like('tb_buku_tanah.pemilik_awal', $data['pemilik']);
//		if ($data['status'] != '') $this->db->where('tb_buku_tanah.status_buku', $data['status']);

		$query = $this->db->get('tb_bencana');
		return $query->num_rows();
	}


	/**
	 * Menampilkan Data Dokumen Yang belum tersimpan
	 *
	 * @return Query Result
	 **/
	public function filtered( Array $data, $limit = 50, $offset = 0) 
	{

		//$this->db->join('tb_desa', 'tb_buku_tanah.id_desa = tb_desa.id_desa');
		$this->db->join('tb_jenisbencana', 'tb_bencana.id_jenis = tb_jenisbencana.id_jenis');
//		$this->db->join('tb_simpan_buku', 'tb_buku_tanah.id_bencana = tb_simpan_buku.id_bencana');

//		if($data['storage']=='belum') :
//			$this->db->where('tb_simpan_buku.no_lemari', 0);	
//			$this->db->where('tb_simpan_buku.no_rak', 0);	
//			$this->db->where('tb_simpan_buku.no_album', 0);	
//			$this->db->where('tb_simpan_buku.no_halaman', 0);
//		elseif($data['storage']=='sudah') :
//			$this->db->where('tb_simpan_buku.no_lemari !=', 0);	
//			$this->db->where('tb_simpan_buku.no_rak !=', 0);	
//			$this->db->where('tb_simpan_buku.no_album !=', 0);	
//			$this->db->where('tb_simpan_buku.no_halaman !=', 0);
//		endif;

		if ($data['id_jenis'] != '') $this->db->where('tb_bencana.id_jenis', $data['id_jenis']);
//		if ($data['no_hakbuku'] != '') $this->db->where('tb_buku_tanah.no_hakbuku', $data['no_hakbuku']);
		if ($data['id_desa'] != '') $this->db->where('tb_bencana.id_desa', $data['id_desa']);
//		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['tanggal'] != '') $this->db->where('tb_bencana.tahun', $data['tanggal']);
//		if ($data['pemilik'] != '') $this->db->like('tb_buku_tanah.pemilik_awal', $data['pemilik']);
//		if ($data['status'] != '') $this->db->where('tb_buku_tanah.status_buku', $data['status']);

		$this->db->order_by('tb_bencana.id_jenis', 'desc');
		$query = $this->db->get('tb_bencana', $limit, $offset);
		return $query->result();
	}


	/**
	 * Mengeprint Data Belum tersimpan berdasarkan FIltered Data
	 *
	 * @return Print Page
	 **/
	public function cetak()
	{
	    $where = array(
	      'id_jenis' => $this->input->get('jenisbencana'), 
	      'id_desa' => $this->input->get('desa'),
//	      'no_hakbuku' => $this->input->get('nohak'),
//	      'no208' => $this->input->get('no208'),
	      'tanggal' => $this->input->get('tanggal'),
//	      'storage' =>$this->input->get('storage'),
//	      'pemilik' => $this->input->get('pemilik'),
//	      'status' => $this->input->get('status')
	    );		

		$data = array('data' => $this->filtered($where, $this->count($where), 0), );
		$this->load->view('app-html/v_print_informasi', $data, FALSE);
	}


}

/* End of file Belum_tersimpan.php */
/* Location: ./application/controllers/Belum_tersimpan.php */