<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Index Data Penyimpanan
 *
 * Controller Ini sudah dialihkan pada  ./../config/routes.php
 * @access http://example_root/settingclemari
 * @package Apps - Class Pinjam_buku.php
 * @author https://facebook.com/muh.azzain
 **/
class Clemari extends CI_Controller {
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
		$this->load->model(array('m_apps','m_arsip'));
		$this->load->helper(array('form','url','html'));
	}
	public function index()
	{
		$page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("setting/clemari?data=lemari");
		$config['per_page'] = 11;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->count_all('tb_lemari');
        $this->pagination->initialize($config);

		$data = array(
			'title' => 'Manajemen Lemari'.DEFAULT_TITLE, 
			'data_lemari' => $this->db->get('tb_lemari',$config['per_page'], $page)->result()
		);

		$this->template->view('setting/v_lemari', $data);
	}

	/**
	 * menambahkan Satu lemari
	 *
	 * @return Callback
	 **/
	public function set_lemari()
	{
		switch ($this->input->get('method')) :
			case 'add':
				$jumlah_lemari = $this->m_arsip->max_name_lemari();
				$this->db->insert('tb_lemari',array('nama_lemari' => ++$jumlah_lemari));
				break;
			case 'delete':
				$this->db->delete('tb_lemari', array('no_lemari'=> $this->input->get('id')));
				$this->db->delete('tb_rak', array('no_lemari' => $this->input->get('id')));	
				$this->db->delete('tb_album', array('no_lemari' => $this->input->get('id')));
				$this->db->delete('tb_halaman', array('no_lemari' => $this->input->get('id')));
				$this->db->update(
					'tb_simpan_buku', 
					array('no_album' => 0, 'no_rak' => 0, 'no_lemari' => 0, 'no_halaman' => 0 ),
					array(
						'no_lemari' => $this->input->get('id')
					)
				);
				$this->db->delete('tb_simpan_warkah', array('no_lemari' => $this->input->get('id')));
				break;
			default:
				redirect('setting/clemari');
				break;
		endswitch;
		redirect('setting/clemari');
	}


	/**
	 * undocumented class variable
	 *
	 * @return Integer
	 **/
	public function atur_rak($rak=0)
	{
		$page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("setting/clemari/atur_rak/{$rak}?data_rak=all");
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->query("SELECT * FROM tb_rak WHERE no_lemari = '{$rak}'")->num_rows();
        $this->pagination->initialize($config);

		$query = $this->db->query("SELECT * FROM tb_rak WHERE no_lemari = '{$rak}' LIMIT {$config['per_page']} OFFSET {$page}")->result();
		$data = array(
			'title' => 'Manajemen Rak'.DEFAULT_TITLE, 
			'data_rak' => $query
		);
		$this->template->view('setting/v_rak', $data);
	}

	/**
	 * menambahkan Crud Rak
	 *
	 * @return Callback
	 **/
	public function set_rak()
	{
		$lemari = $this->input->get('lemari');
		switch ($this->input->get('method')) :
			case 'add':
				$jumlah_rak = $this->m_arsip->max_name_rak($lemari);
				$this->db->insert('tb_rak',array(
					'nama_rak' => ++$jumlah_rak,
					'no_lemari' => $lemari
				));
				break;
			case 'delete':
				$this->db->delete('tb_rak', array('no_rak'=> $this->input->get('id')));
				$this->db->delete('tb_album', array('no_rak' => $this->input->get('id')));
				$this->db->delete('tb_halaman', array('no_rak' => $this->input->get('id')));
				$this->db->update(
					'tb_simpan_buku', 
					array('no_album' => 0, 'no_rak' => 0, 'no_lemari' => 0, 'no_halaman' => 0 ),
					array(
						'no_rak' => $this->input->get('id')
					)
				);
				$this->db->delete('tb_simpan_warkah', array('no_rak' => $this->input->get('id')));
				break;
			default:
				redirect("setting/clemari/atur_rak/{$lemari}");
				break;
		endswitch;
		redirect("setting/clemari/atur_rak/{$lemari}");
	}


	/**
	 * undocumented class variable
	 *
	 * @return Integer
	 **/
	public function atur_album($rak=0)
	{
		$page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("setting/clemari/atur_album/{$rak}?data_album=all");
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->query("SELECT * FROM tb_album WHERE no_rak = '{$rak}'")->num_rows();
        $this->pagination->initialize($config);

		$query = $this->db->query("SELECT * FROM tb_album WHERE no_rak = '{$rak}' LIMIT {$config['per_page']} OFFSET {$page}")->result();
		$data = array(
			'title' => 'Manajemen Album'.DEFAULT_TITLE, 
			'data_album' => $query
		);
		$this->template->view('setting/v_album', $data);
	}

	/**
	 * menambahkan Crud Rak
	 *
	 * @return Callback
	 **/
	public function set_album()
	{
		$lemari = $this->input->get('lemari');
		$rak = $this->input->get('rak');
		switch ($this->input->get('method')) :
			case 'add':
				$jumlah_album = $this->m_arsip->max_name_album($rak, $this->input->get('doc'));
				$max = (!$this->m_arsip->max_album()) ? 0 : $this->m_arsip->max_album();
				$this->db->insert('tb_album',array(
					'no_album' => ++$max,
					'no_rak' => $rak,
					'no_lemari' => $lemari,
					'nama_album' => ++$jumlah_album,
					'document' => $this->input->get('doc')
				));
				$no_album = $max++;
				$jumlah_laman = ($this->input->get('doc')=='buku_tanah') ? 100 : 50;
				for($i=1; $i<=$jumlah_laman; $i++) :
				$this->db->insert('tb_halaman',array(
					'no_halaman' => $i,
					'no_album' => $no_album,
					'no_rak' => $rak,
					'no_lemari' => $lemari
				));
				endfor;
				break;
			case 'delete':
				$this->db->delete('tb_album', array('no_album' => $this->input->get('id')));
				$this->db->delete('tb_halaman', array('no_album' => $this->input->get('id')));
				$this->db->update(
					'tb_simpan_buku', 
					array('no_album' => 0, 'no_rak' => 0, 'no_lemari' => 0, 'no_halaman' => 0 ),
					array(
						'no_album' => $this->input->get('id')
					)
				);
				$this->db->delete('tb_simpan_warkah', array('no_album' => $this->input->get('id')));
				break;
			default:
				redirect("setting/clemari/atur_album/{$rak}");
				break;
		endswitch;
		redirect("setting/clemari/atur_album/{$rak}");
	}


	/**
	 * Menampilkan Halaman detail informasi Album
	 *
	 * @param Integer (no_album)
	 **/
	public function informasi($no_album=0)
	{
		$obj = $this->db->query("SELECT tb_album.*, tb_lemari.*, tb_rak.* FROM tb_album JOIN tb_lemari ON tb_album.no_lemari = tb_lemari.no_lemari JOIN tb_rak ON tb_album.no_rak = tb_rak.no_rak WHERE tb_album.no_album = '{$no_album}'")->row();
		$data = array(
			'title' => 'Informasi Album'.DEFAULT_TITLE, 
			'obj' => $obj
		);
		$this->template->view('setting/v_album_informasi', $data);
	}
}

/* End of file Clemari.php */
/* Location: ./application/modules/setting/controllers/Clemari.php */