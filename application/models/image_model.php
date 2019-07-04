<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Image_model extends CI_Model {

    function insert_image($image, $id_bencana) {
        $data = array(
            'id_bencana' => $this->input->post($id_bencana),
            'foto' => $image
        );
        $this->db->insert('tb_foto', $data);
    }

    //get images from database
    public function get_images() {
        $this->db->select('*');
        $this->db->order_by('id_foto');
        $query = $this->db->get('tb_foto');
        return $query->result();
    }
    
    

    public function getRows($id = '') {
        $this->db->select('id_foto,id_bencana,foto');
        $this->db->from('tb_foto');
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

    public function insert($data = array()) {
        $insert = $this->db->insert_batch('tb_foto', $data);
        return $insert ? true : false;
    }

}
