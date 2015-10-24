<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('laporan/laporan_model');
        $this->load->model('bosk3/bosk3_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'laporan/view_laporan';
        $data['menuTitle'] = 'LAPORAN';
        $data['menuDescription'] = 'Laporan Dana BOS';
        $data['defaultJenisLaporan'] = '';
        $data['defaultTahunAjaran'] = '';
        $data['defaultTriwulan'] = '';
        $data['defaultTanggalAwal'] = '';
        $data['defaultTanggalAkhir'] = '';
        $this->load->view('template', $data);
    }

    /*
     * proses cetak laporan
     */

    public function cetakLaporanPdf() {
        //data POST
        $jenisLaporan = !empty($_POST['jenisLaporan']) ? $_POST['jenisLaporan'] : "";
        $tahunAjaran = !empty($_POST['tahunAjaran']) ? $_POST['tahunAjaran'] : "";
        $triwulan = !empty($_POST['triwulan']) ? $_POST['triwulan'] : "";
        $tanggalAwal = !empty($_POST['tanggalAwal']) ? $_POST['tanggalAwal'] : '';
        $tanggalAkhir = !empty($_POST['tanggalAkhir']) ? $_POST['tanggalAkhir'] : '';

        $data['defaultJenisLaporan'] = $jenisLaporan;
        $data['defaultTahunAjaran'] = $tahunAjaran;
        $data['defaultTriwulan'] = $triwulan;
        $data['defaultTanggalAwal'] = $tanggalAwal;
        $data['defaultTanggalAkhir'] = $tanggalAkhir;
        $tanggalCetak = 'Tgl. Cetak : ' . date('d/m/Y h:i');
        if ($jenisLaporan == 'bosk1' && !empty($tahunAjaran) && !empty($triwulan)) {
            $data['iframe_url'] = site_url('laporan/laporan/laporanBosk1/' . $tahunAjaran . '/' . $triwulan . '/' . $tanggalAwal . '/' . $tanggalAkhir);
            addLogAktifity('laporan', 'laporan k1', 'kriteria pencarian {tahun:' . $tahunAjaran . ', triwulan:' . $triwulan . ', tanggal:' . $tanggalAwal . '-' . $tanggalAkhir . '}');
        } else if ($jenisLaporan == 'bosk2' && !empty($tahunAjaran) && !empty($triwulan)) {
            $data['iframe_url'] = site_url('laporan/laporan/laporanBosk2/' . $tahunAjaran . '/' . $triwulan . '/' . $tanggalAwal . '/' . $tanggalAkhir);
            addLogAktifity('laporan', 'laporan k2', 'kriteria pencarian {tahun:' . $tahunAjaran . ', triwulan:' . $triwulan . ', tanggal:' . $tanggalAwal . '-' . $tanggalAkhir . '}');
        } else if ($jenisLaporan == 'bosk3' && !empty($tahunAjaran) && !empty($triwulan)) {
            $data['iframe_url'] = site_url('laporan/laporan/laporanBosk3/' . $tahunAjaran . '/' . $triwulan . '/' . $tanggalAwal . '/' . $tanggalAkhir);
            addLogAktifity('laporan', 'laporan k3', 'kriteria pencarian {tahun:' . $tahunAjaran . ', triwulan:' . $triwulan . ', tanggal:' . $tanggalAwal . '-' . $tanggalAkhir . '}');
        } else if ($jenisLaporan == 'bosk4' && !empty($tahunAjaran) && !empty($triwulan)) {
            $data['iframe_url'] = site_url('laporan/laporan/laporanBosk4/' . $tahunAjaran . '/' . $triwulan . '/' . $tanggalAwal . '/' . $tanggalAkhir);
            addLogAktifity('laporan', 'laporan k4', 'kriteria pencarian {tahun:' . $tahunAjaran . ', triwulan:' . $triwulan . ', tanggal:' . $tanggalAwal . '-' . $tanggalAkhir . '}');
        } else if ($jenisLaporan == 'bosk5' && !empty($tahunAjaran) && !empty($triwulan)) {
            $data['iframe_url'] = site_url('laporan/laporan/laporanBosk5/' . $tahunAjaran . '/' . $triwulan . '/' . $tanggalAwal . '/' . $tanggalAkhir);
            addLogAktifity('laporan', 'laporan k5', 'kriteria pencarian {tahun:' . $tahunAjaran . ', triwulan:' . $triwulan . ', tanggal:' . $tanggalAwal . '-' . $tanggalAkhir . '}');
        } else if ($jenisLaporan == 'bosk6' && !empty($tahunAjaran) && !empty($triwulan)) {
            $data['iframe_url'] = site_url('laporan/laporan/laporanBosk6/' . $tahunAjaran . '/' . $triwulan . '/' . $tanggalAwal . '/' . $tanggalAkhir);
            addLogAktifity('laporan', 'laporan k6', 'kriteria pencarian {tahun:' . $tahunAjaran . ', triwulan:' . $triwulan . ', tanggal:' . $tanggalAwal . '-' . $tanggalAkhir . '}');
        } else if ($jenisLaporan == 'pengeluaran' && !empty($tahunAjaran) && !empty($triwulan)) {
            $data['iframe_url'] = site_url('laporan/laporan/pengeluaran/' . $tahunAjaran . '/' . $triwulan . '/' . $tanggalAwal . '/' . $tanggalAkhir);
            addLogAktifity('laporan', 'laporan pengeluaran gaji', 'kriteria pencarian {tahun:' . $tahunAjaran . ', triwulan:' . $triwulan . ', tanggal:' . $tanggalAwal . '-' . $tanggalAkhir . '}');
        } else if ($jenisLaporan == 'bosk7' && !empty($tahunAjaran) && !empty($triwulan)) {
            $data['iframe_url'] = site_url('laporan/laporan/laporanBosk7/' . $tahunAjaran . '/' . $triwulan . '/' . $tanggalAwal . '/' . $tanggalAkhir);
            addLogAktifity('laporan', 'laporan k7', 'kriteria pencarian {tahun:' . $tahunAjaran . ', triwulan:' . $triwulan . ', tanggal:' . $tanggalAwal . '-' . $tanggalAkhir . '}');
        }
        $data['previlages'] = $this->previlages;
        $data['page'] = 'laporan/view_laporan';
        $data['menuTitle'] = 'LAPORAN';
        $data['menuDescription'] = 'Laporan Dana BOS';
        $this->load->view('template', $data);
    }

    function laporanBosk1($tahunAjaran, $triwulan, $tglAwal='', $tglAkhir='') {
        $this->load->library('Pdf');
        $data = array();
        $dataLaporan = $this->laporan_model->dataLaporanBosk1($tahunAjaran, $triwulan, $tglAwal, $tglAkhir);
        $data['dataDetail'] = $dataLaporan;
        $data['dataCetak']['TITLE'] = "LAPORAN PENERIMAAN DANA BOS";
        $data['dataCetak']['NAMA_SEKOLAH'] = getValueIdentitasByKey('nama_sekolah');
        $data['dataCetak']['KELURAHAN'] = getValueIdentitasByKey('desa');
        $data['dataCetak']['KECAMATAN'] = getValueIdentitasByKey('kecamatan');
        $data['dataCetak']['KABUPATEN'] = getValueIdentitasByKey('kabupaten');
        $data['dataCetak']['PROVINSI'] = getValueIdentitasByKey('provinsi');
        $this->load->view('laporan/view_pdf_laporan_bos_k1', $data);
    }

    function laporanBosk2($tahunAjaran, $triwulan, $tglAwal='', $tglAkhir='') {
        $this->load->library('Pdf');
        $data = array();
        $dataLaporan = $this->laporan_model->dataLaporanBosk2($tahunAjaran, $triwulan, $tglAwal, $tglAkhir);
        $data['dataDetail'] = $dataLaporan;
        $data['dataCetak']['TITLE'] = "LAPORAN RENCANA ANGGARAN";
        $data['dataCetak']['NAMA_SEKOLAH'] = getValueIdentitasByKey('nama_sekolah');
        $data['dataCetak']['KELURAHAN'] = getValueIdentitasByKey('desa');
        $data['dataCetak']['KECAMATAN'] = getValueIdentitasByKey('kecamatan');
        $data['dataCetak']['KABUPATEN'] = getValueIdentitasByKey('kabupaten');
        $data['dataCetak']['PROVINSI'] = getValueIdentitasByKey('provinsi');
        $this->load->view('laporan/view_pdf_laporan_bos_k2', $data);
    }

    function laporanBosk3($tahunAjaran, $triwulan, $tglAwal='', $tglAkhir='') {
        $this->load->library('Pdf');
        $data = array();
        $saldo = $this->bosk3_model->saldoBosByTahunTriwulan($tahunAjaran, $triwulan);
        $saldoKemarin = $this->bosk3_model->saldoBosTriwulanKemarinByTahunTriwulan($tahunAjaran, $triwulan);
        $dataLaporan = $this->laporan_model->dataLaporanBosk3($tahunAjaran, $triwulan, $tglAwal, $tglAkhir);
        $arrData[] = array(
            'ID_TRANS' => 'saldoKemarin',
            'TGL' => '',
            'NO_BUKTI' => '',
            'NO_KODE' => '',
            'URAIAN' => 'Sisa triwulan Kemarin',
            'JUMLAH_PENERIMAAN' => $saldoKemarin,
            'JUMLAH_PENGELUARAN' => 0,
            'JUMLAH_SALDO' => $saldoKemarin
        );

        $totalSaldo = $saldoKemarin + $saldo;
        $totalPenerimaan = $totalSaldo;
        $totalPengeluaran = 0;
        $arrData[] = array(
            'ID_TRANS' => 'saldoBos',
            'TGL' => '',
            'NO_BUKTI' => '',
            'NO_KODE' => '',
            'URAIAN' => 'Terima BOS',
            'JUMLAH_PENERIMAAN' => $saldo,
            'JUMLAH_PENGELUARAN' => 0,
            'JUMLAH_SALDO' => $totalSaldo
        );
        if ($dataLaporan != NULL) {
            foreach ($dataLaporan as $row) {
                $keluar = $row->JUMLAH_PENGELUARAN;
                $totalPengeluaran = $totalPengeluaran + $keluar;
                $totalSaldo = $totalSaldo - $keluar;
                $arrData[] = array(
                    'ID_TRANS' => $row->ID_TRANS,
                    'TGL' => $row->TGL,
                    'NO_BUKTI' => $row->NO_BUKTI,
                    'NO_KODE' => $row->NO_KODE,
                    'URAIAN' => $row->URAIAN,
                    'JUMLAH_PENERIMAAN' => 0,
                    'JUMLAH_PENGELUARAN' => $keluar,
                    'JUMLAH_SALDO' => $totalSaldo
                );
                if ($row->INPUT_PPH == '1') {//hitung nilai pph (penerimaan)
                    $nilaiPPh = intval($keluar) * 10 / 100;
                    $totalSaldo = $totalSaldo + $nilaiPPh;
                    $arrData[] = array(
                        'ID_TRANS' => 'pph' . $row->ID_TRANS,
                        'TGL' => $row->TGL,
                        'NO_BUKTI' => '',
                        'NO_KODE' => '',
                        'URAIAN' => 'PPh',
                        'JUMLAH_PENERIMAAN' => $nilaiPPh,
                        'JUMLAH_PENGELUARAN' => 0,
                        'JUMLAH_SALDO' => $totalSaldo
                    );
                }
            }
        }
        $data['dataDetail'] = $arrData;
        $data['dataCetak']['TITLE'] = "BUKU KAS UMUM";
        $data['dataCetak']['NAMA_SEKOLAH'] = getValueIdentitasByKey('nama_sekolah');
        $data['dataCetak']['KELURAHAN'] = getValueIdentitasByKey('desa');
        $data['dataCetak']['KECAMATAN'] = getValueIdentitasByKey('kecamatan');
        $data['dataCetak']['KABUPATEN'] = getValueIdentitasByKey('kabupaten');
        $data['dataCetak']['PROVINSI'] = getValueIdentitasByKey('provinsi');

        $data['dataCetak']['SALDO_KAS_UMUMINSI'] = 0;
        $data['dataCetak']['SALDO_BANK'] = 0;
        $data['dataCetak']['SALDO_TUNAI'] = 0;

        $data['dataCetak']['NAMA_KETUA'] = '';
        $data['dataCetak']['NIP_KETUA'] = '';
        $data['dataCetak']['NAMA_BENDAHARA'] = '';
        $data['dataCetak']['NIP_BENDAHARA'] = '';
        $this->load->view('laporan/view_pdf_laporan_bos_k3', $data);
    }

    function laporanBosk4($tahunAjaran, $triwulan, $tglAwal='', $tglAkhir='') {
        $this->load->library('Pdf');
        $data = array();
        $saldo = $this->bosk3_model->saldoBosByTahunTriwulan($tahunAjaran, $triwulan);
        $saldoKemarin = $this->bosk3_model->saldoBosTriwulanKemarinByTahunTriwulan($tahunAjaran, $triwulan);
        $dataLaporan = $this->laporan_model->dataLaporanBosk4($tahunAjaran, $triwulan, $tglAwal, $tglAkhir);
        $arrData[] = array(
            'ID_TRANS' => 'saldoKemarin',
            'TGL' => '',
            'NO_BUKTI' => '',
            'NO_KODE' => '',
            'URAIAN' => 'Sisa triwulan Kemarin',
            'JUMLAH_PENERIMAAN' => $saldoKemarin,
            'JUMLAH_PENGELUARAN' => 0,
            'JUMLAH_SALDO' => $saldoKemarin
        );

        $totalSaldo = $saldoKemarin + $saldo;
        $totalPenerimaan = $totalSaldo;
        $totalPengeluaran = 0;
        $arrData[] = array(
            'ID_TRANS' => 'saldoBos',
            'TGL' => '',
            'NO_BUKTI' => '',
            'NO_KODE' => '',
            'URAIAN' => 'Terima BOS',
            'JUMLAH_PENERIMAAN' => $saldo,
            'JUMLAH_PENGELUARAN' => 0,
            'JUMLAH_SALDO' => $totalSaldo
        );
        if ($dataLaporan != NULL) {
            foreach ($dataLaporan as $row) {
                $keluar = $row->JUMLAH_PENGELUARAN;
                $totalPengeluaran = $totalPengeluaran + $keluar;
                $totalSaldo = $totalSaldo - $keluar;
                $arrData[] = array(
                    'ID_TRANS' => $row->ID_TRANS,
                    'TGL' => $row->TGL,
                    'NO_BUKTI' => $row->NO_BUKTI,
                    'NO_KODE' => $row->NO_KODE,
                    'URAIAN' => $row->URAIAN,
                    'JUMLAH_PENERIMAAN' => 0,
                    'JUMLAH_PENGELUARAN' => $keluar,
                    'JUMLAH_SALDO' => $totalSaldo
                );
            }
        }
        $data['dataDetail'] = $arrData;
        $data['dataCetak']['TITLE'] = "BUKU KAS TUNAI";
        $data['dataCetak']['NAMA_SEKOLAH'] = getValueIdentitasByKey('nama_sekolah');
        $data['dataCetak']['KELURAHAN'] = getValueIdentitasByKey('desa');
        $data['dataCetak']['KECAMATAN'] = getValueIdentitasByKey('kecamatan');
        $data['dataCetak']['KABUPATEN'] = getValueIdentitasByKey('kabupaten');
        $data['dataCetak']['PROVINSI'] = getValueIdentitasByKey('provinsi');

        $data['dataCetak']['NAMA_KETUA'] = '';
        $data['dataCetak']['NIP_KETUA'] = '';
        $data['dataCetak']['NAMA_BENDAHARA'] = '';
        $data['dataCetak']['NIP_BENDAHARA'] = '';
        $this->load->view('laporan/view_pdf_laporan_bos_k4', $data);
    }

    function laporanBosk5($tahunAjaran, $triwulan, $tglAwal='', $tglAkhir='') {
        $this->load->library('Pdf');
        $data = array();
        $saldo = $this->bosk3_model->saldoBosByTahunTriwulan($tahunAjaran, $triwulan);
        $saldoKemarin = $this->bosk3_model->saldoBosTriwulanKemarinByTahunTriwulan($tahunAjaran, $triwulan);
        $dataLaporan = $this->laporan_model->dataLaporanBosk5($tahunAjaran, $triwulan, $tglAwal, $tglAkhir);
        $arrData[] = array(
            'ID_TRANS' => 'saldoKemarin',
            'TGL' => '',
            'NO_BUKTI' => '',
            'NO_KODE' => '',
            'URAIAN' => 'Sisa triwulan Kemarin',
            'JUMLAH_PENERIMAAN' => $saldoKemarin,
            'JUMLAH_PENGELUARAN' => 0,
            'JUMLAH_SALDO' => $saldoKemarin
        );

        $totalSaldo = $saldoKemarin + $saldo;
        $totalPenerimaan = $totalSaldo;
        $totalPengeluaran = 0;
        $arrData[] = array(
            'ID_TRANS' => 'saldoBos',
            'TGL' => '',
            'NO_BUKTI' => '',
            'NO_KODE' => '',
            'URAIAN' => 'Terima BOS',
            'JUMLAH_PENERIMAAN' => $saldo,
            'JUMLAH_PENGELUARAN' => 0,
            'JUMLAH_SALDO' => $totalSaldo
        );
        if ($dataLaporan != NULL) {
            foreach ($dataLaporan as $row) {
                $keluar = $row->JUMLAH_PENGELUARAN;
                $totalPengeluaran = $totalPengeluaran + $keluar;
                $totalSaldo = $totalSaldo - $keluar;
                $arrData[] = array(
                    'ID_TRANS' => $row->ID_TRANS,
                    'TGL' => $row->TGL,
                    'NO_BUKTI' => $row->NO_BUKTI,
                    'NO_KODE' => $row->NO_KODE,
                    'URAIAN' => $row->URAIAN,
                    'JUMLAH_PENERIMAAN' => 0,
                    'JUMLAH_PENGELUARAN' => $keluar,
                    'JUMLAH_SALDO' => $totalSaldo
                );
            }
        }
        $data['dataDetail'] = $arrData;
        $data['dataCetak']['TITLE'] = "BUKU PEMBANTU BANK";
        $data['dataCetak']['NAMA_SEKOLAH'] = getValueIdentitasByKey('nama_sekolah');
        $data['dataCetak']['KELURAHAN'] = getValueIdentitasByKey('desa');
        $data['dataCetak']['KECAMATAN'] = getValueIdentitasByKey('kecamatan');
        $data['dataCetak']['KABUPATEN'] = getValueIdentitasByKey('kabupaten');
        $data['dataCetak']['PROVINSI'] = getValueIdentitasByKey('provinsi');

        $data['dataCetak']['NAMA_KETUA'] = '';
        $data['dataCetak']['NIP_KETUA'] = '';
        $data['dataCetak']['NAMA_BENDAHARA'] = '';
        $data['dataCetak']['NIP_BENDAHARA'] = '';
        $this->load->view('laporan/view_pdf_laporan_bos_k5', $data);
    }

    function laporanBosk6($tahunAjaran, $triwulan, $tglAwal='', $tglAkhir='') {
        $this->load->library('Pdf');
        $data = array();
        $saldo = $this->bosk3_model->saldoBosByTahunTriwulan($tahunAjaran, $triwulan);
        $saldoKemarin = $this->bosk3_model->saldoBosTriwulanKemarinByTahunTriwulan($tahunAjaran, $triwulan);
        $dataLaporan = $this->laporan_model->dataLaporanBosk6($tahunAjaran, $triwulan, $tglAwal, $tglAkhir);
        $data['dataDetail'] = $dataLaporan;

        $data['dataCetak']['TITLE'] = "BUKU PEMBANTU PAJAK";
        $data['dataCetak']['NAMA_SEKOLAH'] = getValueIdentitasByKey('nama_sekolah');
        $data['dataCetak']['KELURAHAN'] = getValueIdentitasByKey('desa');
        $data['dataCetak']['KECAMATAN'] = getValueIdentitasByKey('kecamatan');
        $data['dataCetak']['KABUPATEN'] = getValueIdentitasByKey('kabupaten');
        $data['dataCetak']['PROVINSI'] = getValueIdentitasByKey('provinsi');

        $data['dataCetak']['NAMA_KETUA'] = '';
        $data['dataCetak']['NIP_KETUA'] = '';
        $data['dataCetak']['NAMA_BENDAHARA'] = '';
        $data['dataCetak']['NIP_BENDAHARA'] = '';
        $this->load->view('laporan/view_pdf_laporan_bos_k6', $data);
    }

    function pengeluaran($tahunAjaran, $triwulan, $tglAwal='', $tglAkhir='') {
        $this->load->library('Pdf');
        $data = array();
        $dataLaporan = $this->laporan_model->dataLaporanPengeluaran($tahunAjaran, $triwulan, $tglAwal, $tglAkhir);
        $data['dataDetail'] = $dataLaporan;
        $data['dataCetak']['TITLE'] = "LAPORAN PENGELUARAN";
        $data['dataCetak']['NAMA_SEKOLAH'] = getValueIdentitasByKey('nama_sekolah');
        $data['dataCetak']['KELURAHAN'] = getValueIdentitasByKey('desa');
        $data['dataCetak']['KECAMATAN'] = getValueIdentitasByKey('kecamatan');
        $data['dataCetak']['KABUPATEN'] = getValueIdentitasByKey('kabupaten');
        $data['dataCetak']['PROVINSI'] = getValueIdentitasByKey('provinsi');

        $data['dataCetak']['NAMA_KETUA'] = '';
        $data['dataCetak']['NIP_KETUA'] = '';
        $data['dataCetak']['NAMA_BENDAHARA'] = '';
        $data['dataCetak']['NIP_BENDAHARA'] = '';
        $this->load->view('laporan/view_pdf_laporan_pengeluaran', $data);
    }

    function laporanBosk7($tahunAjaran, $triwulan, $tglAwal='', $tglAkhir='') {
        $this->load->library('Pdf');
        $data = array();
        $dataLaporan = $this->laporan_model->dataLaporanBosk7($tahunAjaran, $triwulan, $tglAwal, $tglAkhir);
        $data['dataDetail'] = $dataLaporan;
        $arrData = array();
        if ($dataLaporan != NULL) {
            foreach ($dataLaporan as $row) {
                $noKode = $row->NO_KODE;
                $namaTriwulan = $row->NAMA_TRIWULAN;
                $uraian = $row->URAIAN;
                $danaLain = $row->JUMLAH_BANTUAN_LAIN;
                $danaTotal = $row->TOTAL_DANA;
                $danaBosPusat = 0;
                $danaBosProvinsi = 0;
                $danaBosKota = 0;
                if ($row->KODE_DANA_BOS == '7') {
                    $danaBosPusat = $row->JUMLAH_DANA_BOS;
                } else if ($row->KODE_DANA_BOS == '8') {
                    $danaBosProvinsi = $row->JUMLAH_DANA_BOS;
                } else {
                    $danaBosKota = $row->JUMLAH_DANA_BOS;
                }
                $danaInfakJumat = 0;
                $danaInfakRaport = 0;
                $danaSukaRela = 0;
                $danaTinggalanKelas = 0;
                if ($row->KODE_PENDAPATAN_SEKOLAH == '15') {
                    $danaInfakJumat = $row->JUMLAH_PENDAPATAN_SEKOLAH;
                } else if ($row->KODE_PENDAPATAN_SEKOLAH == '16') {
                    $danaInfakRaport = $row->JUMLAH_PENDAPATAN_SEKOLAH;
                } else if ($row->KODE_PENDAPATAN_SEKOLAH == '17') {
                    $danaSukaRela = $row->JUMLAH_PENDAPATAN_SEKOLAH;
                } else {
                    $danaTinggalanKelas = $row->JUMLAH_PENDAPATAN_SEKOLAH;
                }
                $danaBsm = 0;
                $danaRuko = 0;
                $danaDudi = 0;
                if ($row->KODE_PENDAPATAN_LAIN == '20') {
                    $danaBosPusat = $row->JUMLAH_PENDAPATAN_LAIN;
                } else if ($row->KODE_PENDAPATAN_LAIN == '21') {
                    $danaBosProvinsi = $row->JUMLAH_PENDAPATAN_LAIN;
                } else {
                    $danaBosKota = $row->JUMLAH_PENDAPATAN_LAIN;
                }
                $arrData[] = array(
                    'NO_KODE' => $noKode,
                    'URAIAN' => $uraian,
                    'NAMA_TRIWULAN' => $namaTriwulan,
                    'DANA_BOS_PUSAT' => $danaBosPusat,
                    'DANA_BOS_PROVINSI' => $danaBosProvinsi,
                    'DANA_BOS_KOTA' => $danaBosKota,
                    'DANA_INFAK_JUMAT' => $danaInfakJumat,
                    'DANA_INFAK_RAPORT' => $danaInfakRaport,
                    'DANA_SUKA_RELA' => $danaSukaRela,
                    'DANA_TINGGALAN_KELAS' => $danaTinggalanKelas,
                    'DANA_BSM' => $danaBsm,
                    'DANA_RUKO' => $danaRuko,
                    'DANA_DUDI' => $danaDudi,
                    'DANA_LAIN' => $danaLain,
                    'TOTAL_DANA' => $danaTotal
                );
            }
        }
        $data['dataDetail'] = $arrData;
        $data['dataCetak']['TITLE'] = "REALISASI PENGGUNAAN DANA BOS";
        $data['dataCetak']['NAMA_SEKOLAH'] = getValueIdentitasByKey('nama_sekolah');
        $data['dataCetak']['KELURAHAN'] = getValueIdentitasByKey('desa');
        $data['dataCetak']['KECAMATAN'] = getValueIdentitasByKey('kecamatan');
        $data['dataCetak']['KABUPATEN'] = getValueIdentitasByKey('kabupaten');
        $data['dataCetak']['PROVINSI'] = getValueIdentitasByKey('provinsi');
        $this->load->view('laporan/view_pdf_laporan_bos_k7', $data);
    }

}
?>