<style>
    .labelField{
        width: 120px;
    }
    .uraian{
        width: 300px;
        height: 40px;
        resize: none
    }
</style>

<div class="row-fluid">
    <form class="form well" method="POST" id="formMasterGuru">
        <input type="hidden" name="idGuru" id="idGuru" class="idGuru" value="" />
        <div class="row-fluid">
            <div class="span6">
                <table>
                    <tr>
                        <td class="labelField">Nama</td>
                        <td><input type="text" name="nama" id="nama" class="nama" value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Jenis Kelamin</td>
                        <td>
                            <select name="jenisKelamin" id="jenisKelamin" required>
                                <option value="">...</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Tugas Mengajar</td>
                        <td><input type="text" name="tugas" id="tugas" class="tugas" value="" required/></td>
                    </tr>
                </table>
            </div>
            <div class="span6">
                <table>
                    <tr>
                        <td class="labelField">Alamat</td>
                        <td><textarea name="alamat" id="alamat" class="uraian" required></textarea></td>
                    </tr>
                    <tr>
                        <td class="labelField">Status Aktif</td>
                        <td><input type="checkbox" name="statusAktif" id="statusAktif" class="statusAktif" value="1"/></td>
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

<div class="row-fluid" style="max-height: 290px !important; overflow: auto">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Jenis Kelamin</th>
                <th>Tugas</th>
                <th>Alamat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="dataTableGuru">
        </tbody>
    </table>
</div>

<!-- JS Deklarasi -->
<script>
    $(document).ready(function(){
        $(document).on("keydown", "input,select,textarea", function(event) {
            if (event.keyCode === 13) {
                var formInput = $('#formMasterGuru').find('input,select,textarea, button, checkbox');
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
        getAllData();
    });
</script>

<!-- JS function Content -->
<script>
    function clearForm(){
        $('#idGuru').val('');
        $('#nama').val('');
        $('#jenisKelamin').val('');
        $('#tugas').val('');
        $('#alamat').val('');
        $('#statusAktif').prop('checked', false);
    }
    
    function disableForm(){
        $('#idGuru').prop('disabled', true);
        $('#nama').prop('disabled', true);
        $('#jenisKelamin').prop('disabled', true);
        $('#tugas').prop('disabled', true);
        $('#alamat').prop('disabled', true);
        $('#statusAktif').prop('disabled', true);
    }
    
    function enableForm(){
        $('#idGuru').prop('disabled', false);
        $('#nama').prop('disabled', false);
        $('#jenisKelamin').prop('disabled', false);
        $('#tugas').prop('disabled', false);
        $('#alamat').prop('disabled', false);
        $('#statusAktif').prop('disabled', false);
    }
    
    /*
     *mengambil data by filter limit
     */
    function getAllData(){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('master/master_guru/getDataAll') ?>",
            data: {id:''},
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
    
    /*
     *proses membuat table
     **/
    function generateDataTable(response, showMsg){
        $('#dataTableGuru').html('');
        if (response['data'] !== null) {
            var strRow = '';
            var no = 1;
            for(var i = 0; i < response['data'].length; i++){
                strRow += '<tr class="rowDataTable" id="rowDataTable'+response['data'][i]['ID_GURU']+'" data-id-guru="'+response['data'][i]['ID_GURU']+'">';
                strRow += '<td>'+no+'</td>';
                strRow += '<td>'+response['data'][i]['NAMA_GURU']+'</td>';
                strRow += '<td>'+response['data'][i]['JENIS_KELAMIN']+'</td>';
                strRow += '<td>'+response['data'][i]['TUGAS']+'</td>';
                strRow += '<td>'+response['data'][i]['ALAMAT']+'</td>';
                strRow += '<td style="text-align:right">'+response['data'][i]['STATUS_AKTIF']+'</td>';
                strRow += '</tr>';
                no++;
            }
            $('#dataTableGuru').append(strRow);
        } else {
            alert(response['message']);
        }
    }
    
    /*
     *mengambil data transaksi by id transaksi
     */
    function getDataById(idTrans){
        if(idTrans !== null){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('master/master_guru/getDataById') ?>",
                data: {idGuru:idTrans},
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
            $('#idGuru').val(response['data']['ID_GURU']);
            $('#nama').val(response['data']['NAMA_GURU']);
            $('#jenisKelamin').val(response['data']['JENIS_KELAMIN']);
            $('#tugas').val(response['data']['TUGAS']);
            $('#alamat').val(response['data']['ALAMAT']);
            if(parseInt(response['data']['STATUS_AKTIF']) === 1){
                $('#statusAktif').prop('checked', true);
            }else{
                $('#statusAktif').prop('checked', false);
            }
        }
        $('#btnAdd').prop('disabled', false);
        $('#btnEdit').prop('disabled', false);
        $('#btnCancel').prop('disabled', true);
        $('#btnSave').prop('disabled', true);
    }
    /*
     *pilih data table
     **/
    $(document).on('click', '.rowDataTable', function(){
        var idTrans = ''+$(this).data('idGuru')+'';
        var idBaris = $(this).attr('id');
        getDataById(idTrans);
        $('#dataTableGuru tr').removeClass('info');
        $('#dataTableGuru #'+idBaris).addClass('info');
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
    });
    
    $(document).on('click', '#btnEdit', function(){
        enableForm();
        $('#btnAdd').prop('disabled', true);
        $('#btnEdit').prop('disabled', true);
        $('#btnCancel').prop('disabled', false);
        $('#btnSave').prop('disabled', false);
    });
    
    $(document).on('click', '#btnCancel', function(){
        var idTrans = ''+$('#idGuru').val()+'';
        if(idTrans.length){
            getDataById(idTrans);
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
        $('#formMasterGuru').validate({
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('master/master_guru/prosesSimpan') ?>",
                    data: $('#formMasterGuru').serialize(),
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
                            if(response['idGuru'] !== null){
                                getDataById(response['idGuru']);
                            }
                            getAllData();                  
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