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

    function dataPasienByFilter($noRM, $nama) {
        $addWhere = '';
        if (!empty($noRM)) {
            $addWhere .= " AND `mpas_id` = '$id'";
        }
        if (!empty($nama)) {
            $addWhere .= " AND `rag_nama` like '%$nama%' ";
        }
        $query = $this->db->query("
            SELECT
            `mpas_id`,
            `mpas_nama
            `mpas_jenis_kelamin`,
            `mpas_tempat_lahir`,
            `mpas_tanggal_lahir`,
            `mpas_alamat`
            FROM `mst_pasien` WHERE 1
            FROM `mst_pasien`
            WHERE 1
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
