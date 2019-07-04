<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utama extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('login')) :
            redirect(site_url('login'));
            return;
        endif;
        $this->load->model(array('m_apps', 'm_users', 'm_presentation'));
        $this->load->library(array('session', 'table'));
        $this->load->helper('color_helper');
    }

    public function index() {
//        $data = array(
//            'title' => 'Dashboard' . DEFAULT_TITLE,
//        );
        
        $x['data']=$this->m_apps->get_data_stok();
//        $x['datask']=$this->m_apps->get_data_stok_baru();
        
        $this->template->view('v_utama', $x);
    }

//    public function get_document() {
//        $tahun = (int) date('Y') - 4;
//        $output = array(
//            'labels' => array(),
//            'type' => 'line',
//        );
//        for ($i = $tahun; $i <= date('Y'); $i++) {
//            $output['labels'][] = $i;
//        }
//        $output['datasets'] = array(
//            array(
//                'fillColor' => '#D0A711',
//                'data' => array()
//            )
//        );
//        for ($b = $tahun; $b <= date('Y'); $b++) {
//            $output['datasets'][0]['data'][] = $this->m_apps->getDok_tahun("DATE_FORMAT(tgl_terima,'%Y')", $b, 'tb_surat_masuk');
//        }
//        $this->output->set_content_type('application/json')->set_output(json_encode($output));
//    }

}

/* End of file Utama.php */
/* Location: ./application/controllers/Utama.php */