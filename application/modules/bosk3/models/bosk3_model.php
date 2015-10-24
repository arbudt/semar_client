<?php

class Bosk3_model extends MY_Model {

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
        if (!empty($data['k3_code'])) {
            $this->db->set('k3_last_update', 'now()', FALSE);
            $this->db->where('k3_code', $data['k3_code']);
            $this->db->update('trans_k3', $data);
        } else {
            $this->db->set('k3_last_update', 'now()', FALSE);
            $this->db->insert('trans_k3', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['k3_code'])) {
                $result['idTrans'] = $data['k3_code'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(k3_code) id FROM trans_k3
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
            k3_code ID_TRANS,
            k3_tahun_code KODE_TAHUN,
            k3_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(k3_date, '%d-%m-%Y') TGL,
            k3_no_bukti NO_BUKTI,
            k3_no_kode NO_KODE,
            k3_uraian URAIAN,
            k3_price JUMLAH_PENGELUARAN,
            k3_input_pph INPUT_PPH
            FROM trans_k3
            WHERE k3_code = '$idTrans'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

    /*
     * saldo Bos by tahun dan triwulan
     */
    function saldoBosByTahunTriwulan($tahun, $triwulan) {
        $query = $this->db->query("
        SELECT SUM(k1_uang_terima) SALDO 
        FROM trans_k1 
        WHERE k1_tahun_code = '$tahun'
        AND k1_triwulan_code = '$triwulan'
        AND k1_donatur_code IN('1','2','3')
        AND k1_status = 0
        ");
        if ($query->num_rows() > 0) {
            return $query->row()->SALDO;
        } else {
            return 0;
        }
    }
    
    /*
     * saldo Bos by tahun dan triwulan
     */
    function saldoBosTriwulanKemarinByTahunTriwulan($tahun, $triwulan) {
        $query = $this->db->query("
        SELECT SUM(k1_uang_terima) SALDO 
        FROM trans_k1 
        WHERE k1_tahun_code = '$tahun'
        AND k1_triwulan_code = '$triwulan'
        AND k1_donatur_code IN('4','5','6')
        AND k1_status = 0
        ");
        if ($query->num_rows() > 0) {
            return $query->row()->SALDO;
        } else {
            return 0;
        }
    }


    function saldoBosByTriwulan($triwulan) {
        $query = $this->db->query("
        SELECT SUM(k1_price) SALDO FROM trans_k1 WHERE k1_triwulan_code = '$triwulan' AND k1_status = 0
        ");
        if ($query->num_rows() > 0) {
            return $query->row()->SALDO;
        } else {
            return 0;
        }
    }

}

?>
