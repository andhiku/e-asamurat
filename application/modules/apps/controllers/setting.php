<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* @author 	 : Emilio Andi Kriswanto
	* @link 	 : http://www.teitramega.com
	* @copyright : BPN App - TeitraMega Team 2016
	*/
class Setting extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session','upload','encrypt','pagination'));
		$this->load->model(array('m_landbook','m_apps','m_warkah','m_setting'));
		$this->load->helper(array('form','url','html'));
	}
	public function index()
	{
		$this->page();
	}
	function page()
	{
		if($this->session->userdata('login')) 
		{
			$session = $this->session->userdata('login');
			if ($session['level_akses']=='admin') 
			{
				$jumlah= $this->m_setting->get_numLemari();
				$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="">';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="">';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = 'Next &rarr;';
				$config['next_tag_open'] = '<li class="">';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = '&larr; Previous';
				$config['prev_tag_open'] = '<li class="">';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="">';
				$config['num_tag_close'] = '</li>';
				$config['base_url'] = site_url().'/apps/setting/page';
				$config['total_rows'] = $jumlah;
				$config['per_page'] = 8; 		//limit nya brpp disini gans
			    $config['uri_segment'] = 4;
				$dari = $this->uri->segment(4);
				$this->pagination->initialize($config);
				$data = array(
					'title' => 'Manajemen Lemari - Rak',
					'page_title' => 'Setting',
					'page_name' => 'Lemari - Rak',
					'session' => $session,
					'lemari' => $this->m_setting->get_allLemari($config['per_page'], $dari),
					 );
				$this->load->view('layout/header', $data);
				$this->load->view('setting/mnjArsip', $data, FALSE);
				$this->load->view('layout/footer', $data);
			} else {
				redirect(site_url().'/dashboard/forbidden','refresh');
			}
        } else {
            //jika seasson ada direct ke home
            redirect(site_url().'/apps/login/','refresh');
        }	
	}
	public function users()
	{
		if($this->session->userdata('login')) 
		{
			$session = $this->session->userdata('login');
			if ($session['level_akses']=='admin') 
			{
				$jumlah= $this->m_setting->user_num();
				$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="">';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="">';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = 'Next &rarr;';
				$config['next_tag_open'] = '<li class="">';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = '&larr; Previous';
				$config['prev_tag_open'] = '<li class="">';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="">';
				$config['num_tag_close'] = '</li>';
				$config['base_url'] = site_url().'/apps/setting/users';
				$config['total_rows'] = $jumlah;
				$config['per_page'] = 10; 		//limit nya brpp disini gans
			    $config['uri_segment'] = 4;
				$dari = $this->uri->segment(4);
				$this->pagination->initialize($config);
				$data = array(
					'title' => 'Manajemen Users',
					'page_title' => 'Setting',
					'page_name' => 'Manajemen Users',
					'session' => $session,
					'all_user' => $this->m_setting->get_allUser($config['per_page'],$dari)
				 );
				$this->load->view('layout/header', $data);
				$this->load->view('setting/users', $data);
				$this->load->view('layout/footer', $data);
			} else {
				redirect(site_url().'/dashboard/forbidden','refresh');
			}
        } else {
            //jika seasson ada direct ke home
            redirect(site_url().'/apps/login/','refresh');
        }
	}
	function addUser()
	{
		if($this->session->userdata('login')) 
		{
			$session = $this->session->userdata('login');
			if ($session['level_akses']=='admin') {
				if ($this->m_setting->cek_user($this->input->post('username')) > 0) {
					redirect(site_url().'/apps/setting/users?bin=exist','refresh');
				} else {
                    $history = array('username'=>$session['username'],'tanggal'=>date('Y-m-d'),'time'=>date('Y-m-d H:i:s'),'menus_id'=>'3');
                    $masuk = $this->db->insert('tb_history',$history);
                    if ($masuk) {
						$pass = md5($this->input->post('pass'));
						$data = array(
							'username' => $this->input->post('username_peg'),
							'nama_lengkap' => $this->input->post('nama'),
							'username' => $this->input->post('username'),
							'pass_login' => $pass,
							'foto' => '',
							'login_terakhir' => '',
							'level_akses' => 'operator',
							'status_user' => 'valid',
							'status' => 'offline'
							 );
						$insert = $this->db->insert('tb_users', $data);
						if ($insert) {
							redirect(site_url().'/setting/users?bin=ok','refresh');
						} else {
							redirect(site_url().'/setting/users?bin=failed','refresh');
						}
					} //end history
				}
			} else {
				redirect(site_url().'/dashboard/forbidden','refresh');
			}
        } else {
            //jika seasson ada direct ke home
            redirect(site_url().'/apps/login/','refresh');
        }	
	}
	function action($id)
	{
		if($this->session->userdata('login')) 
		{
			$session = $this->session->userdata('login');
			if ($session['level_akses']=='admin') {
				if ($this->input->get('a')=='blockir') {
					$data = array('status_user' => 'not', 'login_terakhir'=> '0000-00-00 00:00:00' );
					$this->db->where('id', $id);
					$update = $this->db->update('tb_users', $data);
					if ($update) {
						redirect(site_url().'/apps/setting/users?bin=true','refresh');
					} else {
						redirect(site_url().'/apps/setting/users?bin=failed','refresh');
					}
				} elseif ($this->input->get('a')=='unblockir') {
					$data = array('status_user' => 'valid', 'login_terakhir'=> '0000-00-00 00:00:00' );
					$this->db->where('id', $id);
					$update = $this->db->update('tb_users', $data);
					if ($update) {
						redirect(site_url().'/apps/setting/users?bin=true','refresh');
					} else {
						redirect(site_url().'/apps/setting/users?bin=failed','refresh');
					}
				} elseif ($this->input->get('a')=='hapus') {
					# code...
				}
			} else {
				redirect(site_url().'/dashboard/forbidden','refresh');
			}
        } else {
            //jika seasson ada direct ke home
            redirect(site_url().'/apps/login/','refresh');
        }
	}
	// WILAYAH
	public function wilayah()
	{
		if($this->session->userdata('login')) 
		{
			$session = $this->session->userdata('login');
			if ($session['level_akses']=='admin') {
				$data = array(
					'title' => 'Manajemen Wilayah',
					'page_title' => 'Setting',
					'page_name' => 'Wilayah',
					'session' => $session,
					 );
				$this->load->view('layout/header', $data);
				$this->load->view('setting/datawilayah', $data);
				$this->load->view('layout/footer', $data);
			} else {
				redirect(site_url().'/dashboard/forbidden','refresh');
			}
        } else {
            //jika seasson ada direct ke home
            redirect(site_url().'/apps/login/','refresh');
        }	
	}
	// WILAYAH
	public function foto()
	{
		if($this->session->userdata('login')) 
		{
			$session = $this->session->userdata('login');
			if ($session['level_akses']=='admin') {
				$data = array(
					'title' => 'Manajemen Foto',
					'page_title' => 'Setting',
					'page_name' => 'Foto',
					'session' => $session,
					 );
				$this->load->view('layout/header', $data);
				$this->load->view('setting/datafoto', $data);
				$this->load->view('layout/footer', $data);
			} else {
				redirect(site_url().'/dashboard/forbidden','refresh');
			}
        } else {
            //jika seasson ada direct ke home
            redirect(site_url().'/apps/login/','refresh');
        }	
	}
}

/* End of file setting.php */
/* Location: ./application/modules/apps/controllers/setting.php */