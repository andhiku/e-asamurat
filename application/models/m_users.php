<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    /**
    * @author    : Emilio Andi Kriswanto
    * @link      : http://www.teitramega.com
    * @copyright : BPN App - TeitraMega Team 2016
    */
class M_users extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
    function getMyakun($username) {
        $this->db->where('username',$username);
        $query = $this->db->get('tb_users');
        return $query->result();
    }
    function getHistory($username) {
        $this->db->where('username',$username);
        $this->db->order_by('time','desc');
        $query = $this->db->get('tb_history',20);
        return $query->result();
    }
    function getHistorylimit($username) {

        $this->db->join('tb_buku_tanah', 'tb_history.id_bencana = tb_buku_tanah.id_bencana');
        $this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');
        $this->db->join('tb_users', 'tb_history.username = tb_users.username');
        $this->db->where('tb_history.username', $username);
        $this->db->order_by('tb_history.id', 'desc');
        $query = $this->db->get('tb_history', 5);
        return $query->result();
    }
    function cek_user($id)
    {
        $this->db->where('username', $id);
        $query = $this->db->get('tb_users');
        return $query->num_rows();
    }
    function getMyakun_id($id) {
        $this->db->where('id',$id);
        $query = $this->db->get('tb_users');
        return $query->result();
    }
    function getAllExcel($bln, $thn)
    {
        $this->db->join('tb_users', 'tb_users.username = tb_history.username', 'left');
        $this->db->where('tb_history.bulan', $bln);   
        $this->db->where('tb_history.tahun', $thn);
        $query = $this->db->get('tb_history');
        return $query->result();
    }
    function getIDExcel($username)
    {
        $this->db->join('tb_users', 'tb_users.username = tb_history.username', 'left'); 
        $this->db->where('tb_history.username', $username);  
        $query = $this->db->get('tb_history');
        return $query->result();
    }
}

/* End of file m_users.php */
/* Location: ./application/modules/m_users.php */