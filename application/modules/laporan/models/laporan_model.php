<?php

class Laporan_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * mengambil data identitas sekolah
     */

    function dataIdentitasByKey($key) {
        $query = $this->db->query("
            SELECT 
            identitas_code KODE,
            identitas_label LABEL,
            identitas_value STRING_VALUE
            FROM identitas_sekolah
            WHERE identitas_key = '$key'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

    function dataLaporanBosk1($tahunAjaran, $triwulan, $tglAkwal, $tglAkhir) {
        $query = $this->db->query("
            SELECT 
            A.k1_code ID_TRANS,
            A.k1_tahun_code KODE_TAHUN,
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
            WHERE A.k1_tahun_code = '$tahunAjaran'
            AND A.k1_triwulan_code = '$triwulan'
            AND A.k1_status = 0
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function dataLaporanBosk2($tahunAjaran, $triwulan, $tglAkwal, $tglAkhir) {
        $query = $this->db->query("
            SELECT 
            A.k2_code ID_TRANS,
            A.k2_triwulan_code KODE_TRIWULAN,
            A.k2_donatur_code KODE_SUMBER_DANA,
            DATE_FORMAT(A.k2_date, '%d/%m/%Y') TGL,
            A.k2_no_urut NO_URUT,
            A.k2_no_kode NO_KODE,
            A.k2_uraian URAIAN,
            A.k2_price HARGA,
            B.triwulan_name NAMA_TRIWULAN,
            C.donatur_name NAMA_SUMBER_DANA
            FROM trans_k2 A
            JOIN master_triwulan B ON B.triwulan_code = A.k2_triwulan_code
            JOIN master_donatur C ON C.donatur_code = A.k2_triwulan_code
            WHERE A.k2_tahun_code = '$tahunAjaran'
            AND A.k2_triwulan_code = '$triwulan'
            AND A.k2_status = 0
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function dataLaporanBosk3($tahunAjaran, $triwulan, $tglAkwal, $tglAkhir) {
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
            WHERE A.k3_tahun_code = '$tahunAjaran'
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

    function dataLaporanBosk4($tahunAjaran, $triwulan, $tglAkwal, $tglAkhir) {
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
            WHERE A.k4_tahun_code = '$tahunAjaran'
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

    function dataLaporanBosk5($tahunAjaran, $triwulan, $tglAkwal, $tglAkhir) {
        $query = $this->db->query("
            SELECT 
            A.k5_code ID_TRANS,
            A.k5_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(A.k5_date, '%d/%m/%Y') TGL,
            A.k5_no_bukti NO_BUKTI,
            A.k5_no_kode NO_KODE,
            A.k5_uraian URAIAN,
            A.k5_price JUMLAH_PENGELUARAN,
            B.triwulan_name NAMA_TRIWULAN
            FROM trans_k5 A
            JOIN master_triwulan B ON B.triwulan_code = A.k5_triwulan_code
            WHERE A.k5_tahun_code = '$tahunAjaran'
            AND A.k5_triwulan_code = '$triwulan'
            AND A.k5_status = 0
            ORDER BY A.k5_date ASC
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }
    
    function dataLaporanBosk6($tahunAjaran, $triwulan, $tglAkwal, $tglAkhir) {
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
            A.k6_total_price JUMLAH_TOTAL
            FROM trans_k6 A
            WHERE A.k6_tahun_code = '$tahunAjaran'
            AND A.k6_triwulan_code = '$triwulan'
            AND A.k6_status = 0
            ORDER BY A.k6_date ASC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }

    function dataLaporanPengeluaran($tahunAjaran, $triwulan, $tglAkwal, $tglAkhir) {
        $query = $this->db->query("
            SELECT 
            A.gaji_code ID_TRANS,
            A.gaji_tahun_code KODE_TAHUN,
            A.gaji_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(A.gaji_date, '%d/%m/%Y') TGL,
            A.guru_code KODE_GURU,
            C.guru_name NAMA_GURU,
            A.gaji_tugas TUGAS,
            A.gaji_price JUMLAH,
            B.triwulan_name NAMA_TRIWULAN
            FROM trans_gaji A
            JOIN master_triwulan B ON B.triwulan_code = A.gaji_triwulan_code
            JOIN master_guru C ON C.guru_code = A.guru_code
            WHERE A.gaji_tahun_code = '$tahunAjaran'
            AND A.gaji_triwulan_code = '$triwulan'
            AND A.gaji_status = 0
            ORDER BY A.gaji_date ASC
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function dataLaporanBosk7($tahunAjaran, $triwulan, $tglAwal, $tglAkhir) {
        $query = $this->db->query("
            SELECT 
            A.k7_code ID_TRANS,
            A.k7_tahun_code KODE_TAHUN,
            A.k7_triwulan_code KODE_TRIWULAN,
            B.triwulan_name NAMA_TRIWULAN,
            A.k7_uraian URAIAN,
            A.k7_no_kode NO_KODE,
            A.k7_sumber_dana_bos KODE_DANA_BOS,
            A.k7_jumlah_dana_bos JUMLAH_DANA_BOS,
            A.k7_sumber_dana_pendapatan_sekolah KODE_PENDAPATAN_SEKOLAH,
            A.k7_jumlah_dana_pendapatan_sekolah JUMLAH_PENDAPATAN_SEKOLAH,
            A.k7_sumber_dana_pendapatan_lain KODE_PENDAPATAN_LAIN,
            A.k7_jumlah_dana_pendapatan_lain JUMLAH_PENDAPATAN_LAIN,
            A.k7_jumlah_bantuan_lain JUMLAH_BANTUAN_LAIN,
            (A.k7_jumlah_dana_bos + A.k7_jumlah_dana_pendapatan_sekolah + A.k7_jumlah_dana_pendapatan_lain + A.k7_jumlah_bantuan_lain) TOTAL_DANA
            FROM trans_k7 A
            JOIN master_triwulan B ON B.triwulan_code = A.k7_triwulan_code
            WHERE A.k7_tahun_code = '$tahunAjaran'
            AND A.k7_triwulan_code = '$triwulan'
            AND A.k7_status = 0
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

}

?>
