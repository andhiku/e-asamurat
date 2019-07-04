<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    /**
    * @author    : Emilio Andi Kriswanto
    * @link      : http://www.teitramega.com
    * @copyright : BPN App - TeitraMega Team 2016
    */
class Hak extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_apps','m_jenishak'));
        $this->load->library(array('session','pagination'));
    }
	public function index()
	{
		$this->page();
	}
	function page()
	{
        if($this->session->userdata('login')){
            $session = $this->session->userdata('login');
            if ($session['level_akses']=='admin') {
                $jumlah= $this->m_jenishak->numJenishak();
                $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
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
                $config['base_url'] = site_url().'/setting/hak/page';
                $config['total_rows'] = $jumlah;
                $config['per_page'] = 10;
                $config['uri_segment'] = 4;
                $dari = $this->uri->segment(4);
                $this->pagination->initialize($config);
                $data = array(
                    'title' => 'Setting - Jenis Hak',
                    'page_title' => 'Setting',
                    'page_name' => 'Jenis Hak',
                    'session' => $session,
                    'getAlljenishak' => $this->m_jenishak->getAlljenishak($config['per_page'],$dari)
                     );
                $this->load->view('layout/header',$data);
                $this->load->view('setting/vjenishak',$data);
                $this->load->view('layout/footer', $data);
            } else {
                redirect(site_url().'/dashboard/not_found','refresh');
            }
        } else {
            redirect(site_url().'/login/','refresh');
        }
	}
	public function getInsert()
	{
        if($this->session->userdata('login')){
            $session = $this->session->userdata('login');
            if ($session['level_akses']=='admin') {
            	$data = array('jenis_hak' => $this->input->post('jeni_hak'), );
            	$insert = $this->db->insert('tb_hak_milik', $data);
            	if ($insert) {
            		redirect(site_url().'/setting/hak?bin=true','refresh');
            	} else {
            		redirect(site_url().'/setting/hak?bin=failed','refresh');
            	}
            } else {
                redirect(site_url().'/dashboard/not_found','refresh');
            }
        } else {
            redirect(site_url().'/login/','refresh');
        }
	} 
	public function getUpdate($id)
	{
        if($this->session->userdata('login')){
            $session = $this->session->userdata('login');
            if ($session['level_akses']=='admin') {
            	$data = array('jenis_hak' => $this->input->post('jeni_hak'), );
            	$this->db->where('id_hak', $id);
            	$update = $this->db->update('tb_hak_milik', $data);
            	if ($update) {
            		redirect(site_url().'/setting/hak?bin=true','refresh');
            	} else {
            		redirect(site_url().'/setting/hak?bin=failed','refresh');
            	}
            } else {
                redirect(site_url().'/dashboard/not_found','refresh');
            }
        } else {
            redirect(site_url().'/login/','refresh');
        }
	}
	public function getDelete($id)
	{
        if($this->session->userdata('login')){
            $session = $this->session->userdata('login');
            if ($session['level_akses']=='admin') {
            	$this->db->where('id_hak', $id);
            	$delete = $this->db->delete('tb_hak_milik');
            	if ($delete) {
            		redirect(site_url().'/setting/hak?bin=true','refresh');
            	} else {
            		redirect(site_url().'/setting/hak?bin=failed','refresh');
            	}
            } else {
                redirect(site_url().'/dashboard/not_found','refresh');
            }
        } else {
            redirect(site_url().'/login/','refresh');
        }
	}
}

/* End of file hak.php */
/* Location: ./application/modules/setting/controllers/hak.php */