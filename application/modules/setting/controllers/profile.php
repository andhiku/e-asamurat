<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
        $this->load->library(array('session', 'Excel/PHPExcel', 'upload'));
        $this->load->model(array('m_apps'));
        $this->load->helper(array('form', 'url', 'html'));
    }

    public function index($username = 0) {
        $data_user = $this->db->query("SELECT * FROM tb_users WHERE username = '{$this->username}'")->row();
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;

//        $total_rows = $this->db->query("SELECT * FROM tb_history WHERE username = '{$this->username}'")->num_rows();
//        $config = pagination_list();
//        $config['base_url'] = site_url("setting/profile?data=history");
//        $config['per_page'] = 10;
//        $config['uri_segment'] = 4;
//        $config['page_query_string'] = TRUE;
//        $config['query_string_segment'] = 'page';
//        $config['total_rows'] = $total_rows;
//        $this->pagination->initialize($config);
//        $data_history = $this->db->query("SELECT tb_history.*, tb_buku_tanah.* FROM tb_history JOIN tb_buku_tanah ON tb_history.id_bencana = tb_buku_tanah.id_bencana WHERE tb_history.username = '{$this->username}'  ORDER BY tb_history.time DESC LIMIT {$config['per_page']} OFFSET {$page}")->result();
        $data = array(
            'title' => 'My Akun' . DEFAULT_TITLE,
            'data' => $data_user,
//            'data_history' => $data_history
        );

        $this->template->view('setting/my_akun', $data);
    }

    /**
     * Mengubah Data profile
     *
     * @return string
     * */
    public function update() {
        $data_user = $this->db->query("SELECT * FROM tb_users WHERE username = '{$this->username}'")->row();

        // upload tanda tangan
        $tgl = date("Y-m-d-H-i-s");
        $path = FCPATH . '/assets/doc/ttd';
        $tmp_name = $_FILES['ttd']['tmp_name'];
        $nama = $_FILES['ttd']['name'];
        $nmbaru = $tgl . '-' . $nama;
        copy($tmp_name, "$path/$nmbaru");

        $data = array(
            'nama_lengkap' => $this->input->post('nama'),
            'ttd' => $tgl . '-' . $nama,
        );

        // upload foto profil
        $config['upload_path'] = './assets/user/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '10240';
        $config['max_width'] = '9000';
        $config['max_height'] = '8000';
        //$config['remove_spaces'] = FALSE;
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('img')) :
            $data['foto'] = $this->input->post('no_file');
        else :
            $data['foto'] = $this->upload->file_name;
            //if($data_user->foto =! 'null')
            @unlink("./assets/user/{$data_user->foto}");
        endif;

        $this->db->update('tb_users', $data, array('username' => $this->username));
        if ($data['username'] == $data->username) :
            redirect("setting/profile?data=update");
        else :
            redirect('login/logout');
//            redirect('setting/profile?data=update');
        endif;
    }

    /**
     * Mengecek valid password
     *
     * @return string
     * */
    public function cek_pass() {
        $data_user = $this->db->query("SELECT * FROM tb_users WHERE username = '{$this->username}'")->row();
        $output['valid'] = (password_verify($this->input->post('lama'), $data_user->pass_login)) ? true : false;
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    /**
     * Mengubah Password
     *
     * @var string
     * */
    public function update_pass() {
        $data = array(
            'pass_login' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
        );
        $query_log = $this->db->query("SELECT MAX(id) AS id FROM tb_history")->row();
        $ambil_log = ++$query_log->id;
        $dt_log = array(
            'id' => $ambil_log,
            'id_user' => $this->session->userdata('login')['id'],
            'log' => 'Mengganti password',
            'tanggal' => date('Y-m-d H:i:s'),
        );
        $this->db->update('tb_users', $data, array('username' => $this->username));
        $this->m_apps->add_save('tb_history', $dt_log);
//        redirect("setting/profile?data=security");
        redirect("login/logout");
    }

}

/* End of file Profile.php */
/* Location: ./application/modules/setting/controllers/Profile.php */