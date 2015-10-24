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
            `rag_id` AS kode,
            `rag_nama` AS nama
             FROM `ref_agama` WHERE `rag_isaktif` ='1'
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
            `rpek_id` AS kode,
            `rpek_nama` AS nama
            FROM `ref_pekerjaan` WHERE `rpek_isaktif` = '1'
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

    function getDataKecamatanBykab($id) {
        $query = $this->db->query("
            SELECT
            `rkec_id` AS kode,
            `rkec_nama` AS nama
            FROM `ref_kecamatan`
            WHERE `rkec_isaktif` = '1'
            AND `rkab_id` = '$id'
                        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function getDataKelurahanBykec($id) {
        $query = $this->db->query("
            SELECT
            `rkel_id` AS kode,
            `rkel_nama` AS nama
            FROM `ref_kelurahan`
            WHERE `rkel_isaktif` = '1'
            AND `rkec_id` = '$id'
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
     * simpan transaksi
     */

    function simpanData($data) {
        $result = array(
            'status' => FALSE,
            'mpas_id' => NULL
        );
        if (!empty($data['mpas_id'])) {
//            $this->db->set('k1_last_update', 'now()', FALSE);
            $this->db->where('mpas_id', $data['mpas_id']);
            $this->db->update('mst_pasien', $data);
        } else {
//            $this->db->set('k1_last_update', 'now()', FALSE);
            $this->db->insert('mst_pasien', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['mpas_id'])) {
                $result['mpas_id'] = $data['mpas_id'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(mpas_id) id FROM mst_pasien
                ");
                if ($querySelect->num_rows() > 0) {
                    $result['mpas_id'] = $querySelect->row()->id;
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
     * mengambil data by id
     */

    function dataPasienByDd($id) {
        $query = $this->db->query("
            SELECT
            *
            FROM `mst_pasien`
            WHERE `mpas_id` = '$id'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}
