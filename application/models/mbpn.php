<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mbpn extends CI_Model {

    function __construct() {
        $this->tableName = 'tb_foto';
    }

    /**
     * tb_jenis_hak
     *
     * @return Query
     * */
    
    public function status($ID = 0) {
        if (!$ID) :
            $query = $this->db->query("SELECT * FROM tb_surat_masuk")->result();
        else :
            $query = $this->db->query("SELECT + FROM tb_surat_masuk WHERE status = '{$ID}'")->row();
        endif;
        return $query;
    }

    public function jenis_hak($ID = 0) {
        if (!$ID) :
            $query = $this->db->query("SELECT * FROM tb_jenisbencana")->result();
        else :
            $query = $this->db->query("SELECT + FROM tb_jenisbencana WHERE id_jenis = '{$ID}'")->row();
        endif;
        return $query;
    }

    public function tim($ID = 0) {
        if (!$ID) :
            $query = $this->db->query("SELECT * FROM tb_tim")->result();
        else :
            $query = $this->db->query("SELECT + FROM tb_tim WHERE id_tim = '{$ID}'")->row();
        endif;
        return $query;
    }

    /**
     * tb_kecamatan
     *
     * @return Query
     * */
    public function kecamatan($ID = 0) {
        if (!$ID) :
            $query = $this->db->query("SELECT * FROM tb_kecamatan")->result();
        else :
            $query = $this->db->query("SELECT * FROM tb_kecamatan WHERE id_kecamatan = '{$ID}'")->row();
        endif;
        return $query;
    }

    /**
     * tb_desa
     *
     * @return Query
     * */
    public function desa($ID = 0) {
        if (!$ID) :
            $query = $this->db->query("SELECT * FROM tb_desa")->result();
        else :
            $query = $this->db->query("SELECT * FROM tb_desa WHERE id_desa = '{$ID}'")->row();
        endif;
        return $query;
    }

    /**
     * tb_kecamatan
     *
     * @return Query
     * */
    public function bidang($ID = 0) {
        if (!$ID) :
            $query = $this->db->query("SELECT * FROM tb_bidang")->result();
        else :
            $query = $this->db->query("SELECT * FROM tb_bidang WHERE id_bidang = '{$ID}'")->row();
        endif;
        return $query;
    }

    /**
     * tb_desa
     *
     * @return Query
     * */
    public function pegawai($ID = 0) {
        if (!$ID) :
            $query = $this->db->query("SELECT * FROM tb_pegawai")->result();
        else :
            $query = $this->db->query("SELECT * FROM tb_pegawai WHERE id_pegawai = '{$ID}'")->row();
        endif;
        return $query;
    }

    /**
     * tb_foto
     *
     * @return Query
     * */
    public function foto($ID = 0) {
        if (!$ID) :
            $query = $this->db->query("SELECT * FROM tb_foto")->result();
        else :
            $query = $this->db->query("SELECT * FROM tb_foto WHERE id_foto = '{$ID}'")->row();
        endif;
        return $query;
    }

    /**
     * undocumented class variable
     *
     * @return string TRUE/BOOLEAN
     * */
    public function ketersediaan_buku($ID = 0) {
        $query = $this->db->query("SELECT * FROM tb_simpan_buku WHERE no_hakbuku = '{$ID}'");
        return $query->row();
    }

    /**
     * tb_user
     *
     * @return Query
     * */
    public function user($ID = 0) {
        if (!$ID) :
            $query = $this->db->query("SELECT * FROM tb_users")->result();
        else :
            $query = $this->db->query("SELECT * FROM tb_users WHERE username = '{$ID}'")->row();
        endif;
        return $query;
    }

    /**
     * tb_lemari
     *
     * @return Query
     * */
    public function lemari($ID = 0) {
        $query = $this->db->query("SELECT * FROM tb_lemari WHERE no_lemari = '{$ID}'");
        return (!$query->num_rows()) ? '-' : $query->row()->nama_lemari;
    }

    /*
     * Fetch files data from the database
     * @param id returns a single record if specified, otherwise all records
     */
    public function getRows($id = '') {
        $this->db->select('id_foto,id_bencana,file_name');
        $this->db->from('files');
        if ($id) {
            $this->db->where('id_foto', $id);
            $query = $this->db->get();
            $result = $query->row_array();
        } else {
            $this->db->order_by('id_bencana', 'desc');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return !empty($result) ? $result : false;
    }

    /*
     * Insert file data into the database
     * @param array the data for inserting into the table
     */

    public function insertFoto($data = array()) {
        $insert = $this->db->insert_batch('files', $data);
        return $insert ? true : false;
    }

}

/* End of file mbpn.php */
/* Location: ./application/models/mbpn.php */