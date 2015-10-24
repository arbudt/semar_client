<style>
    .labelField{
        width: 160px;
    }
    .uraian{
        width: 207px;
        height: 40px;
        resize: none       
    }
</style>

<!-- HTML botton TOP -->
<div class="row-fluid" style="margin-top: -8px;">
    <div class="btn-group">
        <button type="button" id="btnListData" class="btn btn-info"><i class="icon-search"></i>List Data Pasien</button>
    </div>
</div>
<br>

<!-- List Rekap -->
<?php $this->load->view('registrasi/view_list_pasien'); ?>

<div class="row-fluid">
    <form class="form well" method="POST" id="formRegistrasi">
        <div class="row-fluid">
            <div class="span6">
                <table>
                    <tr>
                        <td class="labelField">No RM</td>
                        <td><input type="text" name="noRm" id="noRm" value="" class="noRm" readonly/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Nama Pasien</td>
                        <td><input type="text" name="namaPasien" id="namaPasien" value="" class="namaPasien" required /></td>
                    </tr>
                    <tr>
                        <td class="labelField">Tempat Lahir</td>
                        <td><input type="text" name="tempatLahir" id="tempatLahir" value="" class="tempatLahir" required /></td>
                    </tr>
                    <tr>
                        <td class="labelField">Tanggal Lahir</td>
                        <td>
                            <div id="datePickerTanggal" class="input-append date">
                                <input class="input input-small" data-format="dd-MM-yyyy" type="text" name="tanggalLahir" id="tanggalLahir" value="<?php echo tglSekarang(); ?>" required>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Jenis Kelamin</td>
                        <td><?php dropDownJeniskelamin('name="jenisKelamin" id="jenisKelamin" class="jenisKelamin" required'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Status Perkawinan</td>
                        <td><?php dropDownStatusKawin('name="statusKawin" id="statusKawin" class="statusKawin" required'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Agama</td>
                        <td><?php dropDownAgama('name="agama" id="agama" class="agama" required'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Golongan Darah</td>
                        <td><?php dropDownGolonganDarah('name="golonganDarah" id="golonganDarah" class="golonganDarah" required'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">No Telp</td>
                        <td><input type="text" name="noTelepon" id="noTelepon" value="" class="noTelepon" data-rule-number required /></td>
                    </tr>
                    <tr>
                        <td class="labelField">No Identitas</td>
                        <td><input type="text" name="noIdentitas" id="noIdentitas" class="noIdentitas" value="" required/></td>
                    </tr>
                </table>
            </div>
            <div class="span6">
                <table>

                    <tr>
                        <td class="labelField">Propinsi</td>
                        <td><?php dropDownPropinsi('name="propinsi" id="propinsi" class="propinsi" required'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Kabupaten</td>
                        <td>
                            <select name="kabupaten" id="kabupaten" class="kabupaten" required><option value="">...</option></select>
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Kecamatan</td>
                        <td>
                            <select name="kecamatan" id="kecamatan" class="kecamatan" required><option value="">...</option></select>
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Kelurahan</td>
                        <td>
                            <select name="kelurahan" id="kelurahan" class="kelurahan" required><option value="">...</option></select>
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Alamat</td>
                        <td><textarea name="alamat" id="alamat" class="alamat uraian" required></textarea></td>
                    </tr>
                    <tr>
                        <td class="labelField">Pendidikan</td>
                        <td><?php dropDownPendidikan('name="pendidikan" id="pendidikan" class="pendidikan" required'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Pekerjaan</td>
                        <td><?php dropDownPekerjaan('name="pekerjaan" id="pekerjaan" class="pekerjaan" required'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Alergi</td>
                        <td><textarea name="alergi" id="alergi" class="alergi uraian" required></textarea></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="" style="text-align: center; margin-top: 3px;">
            <div class="btn-group">
                <button type="button" id="btnAdd" class="btn btn-info"><i class="icon icon-white icon-plus"></i>Tambah</button>
                <button type="button" id="btnEdit" class="btn btn-warning"><i class="icon icon-white icon-edit"></i>Ubah</button>
                <button type="button" id="btnCancel" class="btn btn-success"><i class="icon icon-white icon-repeat"></i>Batal</button>
                <button type="submit" id="btnSave" class="btn btn-primary"><i class="icon icon-white icon-envelope"></i>Simpan</button>
            </div>
        </div>
    </form>
</div>


<!-- JS Deklarasi -->
<script>
    $(document).ready(function(){
        $('#datePickerTanggal').datetimepicker({
            language: 'pt-BR',
            autoclose: true
        });
    
        $(document).on('focus', '#tanggal', function() {
            $(this).mask("99-99-9999");
        });
        
        $(document).on("keydown", "input,select,textarea", function(event) {
            if (event.keyCode === 13) {
                var formInput = $('#formRegistrasi').find('input,select,textarea, button, checkbox');
                var idx = formInput.index(this);
                if (idx > -1 && (idx + 1 < formInput.length)) {
                    var nextInput = formInput[idx + 1];
                    while ((nextInput.disabled || nextInput.type === "hidden") && (idx + 1 < formInput.length)) {
                        idx++;
                        nextInput = formInput[idx + 1];
                    }
                    nextInput.focus();
                }
                return false;
            }
        });
    });

    $(document).on('change', '#propinsi', function() {
        var kode = ''+$(this).val();
        if (kode.length) {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('registrasi/reg_pasien/get_options_kabupaten_by_prop'); ?>",
                data: {kode: kode},
                beforeSend: function() {
                    showProgressBar('get data...');
                },
                error: function(xhr, status) {
                    hideProgressBar();
                    bootbox.alert("Terjadi saat request data, Hubungi Administrator");
                    $('#kabupaten').html('<option value="">...</option>');
                    $('#kabupaten').val('');
                },
                success: function(response) {
                    hideProgressBar();
                    $('#kabupaten').html(response);
                    $('#kabupaten').val($('#kabupaten option:first').val());
                }
            });
        } else {
            $('#kabupaten').html('<option value="">...</option>');
            $('#kabupaten').val('');
        }
    });

    $(document).on('change', '#kabupaten', function() {
        var kode = ''+$(this).val();
        if (kode.length) {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('registrasi/reg_pasien/get_options_kecamatan_by_kab'); ?>",
                data: {kode: kode},
                beforeSend: function() {
                    showProgressBar('get data...');
                },
                error: function(xhr, status) {
                    hideProgressBar();
                    bootbox.alert("Terjadi saat request data, Hubungi Administrator");
                    $('#kecamatan').html('<option value="">...</option>');
                    $('#kecamatan').val('');
                },
                success: function(response) {
                    hideProgressBar();
                    $('#kecamatan').html(response);
                    $('#kecamatan').val($('#kabupaten option:first').val());
                }
            });
        } else {
            $('#kecamatan').html('<option value="">...</option>');
            $('#kecamatan').val('');
        }
    });

    $(document).on('change', '#kecamatan', function() {
        var kode = ''+$(this).val();
        if (kode.length) {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('registrasi/reg_pasien/get_options_kelurahan_by_kec'); ?>",
                data: {kode: kode},
                beforeSend: function() {
                    showProgressBar('get data...');
                },
                error: function(xhr, status) {
                    hideProgressBar();
                    bootbox.alert("Terjadi saat request data, Hubungi Administrator");
                    $('#kelurahan').html('<option value="">...</option>');
                    $('#kelurahan').val('');
                },
                success: function(response) {
                    hideProgressBar();
                    $('#kelurahan').html(response);
                    $('#kelurahan').val($('#kabupaten option:first').val());
                }
            });
        } else {
            $('#kelurahan').html('<option value="">...</option>');
            $('#kelurahan').val('');
        }
    });
    
</script>

<!-- JS Ready -->
<script>
    $(document).ready(function(){
        clearForm();
        disableForm();
        $('#btnAdd').prop('disabled', false);
        $('#btnEdit').prop('disabled', true);
        $('#btnCancel').prop('disabled', true);
        $('#btnSave').prop('disabled', true);
    });
</script>

<!-- JS function Content -->
<script>
    function clearForm(){
        $('#noRm').val('');
        $('#namaPasien').val('');
        $('#tempatLahir').val('');
        $('#tanggalLahir').val('');
        $('#jenisKelamin').val('');
        $('#statusKawin').val('');
        $('#agama').val('');
        $('#golonganDarah').val('');
        $('#noTelepon').val('');
        $('#noIdentitas').val('');
        $('#propinsi').val('');
        $('#propinsi').change();
        $('#kabupaten').val('');
        $('#kabupaten').change();
        $('#kecamatan').val('');
        $('#kecamatan').change();
        $('#kelurahan').val('');
        $('#kelurahan').change();
        $('#alamat').val('');
        $('#pendidikan').val('');
        $('#pekerjaan').val('');
        $('#alergi').val('');
    }
    
    function disableForm(){
        $('#noRm').prop('disabled', true);
        $('#namaPasien').prop('disabled', true);
        $('#tempatLahir').prop('disabled', true);
        $('#tanggalLahir').prop('disabled', true);
        $('#jenisKelamin').prop('disabled', true);
        $('#statusKawin').prop('disabled', true);
        $('#agama').prop('disabled', true);
        $('#golonganDarah').prop('disabled', true);
        $('#noTelepon').prop('disabled', true);
        $('#noIdentitas').prop('disabled', true);
        $('#propinsi').prop('disabled', true);
        $('#kabupaten').prop('disabled', true);
        $('#kecamatan').prop('disabled', true);
        $('#kelurahan').prop('disabled', true);
        $('#alamat').prop('disabled', true);
        $('#pendidikan').prop('disabled', true);
        $('#pekerjaan').prop('disabled', true);
        $('#alergi').prop('disabled', true);
    }
    
    function enableForm(){
        $('#noRm').prop('disabled', false);
        $('#namaPasien').prop('disabled', false);
        $('#tempatLahir').prop('disabled', false);
        $('#tanggalLahir').prop('disabled', false);
        $('#jenisKelamin').prop('disabled', false);
        $('#statusKawin').prop('disabled', false);
        $('#agama').prop('disabled', false);
        $('#golonganDarah').prop('disabled', false);
        $('#noTelepon').prop('disabled', false);
        $('#noIdentitas').prop('disabled', false);
        $('#propinsi').prop('disabled', false);
        $('#kabupaten').prop('disabled', false);
        $('#kecamatan').prop('disabled', false);
        $('#kelurahan').prop('disabled', false);
        $('#alamat').prop('disabled', false);
        $('#pendidikan').prop('disabled', false);
        $('#pekerjaan').prop('disabled', false);
        $('#alergi').prop('disabled', false);
    }
    
    //    /*
    //     *mengambil data by filter limit
    //     */
    //    function getAllDataTrans(){
    //        var tahun = $('#tahunAjaranData').val();
    //        var triwulan = $('#triwulanData').val();
    //        if(tahun.length && triwulan.length){
    //            $.ajax({
    //                type: "POST",
    //                url: "<?php //echo site_url('bosk1/bosk1/getDataTrans')                    ?>",
    //                data: {tahun:tahun, triwulan:triwulan},
    //                dataType: 'json',
    //                beforeSend: function(xhr) {
    //                    showProgressBar('proses ambil data');
    //                },
    //                error: function(xhr, status) {
    //                    hideProgressBar();
    //                    alert(status);
    //                },
    //                success: function(response) {
    //                    generateDataTable(response, true);
    //                    hideProgressBar();
    //                }
    //            });
    //        }
    //    }
    //
    //    /*
    //     *proses membuat table
    //     **/
    //    function generateDataTable(response, showMsg){
    //        $('#dataTableTransaksi').html('');
    //        if (response['data'] !== null) {
    //            for(var i = 0; i < response['data'].length; i++){
    //                var strRow = '<tr class="rowDataTable" id="rowDataTable'+response['data'][i]['ID_TRANS']+'" data-id-trans="'+response['data'][i]['ID_TRANS']+'">';
    //                strRow += '<td>'+response['data'][i]['TGL']+'</td>';
    //                strRow += '<td>'+response['data'][i]['NAMA_TRIWULAN']+'</td>';
    //                strRow += '<td>'+response['data'][i]['NAMA_SUMBER_DANA']+'</td>';
    //                strRow += '<td>'+response['data'][i]['JUMLAH_SISWA']+'</td>';
    //                strRow += '<td>'+response['data'][i]['UANG_PER_SISWA']+'</td>';
    //                strRow += '<td>'+response['data'][i]['NO_URUT_TERIMA']+'</td>';
    //                strRow += '<td>'+response['data'][i]['NO_KODE_TERIMA']+'</td>';
    //                strRow += '<td>'+response['data'][i]['URAIAN_TERIMA']+'</td>';
    //                strRow += '<td>'+response['data'][i]['UANG_TERIMA']+'</td>';
    //                strRow += '</tr>';
    //                $('#dataTableTransaksi').append(strRow);
    //            }
    //        } else {
    //            if(showMsg === true){
    //                alert(response['message']);
    //            }
    //        }
    //        //set pilih
    //        var idTrans = $('#idTrans').val();
    //        if(idTrans.length){
    //            $('#dataTableTransaksi tr').removeClass('info');
    //            $('#dataTableTransaksi #rowDataTable'+idTrans).addClass('info');
    //        }
    //    }
    //
    //    /*
    //     *mengambil data transaksi by id transaksi
    //     */
    //    //    function getDataByidTrans(idTrans){
    //    //        if(idTrans !== null){
    //    //            $.ajax({
    //    //                type: "POST",
    //    //                url: "<?php //echo site_url('bosk1/bosk1/get_data_pasien_by_id')                    ?>",
    //    //                data: {idTrans:idTrans},
    //    //                dataType: 'json',
    //    //                beforeSend: function(xhr) {
    //    //                    showProgressBar('proses ambil data');
    //    //                },
    //    //                error: function(xhr, status) {
    //    //                    hideProgressBar();
    //    //                    alert(status);
    //    //                },
    //    //                success: function(response) {
    //    //                    setDataTrans(response);
    //    //                    hideProgressBar();
    //    //                }
    //    //            });
    //    //        }else{
    //    //            alert('Identitas data tidak diketahui');
    //    //        }
    //    //    }
    //
    //        /*
    //         *set data from
    //         */
    //        function setDataTrans(response){
    //            clearForm();
    //            disableForm();
    //            if(response['data'] !== null){
    //                $('#idTrans').val(response['data']['ID_TRANS']);
    //                $('#tanggal').val(response['data']['TGL']);
    //                $('#tahunAjaran').val(response['data']['KODE_TAHUN']);
    //                $('#triwulan').val(response['data']['KODE_TRIWULAN']);
    //                $('#sumberDanaBos').val(response['data']['KODE_SUMBER_DANA']);
    //                $('#jumlahSiswa').val(response['data']['JUMLAH_SISWA']);
    //                $('#jumlahUangPerSiswa').val(response['data']['UANG_PER_SISWA']);
    //                $('#noUrutTerima').val(response['data']['NO_URUT_TERIMA']);
    //                $('#noKodeTerima').val(response['data']['NO_KODE_TERIMA']);
    //                $('#uraianTerima').val(response['data']['URAIAN_TERIMA']);
    //                $('#jumlahTerima').val(response['data']['UANG_TERIMA']);
    //            }
    //            $('#btnAdd').prop('disabled', false);
    //            $('#btnEdit').prop('disabled', false);
    //            $('#btnCancel').prop('disabled', true);
    //            $('#btnSave').prop('disabled', true);
    //        }
    //        /*
    //         *pilih data table
    //         **/
    //        $(document).on('click', '.rowDataTable', function(){
    //            var idTrans = $(this).data('idTrans');
    //            var idBaris = $(this).attr('id');
    //            getDataByidTrans(idTrans);
    //            $('#dataTableTransaksi tr').removeClass('info');
    //            $('#dataTableTransaksi #'+idBaris).addClass('info');
    //        });

    function getDataByidTrans(idTrans){
        if(idTrans !== null){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('registrasi/reg_pasien/get_data_pasien_by_id') ?>",
                data: {noRm:idTrans},
                dataType: 'json',
                beforeSend: function(xhr) {
                    showProgressBar('proses ambil data');
                },
                error: function(xhr, status) {
                    hideProgressBar();
                    bootbox.alert(status);
                },
                success: function(response) {
                    setDataTrans(response);
                    hideProgressBar();
                }
            });
        }else{
            bootbox.alert('Identitas data tidak diketahui');
        }
    }

    /*
     *set data from
     */
    function setDataTrans(response){
        clearForm();
        disableForm();
        if(response['data'] !== null){
            $('#noRm').val(response['data']['mpas_id']);
            $('#namaPasien').val(response['data']['mpas_nama']);
            $('#tempatLahir').val(response['data']['mpas_tempat_lahir']);
            $('#tanggalLahir').val(response['data']['mpas_tanggal_lahir']);
            $('#jenisKelamin').val(response['data']['mpas_jenis_kelamin']);
            $('#statusKawin').val(response['data']['rsk_id']);
            $('#agama').val(response['data']['rag_id']);
            $('#golonganDarah').val(response['data']['rgd_id']);
            $('#noTelepon').val(response['data']['mpas_telepon']);
            $('#noIdentitas').val(response['data']['mpas_no_identitas']);
            $('#propinsi').val(response['data']['rpro_id']);
            $('#kabupaten').html(response['optionsKab']);
            $('#kabupaten').val(response['data']['rkab_id']);
            $('#kecamatan').html(response['optionskec']);
            $('#kecamatan').val(response['data']['rkec_id']);
            $('#kelurahan').html(response['optionsKel']);
            $('#kelurahan').val(response['data']['rkel_id']);
            $('#alamat').val(response['data']['mpas_alamat']);
            $('#pendidikan').val(response['data']['rpend_id']);
            $('#pekerjaan').val(response['data']['rpek_id']);
            $('#alergi').val(response['data']['mpas_alergi']);
        }
        $('#btnAdd').prop('disabled', false);
        $('#btnEdit').prop('disabled', false);
        $('#btnCancel').prop('disabled', true);
        $('#btnSave').prop('disabled', true);
    }
</script>

<!-- Js Aksi -->
<script>
    $(document).on('click', '#btnAdd', function(){
        clearForm();
        enableForm();
        $('#btnAdd').prop('disabled', true);
        $('#btnEdit').prop('disabled', true);
        $('#btnCancel').prop('disabled', false);
        $('#btnSave').prop('disabled', false);
    });
    
    //    $(document).on('click', '#btnEdit', function(){
    //        enableForm();
    //        $('#btnAdd').prop('disabled', true);
    //        $('#btnEdit').prop('disabled', true);
    //        $('#btnCancel').prop('disabled', false);
    //        $('#btnSave').prop('disabled', false);
    //    });
    //
    //    $(document).on('click', '#btnCancel', function(){
    //        var idTrans = $('#idTrans').val();
    //        if(idTrans.length){
    //            getDataByidTrans(idTrans);
    //        }else{
    //            clearForm();
    //            disableForm();
    //            $('#btnAdd').prop('disabled', false);
    //            $('#btnEdit').prop('disabled', true);
    //            $('#btnCancel').prop('disabled', true);
    //            $('#btnSave').prop('disabled', true);
    //        }
    //    });
    
    /*
     * btn simpan
     */

    $(document).ready(function() {
        $('#formRegistrasi').validate({
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('registrasi/reg_pasien/proses_simpan'); ?>",
                    data: $('#formRegistrasi').serialize(),
                    dataType: 'json',
                    beforeSend: function(xhr) {
                        showProgressBar('proses simpan');
                    },
                    error: function(xhr, status) {
                        hideProgressBar();
                        bootbox.alert(status);
                    },
                    success: function(response) {
                        hideProgressBar();
                        if (response['status'] === true) {
                            if(response['idTrans'] !== null){
                                getDataByidTrans(response['noRm']);
                            }
                            bootbox.alert(response['message']);
                        } else {
                            bootbox.alert(response['message']);
                        }
                    }
                });
                return false;
            }
        });
    });

</script>

<script>
    $(document).on('click', '#btnListData', function(){
        $('#modalListData').modal('show');
    });
</script>