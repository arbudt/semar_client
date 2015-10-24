<style>
    .labelField{
        width: 150px;
    }
</style>

<div class="row-fluid">
    <form class="form well" method="POST" id="formBosk6">
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
                        <td class="labelField">Tahun Ajaran</td>
                        <td><?php dropDownTahunAjaran('name="tahunAjaran" id="tahunAjaran" class="tahunAjaran" required'); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Triwulan</td>
                        <td><?php dropDownTriwulan('name="triwulan" id="triwulan" class="triwulan" required') ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">No Kode</td>
                        <td><input type="text" name="noKode" id="noKode" class="noKode" value="" /></td>
                    </tr>
                    <tr>
                        <td class="labelField">No Bukti</td>
                        <td><input type="text" name="noBukti" id="noBukti" class="noBukti" value="" /></td>
                    </tr>
                    <tr>
                        <td class="labelField">Uraian</td>
                        <td><input type="text" name="uraian" id="uraian" class="uraian" required /></td>
                    </tr>
                </table>
            </div>
            <div class="span6">
                <table>
                    <tr>
                        <td class="labelField">PPN (Rp)</td>
                        <td><input type="text" name="jumlahPengeluaranPPN" id="jumlahPengeluaranPPN" class="jumlahPengeluaranPPN" data-rule-number value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">PPH21 (Rp)</td>
                        <td><input type="text" name="jumlahPengeluaranPPN21" id="jumlahPengeluaranPPN21" class="jumlahPengeluaranPPN21" data-rule-number value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">PPH22 (Rp)</td>
                        <td><input type="text" name="jumlahPengeluaranPPN22" id="jumlahPengeluaranPPN22" class="jumlahPengeluaranPPN22" data-rule-number value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">PPH23 (Rp)</td>
                        <td><input type="text" name="jumlahPengeluaranPPN23" id="jumlahPengeluaranPPN23" class="jumlahPengeluaranPPN23" data-rule-number value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Total Pengeluaran(Rp)</td>
                        <td><input type="text" name="jumlahTotalPengeluaran" id="jumlahTotalPengeluaran" class="jumlahTotalPengeluaran" data-rule-number value="" readonly=""/></td>
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
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">No Kode</th>
                <th rowspan="2">No Bukti</th>
                <th rowspan="2">Uraian</th>
                <th colspan="5">Penerimaan(Rp)</th>
                <th colspan="5">Penyetoran(Rp)</th>
            </tr>
            <tr>
                <th>PPn</th>
                <th>PPh 21</th>
                <th>PPh 22</th>
                <th>PPh 23</th>
                <th>Jumlah</th>
                <th>PPn</th>
                <th>PPh 21</th>
                <th>PPh 22</th>
                <th>PPh 23</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody id="dataTableTransaksi">
        </tbody>
        <tfoot>
            <tr style="font-weight: bold">
                <td colspan="4" style="text-align: right">Total</td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"><span id="totalPenerimaan"></span></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"><span id="totalPengeluaran"></span></td>
            </tr>
        </tfoot>
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
                var formInput = $('#formBosk6').find('input,select,textarea, button, checkbox');
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
        $('#tanggal').val('');
        $('#tahunAjaran').val('');
        $('#triwulan').val('');
        $('#noBukti').val('');
        $('#noKode').val('');
        $('#uraian').val('');
        $('#jumlahPengeluaranPPN').val('');
        $('#jumlahPengeluaranPPN21').val('');
        $('#jumlahPengeluaranPPN22').val('');
        $('#jumlahPengeluaranPPN23').val('');
        $('#jumlahTotalPengeluaran').val('');
    }
    
    function disableForm(){
        $('#idTrans').prop('disabled', true);
        $('#tanggal').prop('disabled', true);
        $('#tahunAjaran').prop('disabled', true);
        $('#triwulan').prop('disabled', true);
        $('#noBukti').prop('disabled', true);
        $('#noKode').prop('disabled', true);
        $('#uraian').prop('disabled', true);
        $('#jumlahPengeluaranPPN').prop('disabled', true);
        $('#jumlahPengeluaranPPN21').prop('disabled', true);
        $('#jumlahPengeluaranPPN22').prop('disabled', true);
        $('#jumlahPengeluaranPPN23').prop('disabled', true);
        $('#jumlahTotalPengeluaran').prop('disabled', true);
    }
    
    function enableForm(){
        $('#idTrans').prop('disabled', false);
        $('#tanggal').prop('disabled', false);
        $('#tahunAjaran').prop('disabled', false);
        $('#triwulan').prop('disabled', false);
        $('#noBukti').prop('disabled', false);
        $('#noKode').prop('disabled', false);
        $('#uraian').prop('disabled', false);
        $('#jumlahPengeluaranPPN').prop('disabled', false);
        $('#jumlahPengeluaranPPN21').prop('disabled', false);
        $('#jumlahPengeluaranPPN22').prop('disabled', false);
        $('#jumlahPengeluaranPPN23').prop('disabled', false);
        $('#jumlahTotalPengeluaran').prop('disabled', false);
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
                url: "<?php echo site_url('bosk6/bosk6/getDataTrans') ?>",
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
        var totalPengeluaran = 0;
        var totalPenerimaan = 0;
        if (response['data'] !== null) {
            for(var i = 0; i < response['data'].length; i++){
                var strRow = '';
                if(response['data'][i]['ID_TRANS'] !== null){
                    strRow += '<tr class="rowDataTable" id="rowDataTable'+response['data'][i]['ID_TRANS']+'" data-id-trans="'+response['data'][i]['ID_TRANS']+'">';
                }else{
                    strRow += '<tr class="rowDataTable" id="" data-id-trans="">';
                }
                strRow += '<td>'+response['data'][i]['TGL']+'</td>';
                strRow += '<td>'+response['data'][i]['NO_KODE']+'</td>';
                strRow += '<td>'+response['data'][i]['NO_BUKTI']+'</td>';
                strRow += '<td>'+response['data'][i]['URAIAN']+'</td>';
                var pph21 = parseInt(response['data'][i]['JUMLAH_PPN21']);
                var penerimaanPPh21 = pph21;
                strRow += '<td style="text-align: right">'+0+'</td>';
                strRow += '<td style="text-align: right">'+penerimaanPPh21+'</td>';
                strRow += '<td style="text-align: right">'+0+'</td>';
                strRow += '<td style="text-align: right">'+0+'</td>';
                strRow += '<td style="text-align: right">'+penerimaanPPh21+'</td>';
                
                strRow += '<td style="text-align: right">'+response['data'][i]['JUMLAH_PPN']+'</td>';
                strRow += '<td style="text-align: right">'+response['data'][i]['JUMLAH_PPN21']+'</td>';
                strRow += '<td style="text-align: right">'+response['data'][i]['JUMLAH_PPN22']+'</td>';
                strRow += '<td style="text-align: right">'+response['data'][i]['JUMLAH_PPN23']+'</td>';
                strRow += '<td style="text-align: right">'+response['data'][i]['JUMLAH_TOTAL']+'</td>';
                strRow += '</tr>';
                $('#dataTableTransaksi').append(strRow);
                totalPenerimaan += penerimaanPPh21;
                totalPengeluaran += parseInt(response['data'][i]['JUMLAH_TOTAL']);
            }
        } else {
            if(showMsg === true){
                alert(response['message']);
            }
        }
        $('#totalPenerimaan').html(totalPenerimaan);
        $('#totalPengeluaran').html(totalPengeluaran);
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
                url: "<?php echo site_url('bosk6/bosk6/getDataByIdTrans') ?>",
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
            $('#tahunAjaran').val(response['data']['KODE_TAHUN']);
            $('#triwulan').val(response['data']['KODE_TRIWULAN']);
            $('#noBukti').val(response['data']['NO_BUKTI']);
            $('#noKode').val(response['data']['NO_KODE']);
            $('#uraian').val(response['data']['URAIAN']);
            $('#jumlahPengeluaranPPN').val(response['data']['JUMLAH_PPN']);
            $('#jumlahPengeluaranPPN21').val(response['data']['JUMLAH_PPN21']);
            $('#jumlahPengeluaranPPN22').val(response['data']['JUMLAH_PPN22']);
            $('#jumlahPengeluaranPPN23').val(response['data']['JUMLAH_PPN23']);
            $('#jumlahTotalPengeluaran').val(response['data']['JUMLAH_TOTAL']);
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
        var idTrans = ''+$(this).data('idTrans')+'';
        var idBaris = $(this).attr('id');
        if(idTrans.length){
            getDataByidTrans(idTrans);
            $('#dataTableTransaksi tr').removeClass('info');
            $('#dataTableTransaksi #'+idBaris).addClass('info');
        }else{
            alert('Maaf tidak bisa diedit, karna pajak dari k3');
        }
    });
    /*
     *perumahan triwulan tampilkan data
     */
    $(document).on('change', '#tahunAjaranData, #triwulanData', function(){
        getAllDataTrans();
    });
    
    function hitungTotalPengeluaran(){
        var ppn = $('#jumlahPengeluaranPPN').val();
        if(ppn.length < 1){
            ppn = '0';
        }
        var ppn21 = $('#jumlahPengeluaranPPN21').val();
        if(ppn21.length < 1){
            ppn21 = '0';
        }
        var ppn22 = $('#jumlahPengeluaranPPN22').val();
        if(ppn22.length < 1){
            ppn22 = '0';
        }
        var ppn23 = $('#jumlahPengeluaranPPN23').val();
        if(ppn23.length < 1){
            ppn23 = '0';
        }
        var totalPpn = (parseInt(ppn)+parseInt(ppn21)+parseInt(ppn22)+parseInt(ppn23));
        $('#jumlahTotalPengeluaran').val(totalPpn);
    }
    
    $(document).on('change', '#jumlahPengeluaranPPN, #jumlahPengeluaranPPN21, #jumlahPengeluaranPPN22, #jumlahPengeluaranPPN23', function(){
        hitungTotalPengeluaran();
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
                    url: "<?php echo site_url('bosk6/bosk6/prosesDelete') ?>",
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
        $('#formBosk6').validate({
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('bosk6/bosk6/prosesSimpan') ?>",
                    data: $('#formBosk6').serialize(),
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