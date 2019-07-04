<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bpn {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function ketersediaan_buku($lemari = 0, $rak = 0, $album = 0, $laman = 0) {
        $penyimpanan = $this->CI->db->query("SELECT * FROM tb_simpan_buku WHERE no_lemari = '{$lemari}' AND no_rak = '{$rak}' AND no_album = '{$album}' AND no_halaman = '{$laman}'");
        if (!$penyimpanan->num_rows()) :
            $availability = true;
        else :
            $availability = false;
        endif;
        return $availability;
    }

    public function ketersediaan_warkah($lemari = 0, $rak = 0, $album = 0, $laman = 0) {
        $penyimpanan = $this->CI->db->query("SELECT * FROM tb_simpan_warkah WHERE no_lemari = '{$lemari}' AND no_rak = '{$rak}' AND no_album = '{$album}' AND no_halaman = '{$laman}'");
        if (!$penyimpanan->num_rows()) :
            $availability = true;
        else :
            $availability = false;
        endif;
        return $availability;
    }

    /**
     * Menampilkan Hak Milik yang tertera pda buku tanah
     *
     * @var string
     * */
    
    public function kalak($ID = 0) {
        $query = $this->CI->db->query("SELECT * FROM tb_surat_masuk WHERE id_surat = '{$ID}'")->row();
        return $query->no_surat;
    }
    
    public function hak($ID = 0) {
        $query = $this->CI->db->query("SELECT * FROM tb_jenisbencana WHERE id_jenis = '{$ID}'")->row();
        return $query->jenis_bencana;
    }

    /**
     * Menampilkan Tim Pemadam
     *
     * @var string
     * */
    public function tim($ID = 0) {
        $query = $this->CI->db->query("SELECT * FROM tb_tim WHERE id_tim = '{$ID}'")->row();
        return $query->nama_tim;
    }

    /**
     * Menampilkan Bencana
     *
     * @var string
     * */
    public function bencana($ID = 0) {
        $query = $this->CI->db->query("SELECT * FROM tb_bencana WHERE id_bencana = '{$ID}'")->row();
        return $query->foto;
    }

    /**
     * Menampilkan Foto
     *
     * @var string
     * */
    public function foto($ID = 0) {
        $query = $this->CI->db->query("SELECT * FROM tb_foto WHERE id_foto = '{$ID}'")->row();
        return $query->foto;
    }

    /**
     * Menampilkan Kecamatan
     *
     * @var string
     * */
    public function kecamatan($ID = 0) {
        $query = $this->CI->db->query("SELECT * FROM tb_kecamatan WHERE id_kecamatan = '{$ID}'")->row();
        return $query->nama_kecamatan;
    }

    /**
     * Menampilkan Desa
     *
     * @var string
     * */
    public function desa($ID = 0) {
        $query = $this->CI->db->query("SELECT * FROM tb_desa WHERE id_desa = '{$ID}'")->row();
        return $query->nama_desa;
    }

    /**
     * Menampilkan Kecamatan
     *
     * @var string
     * */
    public function bidang($ID = 0) {
        $query = $this->CI->db->query("SELECT * FROM tb_bidang WHERE id_bidang = '{$ID}'")->row();
        return $query->nama_bidang;
    }

    /**
     * Menampilkan Desa
     *
     * @var string
     * */
    public function pegawai($ID = 0) {
        $query = $this->CI->db->query("SELECT * FROM tb_pegawai WHERE id_pegawai = '{$ID}'")->row();
        return $query->nama_pegawai;
    }

    /**
     * menampilkan Nama Rak
     *
     * @var string
     * */
    public function rak($ID = 0) {
        $query = $this->CI->db->query("SELECT * FROM tb_rak WHERE no_rak = '{$ID}'")->row();
        if (!$query) :
            $data = '-';
        else :
            $data = $query->nama_rak;
        endif;
        return $data;
    }

    /**
     * menampilkan Nama Rak
     *
     * @var string
     * */
    public function album($ID = 0) {
        $query = $this->CI->db->query("SELECT * FROM tb_album WHERE no_album = '{$ID}'")->row();
        if (!$query) :
            $data = '-';
        else :
            $data = $query->nama_album;
        endif;
        return $data;
    }

    /**
     * Menggenerate id_kecamatan lewat string
     *
     * @var string
     * */
    public function generate_id_kecamatan($string = '') {
        $query = $this->CI->db->query("SELECT * FROM tb_kecamatan WHERE slug_kecamatan = '{$string}'");
        if (!$query->num_rows()) :
            return false;
        else :
            $row = $query->row();
            return $row->id_kecamatan;
        endif;
    }

    /**
     * Menggenerate id_desa lewat string
     *
     * @var string
     * */
    public function generate_id_desa($string = '') {
        $query = $this->CI->db->query("SELECT * FROM tb_desa WHERE slug_desa = '{$string}'");
        if (!$query->num_rows()) :
            return 0;
        else :
            $row = $query->row();
            return $row->id_desa;
        endif;
    }

    /**
     * Menggenerate id_kecamatan lewat string
     *
     * @var string
     * */
    public function generate_id_bidang($string = '') {
        $query = $this->CI->db->query("SELECT * FROM tb_bidang WHERE slug_bidang = '{$string}'");
        if (!$query->num_rows()) :
            return false;
        else :
            $row = $query->row();
            return $row->id_bidang;
        endif;
    }

    /**
     * Menggenerate id_desa lewat string
     *
     * @var string
     * */
    public function generate_id_pegawai($string = '') {
        $query = $this->CI->db->query("SELECT * FROM tb_pegawai WHERE slug_pegawai = '{$string}'");
        if (!$query->num_rows()) :
            return 0;
        else :
            $row = $query->row();
            return $row->id_pegawai;
        endif;
    }

    /**
     * Menggenerate id_kecamatan lewat string
     *
     * @var string
     * */
    public function generate_id_bencana($string = '') {
        $query = $this->CI->db->query("SELECT * FROM tb_bencana WHERE id_bencana = '{$string}'");
        if (!$query->num_rows()) :
            return false;
        else :
            $row = $query->row();
            return $row->id_bencana;
        endif;
    }

    /**
     * Menggenerate id_desa lewat string
     *
     * @var string
     * */
    public function generate_id_foto($string = '') {
        $query = $this->CI->db->query("SELECT * FROM tb_foto WHERE id_foto = '{$string}'");
        if (!$query->num_rows()) :
            return 0;
        else :
            $row = $query->row();
            return $row->id_foto;
        endif;
    }

    /**
     * Menggenaerate id_jenis lewat string
     *
     * @var string
     * */
    public function generate_id_hak($string = '') {
        $query = $this->CI->db->query("SELECT * FROM tb_jenisbencana WHERE slug_jenis_bencana = '{$string}'");
        if (!$query->num_rows()) :
            return 0;
        else :
            $row = $query->row();
            return $row->id_jenis;
        endif;
    }

}

/* End of file Bpn.php */
/* Location: ./application/libraries/Bpn.php */
