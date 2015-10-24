<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Lis extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('api/lis_model'));
    }

    /*
     * 200 -> success
     * 304 -> Not Modified
     * 400 -> Bad Request
     * 401 -> authentication / Unauthorized
     * 403 -> tidak ada hak akses untuk request
     * 404 -> fungsi tidak ada
     */

    function authentication($serviceName) {
        $IP = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $username = $this->input->server('PHP_AUTH_USER');
        $password = $this->input->server('PHP_AUTH_PW');

        $arrStatus = array(
            'status' => TRUE,
            'message' => NULL
        );

        $akses = $this->lis_model->aksesService($IP, $serviceName);
        if ($akses != NULL) {
            $userAkses = $akses->USERNAME;
            $passAkses = $akses->PASSWORD;

            if (!empty($userAkses) && !empty($passAkses)) {
                /*
                 * cek user password
                 */
                if (($username != $userAkses) || ($password != $passAkses)) {
                    /*
                     * akun salah
                     */
                    $response = array(
                        'message' => 'Username atau password salah',
                        'status' => FALSE
                    );
                    $this->response($response, 403);
                }
            }
        } else {
            /*
             * tidak dapat akses
             */
            $response = array(
                'message' => 'Tidak memiliki akses service ini',
                'status' => FALSE
            );
            $this->response($response, 403);
        }
        return $arrStatus;
    }

    /*
     * post data hasil lab
     */

    public function hasil_post() {
        /*
         * data log request
         */
        $log = array(
            'TKDW_NAMA_WS' => 'POST_HASIL_LIS',
            'TKDW_ALAMAT_SERVER' => !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
            'TKDW_PARAMETER' => NULL,
            'TKDW_DATA' => json_encode($this->input->post()),
            'TKDW_RESULT' => NULL,
            'TKDW_STATUS' => 0,
            'TKDW_USERUPDATE' => '42'
        );

        $idTransLog = NULL;
        $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

        /*
         * authentication
         */
        $this->authentication('POST_HASIL_LIS');

        /*
         * get input post
         */
        $dataPasien = $this->post('pasien');
        $dataHasil = $this->post('hasil');
        if (empty($dataPasien) && empty($dataHasil)) {
            /*
             * get input post not array
             */
            $stringPost = file_get_contents("php://input");
            $log['TKDW_DATA'] = $stringPost;
            if ($this->response->format == 'json') {
                $dataJson = json_decode($stringPost, TRUE);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $response = array(
                        'message' => 'format json salah',
                        'status' => FALSE
                    );
                    $log['TKDW_RESULT'] = json_encode($response);
                    $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

                    $this->response($response, 400);
                } else {
                    if (!empty($dataJson['pasien'])) {
                        $dataPasien = $dataJson['pasien'];
                    }
                    if (!empty($dataJson['hasil'])) {
                        $dataHasil = $dataJson['hasil'];
                    }
                }
            } else if ($this->response->format == 'xml') {
                /*
                 * load library XML2Array
                 */
                $this->load->library('XML2Array');
                try {
                    $dataXml = XML2Array::createArray($stringPost);
                } catch (Exception $ex) {
                    $response = array(
                        'message' => 'format xml salah',
                        'status' => FALSE
                    );
                    $log['TKDW_RESULT'] = json_encode($response);
                    $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

                    $this->response($response, 400);
                }
                if (!empty($dataXml['root']['pasien'])) {
                    $dataPasien = $dataXml['root']['pasien'];
                }
                if (!empty($dataXml['root']['hasil']['item'])) {
                    if (empty($dataXml['root']['hasil']['item'][0])) {
                        $dataHasil[0] = $dataXml['root']['hasil']['item'];
                    } else {
                        $dataHasil = $dataXml['root']['hasil']['item'];
                    }
                }
            }
        }
        if ($log['TKDW_DATA'] == 'false') {
            $dataArrLog['pasien'] = $dataPasien;
            $dataArrLog['hasil'] = $dataHasil;
            $log['TKDW_DATA'] = json_encode($dataArrLog);
        }

        $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

        if (!empty($dataPasien)) {
            if (!empty($dataHasil)) {
                $result = $this->lis_model->insertHasil($dataPasien, $dataHasil);
                if ($result['status'] == TRUE) {
                    $response = array(
                        'message' => 'Proses berhasil',
                        'status' => TRUE
                    );
                    $log['TKDW_STATUS'] = 1;
                    $log['TKDW_RESULT'] = json_encode($response);
                    $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

                    $this->response($response, 200);
                } else {
                    $response = array(
                        'message' => 'Proses gagal',
                        'status' => FALSE,
                        'error' => $result['error']
                    );
                    $log['TKDW_RESULT'] = json_encode($response);
                    $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

                    $this->response($response, 200);
                }
            } else {
                $response = array(
                    'message' => 'Tidak ada data hasil',
                    'status' => FALSE
                );
                $log['TKDW_RESULT'] = json_encode($response);
                $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

                $this->response($response, 200);
            }
        } else {
            $response = array(
                'message' => 'Tidak ada data pasien',
                'status' => FALSE
            );
            $log['TKDW_RESULT'] = json_encode($response);
            $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

            $this->response($response, 200);
        }
    }

    /*
     * get data hasil lab
     */

    public function hasil_get($noLab = '') {
        /*
         * $noLab = $this->get('no_lab');
         */
        /*
         * data log request
         */
        $log = array(
            'TKDW_NAMA_WS' => 'GET_HASIL_LIS',
            'TKDW_ALAMAT_SERVER' => !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
            'TKDW_PARAMETER' => json_encode(array('no_lab' => $noLab)),
            'TKDW_DATA' => NULL,
            'TKDW_RESULT' => NULL,
            'TKDW_STATUS' => 0,
            'TKDW_USERUPDATE' => '42'
        );
        $idTransLog = NULL;
        $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

        /*
         * authentication
         */
        $this->authentication('GET_HASIL_LIS');

        if (!empty($noLab)) {
            $dataHasil = $this->lis_model->dataHasilByNoLab($noLab);
            if ($dataHasil != NULL) {
                $response = array(
                    'status' => TRUE,
                    'data_hasil' => $dataHasil
                );
                $log['TKDW_STATUS'] = 1;
                $log['TKDW_RESULT'] = json_encode($response);
                $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

                $this->response($response, 200);
            } else {
                $response = array(
                    'status' => FALSE,
                    'message' => 'Data tidak ditemukan'
                );
                $log['TKDW_RESULT'] = json_encode($response);
                $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

                $this->response($response, 200);
            }
        } else {
            $response = array(
                'status' => FALSE,
                'message' => 'no lab harus diisi'
            );
            $log['TKDW_RESULT'] = json_encode($response);
            $idTransLog = $this->lis_model->addLogService($log, $idTransLog);

            $this->response($response, 400);
        }
    }

}
