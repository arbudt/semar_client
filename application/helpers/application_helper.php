<?php

if (!function_exists('tglSekarang')) {

    function tglSekarang() {
        date('d-m-Y');
    }

}

if (!function_exists('jamSekarang')) {

    function jamSekarang() {
        date('h:i:s');
    }

}

if (!function_exists('nns')) {

    function nns() {
        return '123456789';
    }

}

if (!function_exists('dateReverse')) {

    function dateReverse($date='') {//d-m-Y
        $tgl = $date;
        if (empty($tgl)) {
            $tgl = tglSekarang();
        }
        $arr = explode('-', $tgl);
        return $arr[2] . '-' . $arr[1] . '-' . $arr[0];
    }

}

if (!function_exists('dropDownStatusKawin')) {

    function dropDownStatusKawin($attribute = 'name="statusKawin" id="statusKawin"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('registrasi/reg_pasien_model');
        $data = $ci->reg_pasien_model->getDataStatusKawin();
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            foreach ($data as $row) {
                if ($row->kode == $value) {
                    echo '<option value="' . $row->kode . '" selected >' . $row->nama . '</option>';
                } else {
                    echo '<option value="' . $row->kode . '">' . $row->nama . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}

if (!function_exists('dropDownJeniskelamin')) {

    function dropDownJeniskelamin($attribute = 'name="jenisKelamin" id="jenisKelamin"', $value = '') {
        echo '<select ' . $attribute . '>';
        echo '<option value="L">Laki-laki</option>';
        echo '<option value="P">Perempuan</option>';
        echo '</select>';
    }

}

if (!function_exists('dropDownGolonganDarah')) {

    function dropDownGolonganDarah($attribute = 'name="golonganDarah" id="golonganDarah"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('registrasi/reg_pasien_model');
        $data = $ci->reg_pasien_model->getDataGolonganDarah();
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            foreach ($data as $row) {
                if ($row->kode == $value) {
                    echo '<option value="' . $row->kode . '" selected >' . $row->nama . '</option>';
                } else {
                    echo '<option value="' . $row->kode . '">' . $row->nama . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}

if (!function_exists('dropDownAgama')) {

    function dropDownAgama($attribute = 'name="agama" id="agama"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('registrasi/reg_pasien_model');
        $data = $ci->reg_pasien_model->getDataAgama();
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            foreach ($data as $row) {
                if ($row->kode == $value) {
                    echo '<option value="' . $row->kode . '" selected >' . $row->nama . '</option>';
                } else {
                    echo '<option value="' . $row->kode . '">' . $row->nama . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}

if (!function_exists('dropDownPropinsi')) {

    function dropDownPropinsi($attribute = 'name="propinsi" id="propinsi"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('registrasi/reg_pasien_model');
        $data = $ci->reg_pasien_model->getDataPropinsi();
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            foreach ($data as $row) {
                if ($row->kode == $value) {
                    echo '<option value="' . $row->kode . '" selected >' . $row->nama . '</option>';
                } else {
                    echo '<option value="' . $row->kode . '">' . $row->nama . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}

if (!function_exists('dropDownPendidikan')) {

    function dropDownPendidikan($attribute = 'name="pendidikan" id="pendidikan"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('registrasi/reg_pasien_model');
        $data = $ci->reg_pasien_model->getDataPendidikan();
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            foreach ($data as $row) {
                if ($row->kode == $value) {
                    echo '<option value="' . $row->kode . '" selected >' . $row->nama . '</option>';
                } else {
                    echo '<option value="' . $row->kode . '">' . $row->nama . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}

if (!function_exists('dropDownPekerjaan')) {

    function dropDownPekerjaan($attribute = 'name="pekerjaan" id="pekerjaan"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('registrasi/reg_pasien_model');
        $data = $ci->reg_pasien_model->getDataPekerjaan();
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            foreach ($data as $row) {
                if ($row->kode == $value) {
                    echo '<option value="' . $row->kode . '" selected >' . $row->nama . '</option>';
                } else {
                    echo '<option value="' . $row->kode . '">' . $row->nama . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}


if (!function_exists('dropDownTahunAjaran')) {

    function dropDownTahunAjaran($attribute = 'name="tahun" id="tahun"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('bosk1/bosk1_model');
        $data = $ci->bosk1_model->dataTahunAjaran();
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            foreach ($data as $row) {
                if ($row->kode == $value) {
                    echo '<option value="' . $row->kode . '" selected >' . $row->nama . '</option>';
                } else {
                    echo '<option value="' . $row->kode . '">' . $row->nama . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}

if (!function_exists('dropDownSumberDanaBos')) {

    function dropDownSumberDanaBos($attribute = 'name="sumberDanaBos" id="sumberDanaBos"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('bosk1/bosk1_model');
        $data = $ci->bosk1_model->dataSumberDataBos();
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            foreach ($data as $row) {
                if ($row->kode == $value) {
                    echo '<option value="' . $row->kode . '" selected >' . $row->nama . '</option>';
                } else {
                    echo '<option value="' . $row->kode . '">' . $row->nama . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}

if (!function_exists('dropDownDataGuru')) {

    function dropDownDataGuru($attribute = 'name="guru" id="guru"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('pengeluaran/trans_gaji_model');
        $data = $ci->trans_gaji_model->dataGuru();
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            foreach ($data as $row) {
                if ($row->KODE_GURU == $value) {
                    echo '<option value="' . $row->KODE_GURU . '" selected data-jenis_kelamin="' . $row->JENIS_KELAMIN . '" data-tugas="' . $row->TUGAS . '" data-alamat="' . $row->ALAMAT . '">' . $row->NAMA_GURU . '</option>';
                } else {
                    echo '<option value="' . $row->KODE_GURU . '" data-jenis_kelamin="' . $row->JENIS_KELAMIN . '" data-tugas="' . $row->TUGAS . '" data-alamat="' . $row->ALAMAT . '">' . $row->NAMA_GURU . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}

if (!function_exists('dropDownSumberDanaBosByParent')) {

    function dropDownSumberDanaBosByParent($attribute = 'name="sumberDanaBos" id="sumberDanaBos"', $parent, $value = '') {

        $ci = & get_instance();
        $ci->load->model('bosk1/bosk1_model');
        $data = $ci->bosk1_model->dataSumberDataBosByParent($parent);
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            foreach ($data as $row) {
                if ($row->kode == $value) {
                    echo '<option value="' . $row->kode . '" selected >' . $row->nama . '</option>';
                } else {
                    echo '<option value="' . $row->kode . '">' . $row->nama . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}

if (!function_exists('dropDownJenisLaporan')) {

    function dropDownJenisLaporan($attribute = 'name="jenisLaporan" id="jenisLaporan"', $value = '') {
        $data[] = array('kode' => 'bosk1', 'nama' => 'Laporan Bos K1 (Penerimaan Dana BOS)');
        $data[] = array('kode' => 'bosk2', 'nama' => 'Laporan Bos K2 (Rencana Anggaran)');
        $data[] = array('kode' => 'bosk3', 'nama' => 'Laporan Bos K3 (Buku Kas Umum)');
        $data[] = array('kode' => 'bosk4', 'nama' => 'Laporan Bos K4 (Buku Kas Tunai)');
        $data[] = array('kode' => 'bosk5', 'nama' => 'Laporan Bos K5 (Buku Pembantu Bank)');
        $data[] = array('kode' => 'bosk6', 'nama' => 'Laporan Bos K6 (Buku Pembantu Pajak)');
        $data[] = array('kode' => 'pengeluaran', 'nama' => 'Laporan Pengeluaran');
        $data[] = array('kode' => 'bosk7', 'nama' => 'Laporan Bos K7 (Realisasa Dana BOS)');
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['kode'] == $value) {
                    echo '<option value="' . $data[$i]['kode'] . '" selected >' . $data[$i]['nama'] . '</option>';
                } else {
                    echo '<option value="' . $data[$i]['kode'] . '" >' . $data[$i]['nama'] . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}


if (!function_exists('getValueIdentitasByKey')) {

    function getValueIdentitasByKey($key) {
        $ci = & get_instance();
        $ci->load->model('laporan/laporan_model');
        $data = $ci->laporan_model->dataIdentitasByKey($key);
        if ($data != NULL) {
            return $data->STRING_VALUE;
        } else {
            return '';
        }
    }

}

if (!function_exists('dropDownGroupUser')) {

    function dropDownGroupUser($attribute = 'name="groupUser" id="groupUser"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('master/master_user_model');
        $data = $ci->master_user_model->dataGroupUser();
        echo '<select ' . $attribute . '>';
        if ($data != NULL) {
            if (count($data) > 1) {
                echo '<option value="">...</option>';
            }
            foreach ($data as $row) {
                if ($row->KODE == $value) {
                    echo '<option value="' . $row->KODE . '" selected >' . $row->NAMA . '</option>';
                } else {
                    echo '<option value="' . $row->KODE . '" >' . $row->NAMA . '</option>';
                }
            }
        } else {
            echo '<option value="">...</option>';
        }
        echo '</select>';
    }

}


if (!function_exists('addLogAktifity')) {

    function addLogAktifity($modul='', $aktifitas = '', $desc='') {
        $ci = & get_instance();
        $ci->load->model('log/log_model');
        $data = $ci->log_model->addLogAktivity($modul, $aktifitas, $desc);
    }

}
?>
