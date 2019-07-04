<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cusers extends CI_Controller {

    private $name_user;
    private $username;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('login')) :
            redirect(site_url('login'));
            return;
        endif;
        $data_session = $this->session->userdata('login');
        $this->name_user = $data_session['nama_lengkap'];
        $this->username = $data_session['username'];
        $this->load->library(array('session', 'Excel/PHPExcel'));
        $this->load->model(array('m_apps'));
        $this->load->helper(array('form', 'url', 'html'));
    }

    public function index() {
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("setting/chak?data=hak");
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->count_all('tb_users');
        $this->pagination->initialize($config);

        $data = array(
            'title' => 'Manajemen Users' . DEFAULT_TITLE,
            'data_users' => $this->db->get('tb_users', $config['per_page'], $page)->result(),
//            'hakmilik' => $this->mbpn->jenis_hak()
        );

        $this->template->view('setting/v_users', $data);
    }

    /**
     * Mengecek Ketersediaan Username
     *
     * @return string
     * */
    public function cek() {
        $data = $this->db->get_where('tb_users', array('username' => $this->input->post('username')));
        $output = array('valid' => (!$data->num_rows()) ? true : false,);
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function add() {
        $pass = password_hash($this->input->post('pass'), PASSWORD_DEFAULT);

        $tgl = date("Y-m-d-H-i-s");
        $path = FCPATH . '/assets/doc/ttd';
        $tmp_name = $_FILES['userfile']['tmp_name'];
        $nama = $_FILES['userfile']['name'];
        $nmbaru = $tgl . '-' . $nama;
        copy($tmp_name, "$path/$nmbaru");

        $ids = $this->session->userdata('login')['id'];
        $query_log = $this->db->query("SELECT MAX(id) AS id FROM tb_history")->row();
        $ambil_log = ++$query_log->id;

        $data_user = array(
            'username' => $this->input->post('username'),
            'nama_lengkap' => $this->input->post('nama'),
//            'email' => $this->input->post('email'),
            'nama_lengkap' => $this->input->post('nama'),
            'pass_login' => $pass,
            'foto' => 'null',
            'login_terakhir' => date('Y-m-d H:i:s'),
            'level_akses' => $this->input->post('akses'),
            'id_bidang' => $this->input->post('bidang'),
            'ttd' => $tgl . '-' . $nama,
            'status_user' => 'valid',
            'status' => 'offline'
        );
        $data_userbidang = array(
            'id_bidang' => $this->input->post('bidang'),
            'nama_pegawai' => $this->input->post('nama'),
            'jabatan' => $this->input->post('akses'),
            'slug_pegawai' => set_permalink($this->input->post('nama'))
        );
        $dt_log = array(
            'id' => $ambil_log,
            'id_user' => $ids,
            'log' => 'Menambah user baru',
            'tanggal' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('tb_users', $data_user);
        $this->db->insert('tb_pegawai', $data_userbidang);
        $this->m_apps->add_save('tb_history', $dt_log);
        redirect('setting/cusers');
    }

    /**
     * undocumented class variable
     *
     * @var string
     * */
    public function block($ID = 0) {
        $ids = $this->session->userdata('login')['id'];
        $query_log = $this->db->query("SELECT MAX(id) AS id FROM tb_history")->row();
        $ambil_log = ++$query_log->id;

        switch ($this->input->get('method')) :
            case 'valid':
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $ids,
                    'log' => 'Memblokir user',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $this->db->update('tb_users', array('status_user' => 'not'), array('id' => $ID));
                $this->m_apps->add_save('tb_history', $dt_log);
                break;
            case 'not':
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $ids,
                    'log' => 'Membuka blokir user',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $this->db->update('tb_users', array('status_user' => 'valid'), array('id' => $ID));
                $this->m_apps->add_save('tb_history', $dt_log);
                break;
            default:
                redirect('setting/cusers');
                break;
        endswitch;
        redirect('setting/cusers');
    }

    public function delete($username = 0) {
        $ids = $this->session->userdata('login')['id'];
        $query_log = $this->db->query("SELECT MAX(id) AS id FROM tb_history")->row();
        $ambil_log = ++$query_log->id;

        $dt_log = array(
            'id' => $ambil_log,
            'id_user' => $ids,
            'log' => 'Menghapus user',
            'tanggal' => date('Y-m-d H:i:s'),
        );
        $data = $this->db->get_where('tb_users', array('username' => $this->input->post('username')))->row();
        @unlink("./assets/user/{$data->foto}");
        @unlink("./assets/doc/ttd/{$data->ttd}");
        $this->db->delete('tb_users', array('username' => $username));
        $this->db->delete('tb_history', array('id_user' => $data->id));
        $this->m_apps->add_save('tb_history', $dt_log);
        redirect('setting/cusers');
    }

    /**
     * undocumented class variable
     *
     * @var string
     * */
//	public function excel()
//	{
//		$where = array(
//			'bln' => $this->input->get('bln'),
//			'thn' => $this->input->get('thn'),
//			'hak' => $this->input->get('jenishak'),
//			'desa' => $this->input->get('desa')
//		);
//
//		$data_history = $this->db->query("SELECT tb_history.*, tb_buku_tanah.*, tb_hak_milik.*, tb_kecamatan.*, tb_desa.* FROM tb_history JOIN tb_buku_tanah ON tb_history.no_hakbuku = tb_buku_tanah.no_hakbuku JOIN tb_hak_milik ON tb_history.id_hak = tb_hak_milik.id_hak JOIN tb_kecamatan ON tb_history.id_kecamatan = tb_kecamatan.id_kecamatan JOIN tb_desa ON tb_history.id_desa = tb_desa.id_desa WHERE tb_history.id_hak = '{$where['hak']}' AND tb_history.id_desa = '{$where['desa']}'")->result();
//		foreach($data_history as $row) :
//			echo "string<br>";
//		endforeach;
//	}

    /**
     * get Excel data history
     *
     * @var string
     * */
//	public function getExcel()
//	{
//            $thn = $this->input->get('thn');
//		$where = array(
//			'bln' => 8,
//			'thn' => 2016,
//			'hak' => $this->input->get('jenishak'),
//			'desa' => $this->input->get('desa')
//		);
//            $objPHPExcel = new PHPExcel();
//            $phpFont = new PHPExcel_Style_Font();
//            $objPHPExcel->getProperties()
//                        ->setCreator("SIM ARSIPARIS BPN RI")
//                        ->setLastModifiedBy('Diunduh Oleh - '.$this->name_user)
//                        ->setTitle("Export Histori Users")
//                        ->setSubject("History - ".date('Y-m-d'))
//                        ->setDescription("Kantor Wilayah Badan Pertanahan Nasional - Bangka Tengah")
//                        ->setKeywords("History")
//                        ->setCategory("History");
//            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
//            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
//            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(5);
//            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(15);
//            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(30);
//            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(20);
//            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(30);
//            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);
//            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(30);
//            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(30);
//            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(30);
//            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(50);
//            for ($cell='A'; $cell<='J'; $cell++) :
//                $objPHPExcel->getActiveSheet()->getStyle($cell.'9')->getFont()->setBold(true);
//            endfor;
//            $objPHPExcel->getActiveSheet()->setTitle(bulan($where['bln']).'-'.$where['thn']);
//            $objPHPExcel->setActiveSheetIndex(0);
//            $objPHPExcel->getActiveSheet(0)
//                        ->setCellValue('A9', "NO.")
//                        ->setCellValue('B9', "USERNAME")
//                        ->setCellValue('C9', "NAMA LENGKAP")
//                        ->setCellValue('D9', "WAKTU")
//                        ->setCellValue('E9', "JENIS HAK")
//                        ->setCellValue('F9', "NO. HAK")
//                        ->setCellValue('G9', "NO. 208")
//                        ->setCellValue('H9', "KECAMATAN")
//                        ->setCellValue('I9', "DESA / KELURAHAN")
//                        ->setCellValue('J9', "KETERANGAN");
//           $data_history = $this->db->query("SELECT tb_history.*, tb_buku_tanah.*, tb_hak_milik.*, tb_kecamatan.*, tb_desa.*, tb_users.* FROM tb_history JOIN tb_buku_tanah ON tb_history.no_hakbuku = tb_buku_tanah.no_hakbuku JOIN tb_hak_milik ON tb_history.id_hak = tb_hak_milik.id_hak JOIN tb_kecamatan ON tb_history.id_kecamatan = tb_kecamatan.id_kecamatan JOIN tb_desa ON tb_history.id_desa = tb_desa.id_desa JOIN tb_users ON tb_history.username = tb_users.username WHERE tb_history.id_hak = '{$where['hak']}' AND tb_history.id_desa = '{$where['desa']}'")->result();
//            $no=1; $cell=10;
//            foreach($data_history as $row) :
//            $objPHPExcel->setActiveSheetIndex(0)
//                        ->setCellValue('A'.$cell,$no.'.')
//                        ->setCellValue('B'.$cell,$row->username)
//                        ->setCellValue('C'.$cell,$row->nama_lengkap)
//                        ->setCellValue('D'.$cell,$row->time)
//                        ->setCellValue('E'.$cell,$row->jenis_hak)
//                        ->setCellValue('F'.$cell,$row->no_hakbuku)
//                        ->setCellValue('G'.$cell,$row->no208)
//                        ->setCellValue('H'.$cell,$row->nama_kecamatan)
//                        ->setCellValue('I'.$cell,$row->nama_desa)
//                        ->setCellValue('J'.$cell,$row->deskripsi);
//            $no++; $cell++; 
//            endforeach;
//            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//           header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//            header("Cache-Control: no-store, no-cache, must-revalidate");
//            header("Cache-Control: post-check=0, pre-check=0", false);
//            header("Pragma: no-cache");
//            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//            header('Content-Disposition: attachment;filename="DATA-HISTORI-'.bulan($where['bln']).'-'.$where['thn'].'.xlsx"');
//            $objWriter->save("php://output");
//	}
//	public function tes($value='')
//	{
//		$where = array('bln' => $this->input->get('bln'), 'thn' => $this->input->get('thn') );
//            $data_history = $this->db->query("SELECT * FROM tb_history WHERE bulan = '{$where['bln']}' AND tahun = '{$where['thn']}'")->result();
//            $no=1; $cell=10;
//                foreach($data_history as $row) :
//                	echo $no++."/".$cell++."<br>"; 
//            endforeach;
//	}
}

/* End of file Cusers.php */
/* Location: ./application/modules/setting/controllers/Cusers.php */