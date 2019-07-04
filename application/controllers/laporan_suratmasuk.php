<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_suratmasuk extends CI_Controller {

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
        $this->level_akses = $data_session['level_akses'];
        $this->load->library(array('session', 'upload', 'encrypt', 'Excel/PHPExcel'));
        $this->load->helper(array('form', 'url', 'html'));
    }

    public function index() {        
        $where = array(
            'status' => $this->input->get('status'),
            'bln' => $this->input->get('bln'),
            'thn' => $this->input->get('thn')
        );

        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $config = pagination_list();
        $config['base_url'] = site_url("laporan_suratmasuk?status={$where['status']}&thn={$where['thn']}&bln={$where['bln']}");
        $config['per_page'] = 50;
        $config['uri_segment'] = 4;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->count($where);
        $this->pagination->initialize($config);

        $data = array(
            'title' => 'Laporan Surat Masuk' . DEFAULT_TITLE,
//            'status' => $this->mbpn->status(),
            'data_surat_masuk' => $this->filtered($where, $config['per_page'], $page)
        );
        $this->template->view('laporan/v_laporan_suratmasuk', $data);
    }

    /**
     * Query Where data suratmasuk
     *
     * @return string
     * */
    public function filtered(Array $data, $limit = 50, $offset = 0) {
//        $this->db->join('tb_surat_masuk', 'tb_users.id_jenis = tb_jenisbencana.id_jenis');

        if ($data['status'] != '')
            $this->db->where('tb_surat_masuk.status', $data['status']);
        if ($data['bln'] != '')
            $this->db->where('MONTH(tb_surat_masuk.tgl_disposisi)', $data['bln']);
        if ($data['thn'] != '')
            $this->db->where('YEAR(tb_surat_masuk.tgl_disposisi)', $data['thn']);
        $this->db->order_by('id_surat', 'desc');
        $query = $this->db->get('tb_surat_masuk', $limit, $offset);
        return $query->result();
    }

    public function count(Array $data) {
//        $this->db->join('tb_jenisbencana', 'tb_bencana.id_jenis = tb_jenisbencana.id_jenis');
        
        if ($data['status'] != '')
            $this->db->where('tb_surat_masuk.status', $data['status']);
        if ($data['bln'] != '')
            $this->db->where('MONTH(tb_surat_masuk.tgl_disposisi)', $data['bln']);
        if ($data['thn'] != '')
            $this->db->where('YEAR(tb_surat_masuk.tgl_disposisi)', $data['thn']);

        $query = $this->db->get('tb_surat_masuk');
        return $query->num_rows();
    }

    /**
     * Menampilkan Cetak Data suratmasuk
     *
     * @return pages print
     * */
    public function cetak() {
        $data = array(
            'status' => $this->input->get('status'),
            'bln' => $this->input->get('bln'),
            'thn' => $this->input->get('thn')
        );
        
//        $this->db->join('tb_desa', 'tb_bencana.id_desa = tb_desa.id_desa');

        if ($data['status'] != '')
            $this->db->where('tb_surat_masuk.status', $data['status']);
//        if ($data['id_desa'] != '')
//            $this->db->where('tb_bencana.id_desa', $data['id_desa']);
        if ($data['bln'] != '')
            $this->db->where('MONTH(tb_surat_masuk.tgl_disposisi)', $data['bln']);
        if ($data['thn'] != '')
            $this->db->where('YEAR(tb_surat_masuk.tgl_disposisi)', $data['thn']);

        $query = $this->db->get('tb_surat_masuk');

        $data_suratmasuk = array(
            'data_loop' => $query->result(),
        );

        $this->load->view('app-html/laporan/cetak_suratmasuk', $data_suratmasuk);
    }
    
    public function get_smasuk($ID = 0) {
        $data = $this->db->get_where('tb_surat_masuk', array('id_surat' => $ID));
        $output = array(
            'status' => (!$data->num_rows()) ? false : true,
            'result' => $data->result()
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
    }

}

/* End of file Laporan_history.php */
/* Location: ./application/controllers/Laporan_history.php */