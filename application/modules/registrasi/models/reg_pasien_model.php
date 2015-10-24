<?php

class Reg_pasien_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function getDataStatusKawin() {
        $query = $this->db->query("
            SELECT
            `rsk_id` AS kode,
            `rsk_nama` AS nama
            FROM  ref_status_kawin
            WHERE rsk_isaktif = '1'
            ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function getDataGolonganDarah() {
        $query = $this->db->query("
            SELECT
            `rgd_id` AS kode,
            `rgd_id` AS nama
             FROM `ref_golongan_darah`
            WHERE `rgd_isaktif` = '1'
            ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function getDataAgama() {
        $query = $this->db->query("
            SELECT
            `rgd_id` AS kode,
            `rgd_id` AS nama
             FROM `ref_golongan_darah`
            WHERE `rgd_isaktif` = '1'
            ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function getDataPropinsi() {
        $query = $this->db->query("
            SELECT
            `rpro_id` AS kode,
            `rpro_nama` AS nama
            FROM `ref_propinsi`
            WHERE `rpro_isaktif` = '1'
            ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function getDataPendidikan() {
        $query = $this->db->query("
            SELECT
            `rpend_id` AS kode,
            `rpend_nama` AS nama
            FROM `ref_pendidikan`
             WHERE `rpend_isaktif` = '1'
            ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function getDataPekerjaan() {
        $query = $this->db->query("
            SELECT
            `rpend_id` AS kode,
            `rpend_nama` AS nama
            FROM `ref_pendidikan`
             WHERE `rpend_isaktif` = '1'
            ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function getDataKabupatenByProp($idProp) {
        $query = $this->db->query("
            SELECT
            `rkab_id` AS kode,
            `rkab_nama` AS nama
            FROM  `ref_kabupaten`
            WHERE  `rkab_isaktif` =  '1'
            AND  `rpro_id` =  $idProp
                        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function tableDescription($tableName) {
        $query = $this->db->query("
        describe $tableName
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }

    /*
     * mengambil data options triwulan
     */

    function dataTriwulanAll() {
        $query = $this->db->query("
        SELECT 
        triwulan_code kode,
        triwulan_name nama 
        FROM master_triwulan
        WHERE triwulan_aktif = '1'
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    /*
     * mengambil data options tahun ajaran
     */

    function dataTahunAjaran() {
        $query = $this->db->query("
        SELECT 
        tahun_code kode,
        tahun_name nama
        FROM master_tahun 
        ORDER BY tahun_name desc
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    /*
     * mengambil data sumber data bos
     */

    function dataSumberDataBos() {
        $query = $this->db->query("
            SELECT 
            donatur_code kode,
            donatur_name nama
            FROM master_donatur
            WHERE donatur_aktif = '1'
            AND donatur_parent IN(
                    SELECT donatur_code 
                    FROM master_donatur
                    WHERE donatur_aktif = '1'
                    AND donatur_parent = '10'
            )    
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    /*
     * mengambil data sumber data bos
     */

    function dataSumberDataBosByParent($kodeParent) {
        $query = $this->db->query("
            SELECT 
            donatur_code kode,
            donatur_name nama
            FROM master_donatur
            WHERE donatur_aktif = '1'
            AND donatur_parent = '$kodeParent'
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    /*
     * cek sudah ada penerimaan dana bos
     */

    function cekSudahAdaDataBos($tahun, $triwulan, $sumberBos) {
        $query = $this->db->query("
            SELECT
            A.k1_code ID_TRANS
            FROM trans_k1 A
            WHERE A.k1_tahun_code = '$tahun'
            AND A.k1_triwulan_code = '$triwulan'
            AND A.k1_donatur_code = '$sumberBos'
            AND A.k1_status = 0
        ");
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * simpan transaksi
     */

    function simpanData($data) {
        $result = array(
            'status' => FALSE,
            'idTrans' => NULL
        );
        if (!empty($data['k1_code'])) {
            $this->db->set('k1_last_update', 'now()', FALSE);
            $this->db->where('k1_code', $data['k1_code']);
            $this->db->update('trans_k1', $data);
        } else {
            $this->db->set('k1_last_update', 'now()', FALSE);
            $this->db->insert('trans_k1', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['k1_code'])) {
                $result['idTrans'] = $data['k1_code'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(k1_code) id FROM trans_k1    
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
            A.k1_code ID_TRANS,
            A.k1_triwulan_code KODE_TRIWULAN,
            A.k1_donatur_code KODE_SUMBER_DANA,
            A.k1_nns NSS,
            A.k1_jumlah_siswa JUMLAH_SISWA,
            A.k1_uang_per_siswa UANG_PER_SISWA,
            DATE_FORMAT(A.k1_date, '%d/%m/%Y') TGL,
            A.k1_no_urut NO_URUT_TERIMA,
            A.k1_no_kode NO_KODE_TERIMA,
            A.k1_uraian URAIAN_TERIMA,
            A.k1_uang_terima UANG_TERIMA,
            B.triwulan_name NAMA_TRIWULAN,
            C.donatur_name NAMA_SUMBER_DANA
            FROM trans_k1 A
            JOIN master_triwulan B ON B.triwulan_code = A.k1_triwulan_code
            JOIN master_donatur C ON C.donatur_code = A.k1_donatur_code
            WHERE A.k1_tahun_code = '$tahun'
            AND A.k1_triwulan_code = '$triwulan'
            AND A.k1_status = 0
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
            k1_code ID_TRANS,
            k1_tahun_code KODE_TAHUN,
            k1_triwulan_code KODE_TRIWULAN,
            k1_donatur_code KODE_SUMBER_DANA,
            k1_nns NSS,
            k1_jumlah_siswa JUMLAH_SISWA,
            k1_uang_per_siswa UANG_PER_SISWA,
            DATE_FORMAT(k1_date, '%d-%m-%Y') TGL,
            k1_no_urut NO_URUT_TERIMA,
            k1_no_kode NO_KODE_TERIMA,
            k1_uraian URAIAN_TERIMA,
            k1_uang_terima UANG_TERIMA
            FROM trans_k1
            WHERE k1_code = '$idTrans'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}
?>
