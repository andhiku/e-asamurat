<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjam_warkah extends CI_Controller {
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
		$this->load->model(array('m_apps','m_buku','m_warkah'));
		$this->load->helper(array('form','url','html'));
	}
	public function index()
	{
		$where = array(
		  'from' => (!$this->input->get_post('from')) ? '0000-00-00' : $this->input->get('from'), 
		  'to' => (!$this->input->get('to')) ? date('Y-m-d') : $this->input->get('to'), 
		  'no208' => $this->input->get('no208'),
		  'thn' => $this->input->get('thn'),
		  'petugas' => $this->input->get('petugas')
		);

		$page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("warkah/keluar?form={$where['from']}&to={$where['to']}&no208={$where['no208']}&thn={$where['thn']}&petugas={$where['petugas']}");
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->m_warkah->count_peminjaman($where);
        $this->pagination->initialize($config);

		$data = array(
			'title' => 'Dokumen Keluar Buku Tanah'.DEFAULT_TITLE, 
			'lemari' => $this->m_apps->lemari(),
			'hakmilik' => $this->mbpn->jenis_hak(),
			'data_pinjaman' => $this->m_warkah->peminjaman($where, $config['per_page'], $page)
		);

		$this->template->view('warkah/data_pinjam_warkah', $data);
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
		$this->db->update('tb_pinjam_warkah', $data, array('id_pinjam_warkah' => $ID));
		redirect("warkah/keluar?form={$where['from']}&to={$where['to']}&jenishak={$where['jenishak']}&petugas={$where['petugas']}&page={$where['page']}");
	}

	/**
	 * menampilkan Data Json Pinjaman Warkah tanah
	 *
	 * @return Object
	 **/
	public function get_json($ID=0)
	{
		$query = $this->db->query("SELECT * FROM tb_pinjam_warkah WHERE id_pinjam_warkah = '{$ID}'");
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
	 * Mencetak Ijin Peminjaman
	 *
	 * @return string
	 **/
	public function cetak($ID=0)
	{
		$query = $this->db->query("SELECT tb_pinjam_warkah.*, tb_warkah.*, tb_buku_tanah.*, tb_users.* FROM tb_pinjam_warkah 
		 JOIN tb_warkah ON tb_pinjam_warkah.id_warkah = tb_warkah.id_warkah JOIN tb_buku_tanah ON tb_warkah.id_bencana = tb_buku_tanah.id_bencana JOIN tb_users ON tb_pinjam_warkah.username = tb_users.username WHERE tb_pinjam_warkah.id_pinjam_warkah = '{$ID}'");
		// JOIN tb_buku_tanah ON tb_buku_tanah.id_bencana = tb_warkah.id_bencana JOIN tb_hak_milik ON tb_buku_tanah.id_hak = tb_hak_milik.id_hak 
		$data = array(
			'title' => 'Dokumen Keluar Buku Tanah'.DEFAULT_TITLE, 
			'data' => $query->row(),
		);

		$this->load->view('app-html/warkah/cetak_pinjam_warkah', $data);
	}

	/**
	 * Menghapus Data Pinjaman Buku Tanah
	 *
	 * @return string
	 **/
	public function delete($ID=0)
	{
		$delete = $this->db->delete('tb_pinjam_warkah', array('id_pinjam_warkah' => $ID));
		$output['status'] = ($delete) ? true : false;
		$this->output->set_content_type('application/json')->set_output(json_encode($output)); 
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
						->setKeywords("Data Dokumen Warkah Tanah")
						->setCategory("Warkah Tanah");
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
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(15);
			// Set Bold
			for ($cell='A'; $cell<='K'; $cell++) :
				$objPHPExcel->getActiveSheet()->getStyle($cell.'1')->getFont()->setBold(true);
			endfor;
			$objPHPExcel->getActiveSheet()->setTitle('DATA-'.bulan($bln).'-'.$thn);
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet(0)
						->setCellValue('A1', "No.")
			            ->setCellValue('B1', "Jenis Hak")
			            ->setCellValue('C1', "No. 208")
			            ->setCellValue('D1', "Nomor Hak")
			            ->setCellValue('E1', "Desa Kelurahan")
			            ->setCellValue('F1', "Tanggal Peminjaman")
			            ->setCellValue('G1', "Tanggal Kembali")
			            ->setCellValue('H1', "Petugas")
			            ->setCellValue('I1', "Peminjam")
			            ->setCellValue('J1', "Kegiatan")
			            ->setCellValue('K1', "Status");
			    $no=1; $cell=2;
			    foreach($this->m_warkah->laporan_pinjam($bln, $thn) as $row) :
			    	$status = ($row->status_pinjam=='N') ? 'Keluar' : 'Kembali';
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$cell,$no.'.')
							->setCellValue('B'.$cell,$row->jenis_hak)
							->setCellValue('C'.$cell,$row->no208)
							->setCellValue('D'.$cell,$row->no_hakbuku)
							->setCellValue('E'.$cell,(!$row->id_desa) ? '-' : $this->bpn->desa($row->id_desa))
							->setCellValue('F'.$cell,tgl_indo($row->tgl_peminjaman))
							->setCellValue('G'.$cell,tgl_indo($row->tgl_kembali))
							->setCellValue('H'.$cell,$row->nama_lengkap)
							->setCellValue('I'.$cell,$row->peminjam)
							->setCellValue('J'.$cell,$row->kegiatan)
							->setCellValue('K'.$cell,$status);
					
				$no++; $cell++; endforeach;
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="DATA-PEMINJAMAN-WARKAHTANAH.xlsx"');
            $objWriter->save("php://output");
	}
}

/* End of file Pinjam_warkah.php */
/* Location: ./application/modules/apps/controllers/Pinjam_warkah.php */