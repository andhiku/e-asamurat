<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Generate Api
 *
 * @access http://example_root/api
 * @package Apps - Class Api.php
 * @author https://facebook.com/muh.azzain
 **/
class Api extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('login') ) :
			redirect(site_url('login'));
			return;
		endif;
		$this->load->library(array('session','upload','encrypt'));
		$this->load->model(array());
		$this->load->helper(array('form','url','html'));
	}
	public function index()
	{
		redirect('404','refresh');
	}

	public function get_listRak( $ID = 0 )
	{
		/**
		 * Menampilkan Rak by no_lemari
		 *
		 * @param Integer
		 * @return String (Object)
		 **/
		$rak = $this->db->query("SELECT * FROM tb_rak WHERE no_lemari = '{$ID}'");
		if(!$rak->num_rows()) :
			$output['status'] = false;
		else :
			$output = array( 'status' => true,'no_lemari'=> $ID, 'result' => array() );
			foreach ($rak->result() as $row) :
				$output['result'][] = array('no_rak' => $row->no_rak, 'nama_rak' => $row->nama_rak );
			endforeach;
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}
	public function get_listAlbum( $lemari = 0, $rak = 0 )
	{
		/**
		 * Menampilkan Album by no_rak
		 *
		 * @param Integer
		 * @return String (Object)
		 **/
		$album = $this->db->query("SELECT * FROM tb_album WHERE no_lemari = '{$lemari}' AND no_rak = '{$rak}' AND document = '{$this->input->get('doc')}'");
		if(!$album->num_rows()) :
			$output['status'] = false;
		else :
			$output = array( 'status' => true,'no_lemari'=> $lemari, 'no_rak' => $rak, 'result' => array() );
			foreach ($album->result() as $row) :
				$output['result'][] = array('no_album' => $row->no_album, 'nama_album' => $row->nama_album );
			endforeach;
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}
	public function get_listLaman( $lemari = 0, $rak = 0, $album = 0 )
	{
		/**
		 * Menampilakn Halaman Tersedia
		 *
		 * @param Integer
		 * @return string (Object)
		 **/
		$laman = $this->db->query("SELECT tb_halaman.*, tb_album.* FROM tb_halaman JOIN tb_album oN tb_halaman.no_album = tb_album.no_album WHERE tb_halaman.no_lemari = '{$lemari}' AND tb_halaman.no_rak = '{$rak}' AND tb_halaman.no_album = '{$album}' AND tb_album.document = 'buku_tanah'");
		if (!$laman->num_rows()) :
			$output['status'] = false;
		else :
			$output = array('status' => true, 'no_lemari' => $lemari, 'no_rak' => $rak, 'no_album' => $album, 'result' => array());
			foreach($laman->result() as $row) :
				$ketersediaan = $this->bpn->ketersediaan_buku($lemari, $rak, $album, $row->no_halaman);
				$output['results'][] = array(
					'no_halaman' => $row->no_halaman,
					'ketersediaan' => $ketersediaan
				);
			endforeach;
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}

	public function get_listLaman_warkah( $lemari = 0, $rak = 0, $album = 0 )
	{
		/**
		 * Menampilakn Halaman Tersedia
		 *
		 * @param Integer
		 * @return string (Object)
		 **/
		$laman = $this->db->query("SELECT * FROM tb_halaman WHERE no_lemari = '{$lemari}' AND no_rak = '{$rak}' AND no_album = '{$album}'");
		if (!$laman->num_rows()) :
			$output['status'] = false;
		else :
			$output = array('status' => true, 'no_lemari' => $lemari, 'no_rak' => $rak, 'no_album' => $album, 'result' => array());
			foreach($laman->result() as $row) : 
				if($row->no_halaman==51) : break; endif;
				$ketersediaan = $this->bpn->ketersediaan_warkah($lemari, $rak, $album, $row->no_halaman);
				$output['results'][] = array(
					'no_halaman' => $row->no_halaman,
					'ketersediaan' => $ketersediaan
				);
			endforeach; 
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}

	public function cek_buku( $lemari = 0, $rak = 0, $album = 0, $halaman = 0)
	{
		/**
		 * Mengecek Ketersediaan Buku Tanah
		 *
		 * @return string (Object)
		 **/
		$row = $this->db->query("SELECT tb_simpan_buku.*, tb_buku_tanah.* FROM tb_simpan_buku INNER JOIN tb_buku_tanah ON tb_simpan_buku.id_bencana = tb_buku_tanah.id_bencana WHERE tb_simpan_buku.no_lemari = '{$lemari}' AND tb_simpan_buku.no_rak = '{$rak}' AND tb_simpan_buku.no_album = '{$album}' AND tb_simpan_buku.no_halaman = '{$halaman}'")->row();
		if(!$row) :
			$output = array('status' => false, );
		else :
			$output = array(
				'status' => true,
				'result' => array(
					'jenis_hak' => $this->bpn->hak($row->id_hak),
					'no_hakbuku' => $row->no_hakbuku,
					'kecamatan' => (!$row->id_kecamatan) ? '-' : $this->bpn->kecamatan($row->id_kecamatan),
					'desa' => (!$row->id_desa) ? '-' : $this->bpn->desa($row->id_desa),
					'no208' => $row->no208,
					'tahun' => $row->tahun,
					'luas' => $row->luas,
					'status' => ($row->status_buku=='Y') ? 'Aktif' : 'Tidak Aktif',
					'pemilik' => $row->pemilik_awal,
					'catatan' => $row->catatan_buku
				)
			);
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}

	public function cek_warkah( $lemari = 0, $rak = 0, $album = 0, $halaman = 0)
	{
		/**
		 * Mengecek Ketersediaan Warkah Tanah
		 *
		 * @return string (Object)
		 **/
		$row = $this->db->query("SELECT tb_simpan_warkah.*, tb_warkah.*, tb_buku_tanah.* FROM tb_simpan_warkah JOIN tb_warkah ON tb_simpan_warkah.id_warkah = tb_warkah.id_warkah JOIN  tb_buku_tanah ON tb_warkah.id_bencana =  tb_buku_tanah.id_bencana WHERE tb_simpan_warkah.no_lemari = '{$lemari}' AND tb_simpan_warkah.no_rak = '{$rak}' AND tb_simpan_warkah.no_album = '{$album}' AND tb_simpan_warkah.no_halaman = '{$halaman}'")->row();
		if(!$row) :
			$output = array('status' => false, );
		else :
			$output = array(
				'status' => true,
				'result' => array(
					'jenis_hak' => $this->bpn->hak($row->id_hak),
					'no_hakbuku' => $row->no_hakbuku,
					'kecamatan' => (!$row->id_kecamatan) ? '-' : $this->bpn->kecamatan($row->id_kecamatan),
					'desa' => (!$row->id_desa) ? '-' : $this->bpn->desa($row->id_desa),
					'no208' => $row->no208,
					'tahun' => $row->tahun,
					'luas' => $row->luas." M",
					'status' => ($row->status_buku=='Y') ? 'Aktif' : 'Tidak Aktif',
					'pemilik' => $row->pemilik_awal,
					'catatan' => $row->catatan_warkah
				)
			);
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}

	/**
	 * Menmpilkan Data Provinsi
	 *
	 * @return string (Object)
	 **/
	public function showbidang()
	{
		$output = array('status' => true, 'results' => array() );
		$query = $this->db->query("SELECT * FROM tb_bidang");
		foreach($query->result() as $row) :
		$output['results'][] = array(
			'id_bidang' => $row->id_bidang,
			'nama_bidang' => $row->nama_bidang
		);
		endforeach;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}

	/**
	 * menampilkan Desa
	 *
	 * @return string (Object)
	 **/
	public function showpegawai($ID=0)
	{
		$output = array('status' => true, 'results' => array() );
		$query = $this->db->query("SELECT * FROM tb_pegawai WHERE id_bidang = '{$ID}'");
		foreach($query->result() as $row) :
		$output['results'][] = array(
			'id_pegawai' => $row->id_pegawai,
			'nama_pegawai' => $row->nama_pegawai,
			'jabatan' => $row->jabatan,
		);
		endforeach;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}
        
	/**
	 * menampilkan Foto
	 *
	 * @return string (Object)
	 **/
	public function showfoto($ID=0)
	{
		$output = array('status' => true, 'results' => array() );
		$query = $this->db->query("SELECT * FROM tb_foto WHERE id_bencana = '{$ID}'");
		foreach($query->result() as $row) :
		$output['results'][] = array(
			'id_foto' => $row->id_foto,
			'file_name' => $row->file_name
		);
		endforeach;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}

	/**
	 * Menampilkan Data Bpn by no_hakkbuku
	 *
	 * @param no_hakkbuku
	 * @return string Object
	 **/
	public function get($ID=0)
	{
		$row = $this->db->query("SELECT tb_buku_tanah.*, tb_simpan_buku.*, tb_warkah.* FROM tb_buku_tanah INNER JOIN tb_simpan_buku ON tb_buku_tanah.id_bencana = tb_simpan_buku.id_bencana JOIN tb_warkah ON tb_buku_tanah.no208 = tb_warkah.no208 WHERE tb_buku_tanah.id_bencana = '{$ID}'")->row();
		if(!$row) :
			$output = array('status' => false, );
		else :
			$output = array(
				'status' => true,
				'result' => array(
					'jenis_hak' => $this->bpn->hak($row->id_hak),
					'no_hakbuku' => $row->no_hakbuku,
					'kecamatan' => (!$row->id_kecamatan) ? '-' : $this->bpn->kecamatan($row->id_kecamatan),
					'desa' => (!$row->id_desa) ? '-' : $this->bpn->desa($row->id_desa),
					'no208' => $row->no208,
					'tahun' => $row->tahun,
					'luas' => $row->luas." M",
					'status' => ($row->status_buku=='Y') ? 'Aktif' : 'Tidak Aktif'
				),
				'storage' => array(
					'lemari' => $row->no_lemari,
					'rak' => $this->bpn->rak($row->no_rak),
					'lemari' => $row->no_lemari, 
					'album' => $this->bpn->album($row->no_album),
					'halaman' => $row->no_halaman
				)
			);
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}

	/**
	 * Mengecek jenis Hak apa banar jenis hak taggungan
	 *
	 * @return string
	 **/
	public function cek_jenis_hak()
	{
		$output['status'] = ($this->input->get('hak')==5) ? true : false;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	/**
	 * Menampilkan table ketersediaan pada halaman Informasi Album
	 *
	 * @var string
	 **/
	public function informasi_album($lemari = 0, $rak = 0, $album = 0)
	{
		// Halaman Buku Tanah
		$output = array('status' => true, 'no_lemari' => $lemari, 'no_rak' => $rak, 'no_album' => $album, 	);
		$obj = $this->db->query("SELECT tb_album.*, tb_lemari.*, tb_rak.* FROM tb_album JOIN tb_lemari ON tb_album.no_lemari = tb_lemari.no_lemari JOIN tb_rak ON tb_album.no_rak = tb_rak.no_rak WHERE tb_album.no_album = '{$album}'")->row();
		$output['object'] = $obj;
		$laman_buku = $this->db->query("SELECT * FROM tb_halaman WHERE no_lemari = '{$lemari}' AND no_rak = '{$rak}' AND no_album = '{$album}'");
		if (!$laman_buku->num_rows()) :
			$output['status'] = false;
			$output['results_buku'] = array();
			$output['results_warkah'] = array();
		else :
			foreach($laman_buku->result() as $row) :
				$ketersediaan = $this->bpn->ketersediaan_buku($lemari, $rak, $album, $row->no_halaman);
				$output['results_buku'][] = array(
					'no_halaman' => $row->no_halaman,
					'ketersediaan' => $ketersediaan,
					'color' => ($ketersediaan) ? 'bg-info' : 'bg-danger'
				);
			endforeach;
		endif;
		// Halaman Warkah
		$laman_warkah = $this->db->query("SELECT * FROM tb_halaman WHERE no_lemari = '{$lemari}' AND no_rak = '{$rak}' AND no_album = '{$album}'");
		if (!$laman_warkah->num_rows()) :
			$output['status_warkah'] = false;
			$output['results_buku'] = array();
			$output['results_warkah'] = array();
		else :
			foreach($laman_warkah->result() as $warkah) : 
				if($warkah->no_halaman==51) : break; endif;
				$ketersediaan = $this->bpn->ketersediaan_warkah($lemari, $rak, $album, $warkah->no_halaman);
				$output['results_warkah'][] = array(
					'no_halaman' => $warkah->no_halaman,
					'ketersediaan' => $ketersediaan,
					'color' => ($ketersediaan) ? 'bg-info' : 'bg-danger'
				);
			endforeach; 
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}
}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */