<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Index Ecport Dokumen Aplikasi
 *
 * Controller Ini sudah dialihkan pada  ./../config/routes.php
 * @access http://example_root/buku
 * @package Apps - Class Ecport.php
 * @author https://facebook.com/muh.azzain
 **/
class Export extends CI_Controller {
	// generate name user
	private $name_user;
	// generate username user
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
		$this->load->library(array('session','upload','encrypt','Excel/PHPExcel','PHPExcel/IOFactory','user_agent'));
		$this->load->model(array('m_apps','m_buku','m_warkah','m_backup','m_laporan'));
		$this->load->helper(array('form','url','html','file'));
		$this->load->dbutil();
	}

	public function index()
	{
	    $where = array(
	      'id_jenis' => $this->input->get('jenisbencana'), 
	      'id_desa' => $this->input->get('desa'),
	      'tanggal' => $this->input->get('tanggal')
	    );

        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $config = pagination_list();
        $config['base_url'] = site_url("apps/export?jenisbencana={$where['id_jenis']}&desa={$where['id_desa']}&tanggal={$where['tanggal']}");
		$config['per_page'] = 50;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->count($where);
        $this->pagination->initialize($config);
        
		$data = array(
			'title' => 'Export Data Bencana'.DEFAULT_TITLE, 
			'data' => $this->filtered($where, $config['per_page'], $page),
			'per_page' => $config['per_page'],
			'total_page' => $config['total_rows']
		);
		$this->template->view('v_export', $data);
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
	      'tanggal' => $this->input->get('tanggal')
	    );		

		$data = array('data' => $this->filtered($where, $this->count($where), 0), );
		$this->load->view('app-html/v_print_export', $data, FALSE);
	}

	/**
	 * Menghitung Jumlah Data Yang akan ditampilkan
	 *
	 * @return Integer
	 **/
	private function count( Array $data)
	{

		$this->db->join('tb_desa', 'tb_bencana.id_desa = tb_desa.id_desa');
		$this->db->join('tb_jenisbencana', 'tb_bencana.id_jenis = tb_jenisbencana.id_jenis');
		$this->db->join('tb_kecamatan', 'tb_bencana.id_kecamatan = tb_kecamatan.id_kecamatan');

		if ($data['id_jenis'] != '') $this->db->where('tb_bencana.id_jenis', $data['id_jenis']);
		if ($data['id_desa'] != '') $this->db->where('tb_bencana.id_desa', $data['id_desa']);
		if ($data['tanggal'] != '') $this->db->where('tb_bencana.tanggal', $data['tanggal']);

		$query = $this->db->get('tb_bencana');
		return $query->num_rows();
	}

	/**
	 * Menampilkan Data Dokumen Yang akan dittampilkan
	 *
	 * @return Query Result
	 **/
	public function filtered( Array $data, $limit = 50, $offset = 0) 
	{

		$this->db->join('tb_desa', 'tb_bencana.id_desa = tb_desa.id_desa');
		$this->db->join('tb_jenisbencana', 'tb_bencana.id_jenis = tb_jenisbencana.id_jenis');
		$this->db->join('tb_kecamatan', 'tb_bencana.id_kecamatan = tb_kecamatan.id_kecamatan');

		if ($data['id_jenis'] != '') $this->db->where('tb_bencana.id_jenis', $data['id_jenis']);
		if ($data['id_desa'] != '') $this->db->where('tb_bencana.id_desa', $data['id_desa']);
		if ($data['tanggal'] != '') $this->db->where('tb_bencana.tanggal', $data['tanggal']);

		$this->db->order_by('tb_bencana.id_bencana', 'desc');
		$query = $this->db->get('tb_bencana', $limit, $offset);
		return $query->result();
	}

	/**
	 * Mengimport Database Dataabse Baru
	 *
	 * @see http://stackoverflow.com/questions/25147099/how-i-can-execute-a-sql-script-with-codeigniter-and-pass-data-to-it
	 * @return Repair (Import Database)
	 **/
	public function import_database()
	{
		$data = array(
			'title' => 'Import Database'.DEFAULT_TITLE, 
		);
		$this->template->view('v_import_database', $data);
	}

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	public function insert_database()
	{
		$config['upload_path'] = './assets/backup_db'; 
		$config['allowed_types'] = 'sql';
		$config['max_size'] = 10000;
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('file_sql'))
		{
			$code = '<div class="alert alert-warning">'."\n".'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'."\n".$this->upload->display_errors()."\n".'</div>';
			$this->session->set_flashdata('alert', $code);
			redirect(site_url('apps/export/import_database'));
		} else {
			$code = '<div class="alert alert-success">'."\n".'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'."\n".'Berhasil mengimport sql. ...'."\n".'</div>';
			$this->session->set_flashdata('alert', $code);
			redirect(site_url('apps/export/import_database'));
		}

        // read derectory and file name
        $inputFileName = './assets/backup_db/'.$this->upload->file_name;
        // loaded file
		$file_restore = $this->load->file($inputFileName, true);
		$file_array = explode(';', $file_restore);

		$sqls = explode(';', $file_restore);
		array_pop($sqls);

		foreach($sqls as $statement) 
		{
		    $statment = $statement . ";";
		    $this->db->query($statement); 
		}  

		@unlink($inputFileName);
	}

	public function test()
	{
        $inputFileName = './assets/backup_db/bpbd.sql';
        // loaded file
		$file_restore = $this->load->file($inputFileName, true);
		$file_array = explode(';', $file_restore);

		$sqls = explode(';', $file_restore);
		array_pop($sqls);

		foreach($sqls as $statement) 
		{
			$statment = $statement . ";";
			//echo $statment."<hr>";
		}

		echo "<pre>";
		$test = get_mime_by_extension(FCPATH.'assets\backup_db\bpbd.sql');

		print_r($test);

		//echo FCPATH.'assets\backup_db\database_sim_bpn.sql';
	}

	/**
	 * force_download file Backup
	 *
	 * @return Zip.file
	 **/
	public function backup()
	{
        $prefs = array(     
                'format'      => 'zip',             
                'filename'    => 'ta.sql'
              );
        $backup =& $this->dbutil->backup($prefs); 

        $db_name = 'BACKUP_DATABASE_ASAMURAT-'. date("Y-m-d-H-i-s") .'.zip';

        $this->load->helper('download');
        force_download($db_name, $backup); 
	}

	/**
	 * Mengeksport Semua Data ke Excel
	 *
	 * @return php excel Output
	 **/
	public function excel()
	{
	    $where = array(
	      'id_jenis' => $this->input->get('jenisbencana'), 
	      'id_desa' => $this->input->get('desa'),
	      'tanggal' => $this->input->get('tanggal')
	    );

        $objPHPExcel = new PHPExcel();
        //buat properties file
		$objPHPExcel->getProperties()
					->setCreator("BPBD V.1.0.1")
					->setLastModifiedBy($this->name_user)
					->setTitle("Backup")
					->setSubject("BACKUP_SISTEM_BPBD")
					->setDescription("BPBD Kota Banjarbaru")
					->setKeywords("Data Dokumen Bencana")
					->setCategory("Export");
		// Create sheet DOKUMEN
		 $worksheet = $objPHPExcel->createSheet(0); // Sheet yang aktif
		// set bold header
	    for ($cell1='A'; $cell1<='I'; $cell1++) :
	        $worksheet->getStyle($cell1.'1')->getFont()->setBold(true);
	    endfor;
		// Header dokumen
		 $worksheet->setCellValue('A1', 'NO.')
				   ->setCellValue('B1', 'JENIS BENCANA')
				   ->setCellValue('C1', 'KECAMATAN')
				   ->setCellValue('D1', 'DESA')
				   ->setCellValue('E1', 'LUAS')
				   ->setCellValue('F1', 'TANGGAL')
				   ->setCellValue('G1', 'KET');
		// DATA dokumen
		$row_cell = 2; $no = 1;
		foreach($this->filtered($where, $this->count($where), 0) as $row) :
		 $worksheet->setCellValue('A'.$row_cell, $no)
				   ->setCellValue('B'.$row_cell, $row->jenis_bencana)
				   ->setCellValue('C'.$row_cell, $row->nama_kecamatan)
				   ->setCellValue('D'.$row_cell, $row->nama_desa)
				   ->setCellValue('E'.$row_cell, $row->luas)
				   ->setCellValue('F'.$row_cell, $row->tanggal)
				   ->setCellValue('G'.$row_cell, $row->ket);
		$no++; $row_cell++;
		endforeach;
		// Create Sheet DOKEMEN
		 $worksheet->setTitle("DOKUMEN");


		// Add new sheet BUKU KELUAR
		 $worksheet = $objPHPExcel->createSheet(1); // Sheet yang aktif
		// set bold header
	    for ($cell2='A'; $cell2<='I'; $cell2++) :
	        $worksheet->getStyle($cell2.'1')->getFont()->setBold(true);
	    endfor;
		// Header buku keluar
		 $worksheet->setCellValue('A1', 'NO.')
				   ->setCellValue('B1', 'JENIS BENCANA')
				   ->setCellValue('C1', 'KECAMATAN')
				   ->setCellValue('D1', 'DESA')
				   ->setCellValue('E1', 'LUAS')
				   ->setCellValue('F1', 'TANGGAL')
				   ->setCellValue('G1', 'KET');
		// DATA BUKU KELUAR
		$row_cell2 = 2; $no = 1;
		foreach($this->m_backup->buku_keluar($where) as $row) :
		 $worksheet->setCellValue('A'.$row_cell2, $no)
				   ->setCellValue('B'.$row_cell2, $row->jenis_bencana)
				   ->setCellValue('C'.$row_cell2, $row->nama_kecamatan)
				   ->setCellValue('D'.$row_cell2, $row->nama_desa)
				   ->setCellValue('E'.$row_cell2, $row->luas)
				   ->setCellValue('F'.$row_cell2, tgl_indo($row->tanggal))
				   ->setCellValue('G'.$row_cell2, $row->ket);
		$row_cell2++; $no++; 
		endforeach;
		// Create Sheet BUKU KELUAR
		$worksheet->setTitle("BUKU KELUAR");



		// Add new sheet WARKAH KELUAR
		 $worksheet = $objPHPExcel->createSheet(2); // Sheet yang aktif
		// set bold header
	    for ($cell3='A'; $cell3<='I'; $cell3++) :
	        $worksheet->getStyle($cell3.'1')->getFont()->setBold(true);
	    endfor;
		// Header warkah keluar
		 $worksheet->setCellValue('A1', 'NO.')
				   ->setCellValue('B1', 'NOMOR 208')
				   ->setCellValue('C1', 'TAHUN')
				   ->setCellValue('D1', 'KELUAR')
				   ->setCellValue('E1', 'KEMBALI')
				   ->setCellValue('F1', 'PETUGAS')
				   ->setCellValue('G1', 'PEMINJAM')
				   ->setCellValue('H1', 'KEGIATAN')
				   ->setCellValue('I1', 'STATUS');
		// DATA WARKAH KELUAR
		$row_cell3 = 2; $no = 1;
		foreach($this->m_backup->warkah_keluar($where) as $row) :
		 $worksheet->setCellValue('A'.$row_cell3, $no)
				   ->setCellValue('B'.$row_cell3, $row->no208)
				   ->setCellValue('C'.$row_cell3, $row->tahun)
				   ->setCellValue('D'.$row_cell3, tgl_indo($row->tgl_peminjaman))
				   ->setCellValue('E'.$row_cell3, tgl_indo($row->tgl_kembali))
				   ->setCellValue('F'.$row_cell3, $row->nama_lengkap)
				   ->setCellValue('G'.$row_cell3, $row->peminjam)
				   ->setCellValue('H'.$row_cell3, $row->kegiatan)
				   ->setCellValue('I'.$row_cell3, ($row->status_pinjam=='Y') ? 'KEMBALI' : 'KELUAR');
		$row_cell3++; $no++;
		endforeach;
		// Create Sheet WARKAH KELUAR
		$worksheet->setTitle("WARKAH KELUAR");


		$objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');\
        header('Content-Disposition: attachment;filename="BACKUP_SISTEM_BPBD_EXCEL.xlsx"');
        $objWriter->save("php://output");
	}


}

/* End of file Export.php */
/* Location: ./application/modules/apps/controllers/Export.php */