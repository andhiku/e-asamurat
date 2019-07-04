<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_presentation extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    // Dokumen
    function getDok($tbl) {
        $query = $this->db->query('SELECT * FROM ' . $tbl);
        return $query->num_rows();
    }
    
    function getDok_aktif() {
        $query = $this->db->query('SELECT * FROM tb_bencana');
        return $query->num_rows();
    }

    function getUser_aktif() {
        $this->db->where('status_user', 'valid');
        $query = $this->db->get('tb_users');
        return $query->num_rows();
    }

    function getTim() {
        $query = $this->db->query('SELECT * FROM tb_tim');
        return $query->num_rows();
    }
    
    function getJenis() {
        $query = $this->db->query('SELECT * FROM tb_jenisbencana');
        return $query->num_rows();
    }

//    function getKecamatan() {
//        $slider_sql = "select * from books  limit 6";
//        $slider_result = $conn->query($slider_sql);
//        while ($slider_row = $slider_result->fetch_assoc()) {
//            extract($slider_row);
//
//            $img_sql = "SELECT big_img FROM images WHERE book_id = '$id'";
//            $img_rs = $conn->query($img_sql);
//            $img_row = $img_rs->fetch_assoc();
//
//            if ($img_rs->num_rows == 0)
//                continue; //--> here I want to start while again to select another book.
//        }
////        $query = $this->db->query('SELECT id_kecamatan FROM tb_kecamatan');
////        if($query->num_rows == 7) {
////            continue;
////        }
////        return $nomor->num_rows();
//    }

    function getTim_negeri() {
        $this->db->where('stts', '1');
        $query = $this->db->get('tb_tim');
        return $query->num_rows();
    }

    function getTim_swasta() {
        $this->db->where('stts', '2');
        $query = $this->db->get('tb_tim');
        return $query->num_rows();
    }

    function getDok_mati() {
        $this->db->where('status_buku', 'N');
        $query = $this->db->get('tb_buku_tanah');
        return $query->num_rows();
    }

    function getDokBuku_keluar() {
        $this->db->where('status_pinjam', 'N');
        $query = $this->db->get('tb_pinjam_buku');
        return $query->num_rows();
    }

    function getDokWarkah_keluar() {
        $this->db->where('status_pinjam', 'N');
        $query = $this->db->get('tb_pinjam_warkah');
        return $query->num_rows();
    }

    // tahun Mundur
    function getDok_tahun($thn) {
        $this->db->where('tahun', $thn);
        $query = $this->db->get('tb_buku_tanah');
        return $query->num_rows();
    }

    function getBencana_tahun($thn) {
        $this->db->where("DATE_FORMAT(tanggal,'%Y')", $thn);
        $query = $this->db->get('tb_bencana');
        return $query->num_rows();
    }

    function getBencana_bulan($bln) {
        $this->db->where("DATE_FORMAT(tanggal,'%m')", $bln);
        $query = $this->db->get('tb_bencana');
        return $query->num_rows();
    }

    function getDok_wilayah($id) {
        $this->db->where('id_kecamatan', $id);
        $query = $this->db->get('tb_bencana');
        return $query->num_rows();
    }

    //jenis-hak
    function numJenishak($id) {
        $this->db->where('id_hak', $id);
        $query = $this->db->get('tb_buku_tanah');
        return $query->num_rows();
    }

    function numJenisbencana($id) {
        $this->db->where('id_jenis', $id);
        $query = $this->db->get('tb_bencana');
        return $query->num_rows();
    }

    function tanggungan_tahun($thn) {
        $this->db->where('tahun', $thn);
        $this->db->where('id_hak', 5);
        $query = $this->db->get('tb_buku_tanah');
        $data = 0;
        foreach ($query->result() as $row) :
            $data += $row->luas;
        endforeach;
        return $data;
    }

}

/* End of file m_presentation.php */
/* Location: ./application/models/m_presentation.php */