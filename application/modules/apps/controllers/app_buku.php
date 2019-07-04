<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class App_buku extends CI_Controller {
    private $name_user;
    private $username;
    private $_ID;
    private $_url;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('login')) :
            redirect(site_url('login'));
            return;
        endif;
        $data_session = $this->session->userdata('login');
        $this->name_user = $data_session['nama_lengkap'];
        $this->username = $data_session['username'];
        $this->load->library(array('session', 'upload', 'encrypt'));
        $this->load->model(array('m_apps', 'm_buku'));
        $this->load->helper(array('form', 'url', 'html'));
    }

    public function index() {
        $data = array(
            'title' => 'Tambah Data Bencana' . DEFAULT_TITLE,
        );
        $this->template->view('buku/add_buku', $data);
    }

    public function insert() {
//        $data_user = $this->session->userdata('login');
        $query_id = $this->db->query("SELECT MAX(id_bencana) AS id_bencana FROM tb_bencana")->row();
        $ambil_id = ++$query_id->id_bencana;
        $id_bencana = $ambil_id + $this->input->post('id_bencana');
        $data_buku = array(
            'id_bencana' => $id_bencana,
            'waktu' => $this->input->post('waktu'),
            'tanggal' => $this->input->post('tanggal'),
            'alamat' => $this->input->post('alamat'),
            'id_kecamatan' => $this->input->post('kecamatan'),
            'id_desa' => $this->input->post('desa'),
            'id_jenis' => $this->input->post('jenis'),
            'luas' => $this->input->post('luas'),
            'sebab' => $this->input->post('sebab'),
            'kk' => $this->input->post('kk'),
            'jiwa' => $this->input->post('jiwa'),
            'rusak_ringan' => $this->input->post('rusak_ringan'),
            'rusak_sedang' => $this->input->post('rusak_sedang'),
            'rusak_berat' => $this->input->post('rusak_berat'),
            'f_pendidikan' => $this->input->post('f_pendidikan'),
            'f_peribadatan' => $this->input->post('f_peribadatan'),
            'f_kesehatan' => $this->input->post('f_kesehatan'),
            'kerugian' => $this->input->post('kerugian'),
            'id_tim' => implode(',', $this->input->post('tim')),
            'ket' => $this->input->post('ket')
//            'ket' => ($data_user['level_akses'] == 'admin' OR $data_user['level_akses'] == 'super_admin') ? 'Y' : 'N'
        );

        $path = "assets/bencana/"; // Lokasi folder untuk menampung file
        if (!empty($_FILES['foto']['name'])) {
            foreach ($_FILES['foto']['name'] as $f => $name) {
                if ($_FILES['foto']['error'][$f] == 4) {
                    continue; // Skip file if any error found
                } else { // No error found! Move uploaded files 
                    if ($_FILES['foto']['error'][$f] == 0) {
                        move_uploaded_file($_FILES["foto"]["tmp_name"][$f], $path . $name);
                        $this->m_apps->unggah($name, $id_bencana);
                    }
                }
            }
        }
        $this->db->insert('tb_bencana', $data_buku);
        $this->session->set_flashdata('success', 'Data telah ditambahkan.');
        redirect('buku/create');
    }

}
