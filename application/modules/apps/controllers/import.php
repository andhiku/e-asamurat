<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Index Import Dokumen Aplikasi
 *
 * Controller Ini sudah dialihkan pada  ./../config/routes.php
 * @access http://example_root/buku
 * @package Apps - Class Import.php
 * @author https://facebook.com/muh.azzain
 **/
class Import extends CI_Controller {
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
		$this->load->library(array('session','upload','encrypt','Excel/PHPExcel','PHPExcel/IOFactory'));
		$this->load->model(array('m_apps','m_buku'));
		$this->load->helper(array('form','url','html'));
	}
	public function index()
	{
		$data = array(
			'title' => 'Import Dokumen'.DEFAULT_TITLE, 
			'hakmilik' => $this->mbpn->jenis_hak(),
			'lemari' => $this->m_apps->lemari(),
		);
		$this->template->view('v_import', $data);
	}

	/**
	 * Proses Mengimport Dokumen
	 *
	 * @return string Callback
	 **/
	public function insert_data()
	{
		$data_user = $this->session->userdata('login');
		$data = array(
			'hak' => $this->input->post('hak'),
			'kecamatan' => $this->input->post('kecamatan'),
			'desa' => $this->input->post('desa'),
		);
		$media = $this->upload->data('file_excel');
        $fileName = $media['file_name'];
        /*  NOTE : Default uploaded file Codeigniter */
        $config['upload_path'] = './assets/files/'; 
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
        $config['encrypt_name'] = FALSE;
        $this->upload->initialize($config);
        if( ! $this->upload->do_upload('file_excel') ) :
			$output['status'] = false;
			$output['error']  = 'Gagal mengimport!';
		else :
			$output['status'] = true;
			$output['error']  = null;
        endif;
        // NOTE : Ambil file_name untuk dimasukkan ke object PHPEXCEL 
        $inputFileName = './assets/files/'.$this->upload->file_name;

       try {
            // NOTE : menerima Object Excel 
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
       	} catch(Exception $e) {
			$output['status'] = false;
			$output['error']  = 'Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage();
			$output['response']  = 'Failed!';
			echo json_encode($output);
            die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage()); 
        }
        // NOTE : Excel Reader Array matriks column 
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        for ($row = 1; $row <= $highestRow; $row++) :            
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);                                         
            // Note : Sesuaikan sama nama kolom tabel di database    
			$query_id = $this->db->query("SELECT MAX(id_bencana) AS id_bencana FROM tb_buku_tanah")->row();
			$ambil_id = ++$query_id->id_bencana;
			$id_bencana = $ambil_id + $rowData[0][1]; 
            if($this->bpn->generate_id_hak( set_permalink( $rowData[0][0] ) ) == false) : continue; endif;
            // if($this->bpn->generate_id_desa( set_permalink( $rowData[0][2] ) ) == false) : continue; endif;
            // if($this->bpn->generate_id_kecamatan( set_permalink( $rowData[0][3] ) ) == false) : continue; endif;
			// data buku tanah
			$data_buku = array(
				'id_bencana' => $id_bencana,
				'id_hak' => $this->bpn->generate_id_hak( set_permalink( $rowData[0][0] ) ),
				'no_hakbuku' => $rowData[0][1],
				'tahun' => $rowData[0][6],
				'luas' => $rowData[0][4],
				'id_kecamatan' => $this->bpn->generate_id_kecamatan( set_permalink( $rowData[0][3] ) ),
				'id_desa' => $this->bpn->generate_id_desa( set_permalink( $rowData[0][2] ) ),
				'no208' => $rowData[0][5],
				'status_buku' => $rowData[0][7],
				'status_entry' => ($data_user['level_akses']=='admin') ? 'Y' : 'N',
				'pemilik_awal' => $rowData[0][8],
				'catatan_buku' => $rowData[0][9]
			);                        
            // Note : memasukkan data buku tanah 
            $this->db->insert("tb_buku_tanah",$data_buku); 
            // data peyimpanan Buku
			$data_penyimpanan = array(
				'id_bencana' => $id_bencana,
				'no_lemari' => 0,
				'no_rak' => 0,
				'no_album' => 0,
				'no_halaman' => $rowData[0][0]
			);
			$this->db->insert('tb_simpan_buku', $data_penyimpanan);
			// data warkah 
			$data_warkah = array(
				'tahun' => $rowData[0][6],
				'no208' => $rowData[0][5],
				'status_warkah' => $rowData[0][7],
				'status_entry' => ($data_user['level_akses']=='admin') ? 'Y' : 'N',
				'id_bencana' => $id_bencana,
				'catatan_warkah' => $rowData[0][10]
			);
			$this->db->insert('tb_warkah', $data_warkah);
        endfor;
        // NOte : Hapus file yang telah diambil 
        @unlink('./assets/files/'.$this->upload->file_name);
		$output['status'] = true;
		$output['response']  = 'Berhasil!';
        echo json_encode($output);
	}

}

/* End of file Import.php */
/* Location: ./application/modules/apps/controllers/Import.php */