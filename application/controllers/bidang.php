<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidang extends CI_Controller {

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
        $config['base_url'] = site_url("bidang?data=bidang");
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->count_all('tb_bidang');
        $this->pagination->initialize($config);

        $data = array(
            'title' => 'Manajemen Bidang' . DEFAULT_TITLE,
            'data_bidang' => $this->db->get('tb_bidang', $config['per_page'], $page)->result()
        );
        $this->template->view('setting/v_bidang', $data);
    }

    public function get_bidang($ID = 0) {
        $data = $this->db->get_where('tb_bidang', array('id_bidang' => $ID));
        $output = array(
            'status' => (!$data->num_rows()) ? false : true,
            'result' => $data->result()
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
    }
    
    public function cek_bidang() {
        $data = $this->db->get_where('tb_bidang', array('nama_bidang' => $this->input->post('nama_bidang')));
        $output = array('valid' => (!$data->num_rows()) ? true : false,);
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    
    public function set_bidang() {
        $id = $this->input->get('id');
        switch ($this->input->get('method')) :
            case 'add':
                $data_bidang = array(
                    'nama_bidang' => $this->input->post('bidang'),
                    'slug_bidang' => set_permalink($this->input->post('bidang'))
                );
                $this->db->insert('tb_bidang', $data_bidang);
                break;
            case 'update':
                $data_bidang = array(
                    'nama_bidang' => $this->input->post('bidang'),
                    'slug_bidang' => set_permalink($this->input->post('bidang'))
                );
                $this->db->update('tb_bidang', $data_bidang, array('id_bidang' => $id));
                break;
            case 'delete':
                $this->db->delete('tb_bidang', array('id_bidang' => $id));
                $this->db->delete('tb_pegawai', array('id_bidang' => $id));
                break;
            default:
                redirect("bidang");
                break;
        endswitch;
        redirect("bidang");
    }

    public function pegawai($ID = 0) {
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("bidang/pegawai/{$ID}?data=pegawai");
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->get_where('tb_pegawai', array('id_bidang' => $ID))->num_rows();
        $this->pagination->initialize($config);
        $data_pegawai = $this->db->query("SELECT * FROM tb_pegawai WHERE id_bidang = '{$ID}' LIMIT {$config['per_page']} OFFSET {$page}")->result();
        $data = array(
            'title' => 'Manajemen Pegawai' . DEFAULT_TITLE,
            'data_pegawai' => $data_pegawai
        );

        $this->template->view('setting/v_pegawai', $data);
    }
        
    public function cek_pegawai() {
        $data = $this->db->get_where('tb_pegawai', array('nama_pegawai' => $this->input->post('nama_pegawai')));
        $output = array('valid' => (!$data->num_rows()) ? true : false,);
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function set_pegawai() {
        $id = $this->input->get('id');
        $bidang = $this->input->get('bidang');
        switch ($this->input->get('method')) :
            case 'add':
                $data_pegawai = array(
                    'id_bidang' => $bidang,
                    'nama_pegawai' => $this->input->post('pegawai'),
                    'jabatan' => $this->input->post('jabatan'),
                    'slug_pegawai' => set_permalink($this->input->post('pegawai'))
                );
                $this->db->insert('tb_pegawai', $data_pegawai);
                break;
            case 'update':
                $data_pegawai = array(
                    'nama_pegawai' => $this->input->post('pegawai'),
                    'jabatan' => $this->input->post('jabatan'),
                    'slug_pegawai' => set_permalink($this->input->post('pegawai'))
                );
                $this->db->update('tb_pegawai', $data_pegawai, array('id_pegawai' => $id));
                break;
            case 'delete':
                $this->db->delete('tb_pegawai', array('id_pegawai' => $id));
                break;
            default:
                redirect("bidang/pegawai/{$bidang}");
                break;
        endswitch;
        redirect("bidang/pegawai/{$bidang}");
//        echo json_encode($data_pegawai);
    }
    
    public function get_pegawai($ID = 0) {
        $data = $this->db->get_where('tb_pegawai', array('id_pegawai' => $ID));
        $output = array(
            'status' => (!$data->num_rows()) ? false : true,
            'result' => $data->result()
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
    }

}