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
    <form class="form well" method="POST" id="formMasterUser">
        <input type="hidden" name="idUser" id="idUser" class="idUser" value="" />
        <div class="row-fluid">
            <div class="span6">
                <table>
                    <tr>
                        <td class="labelField">Nama Lengkap</td>
                        <td><input type="text" name="namaLengkap" id="namaLengkap" class="namaLengkap" value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Nama Panggilan</td>
                        <td><input type="text" name="namaPanggilan" id="namaPanggilan" class="namaPanggilan" value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Group User</td>
                        <td>
                            <?php dropDownGroupUser('name="groupUser" id="groupUser" required'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="labelField">Username</td>
                        <td><input type="text" name="username" id="username" class="username" value="" required/></td>
                    </tr>
                    <tr>
                        <td class="labelField">Password</td>
                        <td><input type="password" name="password" id="password" class="password" value="" required/></td>
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
                <th>Nama</th>
                <th>Nama Panggilan</th>
                <th>Group</th>
                <th>Username</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="dataTableUser">
        </tbody>
    </table>
</div>

<!-- JS Deklarasi -->
<script>
    $(document).ready(function(){
        $(document).on("keydown", "input,select,textarea", function(event) {
            if (event.keyCode === 13) {
                var formInput = $('#formMasterUser').find('input,select,textarea, button, checkbox');
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
        $('#idUser').val('');
        $('#namaLengkap').val('');
        $('#namaPanggilan').val('');
        $('#groupUser').val('');
        $('#username').val('');
        $('#password').val('');
        $('#statusAktif').prop('checked', false);
    }
    
    function disableForm(){
        $('#idUser').prop('disabled', true);
        $('#namaLengkap').prop('disabled', true);
        $('#namaPanggilan').prop('disabled', true);
        $('#groupUser').prop('disabled', true);
        $('#username').prop('disabled', true);
        $('#password').prop('disabled', true);
        $('#statusAktif').prop('disabled', true);
    }
    
    function enableForm(){
        $('#idUser').prop('disabled', false);
        $('#namaLengkap').prop('disabled', false);
        $('#namaPanggilan').prop('disabled', false);
        $('#groupUser').prop('disabled', false);
        $('#username').prop('disabled', false);
        $('#password').prop('disabled', false);
        $('#statusAktif').prop('disabled', false);
    }
    
    /*
     *mengambil data by filter limit
     */
    function getAllData(){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('master/master_user/getDataAll') ?>",
            data: {id:'0'},
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
        $('#dataTableUser').html('');
        if (response['data'] !== null) {
            var strRow = '';
            var no = 1;
            for(var i = 0; i < response['data'].length; i++){
                strRow += '<tr class="rowDataTable" id="rowDataTable'+response['data'][i]['ID_USER']+'" data-id-user="'+response['data'][i]['ID_USER']+'">';
                strRow += '<td>'+no+'</td>';
                strRow += '<td>'+response['data'][i]['NAMA_LENGKAP']+'</td>';
                strRow += '<td>'+response['data'][i]['NAMA_PANGGILAN']+'</td>';
                strRow += '<td>'+response['data'][i]['GROUP_USER']+'</td>';
                strRow += '<td>'+response['data'][i]['USERNAME']+'</td>';
                strRow += '<td style="text-align:right">'+response['data'][i]['STATUS_AKTIF']+'</td>';
                strRow += '</tr>';
                no++;
            }
            $('#dataTableUser').append(strRow);
        } else {
            alert(response['message']);
        }
    }
    
    /*
     *mengambil data transaksi by id transaksi
     */
    function getDataById(idUser){
        if(idUser !== null){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('master/master_user/getDataById') ?>",
                data: {idUser:idUser},
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
            $('#idUser').val(response['data']['ID_USER']);
            $('#namaLengkap').val(response['data']['NAMA_LENGKAP']);
            $('#namaPanggilan').val(response['data']['NAMA_PANGGILAN']);
            $('#groupUser').val(response['data']['GROUP_USER']);
            $('#username').val(response['data']['USERNAME']);
            $('#password').val('');
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
        var idTrans = ''+$(this).data('idUser')+'';
        var idBaris = $(this).attr('id');
        getDataById(idTrans);
        $('#dataTableUser tr').removeClass('info');
        $('#dataTableUser #'+idBaris).addClass('info');
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
        $('#username').prop('disabled', true);
        $('#password').prop('disabled', true);
        $('#btnAdd').prop('disabled', true);
        $('#btnEdit').prop('disabled', true);
        $('#btnCancel').prop('disabled', false);
        $('#btnSave').prop('disabled', false);
    });
    
    $(document).on('click', '#btnCancel', function(){
        var idTrans = ''+$('#idUser').val()+'';
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
        $('#formMasterUser').validate({
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('master/master_user/prosesSimpan') ?>",
                    data: $('#formMasterUser').serialize(),
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
                            if(response['idUser'] !== null){
                                getDataById(response['idUser']);
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