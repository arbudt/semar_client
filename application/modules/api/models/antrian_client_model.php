<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of antrian_client_model
 *
 * @author ziaha
 */
class Antrian_client_model extends MY_Model {
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    function get_antrian_total($id_poli, $tanggal){
      
       $q = $this->db->where("DATE_FORMAT(trans_kunjungan.tkunj_tanggal,'%d-%m-%Y')", $tanggal)
               ->where('trans_kunjungan.mpoli_id', $id_poli)
               ->select('trans_kunjungan.tkunj_no_antrian')
               ->where("trans_kunjungan.tkunj_status_ambil", 1)
               ->from('trans_kunjungan')
               ->order_by('trans_kunjungan.tkunj_id', 'DESC')
               ->limit(1)
               ->get();
       return $q->num_rows() > 0 ? $q->row() : null;
    }

        function get_antrian_sekarang($id_poli, $tanggal){
      
       $q = $this->db->where("DATE_FORMAT(trans_kunjungan.tkunj_tanggal,'%d-%m-%Y')", $tanggal)
               ->where('trans_kunjungan.mpoli_id', $id_poli)
               ->select('trans_kunjungan.tkunj_no_antrian')
               ->where("trans_kunjungan.tkunj_status_ambil", 1)
               ->from('trans_kunjungan')
               ->order_by('trans_kunjungan.tkunj_id', 'DESC')
               ->limit(1)
               ->get();
       return $q->num_rows() > 0 ? $q->row() : null;
    }
}
