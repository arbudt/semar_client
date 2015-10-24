<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rekammedis_client_model
 *
 * @author ziaha
 */
class Rekammedis_client_model extends MY_Model{
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get($no_rm){
        $q = $this->db->from('trans_diagnosa')
                ->join('trans_kunjungan', 'trans_diagnosa.tkunj_id = trans_kunjungan.tkunj_id','left')
                ->join('mst_pasien','trans_diagnosa.mpas_id = mst_pasien.mpas_id','left')
                ->join('mst_poli', 'trans_kunjungan.mpoli_id = mst_poli.mpoli_id')
                ->where('trans_diagnosa.mpas_id', $no_rm)
                ->select('trans_diagnosa.tdiag_nama, mst_poli.mpoli_nama, trans_kunjungan.tkunj_tanggal, mst_pasien.mpas_nama')
                ->get();
        return $q->num_rows() > 0 ? $q->result() : null;
    }
}
