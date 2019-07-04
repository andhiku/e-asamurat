<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctim extends CI_Controller {

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
        $config['base_url'] = site_url("setting/ctim?data=tim");
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->count_all('tb_tim');
        $this->pagination->initialize($config);

        $data = array(
            'title' => 'Manajemen Tim Petugas Lapangan' . DEFAULT_TITLE,
            'data_tim' => $this->db->get('tb_tim', $config['per_page'], $page)->result()
        );

        $this->template->view('setting/v_tim', $data);
    }

    /**
     * Menambahkah Jenis Tim Baru
     *
     * @return string
     * */
    public function cek() {
        $data = $this->db->get_where('tb_tim', array('nama_tim' => $this->input->post('nama_tim')));
        $output = array('valid' => (!$data->num_rows()) ? true : false,);
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function add() {
        $data_tim = array(
            'nama_tim' => $this->input->post('nama_tim')
        );
        $this->db->insert('tb_tim', $data_tim);
        redirect('setting/ctim');
    }

    public function update($ID = 0) {
        $data_tim = array(
            'nama_tim' => $this->input->post('nama_tim')
        );
        $this->db->update('tb_tim', $data_tim, array('id_tim' => $ID));
        redirect('setting/ctim');
    }

    /**
     * Menampilkan Data Jenis Bencana JSON
     *
     * @return string
     * */
    public function get($ID = 0) {
        $data = $this->db->get_where('tb_tim', array('id_tim' => $ID));
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
        $this->db->delete('tb_tim', array('id_tim' => $ID));
        // delete dokumen berkaitan dengan tim
        $data_tim = $this->db->get_where('tb_tim', array('id_tim' => $ID));
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
        $this->db->delete('tb_tim', array('id_tim' => $ID));
        redirect('setting/ctim');
    }

}

/* End of file Chak.php */
/* Location: ./application/modules/setting/controllers/Chak.php */