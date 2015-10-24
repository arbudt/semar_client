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
<!--        <button type="button" id="btnListData" class="btn btn-info"><i class="icon-search"></i>List Data Pasien</button>
        <button type="button" id="btnListDataKunjungan" class="btn btn-info"><i class="icon-search"></i>List Data Poliklinik</button>-->
    </div>
</div>
<br>

<!-- List -->
<?php $this->load->view('registrasi/view_list_pasien'); ?>

<?php $this->load->view('registrasi/view_list_kunjungan'); ?>

<div class="row-fluid">
    <form class="form well" method="POST" id="formRegistrasi">
        <input type="hidden" name="idKunjungan" id="idKunjungan" value="" class="idKunjungan"/>
        <div class="row-fluid">
            <div class="span6">
                <table>
                    <tr>
                        <td class="labelField">No RM</td>
                        <td><input type="text" name="noRm" id="noRm" value="" class="noRm" readonly/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Nama Pasien</td>
                        <td><input type="text" name="namaPasien" id="namaPasien" value="" class="namaPasien" readonly /></td>
                    </tr>
                    <tr>
                        <td class="labelField">Tempat Lahir</td>
                        <td><input type="text" name="tempatLahir" id="tempatLahir" value="" class="tempatLahir" readonly /></td>
                    </tr>
                    <tr>
                        <td class="labelField">Tanggal Lahir</td>
                        <td>
                            <div id="datePickerTanggal" class="input-append date">
                                <input class="input input-small" data-format="dd-MM-yyyy" type="text" name="tanggalLahir" id="tanggalLahir" value="<?php echo tglSekarang(); ?>" readonly>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Jenis Kelamin</td>
                        <td><?php dropDownJeniskelamin('name="jenisKelamin" id="jenisKelamin" class="jenisKelamin" readonly'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Golongan Darah</td>
                        <td><?php dropDownGolonganDarah('name="golonganDarah" id="golonganDarah" class="golonganDarah" readonly'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Alergi</td>
                        <td><textarea name="alergi" id="alergi" class="alergi uraian" readonly></textarea></td>
                    </tr>
                </table>
            </div>
            <div class="span6">
                <table>
                    <tr>
                        <td class="labelField">No Anritan</td>
                        <td><input type="text" name="noAntrian" id="noAntrian" value="" class="noAntrian" readonly/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Poliklinik</td>
                        <td><?php dropDownPoli('name="poli" id="poli" class="poli" required'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Tanggal Periksa</td>
                        <td>
                            <div id="datePickerTanggalPeriksa" class="input-append date">
                                <input class="input input-small" data-format="dd-MM-yyyy" type="text" name="tanggalPeriksa" id="tanggalPeriksa" value="<?php echo tglSekarang(); ?>" readonly>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Dokter</td>
                        <td><?php dropDownDokter('name="dokter" id="dokter" class="dokter"'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Cara Bayar</td>
                        <td><?php dropDownCaraBayar('name="caraBayar" id="caraBayar" class="caraBayar" required'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">No Peserta Jaminan</td>
                        <td><input type="text" name="noPeserta" id="noPeserta" value="" class="noPeserta" /></td>
                    </tr>
                    <tr>
                        <td class="labelField">Keterangan</td>
                        <td><textarea name="keterangan" id="keterangan" class="keterangan uraian"></textarea></td>
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

        $('#datePickerTanggalPeriksa').datetimepicker({
            language: 'pt-BR',
            autoclose: true
        });

        $(document).on('focus', '#tanggalPeriksa', function() {
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
        $('#golonganDarah').val('');
        $('#alergi').val('');

        $('#noAntrian').val('');
        $('#poli').val('');
        $('#tanggalPeriksa').val('');
        $('#dokter').val('');
        $('#caraBayar').val('');
        $('#noPeserta').val('');
        $('#keterangan').val('');
    }

    function disableForm(){
        $('#namaPasien').prop('disabled', true);
        $('#tempatLahir').prop('disabled', true);
        $('#tanggalLahir').prop('disabled', true);
        $('#jenisKelamin').prop('disabled', true);
        $('#golonganDarah').prop('disabled', true);
        $('#alergi').prop('disabled', true);

        $('#noAntrian').prop('disabled', true);
        $('#poli').prop('disabled', true);
        $('#tanggalPeriksa').prop('disabled', true);
        $('#dokter').prop('disabled', true);
        $('#caraBayar').prop('disabled', true);
        $('#noPeserta').prop('disabled', true);
        $('#keterangan').prop('disabled', true);
    }

    function enableForm(){
        $('#noAntrian').prop('disabled', false);
        $('#poli').prop('disabled', false);
        $('#tanggalPeriksa').prop('disabled', false);
        $('#dokter').prop('disabled', false);
        $('#caraBayar').prop('disabled', false);
        $('#noPeserta').prop('disabled', false);
        $('#keterangan').prop('disabled', false);
    }

    /*
     *pilih data table
     **/
    $(document).on('click', '.listData', function(){
        var idTrans = $(this).data('id');
        getDataPasienByidTrans(idTrans);
        $('#modalListData').modal('hide');
    });

    function getDataPasienByidTrans(idTrans){
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
                    setDataPasien(response);
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
    function setDataPasien(response){
        clearForm();
        disableForm();
        if(response['data'] !== null){
            $('#noRm').val(response['data']['mpas_id']);
            $('#namaPasien').val(response['data']['mpas_nama']);
            $('#tempatLahir').val(response['data']['mpas_tempat_lahir']);
            $('#tanggalLahir').val(response['data']['mpas_tanggal_lahir']);
            $('#jenisKelamin').val(response['data']['mpas_jenis_kelamin']);
            $('#golonganDarah').val(response['data']['rgd_id']);
            $('#alergi').val(response['data']['mpas_alergi']);
        }
        enableForm();
        $('#btnAdd').prop('disabled', true);
        $('#btnEdit').prop('disabled', true);
        $('#btnCancel').prop('disabled', false);
        $('#btnSave').prop('disabled', false);
    }

    /*
     *set data from
     */
    function setDataKunjungan(response){
        clearForm();
        disableForm();
        if(response['data'] !== null){
            $('#noRm').val(response['data']['mpas_id']);
            $('#namaPasien').val(response['data']['mpas_nama']);
            $('#tempatLahir').val(response['data']['mpas_tempat_lahir']);
            $('#tanggalLahir').val(response['data']['tanggal_lahir']);
            $('#jenisKelamin').val(response['data']['mpas_jenis_kelamin']);
            $('#golonganDarah').val(response['data']['rgd_id']);
            $('#alergi').val(response['data']['mpas_alergi']);

            $('#idKunjungan').val(response['data']['tkunj_id']);
            $('#noAntrian').val(response['data']['tkunj_no_antrian']);
            $('#poli').val(response['data']['mpoli_id']);
            $('#tanggalPeriksa').val(response['data']['tkunj_tanggal']);
            $('#dokter').val(response['data']['mdok_id']);
            $('#caraBayar').val(response['data']['mcb_id']);
            $('#noPeserta').val(response['data']['tkunj_no_peserta']);
            $('#keterangan').val(response['data']['tkunj_keterangan']);
        }
        $('#btnAdd').prop('disabled', false);
        $('#btnEdit').prop('disabled', false);
        $('#btnCancel').prop('disabled', true);
        $('#btnSave').prop('disabled', true);
    }

    function getDataByidTrans(idTrans){
        if(idTrans !== null){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('registrasi/reg_poli/get_data_kunjungan_by_id') ?>",
                data: {idTrans:idTrans},
                dataType: 'json',
                beforeSend: function(xhr) {
                    showProgressBar('proses ambil data');
                },
                error: function(xhr, status) {
                    hideProgressBar();
                    bootbox.alert(status);
                },
                success: function(response) {
                    setDataKunjungan(response);
                    hideProgressBar();
                }
            });
        }else{
            bootbox.alert('Identitas data tidak diketahui');
        }
    }
</script>

<!-- Js Aksi -->
<script>

    $(document).on('click', '.listDataKunjungan', function(){
        var idTrans = $(this).data('id');
        getDataByidTrans(idTrans);
        $('#modalListDataKunjungan').modal('hide');
    });

    $(document).on('click', '#btnAdd', function(){
        clearForm();
        enableForm();
        $('#btnAdd').prop('disabled', true);
        $('#btnEdit').prop('disabled', true);
        $('#btnCancel').prop('disabled', false);
        $('#btnSave').prop('disabled', false);
    });

    $(document).on('click', '#btnEdit', function(){
        enableForm();
        $('#btnAdd').prop('disabled', true);
        $('#btnEdit').prop('disabled', true);
        $('#btnCancel').prop('disabled', false);
        $('#btnSave').prop('disabled', false);
    });

    $(document).on('click', '#btnCancel', function(){
        var idTrans = ''+$('#idKunjungan').val();
        if(idTrans.length){
            getDataByidTrans(idTrans);
        }else{
            clearForm();
            disableForm();
            $('#btnAdd').prop('disabled', false);
            $('#btnEdit').prop('disabled', true);
            $('#btnCancel').prop('disabled', true);
            $('#btnSave').prop('disabled', true);
        }
    });

    /*
     * btn simpan
     */

    $(document).ready(function() {
        $('#formRegistrasi').validate({
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('registrasi/reg_poli/proses_simpan'); ?>",
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
                                getDataByidTrans(response['idTrans']);
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

    $(document).on('click', '#btnListDataKunjungan', function(){
        $('#modalListDataKunjungan').modal('show');
    });

</script>