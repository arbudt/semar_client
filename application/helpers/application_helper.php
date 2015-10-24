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

if (!function_exists('dropDownPoli')) {

    function dropDownPoli($attribute = 'name="poli" id="poli"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('registrasi/reg_poli_model');
        $data = $ci->reg_poli_model->getDataPoli();
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


if (!function_exists('dropDownDokter')) {

    function dropDownDokter($attribute = 'name="dokter" id="dokter"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('registrasi/reg_poli_model');
        $data = $ci->reg_poli_model->getDataDokter();
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


if (!function_exists('dropDownCaraBayar')) {

    function dropDownCaraBayar($attribute = 'name="caraBayar" id="caraBayar"', $value = '') {

        $ci = & get_instance();
        $ci->load->model('registrasi/reg_poli_model');
        $data = $ci->reg_poli_model->getDataCaraBayar();
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




if (!function_exists('dropDownTest')) {

    function dropDownTest() {

        $ci = & get_instance();
        //$ci->load->controller('registrasi/reg_pasien');
//        $ci->load->model('registrasi/reg_pasien_model');
//        $data = $ci->reg_pasien_model->getDataPekerjaan();
        //$data = $ci->reg_pasien->data_test();
        $nilai = 10;
        ;
        return $nilai;
    }

}
