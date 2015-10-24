<style>
    .labelField{
        width: 180px;
    }
    .uraian{
        width: 300px;
        height: 40px;
        resize: none       
    }
</style>

<div class="row-fluid">
    <form class="form well form-inline" method="POST" id="formBosk7">
        <input type="hidden" name="idTrans" id="idTrans" class="idTrans" value="" />
        <div class="row-fluid">
            <div class="span5">
                <table>
                    <tr>
                        <td class="labelField">No Kode</td>
                        <td><input type="text" name="noKode" id="noKode" class="noKode" value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Tahun Ajaran</td>
                        <td><?php dropDownTahunAjaran('name="tahunAjaran" id="tahunAjaran" class="tahunAjaran" required'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Triwulan</td>
                        <td><?php dropDownTriwulan('name="triwulan" id="triwulan" class="triwulan" required') ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Uraian Kegiatan</td>
                        <td><textarea name="uraian" id="uraian" class="uraian" required></textarea></td>
                    </tr>
                </table>
            </div>
            <div class="span7">
                <table>
                    <tr>
                        <td class="labelField">Bos Sumber</td>
                        <td>
                            <?php dropDownSumberDanaBosByParent('name="sumberDanaBos" id="sumberDanaBos" class="sumberDanaBos"', '10') ?>
                            Rp
                            <input type="text" name="jumlahSumberDanaBos" id="jumlahSumberDanaBos" class="jumlahSumberDanaBos" data-rule-number value=""/>
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Sumber Pendapatan Sekolah</td>
                        <td>
                            <?php dropDownSumberDanaBosByParent('name="sumberDanaPendapatanSekolah" id="sumberDanaPendapatanSekolah" class="sumberDanaPendapatanSekolah"', '14') ?>
                            Rp
                            <input type="text" name="jumlahSumberDanaPendapatanSekolah" id="jumlahSumberDanaPendapatanSekolah" class="jumlahSumberDanaPendapatanSekolah" data-rule-number value=""/>
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Sumber Pendapatan Lain</td>
                        <td>
                            <?php dropDownSumberDanaBosByParent('name="sumberDanaPendapatanLain" id="sumberDanaPendapatanLain" class="sumberDanaPendapatanLain"', '19') ?>
                            Rp
                            <input type="text" name="jumlahSumberDanaPendapatanLain" id="jumlahSumberDanaPendapatanLain" class="jumlahSumberDanaPendapatanLain" data-rule-number value="" />
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Bantuan Lain Sekolah)</td>
                        <td><input type="text" name="jumlahBantuanLain" id="jumlahBantuanLain" class="jumlahBantuanLain" data-rule-number value=""/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Total(Rp)</td>
                        <td><input type="text" name="totalDana" id="totalDana" class="totalDana" data-rule-number value="" readonly=""/></td>
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
                <button type="button" id="btnDelete" class="btn btn-danger"><i class="icon icon-white icon-remove"></i>Hapus</button>
            </div>
        </div>
    </form>
</div>
<div class="row-fluid">
    <b>Tampilkan Data</b> Tahun Ajaran : <?php dropDownTahunAjaran('name="tahunAjaranData" id="tahunAjaranData" class="tahunAjaranData input-medium" required'); ?> Triwulan : <?php dropDownTriwulan('name="triwulanData" id="triwulanData" class="triwulanData input-medium"'); ?>
</div>
<div class="row-fluid" style="max-height: 290px !important; overflow: auto">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th rowspan="3">No Kode</th>
                <th rowspan="3">Uraian</th>
                <th rowspan="3">Triwulan</th>
                <th colspan="12">Penggunaan Dana Bersumber</th>
            </tr>
            <tr>
                <th colspan="3">Bantuan Operasional Sekolah (BOS)</th>
                <th colspan="4">Sumber Pendapatan Sekolah</th>
                <th colspan="3">Sumber Pendapatan Lain</th>
                <th rowspan="2">Lain</th>
                <th rowspan="2">Jumlah</th>
            </tr>
            <tr>
                <th>Pusat</th>
                <th>Provinsi</th>
                <th>Kab/Kota</th>
                <th>Infak Jum'at</th>
                <th>Infak Penerimaan Raport</th>
                <th>Sumbahangn Suka Rela</th>
                <th>Tinggalan Kelas VI</th>
                <th>BSM</th>
                <th>Ruko</th>
                <th>Dudi</th>
            </tr>
        </thead>
        <tbody id="dataTableTransaksi">
        </tbody>
        <tfoot>
            <tr style="font-weight: bold">
                <td colspan="14" style="text-align: right">Total Penggunaan Dana</td>
                <td style="text-align: right"><span id="totalPengeluaran"></span></td>
            </tr>
        </tfoot>
    </table>
</div>

<!-- JS Deklarasi -->
<script>
    $(document).ready(function(){
        $(document).on("keydown", "input,select,textarea", function(event) {
            if (event.keyCode === 13) {
                var formInput = $('#formBosk7').find('input,select,textarea, button, checkbox');
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
        getAllDataTrans();
    });
</script>

<!-- JS function Content -->
<script>
    function clearForm(){
        $('#idTrans').val('');
        $('#noKode').val('');
        $('#uraian').val('');
        $('#tahunAjaran').val('');
        $('#triwulan').val('');
        $('#sumberDanaBos').val('');
        $('#jumlahSumberDanaBos').val('');
        $('#sumberDanaPendapatanSekolah').val('');
        $('#jumlahSumberDanaPendapatanSekolah').val('');
        $('#sumberDanaPendapatanLain').val('');
        $('#jumlahSumberDanaPendapatanLain').val('');
        $('#jumlahBantuanLain').val('');
        $('#totalDana').val('');
    }
    
    function disableForm(){
        $('#idTrans').prop('disabled', true);
        $('#noKode').prop('disabled', true);
        $('#uraian').prop('disabled', true);
        $('#tahunAjaran').prop('disabled', true);
        $('#triwulan').prop('disabled', true);
        $('#sumberDanaBos').prop('disabled', true);
        $('#jumlahSumberDanaBos').prop('disabled', true);
        $('#sumberDanaPendapatanSekolah').prop('disabled', true);
        $('#jumlahSumberDanaPendapatanSekolah').prop('disabled', true);
        $('#sumberDanaPendapatanLain').prop('disabled', true);
        $('#jumlahSumberDanaPendapatanLain').prop('disabled', true);
        $('#jumlahBantuanLain').prop('disabled', true);
        $('#totalDana').prop('disabled', true);
    }
    
    function enableForm(){
        $('#idTrans').prop('disabled', false);
        $('#noKode').prop('disabled', false);
        $('#uraian').prop('disabled', false);
        $('#tahunAjaran').prop('disabled', false);
        $('#triwulan').prop('disabled', false);
        $('#sumberDanaBos').prop('disabled', false);
        $('#jumlahSumberDanaBos').prop('disabled', false);
        $('#sumberDanaPendapatanSekolah').prop('disabled', false);
        $('#jumlahSumberDanaPendapatanSekolah').prop('disabled', false);
        $('#sumberDanaPendapatanLain').prop('disabled', false);
        $('#jumlahSumberDanaPendapatanLain').prop('disabled', false);
        $('#jumlahBantuanLain').prop('disabled', false);
        $('#totalDana').prop('disabled', false);
    }
    
    /*
     *mengambil data by filter limit
     */
    function getAllDataTrans(){
        var tahun = $('#tahunAjaranData').val();
        var triwulan = $('#triwulanData').val();
        if(tahun.length && triwulan.length){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('bosk7/bosk7/getDataTrans') ?>",
                data: {tahun:tahun, triwulan:triwulan},
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
        var total = 0;
        if (response['data'] !== null) {
            for(var i = 0; i < response['data'].length; i++){
                var strRow = '<tr class="rowDataTable" id="rowDataTable'+response['data'][i]['ID_TRANS']+'" data-id-trans="'+response['data'][i]['ID_TRANS']+'">';
                strRow += '<td>'+response['data'][i]['NO_KODE']+'</td>';
                strRow += '<td>'+response['data'][i]['URAIAN']+'</td>';
                strRow += '<td>'+response['data'][i]['NAMA_TRIWULAN']+'</td>';
                if(response['data'][i]['KODE_DANA_BOS'] === '7'){
                    strRow += '<td>'+response['data'][i]['JUMLAH_DANA_BOS']+'</td>';
                    strRow += '<td>0</td>';
                    strRow += '<td>0</td>';
                }else if(response['data'][i]['KODE_DANA_BOS'] === '8'){
                    strRow += '<td>0</td>';
                    strRow += '<td>'+response['data'][i]['JUMLAH_DANA_BOS']+'</td>';
                    strRow += '<td>0</td>';
                }else{
                    strRow += '<td>0</td>';
                    strRow += '<td>0</td>';
                    strRow += '<td>'+response['data'][i]['JUMLAH_DANA_BOS']+'</td>';
                }
                if(response['data'][i]['KODE_PENDAPATAN_SEKOLAH'] === '15'){
                    strRow += '<td>'+response['data'][i]['JUMLAH_PENDAPATAN_SEKOLAH']+'</td>';
                    strRow += '<td>0</td>';
                    strRow += '<td>0</td>';
                    strRow += '<td>0</td>';
                }else if(response['data'][i]['KODE_PENDAPATAN_SEKOLAH'] === '16'){
                    strRow += '<td>0</td>';
                    strRow += '<td>'+response['data'][i]['JUMLAH_PENDAPATAN_SEKOLAH']+'</td>';
                    strRow += '<td>0</td>';
                    strRow += '<td>0</td>';
                }else if(response['data'][i]['KODE_PENDAPATAN_SEKOLAH'] === '17'){
                    strRow += '<td>0</td>';
                    strRow += '<td>0</td>';
                    strRow += '<td>'+response['data'][i]['JUMLAH_PENDAPATAN_SEKOLAH']+'</td>';
                    strRow += '<td>0</td>';
                }else{
                    strRow += '<td>0</td>';
                    strRow += '<td>0</td>';
                    strRow += '<td>0</td>';
                    strRow += '<td>'+response['data'][i]['JUMLAH_PENDAPATAN_SEKOLAH']+'</td>';
                }
                if(response['data'][i]['KODE_PENDAPATAN_LAIN'] === '20'){
                    strRow += '<td>'+response['data'][i]['JUMLAH_PENDAPATAN_LAIN']+'</td>';
                    strRow += '<td>0</td>';
                    strRow += '<td>0</td>';
                }else if(response['data'][i]['KODE_PENDAPATAN_LAIN'] === '21'){
                    strRow += '<td>0</td>';
                    strRow += '<td>'+response['data'][i]['JUMLAH_PENDAPATAN_LAIN']+'</td>';
                    strRow += '<td>0</td>';
                }else{
                    strRow += '<td>0</td>';
                    strRow += '<td>0</td>';
                    strRow += '<td>'+response['data'][i]['JUMLAH_PENDAPATAN_LAIN']+'</td>';
                }
                strRow += '<td>'+response['data'][i]['JUMLAH_BANTUAN_LAIN']+'</td>';
                strRow += '<td>'+response['data'][i]['TOTAL_DANA']+'</td>';
                strRow += '</tr>';
                total += parseInt(response['data'][i]['TOTAL_DANA']);
                $('#dataTableTransaksi').append(strRow);
            }
        } else {
            if(showMsg === true){
                alert(response['message']);
            }
        }
        $('#totalPengeluaran').html(total);
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
                url: "<?php echo site_url('bosk7/bosk7/getDataByIdTrans') ?>",
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
            $('#noKode').val(response['data']['NO_KODE']);
            $('#uraian').val(response['data']['URAIAN']);
            $('#tahunAjaran').val(response['data']['KODE_TAHUN']);
            $('#triwulan').val(response['data']['KODE_TRIWULAN']);
            $('#sumberDanaBos').val(response['data']['KODE_SUMBER_BOS']);
            $('#jumlahSumberDanaBos').val(response['data']['JUMLAH_DANA_BOS']);
            $('#sumberDanaPendapatanSekolah').val(response['data']['KODE_SUMBER_PENDAPATAN_SEKOLAH']);
            $('#jumlahSumberDanaPendapatanSekolah').val(response['data']['JUMLAH_PENDAPATAN_SEKOLAH']);
            $('#sumberDanaPendapatanLain').val(response['data']['KODE_SUMBER_PENDAPATAN_LAIN']);
            $('#jumlahSumberDanaPendapatanLain').val(response['data']['JUMLAH_PENDAPATAN_LAIN']);
            $('#jumlahBantuanLain').val(response['data']['JUMLAH_BANTUAN_LAIN']);
            $('#totalDana').val(response['data']['TOTAL_DANA']);
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
    $(document).on('change', '#tahunAjaranData, #triwulanData', function(){
        getAllDataTrans();
    });
    
    /*
     *menghitung total dana
     */
    function hitungTotalDana(){
        var danaBos = $('#jumlahSumberDanaBos').val();
        if(danaBos.length < 1){
            danaBos = '0';
        }
        var danaPendapatanSekolah = $('#jumlahSumberDanaPendapatanSekolah').val();
        if(danaPendapatanSekolah.length < 1){
            danaPendapatanSekolah = '0';
        }
        var danaPendapatanLain = $('#jumlahSumberDanaPendapatanLain').val();
        if(danaPendapatanLain.length < 1){
            danaPendapatanLain = '0';
        }
        var danaBantuanLain = $('#jumlahBantuanLain').val();
        if(danaBantuanLain.length < 1){
            danaBantuanLain = '0';
        }
        var total = parseInt(danaBos)+ parseInt(danaPendapatanSekolah)+ parseInt(danaPendapatanLain)+ parseInt(danaBantuanLain);
        $('#totalDana').val(total);
    }
    /*
     *perumahan triwulan tampilkan data
     */
    $(document).on('change', '#jumlahSumberDanaBos, #jumlahSumberDanaPendapatanSekolah, #jumlahSumberDanaPendapatanLain, #jumlahBantuanLain', function(){
        hitungTotalDana();
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
                    url: "<?php echo site_url('bosk7/bosk7/prosesDelete') ?>",
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
                            getAllDataTrans();                   
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
        $('#formBosk7').validate({
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('bosk7/bosk7/prosesSimpan') ?>",
                    data: $('#formBosk7').serialize(),
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
                            getAllDataTrans();                  
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