<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Index Data peminjaman Buku Tanah
 *
 * Controller Ini sudah dialihkan pada  ./../config/routes.php
 * @access http://example_root/buku
 * @package Apps - Class Pinjam_buku.php
 * @author https://facebook.com/muh.azzain
 **/
class Pinjam_buku extends CI_Controller {
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
		$this->load->library(array('session','upload','encrypt','Excel/PHPExcel'));
		$this->load->model(array('m_apps','m_buku'));
		$this->load->helper(array('form','url','html'));
	}
	public function index()
	{
		$where = array(
		  'from' => (!$this->input->get_post('from')) ? '0000-00-00' : $this->input->get('from'), 
		  'to' => (!$this->input->get('to')) ? date('Y-m-d') : $this->input->get('to'), 
		  'jenishak' => $this->input->get('jenishak'),
		  'nohak' => $this->input->get('nohak'),
		  'desa' => $this->input->get('desa'),
		  'petugas' => $this->input->get('petugas')
		);

		$page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("buku/keluar?form={$where['from']}&to={$where['to']}&jenishak={$where['jenishak']}&petugas={$where['petugas']}");
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->m_buku->count_peminjaman($where);
        $this->pagination->initialize($config);

		$data = array(
			'title' => 'Dokumen Keluar Buku Tanah'.DEFAULT_TITLE, 
			'lemari' => $this->m_apps->lemari(),
			'hakmilik' => $this->mbpn->jenis_hak(),
			'data_pinjaman' => $this->m_buku->peminjaman($where, $config['per_page'], $page)
		);

		$this->template->view('buku/data_pinjam_buku', $data);
	}

	/**
	 * menampilkan Data Json Pinjaman Buku tanah
	 *
	 * @return Object
	 **/
	public function get_json($ID=0)
	{
		$query = $this->db->query("SELECT * FROM tb_pinjam_buku WHERE id_pinjam_buku = '{$ID}'");
		if(!$query->num_rows()) :
			$output = array('status' => false, );
		else :
			$output = array(
				'status' => true ,
				'result' => array($query->row()) 
			);
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}

	/**
	 * Mengubah Data Pinjaman Buku Tanah
	 *
	 * @var string
	 **/
	public function update($ID=0)
	{
		$where = array(
		  'from' => $this->input->post('from'), 
		  'to' => $this->input->post('to'), 
		  'jenishak' => $this->input->post('jenishak'),
		  'petugas' => $this->input->post('petugas'),
		  'page' => $this->input->post('page')
		);
		// data Update
		$data = array(
			'tgl_peminjaman' => $this->input->post('pinjam'),
			'tgl_kembali' => $this->input->post('kembali'),
			'peminjam' => $this->input->post('peminjam'),
			'kegiatan' => $this->input->post('kegiatan'),
			'status_pinjam' => $this->input->post('status') 
		);
		$this->db->update('tb_pinjam_buku', $data, array('id_pinjam_buku' => $ID));
		redirect("buku/keluar?form={$where['from']}&to={$where['to']}&jenishak={$where['jenishak']}&petugas={$where['petugas']}&page={$where['page']}");
	}

	/**
	 * Menghapus Data Pinjaman Buku Tanah
	 *
	 * @return string
	 **/
	public function delete($ID=0)
	{
		$delete = $this->db->delete('tb_pinjam_buku', array('id_pinjam_buku' => $ID));
		$output['status'] = ($delete) ? true : false;
		$this->output->set_content_type('application/json')->set_output(json_encode($output)); 
	}

	/**
	 * Mencetak Ijin Peminjaman
	 *
	 * @return string
	 **/
	public function cetak($ID=0)
	{
		$query = $this->db->query("SELECT tb_pinjam_buku.*, tb_buku_tanah.*, tb_hak_milik.*, tb_users.* FROM tb_pinjam_buku 
			INNER JOIN tb_buku_tanah ON tb_pinjam_buku.id_bencana = tb_buku_tanah.id_bencana JOIN tb_hak_milik ON tb_buku_tanah.id_hak = tb_hak_milik.id_hak JOIN tb_users ON tb_pinjam_buku.username = tb_users.username WHERE tb_pinjam_buku.id_pinjam_buku = '{$ID}'");
		$data = array(
			'title' => 'Dokumen Keluar Buku Tanah'.DEFAULT_TITLE, 
			'data' => $query->row(),
		);

		$this->load->view('app-html/buku/cetak_pinjam_buku', $data);
	}

	/**
	 * mengunduh Data Dokumen Keluar Buku Tanah
	 *
	 * @return string
	 **/
	public function unduh()
	{
		$bln = $this->input->post('bln');
		$thn = $this->input->post('thn');
	        $objPHPExcel = new PHPExcel();
	        $phpFont = new PHPExcel_Style_Font();
			$objPHPExcel->getProperties()
						->setCreator("SIM ARSIPARIS BPN RI")
						->setLastModifiedBy('Diunduh Oleh - '.$this->name_user)
						->setTitle("Laporan Peminjaman")
						->setSubject("Laporan - Peminjaman ".date('Y-m-d'))
						->setDescription("Kantor Wilayah Badan Pertanahan Nasional - Bangka Tengah")
						->setKeywords("Data Dokumen Buku Tanah")
						->setCategory("Buku Tanah");
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(5);
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(40);
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(15);
			// Set Bold
			for ($cell='A'; $cell<='J'; $cell++) :
				$objPHPExcel->getActiveSheet()->getStyle($cell.'9')->getFont()->setBold(true);
			endfor;
			$objPHPExcel->getActiveSheet()->setTitle('DATA-'.bulan($bln).'-'.$thn);
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet(0)
						->setCellValue('A9', "No.")
			            ->setCellValue('B9', "Jenis Hak")
			            ->setCellValue('C9', "No Hak")
			            ->setCellValue('D9', "Kelurahan / Desa")
			            ->setCellValue('E9', "Tanggal Peminjaman")
			            ->setCellValue('F9', "Tanggal Kembali")
			            ->setCellValue('G9', "Petugas")
			            ->setCellValue('H9', "Peminjam")
			            ->setCellValue('I9', "Kegiatan")
			            ->setCellValue('J9', "Status");
			    $no=1; $cell=10;
			    foreach($this->m_buku->laporan_pinjam($bln, $thn) as $row) :
			    	$status = ($row->status_pinjam=='N') ? 'Keluar' : 'Kembali';
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$cell,$no.'.')
							->setCellValue('B'.$cell,$row->jenis_hak)
							->setCellValue('C'.$cell,$row->no_hakbuku)
							->setCellValue('D'.$cell,(!$row->id_desa) ? '-' : $this->bpn->desa($row->id_desa))
							->setCellValue('E'.$cell,tgl_indo($row->tgl_peminjaman))
							->setCellValue('F'.$cell,tgl_indo($row->tgl_kembali))
							->setCellValue('G'.$cell,$row->nama_lengkap)
							->setCellValue('H'.$cell,$row->peminjam)
							->setCellValue('I'.$cell,$row->kegiatan)
							->setCellValue('J'.$cell,$status);
					
				$no++; $cell++; endforeach;
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="DATA-PEMINJAMAN-BUKUTANAH.xlsx"');
            $objWriter->save("php://output");
	}

}

/* End of file Pinjam_buku.php */
/* Location: ./application/modules/apps/controllers/Pinjam_buku.php */