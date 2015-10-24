<?php

class Monitoring_dana_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * saldo Bos by tahun dan triwulan
     */

    function danaPenerimaanBosByTahunTriwulan($tahun, $triwulan) {
        $query = $this->db->query("
        SELECT SUM(k1_uang_terima) SALDO
        FROM trans_k1
        WHERE k1_tahun_code = '$tahun'
        AND k1_triwulan_code = '$triwulan'
        AND k1_donatur_code IN('1','2','3','4','5','6')
        AND k1_status = 0
        ");
        if ($query->num_rows() > 0) {
            if (!empty($query->row()->SALDO)) {
                return $query->row()->SALDO;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function danaPengeluaranBosByTahunTriwulan($tahun, $triwulan) {
        $query = $this->db->query("
        SELECT SUM(k3_price) PENGELUARAN FROM trans_k3
        WHERE k3_status = '0'
        AND k3_tahun_code = '$tahun'
        AND k3_triwulan_code = '$triwulan'
        ");
        if ($query->num_rows() > 0) {
            if (!empty($query->row()->PENGELUARAN)) {
                return $query->row()->PENGELUARAN;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

}
?>
