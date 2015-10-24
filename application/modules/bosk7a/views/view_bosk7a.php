<style>
    .labelField{
        width: 120px;
    }
</style>

<div class="row-fluid">
    <form class="form well" method="POST" id="formBosk7a">
        <input type="hidden" name="idTrans" id="idTrans" class="idTrans" value="" />
        <div class="row-fluid">
            <div class="span6">
                <table>
                    <tr>
                        <td class="labelField">Tanggal</td>
                        <td>
                            <div id="datePickerTanggal" class="input-append date">
                                <input class="input input-small" data-format="dd-MM-yyyy" type="text" name="tanggal" id="tanggal" value="<?php echo tglSekarang(); ?>" required>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Triwulan</td>
                        <td><?php dropDownTriwulan('name="triwulan" id="triwulan" class="triwulan" required') ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">No Urut</td>
                        <td><input type="text" name="noUrut" id="noUrut" class="noUrut" value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Program Kegiatan</td>
                        <td><input type="text" name="programKegiatan" id="programKegiatan" class="programKegiatan" value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Uraian Penggunaan</td>
                        <td><input type="text" name="uraian" id="uraian" class="uraian" value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Jumlah (Rp)</td>
                        <td><input type="text" name="jumlahPengeluaran" id="jumlahPengeluaran" class="jumlahPengeluaran" data-rule-number value="" required/></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="" style="text-align: center">
            <div class="btn-group">
                <button type="button" id="btnAdd" class="btn btn-info"><i class="icon icon-white icon-plus"></i>Tambah</button>
                <button type="button" id="btnEdit" class="btn btn-warning"><i class="icon icon-white icon-edit"></i>Ubah</button>
                <button type="button" id="btnCancel" class="btn btn-success"><i class="icon icon-white icon-repeat"></i>Batal</button>
                <button type="submit" id="btnSave" class="btn btn-primary"><i class="icon icon-white icon-envelope"></i>Simpan</button>
                <button type="button" id="btnDelete" class="btn btn-danger"><i class="icon icon-white icon-remove"></i>Hapus</button>
            </div>
        </div>
    </form>
</div>
<div class="row-fluid">
    <b>Tampilkan Data</b> Triwulan : <?php dropDownTriwulan('name="triwulanData" id="triwulanData" class="triwulanData"'); ?>
</div>
<div class="row-fluid" style="max-height: 290px !important; overflow: auto">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Triwulan</th>
                <th>No Urut</th>
                <th>Program Kegiatan</th>
                <th>Uraian Penggunaan</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody id="dataTableTransaksi">
        </tbody>
    </table>
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
                var formInput = $('#formBosk7a').find('input,select,textarea, button, checkbox');
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
        $('#btnDelete').prop('disabled', true);
        $('#triwulan').val('2');
        getAllDataTransLimit();
    });
</script>

<!-- JS function Content -->
<script>
    function clearForm(){
        $('#idTrans').val('');
        $('#tanggal').val('');
        $('#triwulan').val('');
        $('#programKegiatan').val('');
        $('#noUrut').val('');
        $('#uraian').val('');
        $('#jumlahPengeluaran').val('');
    }
    
    function disableForm(){
        $('#idTrans').prop('disabled', true);
        $('#tanggal').prop('disabled', true);
        $('#triwulan').prop('disabled', true);
        $('#programKegiatan').prop('disabled', true);
        $('#noUrut').prop('disabled', true);
        $('#uraian').prop('disabled', true);
        $('#jumlahPengeluaran').prop('disabled', true);
    }
    
    function enableForm(){
        $('#idTrans').prop('disabled', false);
        $('#tanggal').prop('disabled', false);
        $('#triwulan').prop('disabled', false);
        $('#programKegiatan').prop('disabled', false);
        $('#noUrut').prop('disabled', false);
        $('#uraian').prop('disabled', false);
        $('#jumlahPengeluaran').prop('disabled', false);
    }
    
    /*
     *mengambil data by filter limit
     */
    function getAllDataTransLimit(){
        var triwulan = $('#triwulanData').val();
        if(triwulan.length){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('bosk7a/bosk7a/getDataFilterLimit') ?>",
                data: {triwulan:triwulan},
                dataType: 'json',
                beforeSend: function(xhr) {
                    showProgressBar('proses ambil data');
                },
                error: function(xhr, status) {
                    hideProgressBar();
                    alert(status);
                },
                success: function(response) {
                    generateDataTable(response, true);
                    hideProgressBar();
                }
            });
        }
    }
    
    /*
     *proses membuat table
     **/
    function generateDataTable(response, showMsg){
        $('#dataTableTransaksi').html('');
        if (response['data'] !== null) {
            for(var i = 0; i < response['data'].length; i++){
                var strRow = '<tr class="rowDataTable" id="rowDataTable'+response['data'][i]['ID_TRANS']+'" data-id-trans="'+response['data'][i]['ID_TRANS']+'">';
                strRow += '<td>'+response['data'][i]['TGL']+'</td>';
                strRow += '<td>'+response['data'][i]['NAMA_TRIWULAN']+'</td>';
                strRow += '<td>'+response['data'][i]['NO_URUT']+'</td>';
                strRow += '<td>'+response['data'][i]['PROGRAM_KEGIATAN']+'</td>';
                strRow += '<td>'+response['data'][i]['URAIAN_PENGGUNAAN']+'</td>';
                strRow += '<td>'+response['data'][i]['JUMLAH']+'</td>';
                strRow += '</tr>';
                $('#dataTableTransaksi').append(strRow);
            }
        } else {
            if(showMsg === true){
                alert(response['message']);
            }
        }
        //set pilih
        var idTrans = $('#idTrans').val();
        if(idTrans.length){
            $('#dataTableTransaksi tr').removeClass('info');
            $('#dataTableTransaksi #rowDataTable'+idTrans).addClass('info');
        }
    }
    
    /*
     *mengambil data transaksi by id transaksi
     */
    function getDataByidTrans(idTrans){
        if(idTrans !== null){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('bosk7a/bosk7a/getDataByIdTrans') ?>",
                data: {idTrans:idTrans},
                dataType: 'json',
                beforeSend: function(xhr) {
                    showProgressBar('proses ambil data');
                },
                error: function(xhr, status) {
                    hideProgressBar();
                    alert(status);
                },
                success: function(response) {
                    setDataTrans(response);
                    hideProgressBar();
                }
            });
        }else{
            alert('Identitas data tidak diketahui');
        }
    }
    
    /*
     *set data from 
     */
    function setDataTrans(response){
        clearForm();
        disableForm();
        if(response['data'] !== null){
            $('#idTrans').val(response['data']['ID_TRANS']);
            $('#tanggal').val(response['data']['TGL']);
            $('#triwulan').val(response['data']['KODE_TRIWULAN']);
            $('#programKegiatan').val(response['data']['PROGRAM_KEGIATAN']);
            $('#noUrut').val(response['data']['NO_URUT']);
            $('#uraian').val(response['data']['URAIAN_PENGGUNAAN']);
            $('#jumlahPengeluaran').val(response['data']['JUMLAH']);
        }
        $('#btnAdd').prop('disabled', false);
        $('#btnEdit').prop('disabled', false);
        $('#btnCancel').prop('disabled', true);
        $('#btnSave').prop('disabled', true);
        $('#btnDelete').prop('disabled', false);
    }
    /*
     *pilih data table
     **/
    $(document).on('click', '.rowDataTable', function(){
        var idTrans = $(this).data('idTrans');
        var idBaris = $(this).attr('id');
        getDataByidTrans(idTrans);
        $('#dataTableTransaksi tr').removeClass('info');
        $('#dataTableTransaksi #'+idBaris).addClass('info');
    });
    /*
     *perumahan triwulan tampilkan data
     */
    $(document).on('change', '#triwulanData', function(){
        getAllDataTransLimit();
    });
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
        $('#btnDelete').prop('disabled', true);
    });
    
    $(document).on('click', '#btnEdit', function(){
        enableForm();
        $('#btnAdd').prop('disabled', true);
        $('#btnEdit').prop('disabled', true);
        $('#btnCancel').prop('disabled', false);
        $('#btnSave').prop('disabled', false);
        $('#btnDelete').prop('disabled', true);
    });
    
    $(document).on('click', '#btnCancel', function(){
        var idTrans = $('#idTrans').val();
        if(idTrans.length){
            getDataByidTrans(idTrans);
        }else{
            clearForm();
            disableForm();
            $('#btnAdd').prop('disabled', false);
            $('#btnEdit').prop('disabled', true);
            $('#btnCancel').prop('disabled', true);
            $('#btnSave').prop('disabled', true);
            $('#btnDelete').prop('disabled', true);
        }
    });
    
    $(document).on('click', '#btnDelete', function(){
        var idTrans = $('#idTrans').val();
        if(idTrans.length){
            if(confirm('Yakin akan menghapus data ini')){
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('bosk7a/bosk7a/prosesDelete') ?>",
                    data: {idTrans:idTrans},
                    dataType: 'json',
                    beforeSend: function(xhr) {
                        showProgressBar('proses hapus data');
                    },
                    error: function(xhr, status) {
                        hideProgressBar();
                        alert(status);
                    },
                    success: function(response) {
                        hideProgressBar();
                        if (response['status'] === true) {
                            getAllDataTransLimit();                   
                            clearForm();
                            disableForm();
                            $('#btnAdd').prop('disabled', false);
                            $('#btnEdit').prop('disabled', true);
                            $('#btnCancel').prop('disabled', true);
                            $('#btnSave').prop('disabled', true);
                            $('#btnDelete').prop('disabled', true);
                            alert(response['message']);
                        } else {
                            alert(response['message']);
                        }
                    }
                });
            }
        }
    });
    
    /*
     * btn simpan
     */
    $(document).ready(function() {
        $('#formBosk7a').validate({
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('bosk7a/bosk7a/prosesSimpan') ?>",
                    data: $('#formBosk7a').serialize(),
                    dataType: 'json',
                    beforeSend: function(xhr) {
                        showProgressBar('proses simpan');
                    },
                    error: function(xhr, status) {
                        hideProgressBar();
                        alert(status);
                    },
                    success: function(response) {
                        hideProgressBar();
                        if (response['status'] === true) {
                            if(response['idTrans'] !== null){
                                getDataByidTrans(response['idTrans']);
                            }
                            getAllDataTransLimit();                  
                            alert(response['message']);
                        } else {
                            alert(response['message']);
                        }
                    }
                });
                return false;
            }
        });
    });
</script>