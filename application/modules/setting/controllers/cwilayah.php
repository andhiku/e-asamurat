<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cwilayah extends CI_Controller {

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
        $config['base_url'] = site_url("setting/cwilayah?data=kecamatan");
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->count_all('tb_kecamatan');
        $this->pagination->initialize($config);

        $data = array(
            'title' => 'Manajemen Kecamatan' . DEFAULT_TITLE,
            'data_kecamatan' => $this->db->get('tb_kecamatan', $config['per_page'], $page)->result()
        );
        $this->template->view('setting/v_kecamatan', $data);
    }

    public function get_kecamatan($ID = 0) {
        $data = $this->db->get_where('tb_kecamatan', array('id_kecamatan' => $ID));
        $output = array(
            'status' => (!$data->num_rows()) ? false : true,
            'result' => $data->result()
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
    }

    /**
     * Crud tb_kecamatan
     *
     * @return string
     * */
    public function set_kecamatan() {
        $id = $this->input->get('id');
        switch ($this->input->get('method')) :
            case 'add':
                $data_kecamatan = array(
                    'nama_kecamatan' => $this->input->post('kecamatan'),
                    'slug_kecamatan' => set_permalink($this->input->post('kecamatan'))
                );
                $this->db->insert('tb_kecamatan', $data_kecamatan);
                break;
            case 'update':
                $data_kecamatan = array(
                    'nama_kecamatan' => $this->input->post('kecamatan'),
                    'slug_kecamatan' => set_permalink($this->input->post('kecamatan'))
                );
                $this->db->update('tb_kecamatan', $data_kecamatan, array('id_kecamatan' => $id));
                break;
            case 'delete':
                $this->db->delete('tb_kecamatan', array('id_kecamatan' => $id));
                // delete dokumen berkaitan dengan kecamatan
                $data_buku = $this->db->get_where('tb_bencana', array('id_kecamatan' => $id));
                $this->db->delete('tb_bencana', array('id_kecamatan' => $id));
                break;
            default:
                redirect("setting/cwilayah");
                break;
        endswitch;
        redirect("setting/cwilayah");
    }

    /**
     * Menampilkan Desa / Kelurahan
     *
     * @return Data table
     * */
    public function desa($ID = 0) {
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("setting/cwilayah/desa/{$ID}?data=desa");
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->get_where('tb_desa', array('id_kecamatan' => $ID))->num_rows();
        $this->pagination->initialize($config);
        $data_desa = $this->db->query("SELECT * FROM tb_desa WHERE id_kecamatan = '{$ID}' LIMIT {$config['per_page']} OFFSET {$page}")->result();
        $data = array(
            'title' => 'Manajemen Desa' . DEFAULT_TITLE,
            'data_desa' => $data_desa
        );

        $this->template->view('setting/v_desa', $data);
    }

    /**
     * Crud tb_kecamatan
     *
     * @return string
     * */
    public function set_desa() {
        $id = $this->input->get('id');
        $kecamatan = $this->input->get('kecamatan');
        switch ($this->input->get('method')) :
            case 'add':
                $data_desa = array(
                    'id_kecamatan' => $kecamatan,
                    'nama_desa' => $this->input->post('desa'),
                    'slug_desa' => set_permalink($this->input->post('desa'))
                );
                $this->db->insert('tb_desa', $data_desa);
                break;
            case 'update':
                $data_desa = array(
                    'nama_desa' => $this->input->post('desa'),
                    'slug_desa' => set_permalink($this->input->post('desa'))
                );
                $this->db->update('tb_desa', $data_desa, array('id_desa' => $id));
                break;
            case 'delete':
                $this->db->delete('tb_desa', array('id_desa' => $id));
                // delete dokumen berkaitan dengan desa
//                $data_buku = $this->db->get_where('tb_bencana', array('id_desa' => $id));
//                foreach ($data_buku->result() as $row) :
//                    $data_file_buku = $this->db->get_where('tb_file_tanah', array('no_hakbuku' => $row->no_hakbuku));
//                    // buku tanah
//                    $this->db->delete('tb_simpan_buku', array('no_hakbuku' => $row->no_hakbuku));
//                    $this->db->delete('tb_pinjam_buku', array('no_hakbuku' => $row->no_hakbuku));
//                    foreach ($data_file_buku->result() as $file) :
//                        @unlink("./assets/files/{$file->nama_file}");
//                    endforeach;
//                    // warkah tanah
//                    $this->db->delete('tb_simpan_warkah', array('no208' => $row->no208));
//                    $this->db->delete('tb_pinjam_warkah', array('no208' => $row->no208));
//                    $data_file_warkah = $this->db->get_where('tb_file_warkah', array('no208' => $row->no208));
//                    foreach ($data_file_warkah->result() as $file) :
//                        @unlink("./assets/files/{$file->nama_file}");
//                    endforeach;
//                    $this->db->delete('tb_file_warkah', array('no208' => $row->no208));
//                endforeach;
                $this->db->delete('tb_bencana', array('id_desa' => $id));
                break;
            default:
                redirect("setting/cwilayah/desa/{$kecamatan}");
                break;
        endswitch;
        redirect("setting/cwilayah/desa/{$kecamatan}");
    }

    /**
     * undocumented class variable
     *
     * @var string
     * */
    public function update_prop($ID = 0) {
        $this->db->update(
                'tb_kecamatan', array(
            'nama_kecamatan' => $this->input->post('prop'),
            'slug_kecamatan' => set_permalink($this->input->post('prop'))
                ), array('id_kecamatan' => $ID)
        );

        $this->db->update(
                'tb_desa', array(
            'nama_desa' => $this->input->post('kab'),
            'slug_desa' => set_permalink($this->input->post('kab'))
                ), array('id_kecamatan' => $ID)
        );
        redirect("setting/cwilayah");
    }

    /**
     * Menampilkan Data Desa JSON
     *
     * @return string
     * */
    public function get_desa($ID = 0) {
        $data = $this->db->get_where('tb_desa', array('id_desa' => $ID));
        $output = array(
            'status' => (!$data->num_rows()) ? false : true,
            'result' => $data->result()
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
    }

}

/* End of file Cwilayah.php */
/* Location: ./application/modules/setting/controllers/Cwilayah.php */