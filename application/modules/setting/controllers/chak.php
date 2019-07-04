<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Halaman Index Data Hak Bangka Tengah
 *
 * Controller Ini sudah dialihkan pada  ./../config/routes.php
 * @access http://example_root/setting/chak
 * @package Apps - Class chak.php
 * @author https://facebook.com/muh.azzain
 * */
class Chak extends CI_Controller {

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
        $this->load->library(array('session'));
        $this->load->model(array('m_apps'));
        $this->load->helper(array('form', 'url', 'html'));
    }

    public function index() {
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("setting/chak?data=jenis");
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->count_all('tb_jenisbencana');
        $this->pagination->initialize($config);

        $data = array(
            'title' => 'Manajemen Jenis Bencana' . DEFAULT_TITLE,
            'data_bencana' => $this->db->get('tb_jenisbencana', $config['per_page'], $page)->result()
        );

        $this->template->view('setting/v_hak', $data);
    }

    /**
     * cek Jenis pada db
     *
     * @return string
     * */
    public function cek() {
        $data = $this->db->get_where('tb_jenisbencana', array('jenis_bencana' => $this->input->post('jenis_bencana')));
        $output = array('valid' => (!$data->num_rows()) ? true : false,);
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    /**
     * Menambahkah Jenis Bencana Baru
     *
     * @return string
     * */
    public function add() {
        $data_jenis = array(
            'jenis_bencana' => $this->input->post('jenis_bencana'),
            'slug_jenis_bencana' => set_permalink($this->input->post('jenis_bencana'))
        );
        $this->db->insert('tb_jenisbencana', $data_jenis);
        redirect('setting/chak');
    }

    /**
     * Mengubah Jenis Hak Baru
     *
     * @return string
     * */
    public function update($ID = 0) {
        $data_jenis = array(
            'jenis_bencana' => $this->input->post('jenis_bencana'),
            'slug_jenis_bencana' => set_permalink($this->input->post('jenis_bencana'))
        );
        $this->db->update('tb_jenisbencana', $data_jenis, array('id_jenis' => $ID));
        redirect('setting/chak');
    }

    /**
     * Menampilkan Data Jenis Bencana JSON
     *
     * @return string
     * */
    public function get($ID = 0) {
        $data = $this->db->get_where('tb_jenisbencana', array('id_jenis' => $ID));
        $output = array(
            'status' => (!$data->num_rows()) ? false : true,
            'result' => $data->result()
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
    }

    /**
     * Menghapus Data Jenis Bencana dan dokumen berkaitan
     *
     * @return string
     * */
    public function delete($ID = 0) {
        $this->db->delete('tb_jenisbencana', array('id_jenis' => $ID));
        // delete dokumen berkaitan dengan kecamatan
        $data_bencana = $this->db->get_where('tb_bencana', array('id_jenis' => $ID));
//		foreach($data_buku->result() as $row) :
//			$data_file_buku = $this->db->get_where('tb_file_tanah', array('no_hakbuku'=>$row->no_hakbuku));
//			// buku tanah
//			$this->db->delete('tb_simpan_buku', array('no_hakbuku' => $row->no_hakbuku));
//			$this->db->delete('tb_pinjam_buku', array('no_hakbuku' => $row->no_hakbuku));
//			foreach($data_file_buku->result() as $file) :
//				@unlink("./assets/files/{$file->nama_file}");
//			endforeach;
//			// warkah tanah
//			$this->db->delete('tb_simpan_warkah', array('no208' => $row->no208));
//			$this->db->delete('tb_pinjam_warkah', array('no208' => $row->no208));
//			$data_file_warkah = $this->db->get_where('tb_file_warkah', array('no208'=>$row->no208));
//			foreach($data_file_warkah->result() as $file) :
//				@unlink("./assets/files/{$file->nama_file}");
//			endforeach;
//			$this->db->delete('tb_file_warkah', array('no208' => $row->no208));
//		endforeach;
        $this->db->delete('tb_bencana', array('id_jenis' => $ID));
        redirect('setting/chak');
    }

}

/* End of file Chak.php */
/* Location: ./application/modules/setting/controllers/Chak.php */