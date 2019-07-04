<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    /**
    * @author    : Emilio Andi Kriswanto
    * @link      : http://www.teitramega.com
    * @copyright : BPN App - TeitraMega Team 2016
    */
class Login extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_apps');
    }
	public function index()
	{
        $data = array(
            'title' => 'Aplikasi Manajemen Surat', );
        $this->load->view('v_login' , $data);
	}
    public function act_login() 
    {  
        $password   = $this->input->post('passlogin');   
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->db->where('username', $this->input->post('username'));
        $query = $this->db->get('tb_users');
        $row = $query->row();
        if (!$row) {
           echo "<div id='gagal' class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button>Maaf! Username anda tidak terdaftar.</div>";
        } else {
            if (password_verify($this->input->post('passlogin'), $row->pass_login)) {
                $result = $this->m_apps->login($this->input->post('username'),$row->pass_login);
                if($result)
                {
                    foreach($result as $row)
                    {
                        $sess_array = array(
                            'id' => $row->id,
                            'username' => $row->username,
                            'nama_lengkap'=> $row->nama_lengkap,
                            'pass_login' => $row->pass_login,
                            'foto' => $row->foto,
                            'level_akses' => $row->level_akses
                        );
                        $obj = array('login_terakhir' =>date('Y-m-d H:i:s') ,'status'=>'online');
                        $this->db->where('username',$row->username);
                        $this->db->update('tb_users',$obj);
                        $this->session->sess_expiration = '1800';
                        $this->session->set_userdata('login', $sess_array);
                    }
                    echo '<img src="'.base_url().'assets/images/load.gif"><script>window.location="'.site_url().'"</script>';
                } 
            } else {
                echo "<div id='gagal' class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button>Maaf! Kombinasi Username dan Password anda tidak cocok.</div>";
            }          
        }
    
    }
    public function logout() {
        if (!$this->session->userdata('login')) {
            redirect(site_url().'/login','refresh');
        } else {
            $session = $this->session->userdata('login');
            $data = array('status' => 'offline', );
            $this->db->where('username', $session['username']);
            $this->db->update('tb_users',$data);
            if (!$session['username']) {
                redirect(site_url().'/login','refresh');
            } else {
                $this->session->unset_userdata('login');
                redirect(site_url().'/login','refresh');
            }
        }
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */