<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* @author 	 : Emilio Andi Kriswanto
	* @link 	 : http://www.teitramega.com
	* @copyright : BPN App - TeitraMega Team 2016
	*/
class Users extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session','upload','encrypt','pagination'));
		$this->load->model(array('m_landbook','m_apps','m_warkah','m_setting'));
		$this->load->helper(array('form','url','html'));
	}
	public function index()
	{
		if($this->session->userdata('login')) 
		{
			$session = $this->session->userdata('login');
			$data = array(
				'title' => 'Timeline User ',
				'page_title' => 'Timeline',
				'page_name' => 'Timeline',
				'session' => $session,
			 );
			$this->load->view('layout/header', $data);
			$this->load->view('setting/timeline', $data);
			$this->load->view('layout/footer', $data);
        } else {
            //jika seasson ada direct ke home
            redirect(site_url().'/apps/login/','refresh');
        }	
	}

}

/* End of file users.php */
/* Location: ./application/modules/apps/controllers/users.php */