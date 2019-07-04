<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Index file Warkah Aplikasi
 *
 * @access http://example_root/buku/file
 * @package Apps - Class File_warkah.php
 * @author https://facebook.com/muh.azzain
 **/
class File_warkah extends CI_Controller {
	private $name_user;
	private $username;

	public function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('login') ) :
			redirect(site_url('login'));
			return;
		endif;
		$data_session = $this->session->userdata('login');
		$this->name_user = $data_session['nama_lengkap'];
		$this->username = $data_session['username'];
		$this->load->library(array('session','upload','encrypt'));
		$this->load->model(array('m_apps','m_buku'));
		$this->load->helper(array('form','url','html'));
	}
	public function index()
	{
		
	}

	/**
	 * menghapus File Buku Tanah
	 *
	 * @return string
	 **/
	public function delete($ID=0, $id_warkah=0)
	{
		$row = $this->db->query("SELECT * FROM tb_file_warkah WHERE id = '{$ID}'")->row();
		@unlink("./assets/files/{$row->nama_file}");
		$this->db->delete('tb_file_warkah', array('id'=>$ID ));
		redirect("warkah/document/{$id_warkah}?t=file");
	}

	/**
	 * Menghandle Action Multiple File Buku Tanah
	 *
	 * @return string
	 **/
	public function bulk_action($ID=0)
	{
		switch ($this->input->post('action')) :
			case 'delete':
				for($i=0; $i<count($this->input->post('file')); $i++) :
					$row = $this->db->query("SELECT * FROM tb_file_warkah WHERE id = '".$this->input->post('file')[$i]."'")->row();
					@unlink("./assets/files/{$row->nama_file}");
					$this->db->delete('tb_file_warkah', array('id'=>$this->input->post('file')[$i]));
				endfor;
				break;
			default:
				redirect("warkah/document/{$ID}?t=file");
				break;
		endswitch;
		redirect("warkah/document/{$ID}?t=file");
	}

	/**
	 * Menambahkan File Dokumen Warkah Tanah
	 *
	 * @param Integer (no_hakbuku)
	 * @return string (Callback) 
	 **/
	public function add_multiple($ID=0)
	{
		// Upload File Dokumen Buku
		$config['upload_path'] =  'assets/files/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|PDF|JPG|PNG|GIF';
		$config['max_size']	= '10240';
		$config['max_width']  = '3000';
		$config['max_height']  = '3000';
		$config['remove_spaces'] = FALSE;
		$config['overwrite'] = FALSE;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		$file = array();
        if($this->upload->do_multi_upload("file")) :
        	foreach( $this->upload->get_multi_upload_data() as $key => $item) :
           	$file[] = array(
           		'id_warkah' => $ID,
           		'nama_file' =>  $item['file_name'],
           		'mime_type' => $item['file_type'],
           		'file_ext' => $item['file_ext']
           	);
           endforeach;
        endif;
        $this->db->insert_batch('tb_file_warkah', $file);
        redirect("warkah/document/{$ID}?t=file");
	}
}

/* End of file File_warkah.php */
/* Location: ./application/modules/apps/controllers/File_warkah.php */