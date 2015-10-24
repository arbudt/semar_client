<?php

class Bosk4_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * simpan transaksi
     */

    function simpanData($data) {
        $result = array(
            'status' => FALSE,
            'idTrans' => NULL
        );
        if (!empty($data['k4_code'])) {
            $this->db->set('k4_last_update', 'now()', FALSE);
            $this->db->where('k4_code', $data['k4_code']);
            $this->db->update('trans_k4', $data);
        } else {
            $this->db->set('k4_last_update', 'now()', FALSE);
            $this->db->insert('trans_k4', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['k4_code'])) {
                $result['idTrans'] = $data['k4_code'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(k4_code) id FROM trans_k4
                ");
                if ($querySelect->num_rows() > 0) {
                    $result['idTrans'] = $querySelect->row()->id;
                }
            }
        }
        return $result;
    }

    /*
     * mengambil data limit
     */

    function dataTransByFilter($tahun, $triwulan) {
        $query = $this->db->query("
            SELECT 
            A.k4_code ID_TRANS,
            A.k4_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(A.k4_date, '%d/%m/%Y') TGL,
            A.k4_no_bukti NO_BUKTI,
            A.k4_no_kode NO_KODE,
            A.k4_uraian URAIAN,
            A.k4_price JUMLAH_PENGELUARAN,
            B.triwulan_name NAMA_TRIWULAN
            FROM trans_k4 A
            JOIN master_triwulan B ON B.triwulan_code = A.k4_triwulan_code
            WHERE A.k4_tahun_code = '$tahun'
            AND A.k4_triwulan_code = '$triwulan'
            AND A.k4_status = 0 
            ORDER BY A.k4_date ASC
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    /*
     * mengambil transaksi by id transaksi
     */

    function dataTransById($idTrans) {
        $query = $this->db->query("
            SELECT 
            k4_code ID_TRANS,
            k4_tahun_code KODE_TAHUN,
            k4_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(k4_date, '%d-%m-%Y') TGL,
            k4_no_bukti NO_BUKTI,
            k4_no_kode NO_KODE,
            k4_uraian URAIAN,
            k4_price JUMLAH_PENGELUARAN
            FROM trans_k4
            WHERE k4_code = '$idTrans'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}

?>
