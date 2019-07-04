<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('login')) :
            redirect(site_url('login'));
            return;
        endif;
        $data_session = $this->session->userdata('login');
        $this->name_user = $data_session['nama_lengkap'];
        $this->username = $data_session['username'];
        $this->load->model(array('m_apps'));
        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library('pdf');
    }

    function index() {
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("surat?data=surat");
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->count_all('tb_surat_masuk');
        $this->pagination->initialize($config);
        $data = array(
            'title' => 'Tambah Surat Masuk' . DEFAULT_TITLE,
            'data_surat' => $this->db->get('tb_surat_masuk', $config['per_page'], $page)->result()
        );
        $this->template->view('surat/v_smasuk', $data);
    }

    public function get_smasuk($ID = 0) {
        $data = $this->db->get_where('tb_surat_masuk', array('id_surat' => $ID));
        $output = array(
            'status' => (!$data->num_rows()) ? false : true,
            'result' => $data->result()
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
    }

    public function set_smasuk() {
        $id = $this->input->get('id');
        $ids = $this->session->userdata('login')['id'];
        $query_id = $this->db->query("SELECT MAX(id_surat) AS id_surat FROM tb_surat_masuk")->row();
        $ambil_id = ++$query_id->id_surat;

        $query_log = $this->db->query("SELECT MAX(id) AS id FROM tb_history")->row();
        $ambil_log = ++$query_log->id;
        switch ($this->input->get('method')) :
            case 'add':
                $tgl_disposisi = date("Y-m-d");

                $path = FCPATH . '/assets/doc/smasuk';
                $tmp_name = $_FILES['filed']['tmp_name'];
                $nama = $_FILES['filed']['name'];
                copy($tmp_name, "$path/$nama");

                $data_smasuk = array(
                    'id_surat' => $ambil_id + $this->input->post('id_surat'),
                    'no_surat' => $this->input->post('no'),
                    'tgl_surat' => $this->input->post('ts'),
                    'tgl_terima' => $this->input->post('tt'),
                    'asal' => $this->input->post('asal'),
                    'perihal' => $this->input->post('perihal'),
                    'keterangan' => $this->input->post('ket'),
                    'file' => $nama,
                    'tgl_disposisi' => $tgl_disposisi,
                    'status' => tempel('tb_users', 'level_akses', "id = '$ids'")
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $ids,
                    'log' => 'Menambah surat masuk',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $this->m_apps->add_save('tb_surat_masuk', $data_smasuk);
                $this->m_apps->add_save('tb_history', $dt_log);
                break;
            case 'update':
                $data_smasuk = array(
                    'asal' => $this->input->post('asal'),
                    'perihal' => $this->input->post('perihal'),
                    'tgl_surat' => $this->input->post('ts'),
                    'tgl_terima' => $this->input->post('tt'),
                    'keterangan' => $this->input->post('ket')
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $ids,
                    'log' => 'Mengedit surat masuk',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $this->m_apps->data_update('tb_surat_masuk', "id_surat = '$id'", $data_smasuk);
                $this->m_apps->add_save('tb_history', $dt_log);
                break;
            case 'delete':
                $row = $this->db->query("SELECT * FROM tb_surat_masuk WHERE id_surat = '{$id}'")->row();
                if ($row->disposisi != 'default.pdf') {
                    @unlink("./assets/doc/disposisi/{$row->disposisi}") or die('Tidak dapat menghapus file');
                }
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $ids,
                    'log' => 'Menghapus surat masuk',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $this->m_apps->hapus_data('tb_surat_masuk', "id_surat = '$id'");
                $this->m_apps->add_save('tb_history', $dt_log);
                break;
            default:
                redirect("surat");
                break;
        endswitch;
        redirect("surat");
    }

    public function cek() {
        $data = $this->db->get_where('tb_surat_masuk', array(
            'no_surat' => $this->input->post('no')
        ));
        $output = array('valid' => (!$data->num_rows()) ? true : false,);
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    function cek_pwd() {
        $username = $this->session->userdata('login')['username'];
        $password = $this->input->post('password');
        $query = $this->db->select('pass_login')->from('tb_users')->where('username', $username)->get();
        $row = $query->row();
        $output = array('valid' => (password_verify($password, $row->pass_login)) ? true : false,);
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    function addlaporan() {
        $id = $this->input->get('id');
        $source = 'assets/doc/pdf.pdf';
        $nama = date("Ymd-His") . '.pdf';
        $fcpath = "./assets/doc/disposisi/";
        $image = 'assets/images/bjb.png';
        $output = 'assets/doc/disposisi/' . $nama;

        //kosongan
        $ttd = 'assets/doc/ttd/kosong.png';
        $nol = '---------------------';

        $session = $this->session->userdata('login');
        $data_user = $this->db->query("SELECT * FROM tb_users WHERE id = '{$session['id']}'")->row();
        $digsig = 'assets/doc/ttd/' . $data_user->ttd;
        
        $query_log = $this->db->query("SELECT MAX(id) AS id FROM tb_history")->row();
        $ambil_log = ++$query_log->id;

        $sql = "SELECT disposisi FROM tb_surat_masuk WHERE id_surat = '$id'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $names = array_column($result, 'disposisi');
        $dt = $fcpath . $names[0];

        switch ($this->input->get('method')) :
            case 'add': //membuat pdf baru kalak saat modal diload
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $data_user->id,
                    'log' => 'Menindaklanjuti surat masuk',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $dok = array(
                    'disposisi' => $nama
                );
                $row = $this->db->query("SELECT * FROM tb_surat_masuk WHERE id_surat = '{$id}'")->row();
                if ($row->disposisi == 'default.pdf') {
                    $this->m_apps->data_update('tb_surat_masuk', "id_surat = '$id'", $dok);
                    $this->m_apps->add_save('tb_history', $dt_log);
                    $this->laporan($source, $output, $image, $ttd, $ttd, $ttd, $id, $nol, $nol, $nol);
                }
                break;
            case 'insert': //membuat pdf baru, menghapus yang lama, menambah tujuan dan isi kalak saat submit
                if ($names[0] != 'default.pdf') {
                    unlink($dt) or die('Tidak dapat menghapus file');
                }
                $dok = array(
                    'disposisi' => $nama,
                    'tujuan' => $this->input->post('tujuan'),
                    'isi' => $this->input->post('isi')
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $data_user->id,
                    'log' => 'Menindaklanjuti surat masuk',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $this->m_apps->data_update('tb_surat_masuk', "id_surat = '$id'", $dok);
                $this->m_apps->add_save('tb_history', $dt_log);
                $this->laporan($source, $output, $image, $ttd, $ttd, $ttd, $id, $nol, $nol, $nol);
                break;
            case 'update': //membuat pdf baru, menghapus yang lama, menambah tujuan dan isi kalak saat submit
                if ($names[0] != 'default.pdf') {
                    unlink($dt) or die('Tidak dapat menghapus file');
                }
                $dok = array(
                    'disposisi' => $nama,
                    'tgl_disposisi' => date("Ymd"),
                    'tujuan' => $this->input->post('tjn'),
                    'isi' => $this->input->post('isii'),
                    'status' => 'kabag',
                    'lvl1' => $data_user->id,
                    'lvl2' => $this->input->post('tjn'),
                    'notif' => '1',
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $data_user->id,
                    'log' => 'Menindaklanjuti surat masuk',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $pak_kalak = $data_user->nama_lengkap;
                $this->m_apps->data_update('tb_surat_masuk', "id_surat = '$id'", $dok);
                $this->m_apps->add_save('tb_history', $dt_log);
                $this->laporan($source, $output, $image, $digsig, $ttd, $ttd, $id, $pak_kalak, $nol, $nol);
                break;
            case 'agree': //membuat pdf baru, menghapus yang lama, menambah tujuan kabag saat submit
                $dt_smasuk = $this->db->query("SELECT * FROM tb_surat_masuk WHERE id_surat = '$id'")->row();
                $dt_usr_kalak = $this->db->query("SELECT * FROM tb_users WHERE id = $dt_smasuk->lvl1")->row();
                $dt_usr_kabag = $this->db->query("SELECT * FROM tb_users WHERE id = $dt_smasuk->lvl2")->row();
                $ds_kalak = 'assets/doc/ttd/' . $dt_usr_kalak->ttd;
                $ds_kabag = 'assets/doc/ttd/' . $dt_usr_kabag->ttd;
                if ($names[0] != 'default.pdf') {
                    unlink($dt) or die('Tidak dapat menghapus file');
                }
                $dok = array(
                    'disposisi' => $nama,
                    'tgl_disposisi' => date("Ymd"),
                    'tujuan' => $this->input->post('tjn_end'),
                    'status' => 'pelaksana',
                    'lvl3' => $this->input->post('tjn_end'),
                    'notif' => '1',
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $data_user->id,
                    'log' => 'Menindaklanjuti surat masuk',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $pak_kalak = $dt_usr_kalak->nama_lengkap;
                $pak_kabag = $dt_usr_kabag->nama_lengkap;
                $this->m_apps->data_update('tb_surat_masuk', "id_surat = '$id'", $dok);
                $this->m_apps->add_save('tb_history', $dt_log);
                $this->laporan($source, $output, $image, $ds_kalak, $ds_kabag, $ttd, $id, $pak_kalak, $pak_kabag, $nol);
                break;
            case 'selesai': //pelaksana
                $dt_smasuk = $this->db->query("SELECT * FROM tb_surat_masuk WHERE id_surat = '$id'")->row();
                $dt_usr_kalak = $this->db->query("SELECT * FROM tb_users WHERE id = $dt_smasuk->lvl1")->row();
                $dt_usr_kabag = $this->db->query("SELECT * FROM tb_users WHERE id = $dt_smasuk->lvl2")->row();
                $dt_usr_pelak = $this->db->query("SELECT * FROM tb_users WHERE id = $dt_smasuk->lvl3")->row();
                $ds_kalak = 'assets/doc/ttd/' . $dt_usr_kalak->ttd;
                $ds_kabag = 'assets/doc/ttd/' . $dt_usr_kabag->ttd;
                $ds_pelak = 'assets/doc/ttd/' . $dt_usr_pelak->ttd;
                if ($names[0] != 'default.pdf') {
                    unlink($dt) or die('Tidak dapat menghapus file');
                }
                $dok = array(
                    'disposisi' => $nama,
                    'tgl_disposisi' => date("Ymd"),
                    'tujuan' => '0',
                    'status' => 'selesai',
                    'notif' => '1',
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $data_user->id,
                    'log' => 'Menindaklanjuti surat masuk',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $pak_kalak = $dt_usr_kalak->nama_lengkap;
                $pak_kabag = $dt_usr_kabag->nama_lengkap;
                $pak_pelaksana = $dt_usr_pelak->nama_lengkap;
                $this->m_apps->data_update('tb_surat_masuk', "id_surat = '$id'", $dok);
                $this->m_apps->add_save('tb_history', $dt_log);
                $this->laporan($source, $output, $image, $ds_kalak, $ds_kabag, $ds_pelak, $id, $pak_kalak, $pak_kabag, $pak_pelaksana);
                break;
            default:
                redirect("surat");
                break;
        endswitch;
        redirect("surat");
    }

    function skeluar() {
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("surat/skeluar/?data=surat");
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->count_all('tb_surat_keluar');
        $this->pagination->initialize($config);
        $data = array(
            'title' => 'Tambah Surat Keluar' . DEFAULT_TITLE,
            'data_surat' => $this->db->get('tb_surat_keluar', $config['per_page'], $page)->result()
        );
        $this->template->view('surat/v_skeluar', $data);
    }

    public function get_skeluar($ID = 0) {
        $data = $this->db->get_where('tb_surat_keluar', array('id_surat' => $ID));
        $output = array(
            'status' => (!$data->num_rows()) ? false : true,
            'result' => $data->result()
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
    }

    public function set_skeluar() {
        $id = $this->input->get('id');
        $ids = $this->session->userdata('login')['id'];
        $query_id = $this->db->query("SELECT MAX(id_surat) AS id_surat FROM tb_surat_keluar")->row();
        $ambil_id = ++$query_id->id_surat;
        
        $query_log = $this->db->query("SELECT MAX(id) AS id FROM tb_history")->row();
        $ambil_log = ++$query_log->id;
        switch ($this->input->get('method')) :
            case 'add':
                
//                $path = FCPATH . '/assets/doc/skeluar';
//                $tmp_name = $_FILES['file']['tmp_name'];
//                $nama = $_FILES['file']['name'];
//                copy($tmp_name, "$path/$nama");

                $data_skeluar = array(
                    'id_surat' => $ambil_id,
                    'no_surat' => $this->input->post('nosk'),
                    'tgl_surat' => $this->input->post('tssk'),
                    'perihal' => $this->input->post('perihalsk'),
                    'tempat_tujuan' => $this->input->post('tmptjsk'),
                    'keterangan' => $this->input->post('ketsk'),
                    'tgl_proses' => date("Y-m-d"),
                    'status' => tempel('tb_users', 'level_akses', "id = '$ids'")
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $ids,
                    'log' => 'Menambah surat keluar',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $this->m_apps->add_save('tb_surat_keluar', $data_skeluar);
                $this->m_apps->add_save('tb_history', $dt_log);
                break;
            case 'update':
                $data_skeluar = array(
                    'tgl_surat' => $this->input->post('tssk'),
                    'perihal' => $this->input->post('perihalsk'),
                    'tempat_tujuan' => $this->input->post('tmptjsk'),
                    'keterangan' => $this->input->post('ketsk')
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $ids,
                    'log' => 'Mengedit surat masuk',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $this->m_apps->data_update('tb_surat_keluar', "id_surat = '$id'", $data_skeluar);
                $this->m_apps->add_save('tb_history', $dt_log);
                break;
            case 'delete':
                $row = $this->db->query("SELECT * FROM tb_surat_keluar WHERE id_surat = '{$id}'")->row();
                if ($row->surat_keluar != 'default.pdf') {
                    @unlink("./assets/doc/skeluar/{$row->surat_keluar}") or die('Tidak dapat menghapus file');
                }
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $ids,
                    'log' => 'Menghapus surat keluar',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $this->m_apps->hapus_data('tb_surat_keluar', "id_surat = '$id'");
                $this->m_apps->add_save('tb_history', $dt_log);
                break;
            default:
                redirect("surat/skeluar");
                break;
        endswitch;
        redirect("surat/skeluar");
    }

    public function cek_skeluar() {
        $data = $this->db->get_where('tb_surat_keluar', array(
            'no_surat' => $this->input->post('nosk')
        ));
        $output = array('valid' => (!$data->num_rows()) ? true : false,);
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    
    function addlaporan_sk() {
        $id = $this->input->get('id');
        $source = 'assets/doc/pdf.pdf';
        $nama = date("Ymd-His") . '.pdf';
        $fcpath = "./assets/doc/skeluar/";
        $image = 'assets/images/bjb.png';
        $output = 'assets/doc/skeluar/' . $nama;

        //kosongan
        $ttd = 'assets/doc/ttd/kosong.png';
        $nol = '---------------------';

        $session = $this->session->userdata('login');
        $data_user = $this->db->query("SELECT * FROM tb_users WHERE id = '{$session['id']}'")->row();
        $digsig = 'assets/doc/ttd/' . $data_user->ttd;
        
        $query_log = $this->db->query("SELECT MAX(id) AS id FROM tb_history")->row();
        $ambil_log = ++$query_log->id;

        $sql = "SELECT surat_keluar FROM tb_surat_keluar WHERE id_surat = '$id'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $names = array_column($result, 'surat_keluar');
        $dt = $fcpath . $names[0];

        switch ($this->input->get('method')) :
            case 'add': //membuat pdf baru admin klik generate pdf
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $data_user->id,
                    'log' => 'Generate PDF surat keluar',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $dok = array(
                    'surat_keluar' => $nama,
                );
                $row = $this->db->query("SELECT * FROM tb_surat_keluar WHERE id_surat = '{$id}'")->row();
                if ($row->tujuan == '') {
                    $this->m_apps->data_update('tb_surat_keluar', "id_surat = '$id'", $dok);
                    $this->m_apps->add_save('tb_history', $dt_log);
                    $this->laporan_skeluar($source, $output, $image, $ttd, $ttd, $ttd, $id, $nol, $nol, $nol);
                    unlink($dt) or die('Tidak dapat menghapus file');
                }
                break;
            case 'insert': //membuat pdf baru, menghapus yang lama, menambah tujuan dan isi kalak saat submit
                if ($names[0] != 'default.pdf') {
                    unlink($dt) or die('Tidak dapat menghapus file');
                }
                $dok = array(
                    'surat_keluar' => $nama,
                    'tujuan' => $this->input->post('tujuansk'),
                    'isi' => $this->input->post('isisk')
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $data_user->id,
                    'log' => 'Menindaklanjuti surat keluar',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $this->m_apps->data_update('tb_surat_keluar', "id_surat = '$id'", $dok);
                $this->m_apps->add_save('tb_history', $dt_log);
                $this->laporan_skeluar($source, $output, $image, $ttd, $ttd, $ttd, $id, $nol, $nol, $nol);
                break;
            case 'update': //membuat pdf baru, menghapus yang lama, menambah tujuan dan isi kalak saat submit
                if ($names[0] != 'default.pdf') {
                    unlink($dt) or die('Tidak dapat menghapus file');
                }
                $dok = array(
                    'surat_keluar' => $nama,
                    'tgl_proses' => date("Ymd"),
                    'tujuan' => $this->input->post('tjnsk'),
                    'isi' => $this->input->post('isiisk'),
                    'status' => 'kabag',
                    'lvl1' => $data_user->id,
                    'lvl2' => $this->input->post('tjnsk'),
                    'notif' => '1',
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $data_user->id,
                    'log' => 'Menindaklanjuti surat keluar',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $pak_kalak = $data_user->nama_lengkap;
                $this->m_apps->data_update('tb_surat_keluar', "id_surat = '$id'", $dok);
                $this->m_apps->add_save('tb_history', $dt_log);
                $this->laporan_skeluar($source, $output, $image, $digsig, $ttd, $ttd, $id, $pak_kalak, $nol, $nol);
                break;
            case 'agree': //membuat pdf baru, menghapus yang lama, menambah tujuan kabag saat submit
                $dt_skeluar = $this->db->query("SELECT * FROM tb_surat_keluar WHERE id_surat = '$id'")->row();
                $dt_usr_kalak = $this->db->query("SELECT * FROM tb_users WHERE id = $dt_skeluar->lvl1")->row();
                $dt_usr_kabag = $this->db->query("SELECT * FROM tb_users WHERE id = $dt_skeluar->lvl2")->row();
                $ds_kalak = 'assets/doc/ttd/' . $dt_usr_kalak->ttd;
                $ds_kabag = 'assets/doc/ttd/' . $dt_usr_kabag->ttd;
                if ($names[0] != 'default.pdf') {
                    unlink($dt) or die('Tidak dapat menghapus file');
                }
                $dok = array(
                    'surat_keluar' => $nama,
                    'tgl_proses' => date("Ymd"),
                    'tujuan' => $this->input->post('tjn_endingsk'),
                    'status' => 'pelaksana',
                    'lvl3' => $this->input->post('tjn_endingsk'),
                    'notif' => '1',
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $data_user->id,
                    'log' => 'Menindaklanjuti surat keluar',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $pak_kalak = $dt_usr_kalak->nama_lengkap;
                $pak_kabag = $dt_usr_kabag->nama_lengkap;
                $this->m_apps->data_update('tb_surat_keluar', "id_surat = '$id'", $dok);
                $this->m_apps->add_save('tb_history', $dt_log);
                $this->laporan_skeluar($source, $output, $image, $ds_kalak, $ds_kabag, $ttd, $id, $pak_kalak, $pak_kabag, $nol);
                break;
            case 'selesai': //pelaksana
                $dt_skeluar = $this->db->query("SELECT * FROM tb_surat_keluar WHERE id_surat = '$id'")->row();
                $dt_usr_kalak = $this->db->query("SELECT * FROM tb_users WHERE id = $dt_skeluar->lvl1")->row();
                $dt_usr_kabag = $this->db->query("SELECT * FROM tb_users WHERE id = $dt_skeluar->lvl2")->row();
                $dt_usr_pelak = $this->db->query("SELECT * FROM tb_users WHERE id = $dt_skeluar->lvl3")->row();
                $ds_kalak = 'assets/doc/ttd/' . $dt_usr_kalak->ttd;
                $ds_kabag = 'assets/doc/ttd/' . $dt_usr_kabag->ttd;
                $ds_pelak = 'assets/doc/ttd/' . $dt_usr_pelak->ttd;
                if ($names[0] != 'default.pdf') {
                    unlink($dt) or die('Tidak dapat menghapus file');
                }
                $dok = array(
                    'surat_keluar' => $nama,
                    'tgl_proses' => date("Ymd"),
                    'tujuan' => '0',
                    'status' => 'selesai',
                    'notif' => '1',
                );
                $dt_log = array(
                    'id' => $ambil_log,
                    'id_user' => $data_user->id,
                    'log' => 'Menindaklanjuti surat keluar',
                    'tanggal' => date('Y-m-d H:i:s'),
                );
                $pak_kalak = $dt_usr_kalak->nama_lengkap;
                $pak_kabag = $dt_usr_kabag->nama_lengkap;
                $pak_pelaksana = $dt_usr_pelak->nama_lengkap;
                $this->m_apps->data_update('tb_surat_keluar', "id_surat = '$id'", $dok);
                $this->m_apps->add_save('tb_history', $dt_log);
                $this->laporan_skeluar($source, $output, $image, $ds_kalak, $ds_kabag, $ds_pelak, $id, $pak_kalak, $pak_kabag, $pak_pelaksana);
                break;
            default:
                redirect("surat/skeluar");
                break;
        endswitch;
        redirect("surat/skeluar");
    }

    function laporan($source, $output, $image, $ttd_kalak, $ttd_kabag, $ttd_pelaksana, $id, $pak_kalak, $pak_kabag, $pak_pelaksana) {
        $font = 10;
        $isikanan = 130;
        $namakiri = 60;

        $pdf = new FPDI('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->setSourceFile($source);
        $tppl = $pdf->importPage(1);
        $pdf->useTemplate($tppl, 2, 2, 2, 2);
        $pdf->SetAutoPageBreak(false);
        $pdf->Image($image, 17, 10, 17.5, 23);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(213, 7, 'PEMERINTAH KOTA BANJARBARU', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(213, 7, 'BADAN PENANGGULANGAN BENCANA DAERAH', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(213, 5, 'Jl. Trikora No.1 Banjarbaru Kalimantan Selatan 70713 Telp. 085103668118 - 081253951966', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(213, 5, 'email: bpbdbanjarbaru@gmail.com', 0, 1, 'C');
        $pdf->SetLineWidth(0.5);
        $pdf->Line(200, 40, 10, 40);
        $pdf->Cell(20, 7, '', 0, 1); // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(203, 17, 'LEMBAR DISPOSISI', 0, 1, 'C');
        // start of laporan header
        $pdf->SetLineWidth(0.1);
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Perihal', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        $dt = $this->m_apps->getwhere('tb_surat_masuk', "id_surat = '$id'")->result();
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . $row->perihal, 0, 1);
        }
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Asal Surat', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . $row->asal, 0, 1);
        }
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Tanggal Surat', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . strtoupper(tgl_panjang_indo($row->tgl_surat)), 0, 1);
        }
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Nomor Surat', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . $row->no_surat, 0, 1);
        }
        // end of laporan header
        // start of laporan body
        $pdf->Cell(4, 4, '', 0, 1);
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Diterima TUMSIP', 0, 1);
        $pdf->Cell($namakiri, 6, 'Tanggal Diterima', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . strtoupper(tgl_panjang_indo($row->tgl_terima)), 0, 1);
        }
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Nomor Agenda', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . $row->id_surat, 0, 1);
        }
        $pdf->Cell(4, 4, '', 0, 1);
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Diteruskan Kepada', 0, 0);
        $pdf->Cell($isikanan, 6, 'Isi Disposisi', 0, 1, 'C');
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pgw = $row->status;
            if ($pgw == 'admin') {
                $hsl = 'Kepala Pelaksana';
            } elseif ($pgw == 'kalak') {
                $hsl = 'Kepala Pelaksana';
            } elseif ($pgw == 'kabag') {
                $hsl = 'Kepala Bagian';
            } elseif ($pgw == 'pelaksana') {
                $hsl = 'Pelaksana';
            } elseif ($pgw == 'selesai') {
                $hsl = 'Pelaksana';
            } elseif ($pgw == 'super_admin') {
                $hsl = 'Programmer';
            }
        }
        $pdf->Cell($namakiri, 6, '    ' . $hsl, 0, 1);
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Tanggal', 0, 1);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($namakiri, 6, '    ' . strtoupper(tgl_panjang_indo($row->tgl_disposisi)), 0, 0);
            $pdf->MultiCell($isikanan, $font, $row->isi, 0, 'J', 0);
        }
        // end of laporan body
        // start of laporan footer
        $pdf->SetY(-80);
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell(50, 0, 'Pelaksana', 0, 0, 'C');
        $pdf->Cell(90, 0, 'Kepala Bagian', 0, 0, 'C');
        $pdf->Cell(50, 0, 'Kepala Pelaksana', 0, 1, 'C');
        $pdf->SetFont('Arial', 'BU', $font);
        $pdf->Image($ttd_pelaksana, 10, 225, 45, 37);
        $pdf->Image($ttd_kabag, 80, 225, 45, 37);
        $pdf->Image($ttd_kalak, 150, 225, 45, 37);
//        Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
        $pdf->Cell(50, 70, $pak_pelaksana, 0, 0, 'C');
        $pdf->Cell(90, 70, $pak_kabag, 0, 0, 'C');
        $pdf->Cell(50, 70, $pak_kalak, 0, 1, 'C');
        $pdf->SetFont('Arial', '', $font);
//        $pdf->Cell(50, -60, 'NIP : XXXXXXXX XXXXXX X XXX', 0, 0, 'C');
//        $pdf->Cell(90, -60, 'NIP : XXXXXXXX XXXXXX X XXX', 0, 0, 'C');
//        $pdf->Cell(50, -60, 'NIP : XXXXXXXX XXXXXX X XXX', 0, 1, 'C');
//         $pdf->Image($ttd, 150, 10, 20, 23);
        // end of laporan footer

        $pdf->Output($output, "F");
    }
    
    function laporan_skeluar($source, $output, $image, $ttd_kalak, $ttd_kabag, $ttd_pelaksana, $id, $pak_kalak, $pak_kabag, $pak_pelaksana) {
        $font = 10;
        $isikanan = 130;
        $namakiri = 60;

        $pdf = new FPDI('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->setSourceFile($source);
        $tppl = $pdf->importPage(1);
        $pdf->useTemplate($tppl, 2, 2, 2, 2);
        $pdf->SetAutoPageBreak(false);
        $pdf->Image($image, 17, 10, 17.5, 23);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(213, 7, 'PEMERINTAH KOTA BANJARBARU', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(213, 7, 'BADAN PENANGGULANGAN BENCANA DAERAH', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(213, 5, 'Jl. Trikora No.1 Banjarbaru Kalimantan Selatan 70713 Telp. 085103668118 - 081253951966', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(213, 5, 'email: bpbdbanjarbaru@gmail.com', 0, 1, 'C');
        $pdf->SetLineWidth(0.5);
        $pdf->Line(200, 40, 10, 40);
        $pdf->Cell(20, 7, '', 0, 1); // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(203, 17, 'LEMBAR SURAT KELUAR', 0, 1, 'C');
        // start of laporan header
        $pdf->SetLineWidth(0.1);
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Perihal', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        $dt = $this->m_apps->getwhere('tb_surat_keluar', "id_surat = '$id'")->result();
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . $row->perihal, 0, 1);
        }
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, ' ', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ' ' , 0, 1);
        }
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Tanggal Surat', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . strtoupper(tgl_panjang_indo($row->tgl_surat)), 0, 1);
        }
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Nomor Surat', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . $row->no_surat, 0, 1);
        }
        // end of laporan header
        // start of laporan body
        $pdf->Cell(4, 4, '', 0, 1);
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Diserahkan TUMSIP', 0, 1);
        $pdf->Cell($namakiri, 6, 'Nomor Agenda', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . $row->id_surat, 0, 1);
        }
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Tujuan', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . $row->tempat_tujuan, 0, 1);
        }
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Keterangan', 0, 0);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($isikanan, 6, ': ' . $row->keterangan, 0, 1);
        }
        $pdf->Cell(4, 4, '', 0, 1);
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Diteruskan Kepada', 0, 0);
        $pdf->Cell($isikanan, 6, 'Isi Surat Keluar', 0, 1, 'C');
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pgw = $row->status;
            if ($pgw == 'admin') {
                $hsl = 'Kepala Pelaksana';
            } elseif ($pgw == 'kalak') {
                $hsl = 'Kepala Pelaksana';
            } elseif ($pgw == 'kabag') {
                $hsl = 'Kepala Bagian';
            } elseif ($pgw == 'pelaksana') {
                $hsl = 'Pelaksana';
            } elseif ($pgw == 'selesai') {
                $hsl = 'Pelaksana';
            } elseif ($pgw == 'super_admin') {
                $hsl = 'Kepala Pelaksana';
            }
        }
        $pdf->Cell($namakiri, 6, '    ' . $hsl, 0, 1);
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell($namakiri, 6, 'Tanggal', 0, 1);
        $pdf->SetFont('Arial', '', $font);
        foreach ($dt as $row) {
            $pdf->Cell($namakiri, 6, '    ' . strtoupper(tgl_panjang_indo($row->tgl_proses)), 0, 0);
            $pdf->MultiCell($isikanan, $font, $row->isi, 0, 'J', 0);
        }
        // end of laporan body
        // start of laporan footer
        $pdf->SetY(-80);
        $pdf->SetFont('Arial', 'B', $font);
        $pdf->Cell(50, 0, 'Pelaksana', 0, 0, 'C');
        $pdf->Cell(90, 0, 'Kepala Bagian', 0, 0, 'C');
        $pdf->Cell(50, 0, 'Kepala Pelaksana', 0, 1, 'C');
        $pdf->SetFont('Arial', 'BU', $font);
        $pdf->Image($ttd_pelaksana, 10, 225, 45, 37);
        $pdf->Image($ttd_kabag, 80, 225, 45, 37);
        $pdf->Image($ttd_kalak, 150, 225, 45, 37);
//        Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
        $pdf->Cell(50, 70, $pak_pelaksana, 0, 0, 'C');
        $pdf->Cell(90, 70, $pak_kabag, 0, 0, 'C');
        $pdf->Cell(50, 70, $pak_kalak, 0, 1, 'C');
        $pdf->SetFont('Arial', '', $font);
//        $pdf->Cell(50, -60, 'NIP : XXXXXXXX XXXXXX X XXX', 0, 0, 'C');
//        $pdf->Cell(90, -60, 'NIP : XXXXXXXX XXXXXX X XXX', 0, 0, 'C');
//        $pdf->Cell(50, -60, 'NIP : XXXXXXXX XXXXXX X XXX', 0, 1, 'C');
//         $pdf->Image($ttd, 150, 10, 20, 23);
        // end of laporan footer

        $pdf->Output($output, "F");
    }

}
