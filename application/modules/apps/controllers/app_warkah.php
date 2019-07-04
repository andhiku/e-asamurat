<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Index Warkah Aplikasi
 *
 * Controller Ini sudah dialihkan pada  ./../config/routes.php
 * @access http://example_root/buku
 * @package Apps - Class App_warkah.php
 * @author https://facebook.com/muh.azzain
 **/
class App_warkah extends CI_Controller {

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
		$this->load->library(array('session','upload','encrypt'));
		$this->load->model(array('m_apps','m_buku','m_warkah'));
		$this->load->helper(array('form','url','html'));
	}

	public function index()
	{
		$where = array( 'no' => $this->input->get('no'), 'thn' => $this->input->get('thn') );
		// Query Pencarian Data Buku Tanah
		$data = array(
			'title' => 'Cari Warkah Tanah'.DEFAULT_TITLE, 
		);
		$query = $this->db->query("SELECT tb_warkah.*, tb_buku_tanah.* FROM tb_warkah JOIN  tb_buku_tanah ON tb_warkah.id_bencana =  tb_buku_tanah.id_bencana WHERE tb_warkah.no208 = '{$where['no']}' AND tb_warkah.tahun = '{$where['thn']}'");
		// Transfer Data Ke views
		$data['data'] = $query->row();
		// insert history
		if($query->num_rows() >= 1) :
		// data history
			$row = $query->row();
		$data_history = array(
			'username' => $this->username,
			'tanggal' => date('Y-m-d'),
			'time' => date('Y-m-d H:i:s'),
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'id_bencana' => $data['data']->id_bencana,
			'deskripsi' => "Mencari dokumen warkah.", 
		);
			$this->db->insert('tb_history', $data_history);
			$data['storage'] = $this->m_warkah->storage($query->row()->id_warkah);
		endif;
		$this->template->view('warkah/search_warkah', $data);
	}

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	public function get($ID=0)
	{
		$row = $this->db->query("SELECT tb_warkah.*, tb_buku_tanah.* FROM tb_warkah INNER JOIN  tb_buku_tanah ON tb_warkah.no208 =  tb_buku_tanah.no208 WHERE tb_warkah.id_warkah = '{$ID}'")->row();
		$data = array(
			'title' => 'Edit Warkah Tanah'.DEFAULT_TITLE, 
			'lemari' => $this->m_apps->lemari(),
			'hakmilik' => $this->mbpn->jenis_hak(),
			'data' => $row,
			'file' => $this->m_warkah->file(0, $ID),
			'storage' => $this->m_warkah->storage($ID)
		);
		$this->template->view('warkah/edit_warkah', $data);
	}

	/**
	 * Update Penyimpanan Warkah Tanah
	 *
	 * @return string
	 **/
	public function update_penyimpanan($ID=0)
	{
		$row = $this->db->query("SELECT tb_warkah.*, tb_buku_tanah.* FROM tb_warkah JOIN tb_buku_tanah ON tb_warkah.id_bencana =  tb_buku_tanah.id_bencana WHERE tb_warkah.id_warkah = '{$ID}'")->row();
		$simpan = $this->db->query("SELECT * FROM tb_simpan_warkah WHERE id_warkah = '{$ID}'")->row();
		// Updating Warkah (Catatan)
		$this->db->update('tb_warkah', array('catatan_warkah' => $this->input->post('catatan')), array('id_warkah' => $ID));
		// jika data penyimpanan tidak tersedian dan user mengklik simpan
		if(!$this->input->post('lemari') AND !$this->input->post('rak') AND !$this->input->post('album') AND !$this->input->post('no_halaman'))
			redirect("warkah/document/{$ID}?t=storage");
		$data_penyimpanan = array(
			'id_warkah' => $ID,
			'no_lemari' => (!$this->input->post('lemari')) ? $simpan->no_lemari : $this->input->post('lemari'),
			'no_rak' => (!$this->input->post('rak')) ? $simpan->no_rak : $this->input->post('rak'),
			'no_album' => (!$this->input->post('album')) ? $simpan->no_album : $this->input->post('album'),
			'no_halaman' => (!$this->input->post('no_halaman')) ? $simpan->no_halaman : $this->input->post('no_halaman')
		);

		if(!$this->m_warkah->storage($ID)) :
			$this->db->insert('tb_simpan_warkah', $data_penyimpanan); 
		else :
			$this->db->update('tb_simpan_warkah', $data_penyimpanan, array('id_warkah'=>$ID));
		endif;
		// data history
		$data_history = array(
			'username' => $this->username,
			'tanggal' => date('Y-m-d'),
			'time' => date('Y-m-d H:i:s'),
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'id_bencana' => $row->id_bencana,
			'deskripsi' => "Mengubah penyimpanan dokumen warkah.", 
		);
		$this->db->insert('tb_history', $data_history);
		redirect("warkah/document/{$ID}?t=storage");
	}

	/**
	 * meminjam Buku Tanah
	 *
	 * @return string
	 **/
	public function pinjam_warkah($ID=0)
	{
		$data = $this->db->query("SELECT tb_warkah.*, tb_buku_tanah.* FROM tb_warkah INNER JOIN  tb_buku_tanah ON tb_warkah.id_bencana =  tb_buku_tanah.id_bencana WHERE tb_warkah.id_warkah = '{$ID}'")->row();
		// data history
		$data_history = array(
			'username' => $this->username,
			'tanggal' => date('Y-m-d'),
			'time' => date('Y-m-d H:i:s'),
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'id_bencana' => $data->id_bencana,
			'deskripsi' => "mengeluarkan dokumen warkah.", 
		);
		// data pinjam
		$data_pinjam = array(
			'id_warkah' => $ID,
			'tgl_peminjaman' => date('Y-m-d'),
			'tgl_kembali' => '0000-00-00',
			'kegiatan' => $this->input->post('kegiatan'),
			'peminjam' => $this->input->post('peminjam'),
			'username' => $this->username,
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'status_pinjam' => 'N'
		);
		$this->db->insert('tb_pinjam_warkah', $data_pinjam);
		$this->db->insert('tb_history', $data_history);
		$data_print = $this->db->query("SELECT MAX(id_pinjam_warkah) AS id_pinjam_warkah FROM tb_pinjam_warkah")->row();
		redirect("warkah/search?no={$data->no208}&thn={$data->tahun}&print=true&data_print={$data_print->id_pinjam_warkah}");
	}

	/**
	 * Mengembalikan Buku yang keluar
	 *
	 * @return string
	 **/
	public function kembali_warkah($ID=0)
	{
		$row = $this->db->query("SELECT * FROM tb_warkah WHERE id_warkah = '{$ID}'")->row();
		$data = $this->db->query("SELECT tb_warkah.*, tb_buku_tanah.* FROM tb_warkah INNER JOIN  tb_buku_tanah ON tb_warkah.id_bencana =  tb_buku_tanah.id_bencana WHERE tb_warkah.id_warkah = '{$ID}'")->row();
		// data history
		$data_history = array(
			'username' => $this->username,
			'tanggal' => date('Y-m-d'),
			'time' => date('Y-m-d H:i:s'),
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'id_bencana' => $data->id_bencana,
			'deskripsi' => "Mengembalikan dokumen warkah.", 
		);
		// data kembali
		$data_kembali = array(
			'tgl_kembali' => date('Y-m-d'),
			'status_pinjam' => 'Y'
		);
		$this->db->update('tb_pinjam_warkah', $data_kembali, array('id_warkah'=>$ID, 'status_pinjam' => 'N'));
		$this->db->insert('tb_history', $data_history);
		redirect("warkah/search?no={$row->no208}&thn={$row->tahun}");
	}

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	public function selipkan()
	{
		// Query mengambil data peyimpanan
		$obj = $this->db->query("SELECT tb_album.*, tb_lemari.*, tb_rak.* FROM tb_album JOIN tb_lemari ON tb_album.no_lemari = tb_lemari.no_lemari JOIN tb_rak ON tb_album.no_rak = tb_rak.no_rak WHERE tb_album.no_album = '{$this->input->post('album')}'")->row();
		// Query Cek Warkah dengan no208 dan tahun
		$warkah = $this->db->query("SELECT * FROM tb_warkah WHERE no208 = '{$this->input->post('no')}' AND tahun = '{$this->input->post('thn')}'")->row();

		// Authenfikasi
		if(!$warkah) :
			$output = array('status' => false);
		else :
			$cek_warkah = $this->db->get_where('tb_simpan_warkah', array('id_warkah'=>$warkah->id_warkah))->num_rows();
			// data yng akan disimpan
			$data_penyimpanan = array(
				'id_warkah' => $warkah->id_warkah,
				'no_lemari' => $obj->no_lemari,
				'no_rak' => $obj->no_rak,
				'no_album' => $this->input->post('album'),
				'no_halaman' => $this->input->post('halaman')
			);
			// cek apabila sebelumnya sudah tersimpan
			if(!$cek_warkah) :
				$this->db->insert('tb_simpan_warkah', $data_penyimpanan);
			else :
				$this->db->update('tb_simpan_warkah', $data_penyimpanan, array('id_warkah'=> $warkah->id_warkah));
			endif;
			$output = array('status' => true);
		endif;
		
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
}

/* End of file App_warkah.php */
/* Location: ./application/modules/apps/controllers/App_warkah.php */	