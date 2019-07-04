<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan extends CI_Model {

    /**
     * mengambil Thun terendah dari dokumen
     *
     * @return Integer
     * */
    public function getRows($id_bencana = '') {
        $this->db->select('id_bencana,foto');
        $this->db->from('tb_foto');
        if ($id_bencana) {
            $this->db->where('id_bencana', $id_bencana);
            $query = $this->db->get();
            $result = $query->row_array();
        } else {
            $this->db->order_by('id_foto', 'desc');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return !empty($result) ? $result : false;
    }

    public function min_month() {
        $query = $this->db->query("SELECT MIN(tanggal) AS tanggal FROM tb_bencana WHERE tanggal NOT IN('0')")->row();
        return $query->tanggal;
    }

    /**
     * menghitung status dokumen
     *
     * @return Integer
     * */
    public function count_status($id_jenis = 0, $tanggal = 0) {
        if (!$tanggal) :
            $query = $this->db->query("SELECT * FROM tb_bencana WHERE id_jenis = '{$id_jenis}'");
        else :
            $query = $this->db->query("SELECT * FROM tb_bencana WHERE id_jenis = '{$id_jenis}' AND tanggal = '{$tanggal}'");
        endif;
        return (!$query->num_rows()) ? '-' : $query->num_rows();
    }

    /**
     * menghitung Luas Dokumen
     *
     * @return Integer
     * */
    public function count_luas($id_jenis = 0, $tanggal = 0) {
        if ($id_jenis == 5) :
            $query = $this->db->query("SELECT SUM(luas) AS luas FROM tb_bencana WHERE id_jenis = '{$id_jenis}' AND tanggal = '{$tanggal}'")->row();
        //$query = $this->db->query("SELECT SUM(luas) AS luas FROM tb_buku_tanah WHERE id_hak = '{$id_hak}' AND tahun = '{$tahun}'")->row();
        elseif (!$tanggal) :
            // tinggalkan jenis hak
            $query = $this->db->query("SELECT SUM(luas) AS luas FROM tb_bencana WHERE id_jenis = '{$id_jenis}'")->row();
//			$query = $this->db->query("SELECT SUM(luas) AS luas FROM tb_bencana WHERE id_jenis = '{$id_hak}' AND status_buku NOT IN ('N')")->row();
        else :
            $query = $this->db->query("SELECT SUM(luas) AS luas FROM tb_bencana WHERE id_jenis = '{$id_jenis}' AND tanggal = '{$tanggal}'")->row();
//			$query = $this->db->query("SELECT SUM(luas) AS luas FROM tb_bencana WHERE id_jenis = '{$id_hak}' AND tahun = '{$tahun}' AND status_buku NOT IN ('N')")->row();
        endif;
        return (!$query->luas) ? '-' : number_format($query->luas);
    }

}

/* End of file M_laporan.php */
/* Location: ./application/models/M_laporan.php */