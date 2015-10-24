<?php

class Bosk6_model extends MY_Model {

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
        if (!empty($data['k6_code'])) {
            $this->db->set('k6_last_update', 'now()', FALSE);
            $this->db->where('k6_code', $data['k6_code']);
            $this->db->update('trans_k6', $data);
        } else {
            $this->db->set('k6_last_update', 'now()', FALSE);
            $this->db->insert('trans_k6', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['k6_code'])) {
                $result['idTrans'] = $data['k6_code'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(k6_code) id FROM trans_k6
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
            A.k6_code ID_TRANS,
            A.k6_tahun_code KOdE_TAHUN,
            A.k6_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(A.k6_date, '%d/%m/%Y') TGL,
            A.k6_no_bukti NO_BUKTI,
            A.k6_no_kode NO_KODE,
            A.k6_uraian URAIAN,
            A.k6_ppn JUMLAH_PPN,
            A.k6_ppn21 JUMLAH_PPN21,
            A.k6_ppn22 JUMLAH_PPN22,
            A.k6_ppn23 JUMLAH_PPN23,
            A.k6_total_price JUMLAH_TOTAL,
            B.triwulan_name NAMA_TRIWULAN
            FROM trans_k6 A
            JOIN master_triwulan B ON B.triwulan_code = A.k6_triwulan_code
            WHERE A.k6_tahun_code = '$tahun'
            AND A.k6_triwulan_code = '$triwulan'
            AND A.k6_status = 0
            ORDER BY A.k6_date ASC
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function dataTransPPhK3ByFilter($tahun, $triwulan) {
        $query = $this->db->query("
            SELECT
            A.k3_code ID_TRANS,
            A.k3_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(A.k3_date, '%d/%m/%Y') TGL,
            A.k3_no_bukti NO_BUKTI,
            A.k3_no_kode NO_KODE,
            A.k3_uraian URAIAN,
            A.k3_price JUMLAH_PENGELUARAN,
            B.triwulan_name NAMA_TRIWULAN,
            A.k3_input_pph INPUT_PPH
            FROM trans_k3 A
            JOIN master_triwulan B ON B.triwulan_code = A.k3_triwulan_code
            WHERE A.k3_tahun_code = '$tahun'
            AND A.k3_triwulan_code = '$triwulan'
            AND A.k3_input_pph = '1'
            AND A.k3_status = 0
            ORDER BY A.k3_date ASC
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
            k6_code ID_TRANS,
            k6_tahun_code KODE_TAHUN,
            k6_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(k6_date, '%d-%m-%Y') TGL,
            k6_no_bukti NO_BUKTI,
            k6_no_kode NO_KODE,
            k6_uraian URAIAN,
            0 JUMLAH_PENERIMAAN,
            k6_ppn JUMLAH_PPN,
        	k6_ppn21 JUMLAH_PPN21,
        	k6_ppn22 JUMLAH_PPN22,
        	k6_ppn23 JUMLAH_PPN23,
        	k6_total_price JUMLAH_TOTAL,
            0 JUMLAH_SALDO
            FROM trans_k6
            WHERE k6_code = '$idTrans'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}

?>
