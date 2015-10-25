<style>
    .labelField{
        width: 160px;
    }
    .uraian{
        width: 207px;
        height: 40px;
        resize: none
    }
    .modalAmbilRiwayat{
        margin-left: -250px;
        width: 500px;
    }
</style>


<!-- HTML POP UP  -->
<div id="modalAmbilRiwayat" class="modal hide fade modalAmbilRiwayat" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header btn-info">
        <button type="button" class="close closeModalAmbilRiwayat" data-dismiss="modal" aria-hidden="true">x</button>
        <h4></h4>
    </div>
    <form class="well form-inline" method="post" id="formAmbilRiwayat">
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Rmah Sakit</th>
                                <th>No Rekamedik</th>
                            </tr>
                        </thead>
                        <tbody id="dataFromAmbilRiwayat">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" id="btnCariRiwayat" class="btn btn-primary"><i class="icon icon-white icon-search"></i>Ambil Data</button>
            <button class="btn close-list-rekap" aria-hidden="true" data-dismiss="modal" type="button">Tutup</button>
        </div>
    </form>
</div>

<div class="row-fluid">
    <div class="span4 well">
        <span><b>NO ANTRIAN SEKARANG : </b></span>
        <span id="noAntrianSekarang" style="font-weight: bold; font-size: large"></span>
        <br>
        <br>
    </div>
    <div class="span4 well">
        <div class="btn-group">
            <?php dropDownPoli('name="antrianPoli" id="antrianPoli" class="antrianPoli"'); ?>
            <button type="button" id="btnAmbilAntrian" class="btn btn-info"><i class="icon-download"></i>Ambil Antrian</button>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span8 well">
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
    </div>
    <div class="span4 well">
        <label><b>Riwayat Diagnosa Internal RS</b></label>
        <div class="" id="dataDetailRiwayat"></div>
    </div>
</div>

<div class="row-fluid">
    <div class="span8 well">
        <h5>Input Data Diagnosa</h5>
        <div class="row-fluid">
            <div class="span8">
                <form method="POST" id="formInputDiagnosa">
                    <input type="hidden" name="idTransDiagnosa" id="idTransDiagnosa" value="" class="idTransDiagnosa" />
                    <input type="hidden" name="idKunjDiagnosa" id="idKunjDiagnosa" value="" class="idKunjDiagnosa" />
                    <input type="hidden" name="noRmDiagnosa" id="noRmDiagnosa" value="" class="noRmDiagnosa" />
                    <table>
                        <tr>
                            <td class="labelField">Diagnosa</td>
                            <td><input type="text" name="namaDiagnosa" id="namaDiagnosa" value="" required class="namaDiagnosa" /></td>
                        </tr>
                        <tr>
                            <td class="labelField">Keterangan</td>
                            <td><textarea name="keteranganDiagnosa" id="keteranganDiagnosa" class="keteranganDiagnosa uraian"></textarea></td>
                        </tr>
                        <tr>
                            <td class="labelField">&nbsp;</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="labelField"></td>
                            <td>
                                <button type="button" id="btnEdit" class="btn btn-warning"><i class="icon icon-white icon-edit"></i>Ubah</button>
                                <button type="button" id="btnCancel" class="btn btn-success"><i class="icon icon-white icon-repeat"></i>Batal Ubah</button>
                                <button type="submit" id="btnSave" class="btn btn-primary"><i class="icon icon-white icon-envelope"></i>Simpan</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="span4">
            </div>
        </div>
        <br><br>
    </div>
    <div class="span4 well form-inline">
        <label><b>Riwayat Diagnosa External RS</b></label>&nbsp;
        <button type="button" id="btnAmbilRiwayatExt" class="btn btn-info"><i class="icon-list"></i>Lihat</button>
        <div class="" id="dataDetailRiwayat2"></div>
    </div>
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
                var formInput = $('#formInputDiagnosa').find('input,select,textarea, button, checkbox');
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

        clearFormD();
        disableFormD();
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
   
</script>

<script>
    $(document).on('click','#btnAmbilRiwayatExt', function(){
        var noRm = $('#noRm').val();
        if(noRm.length){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('pelayanan/pelayanan/get_data_rs'); ?>",
                data: {noRm:noRm},
                dataType: 'json',
                beforeSend: function(xhr) {
                    showProgressBar('proses ambil data');
                },
                error: function(xhr, status) {
                    hideProgressBar();
                    bootbox.alert(status);
                },
                success: function(response) {
                    hideProgressBar();
                    if (response['data']) {
                        var string_tr = '';
                        for (var i = 0; i < response['data'].length; i++) {
                            string_tr += '<tr>';
                            string_tr += '<td nowrap>' + response['data'][i]['nama_rs'] + '</td>';
                            string_tr += '<td nowrap>';
                            string_tr += '<input type="hidden" name="ambilIdRs[]" class="ambilIdRs" value="' + response['data'][i]['id_rs'] +'" />';
                            string_tr += '<input type="text" name="ambilNoRm[]" class="ambilNoRm" value="' + response['data'][i]['no_rm'] +'" />';
                            string_tr += '</td>';
                            string_tr += '</tr>';
                        }
                        $('#dataFromAmbilRiwayat').html(string_tr);
                    } else {
                        bootbox.alert(response['message']);
                    }
                    $('#modalAmbilRiwayat').modal('show');
                }
            });
        }else{
            bootbox.alert('Identitas data tidak diketahui');
        }
    });

    $(document).ready(function() {
        $('#formAmbilRiwayat').validate({
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('pelayanan/pelayanan/proses_ambil_data_riwayat'); ?>",
                    data: $('#formAmbilRiwayat').serialize(),
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
                        if (response['data']) {
                            $hotRiwayatInstance2.loadData(response['data']);
                            $('#modalAmbilRiwayat').modal('hide');
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

<!-- Js Aksi -->
<script>

    function clearFormD(){
        $('#idTransDiagnosa').val('');
        $('#idKunjDiagnosa').val('');
        $('#noRmDiagnosa').val('');
        $('#namaDiagnosa').val('');
        $('#keteranganDiagnosa').val('');
    }

    function disableFormD(){
        $('#idTransDiagnosa').prop('disabled', true);
        $('#namaDiagnosa').prop('disabled', true);
        $('#keteranganDiagnosa').prop('disabled', true);
    }

    function enableFormD(){
        $('#idTransDiagnosa').prop('disabled', false);
        $('#namaDiagnosa').prop('disabled', false);
        $('#keteranganDiagnosa').prop('disabled', false);
    }

    /*
     *set data from
     */
    function setDataDiagnosa(response){
        clearFormD();
        disableFormD();
        if(response['data'] !== null){
            $('#idTransDiagnosa').val(response['data']['tdiag_id']);
            $('#idKunjDiagnosa').val(response['data']['tkunj_id']);
            $('#noRmDiagnosa').val(response['data']['mpas_id']);
            $('#namaDiagnosa').val(response['data']['tdiag_nama']);
            $('#keteranganDiagnosa').val(response['data']['tdiag_keterangan']);
        }
        $('#btnEdit').prop('disabled', false);
        $('#btnCancel').prop('disabled', true);
        $('#btnSave').prop('disabled', true);
    }



    function getDataDiagnosaByidTrans(idTrans){
        if(idTrans !== null){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('pelayanan/pelayanan/get_data_diagnosa_by_id') ?>",
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
                    setDataDiagnosa(response);
                    hideProgressBar();
                }
            });
        }else{
            bootbox.alert('Identitas data tidak diketahui');
        }
    }
    
    $(document).on('click', '#btnEdit', function(){
        enableFormD();
        $('#btnEdit').prop('disabled', true);
        $('#btnCancel').prop('disabled', false);
        $('#btnSave').prop('disabled', false);
    });

    $(document).on('click', '#btnCancel', function(){
        var idTrans = ''+$('#idTransDiagnosa').val();
        if(idTrans.length){
            getDataDiagnosaByidTrans(idTrans);
        }else{
            $('#idTransDiagnosa').val('');
            $('#namaDiagnosa').val('');
            $('#keteranganDiagnosa').val('');
            disableFormD();
            $('#btnEdit').prop('disabled', false);
            $('#btnCancel').prop('disabled', true);
            $('#btnSave').prop('disabled', true);
        }
    });

    /*
     * btn simpan
     */

    $(document).ready(function() {
        $('#formInputDiagnosa').validate({
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('pelayanan/pelayanan/proses_simpan'); ?>",
                    data: $('#formInputDiagnosa').serialize(),
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
                                getDataDiagnosaByidTrans(response['idTrans']);
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
    $(document).on('click', '#btnAmbilAntrian', function(){
        var poli = $('#antrianPoli').val();
        if(poli.length){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('pelayanan/pelayanan/get_antrian_by_poli'); ?>",
                data: {poli:poli},
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
                    if (response['data'] !== null) {
                        setDataKunjungan(response);
                    } else {
                        bootbox.alert(response['message']);
                    }
                }
            });
        }
    });

    /*
     *set data from
     */
    function setDataKunjungan(response){
        clearForm();
        disableForm();
        $hotRiwayatInstance.loadData([]);
        $hotRiwayatInstance2.loadData([]);

        if(response['data'] !== null){
            $('#noRm').val(response['data']['mpas_id']);
            $('#namaPasien').val(response['data']['mpas_nama']);
            $('#tempatLahir').val(response['data']['mpas_tempat_lahir']);
            $('#tanggalLahir').val(response['data']['tanggal_lahir']);
            $('#jenisKelamin').val(response['data']['mpas_jenis_kelamin']);
            $('#golonganDarah').val(response['data']['rgd_id']);
            $('#alergi').val(response['data']['mpas_alergi']);

            $('#noAntrianSekarang').html(response['data']['tkunj_no_antrian']);
            $('#noAntrian').val(response['data']['tkunj_no_antrian']);
            $('#poli').val(response['data']['mpoli_id']);
            $('#tanggalPeriksa').val(response['data']['tkunj_tanggal']);
            $('#dokter').val(response['data']['mdok_id']);
            $('#caraBayar').val(response['data']['mcb_id']);
            $('#noPeserta').val(response['data']['tkunj_no_peserta']);
            $('#keterangan').val(response['data']['tkunj_keterangan']);

            $('#idKunjDiagnosa').val(response['data']['tkunj_id']);
            $('#noRmDiagnosa').val(response['data']['mpas_id']);

            if(response['dataDiagnosa'] !== null){
                $('#idTransDiagnosa').val(response['dataDiagnosa']['tdiag_id']);
                $('#namaDiagnosa').val(response['dataDiagnosa']['tdiag_nama']);
                $('#keteranganDiagnosa').val(response['dataDiagnosa']['tdiag_keterangan']);
            }
            if(response['dataRiwayat']){
                $hotRiwayatInstance.loadData(response['dataRiwayat']);
            }            
        }
        $('#btnEdit').prop('disabled', false);
        $('#btnCancel').prop('disabled', true);
        $('#btnSave').prop('disabled', true);
    }
</script>

<!-- JS Detail -->
<script>
    var $hotRiwayatInstance;
    var $hotRiwayat = $('#dataDetailRiwayat');

    $(document).ready(function() {
        initDetailBatch();
    });

    /** Set Report. */
    function initDetailBatch() {
        if ($hotRiwayatInstance) {
            $hotRiwayatInstance.destroy();
        }
        $hotRiwayat.html('');
        $hotRiwayat.handsontable({
            rowHeaders: false,
            autoWrapRow: true,
            readOnly: false,
            data: [],
            minRows: 0,
            scrollV: true,
            colWidths: [50, 80, 120],
            stretchH: 'all',
            fillHandle: false,
            multiSelect: true,
            removeRowPlugin: true,
            currentRowClassName: 'hot-current-row',
            manualColumnResize: false,
            enterMoves: function(evt) {
                if (evt.ctrlKey || evt.altKey) {
                    return {row: 0, col: 0};
                } else {
                    return {row: 0, col: 1};
                }
            },
            enterBeginsEditing: false,
            columnSorting: false,
            height: 200,
            dataSchema: {
                tanggal: null,
                nama_poli: null,
                diagnosa: null
            },
            colHeaders: function(col) {
                switch (col) {
                    case 0:
                        return "Tanggal";
                    case 1:
                        return "Poli";
                    case 2:
                        return "Diagnosa";
                }
            },
            columns: [
                {data: 'tanggal', type: 'text', align: 'center', readOnly: true},
                {data: 'nama_poli', type: 'text', align: 'left', readOnly: true},
                {data: 'diagnosa', type: 'text', align: 'left', readOnly: true},
            ],
            cells: function(row, col, prop) {
                this.renderer = hotRenderer;
            },
            afterChange: function(chg, src) {
                hotAfterChange(chg, src);
            }
        });
        $hotRiwayatInstance = $hotRiwayat.handsontable('getInstance');
    }

    /** Format render. */
    function hotRenderer(instance, td, row, col, prop, value, cellProperties) {
        if (cellProperties.type === 'checkbox') {
            Handsontable.CheckboxCell.renderer.apply(this, arguments);
        }
        else if (cellProperties.type === 'numeric') {
            Handsontable.NumericCell.renderer.apply(this, arguments);
        }
        else if (cellProperties.type === 'autocomplete') {
            Handsontable.AutocompleteCell.renderer.apply(this, arguments);
            td.title = 'Ketik untuk menampilkan pilihan...';
            return true;
        }
        else if (cellProperties.type === 'date') {
            Handsontable.DateCell.renderer.apply(this, arguments);
            return true;
        }
        else {
            Handsontable.TextCell.renderer.apply(this, arguments);
        }
        ;
        if (cellProperties.readOnly === true) {
            td.className += ' readonly';
        }
        ;
        if (cellProperties.align === 'center') {
            td.style.textAlign = 'center';
        }
        ;
        if (cellProperties.align === 'right') {
            td.style.textAlign = 'right';
        }
        ;
        
        if (cellProperties.backgroundColor) {
            td.style.backgroundColor = cellProperties.backgroundColor;
        }
        ;
       
    }

    //aksi setelah perubahan data cell
    function hotAfterChange(chg, src) {
        if (src === 'edit') {
            // fix bad value on checkbox delete/backspace
            $cellmeta = $hotRiwayatInstance.getCellMeta(chg[0][0], $hotRiwayatInstance.propToCol(chg[0][1]));
            if (typeof $cellmeta.checkedTemplate !== 'undefined') {
                if (chg[0][3] === '') {
                    $hotRiwayatInstance.setDataAtRowProp(chg[0][0], chg[0][1], $cellmeta.uncheckedTemplate, 'on_empty');
                }
            }
        }
    }
</script>

<!-- JS Detail -->
<script>
    var $hotRiwayatInstance2;
    var $hotRiwayat2 = $('#dataDetailRiwayat2');

    $(document).ready(function() {
        initDetailBatch2();
    });

    /** Set Report. */
    function initDetailBatch2() {
        if ($hotRiwayatInstance2) {
            $hotRiwayatInstance2.destroy();
        }
        $hotRiwayat2.html('');
        $hotRiwayat2.handsontable({
            rowHeaders: false,
            autoWrapRow: true,
            readOnly: false,
            data: [],
            minRows: 0,
            scrollV: true,
            colWidths: [100, 80, 80, 120],
            stretchH: 'all',
            fillHandle: false,
            multiSelect: true,
            removeRowPlugin: true,
            currentRowClassName: 'hot-current-row',
            manualColumnResize: false,
            enterMoves: function(evt) {
                if (evt.ctrlKey || evt.altKey) {
                    return {row: 0, col: 0};
                } else {
                    return {row: 0, col: 1};
                }
            },
            enterBeginsEditing: false,
            columnSorting: false,
            height: 200,
            dataSchema: {
                nama_rs:null,
                tanggal: null,
                nama_poli: null,
                diagnosa: null
            },
            colHeaders: function(col) {
                switch (col) {
                    case 0:
                        return "Nama RS";
                    case 1:
                        return "Tanggal";
                    case 2:
                        return "Poli";
                    case 3:
                        return "Diagnosa";
                }
            },
            columns: [
                {data: 'nama_rs', type: 'text', align: 'center', readOnly: true},
                {data: 'tanggal', type: 'text', align: 'center', readOnly: true},
                {data: 'nama_poli', type: 'text', align: 'left', readOnly: true},
                {data: 'diagnosa', type: 'text', align: 'left', readOnly: true},
            ],
            cells: function(row, col, prop) {
                this.renderer = hotRenderer2;
            },
            afterChange: function(chg, src) {
                hotAfterChange2(chg, src);
            }
        });
        $hotRiwayatInstance2 = $hotRiwayat2.handsontable('getInstance');
    }

    /** Format render. */
    function hotRenderer2(instance, td, row, col, prop, value, cellProperties) {
        if (cellProperties.type === 'checkbox') {
            Handsontable.CheckboxCell.renderer.apply(this, arguments);
        }
        else if (cellProperties.type === 'numeric') {
            Handsontable.NumericCell.renderer.apply(this, arguments);
        }
        else if (cellProperties.type === 'autocomplete') {
            Handsontable.AutocompleteCell.renderer.apply(this, arguments);
            td.title = 'Ketik untuk menampilkan pilihan...';
            return true;
        }
        else if (cellProperties.type === 'date') {
            Handsontable.DateCell.renderer.apply(this, arguments);
            return true;
        }
        else {
            Handsontable.TextCell.renderer.apply(this, arguments);
        }
        ;
        if (cellProperties.readOnly === true) {
            td.className += ' readonly';
        }
        ;
        if (cellProperties.align === 'center') {
            td.style.textAlign = 'center';
        }
        ;
        if (cellProperties.align === 'right') {
            td.style.textAlign = 'right';
        }
        ;

        if (cellProperties.backgroundColor) {
            td.style.backgroundColor = cellProperties.backgroundColor;
        }
        ;

    }

    //aksi setelah perubahan data cell
    function hotAfterChange2(chg, src) {
        if (src === 'edit') {
            // fix bad value on checkbox delete/backspace
            $cellmeta = $hotRiwayatInstance2.getCellMeta(chg[0][0], $hotRiwayatInstance2.propToCol(chg[0][1]));
            if (typeof $cellmeta.checkedTemplate !== 'undefined') {
                if (chg[0][3] === '') {
                    $hotRiwayatInstance2.setDataAtRowProp(chg[0][0], chg[0][1], $cellmeta.uncheckedTemplate, 'on_empty');
                }
            }
        }
    }
</script>
