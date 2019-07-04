<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

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
        $this->load->library(array('form_validation', 'session'));
//        $this->load->library(array('session', 'upload', 'encrypt', 'Excel/PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->model(array('m_apps', 'm_laporan', 'image_model'));
    }

    public function index() {
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("laporan?data=smasuk");
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->count_all('tb_surat_masuk');
        $this->pagination->initialize($config);

        $data = array(
            'title' => 'Laporan Data Surat Masuk' . DEFAULT_TITLE,
            'data_smasuk' => $this->db->get('tb_surat_masuk', $config['per_page'], $page)->result()
        );
        $this->template->view('v_laporan', $data);
    }

    public function get($ID = 0) {
        $data = $this->db->get_where('tb_surat_masuk', array('id_surat' => $ID));
        $output = array(
            'status' => (!$data->num_rows()) ? false : true,
            'result' => $data->result()
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
    }

    public function set_smasuk() {
        $id = $this->input->get('id');
        switch ($this->input->get('method')) :
            case 'delete':
                $this->db->delete('tb_surat_masuk', array('id_surat' => $id));
//                $this->db->delete('tb_foto', array('id_bencana' => $id));
                break;
            default:
                redirect("laporan");
                break;
        endswitch;
        redirect("laporan");
    }

//    function foto($x) {
//        $dt['dtlist'] = $this->m_apps->getwhere("tb_foto", "id_bencana = '$x'");
//        $this->template->view('setting/v_foto', $dt);
//    }
    
//    function set_foto() {
//        $query_id = $this->db->query("SELECT MAX(id_foto) AS id_foto FROM tb_foto")->row();
//        $ambil_id = ++$query_id->id_foto;
//        $id_foto = $ambil_id + $this->input->post('id_foto');
//        $bencana = $this->input->get('bencana');
//        switch ($this->input->get('method')) :
//            case 'add':
//                $data_foto = array(
//                    'id_foto' => $id_foto,
//                    'id_bencana' => $bencana,
//                    'foto' => $this->input->post('foto'),
//                );
//                $this->db->insert('tb_foto', $data_foto);
//                break;
//            default:
//                redirect("laporan/foto/{$bencana}");
//                break;
//        endswitch;
//        redirect("laporan/foto/{$bencana}");
//    }
//
//    function upload() {
//        $data = array();
//        if ($this->input->post('submitForm') && !empty($_FILES['foto']['name'])) {
//            $filesCount = count($_FILES['foto']['name']);
//            for ($i = 0; $i < $filesCount; $i++) {
//                $_FILES['foto']['name'] = $_FILES['foto']['name'][$i];
//                $_FILES['upload_File']['type'] = $_FILES['upload_Files']['type'][$i];
//                $_FILES['upload_File']['tmp_name'] = $_FILES['upload_Files']['tmp_name'][$i];
//                $_FILES['upload_File']['error'] = $_FILES['upload_Files']['error'][$i];
//                $_FILES['upload_File']['size'] = $_FILES['upload_Files']['size'][$i];
//                $uploadPath = 'uploads/files/';
//                $config['upload_path'] = $uploadPath;
//                $config['allowed_types'] = 'gif|jpg|png';
//                $this->load->library('upload', $config);
//                $this->upload->initialize($config);
//                if ($this->upload->do_upload('upload_File')) {
//                    $fileData = $this->upload->data();
//                    $uploadData[$i]['file_name'] = $fileData['file_name'];
//                    $uploadData[$i]['created'] = date("Y-m-d H:i:s");
//                    $uploadData[$i]['modified'] = date("Y-m-d H:i:s");
//                }
//            }
//            if (!empty($uploadData)) {
//                //Insert file information into the database
//                $insert = $this->image_model->insert($uploadData);
//                $statusMsg = $insert ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
//                $this->session->set_flashdata('statusMsg', $statusMsg);
//            }
//        }
//        $data['gallery'] = $this->image_model->getRows();
//        $this->template->view('files_upload/index', $data);
//    }

}
