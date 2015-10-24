<!-- Style -->
<style>
    .title{
        width:40%;
    }

    .modal-list-data2{
        margin-left: -550px;
        width: 1100px;
    }

    th{
        text-align: center !important;
        vertical-align: middle;
    } 

</style>

<!-- HTML POP UP  -->
<div id="modalListDataKunjungan" class="modal hide fade modal-list-data2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header btn-info">
        <button type="button" class="close close-list-rekap" data-dismiss="modal" aria-hidden="true">x</button>
        <h4>List Kunjungan Poli</h4>
    </div>
    <div class="modal-body">
        <form class="well form-inline" method="post" id="formListDataKunjungan">
            <div class="row-fluid">
                <div class="span5">   
                    <table>
                        <tr>
                            <td class="title"><input type="checkbox" id="listCekPoliKunjungan" name="listCekPoliKunjungan" value="1"/>&nbsp;<label for="listCekPoliKunjungan">Poli</label></td>
                            <td><?php dropDownPoli('name="listPoliKunjungan" id="listPoliKunjungan" class="listPoliKunjungan" '); ?></td>
                        </tr>
                        <tr>
                            <td class="title"><input type="checkbox" id="listCekNoRmKunjungan" name="listCekNoRmKunjungan" value="1"/>&nbsp;<label for="listCekNoRmKunjungan">No Rm</label></td>
                            <td>
                                <input type="text" name="listNoRmKunjungan" id="listNoRmKunjungan" value=""/>
                            </td>
                        </tr>
                        <tr>
                            <td class="title"><input type="checkbox" id="listCekNamaKunjungan" name="listCekNamaKunjungan" value="1"/>&nbsp;<label for="listCekNamaKunjungan">Nama</label></td>
                            <td>
                                <input type="text" name="listNamaKunjungan" id="listNamaKunjungan" value=""/>
                            </td>
                        </tr>
                        <tr>
                            <td class="title"></td>
                            <td style="text-align: right"><button type="submit" class="btn btn-success" id="btnCari"><i class="icon-search"></i> Cari</button> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
        <h4>List Data</h4>
        <table id="tableListDataKunjungan" class="table table-bordered table-condensed table-hover" style="cursor: pointer;">
            <thead>
                <tr style="text-align: center; font-weight: bold;">
                    <th>Nama Poli</th>
                    <th>No RM</th>
                    <th>Nama Pasien</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody id="datatableListDataKunjunganKunjungan">
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button class="btn close-list-rekap" aria-hidden="true" data-dismiss="modal" type="button">Tutup</button>
    </div>
</div>

<!-- JS GLOBAL -->
<script>
    
    /*
     * clear field tag input
     * @param {type} id
     * @returns {undefined}
     */
    function clearFieldsList(id) {
        $('input,select,textarea', '#' + id).not('[id=regPasienLama],[id=regPasienBaru],[id=kodePelayanan],[id=inputTanggalDaftar],[id=inputTanggalRegistrasi],[id=inputJamRegistrasi],[id=aksi],[id=pnj_btn_tindakan], [id=pnj_btn_tindakan_versi_all]').each(function(i) {
            if ($(this).attr('type') === 'checkbox') {
                $(this).prop('checked', false);
            }
            if ($(this).attr('type') !== 'radio' && $(this).attr('type') !== 'checkbox') {
                $(this).val('');
            }
        });
    }

    /*
     * hapus atribut required tag input
     * @param {type} containerId = grup form
     * @param {type} notId = data not set, exp = #id1,#id2,.class1
     * @returns {undefined}
     */
    function removeRequiredList(containerId, notId) {
        var strNotId = '';
        if (notId !== undefined && notId !== '') {
            strNotId = strNotId + ', ' + notId;
        }
        $('input,select,textarea', '#' + containerId).not('.select2-input, [id^=s2id_]' + strNotId).each(function() {
            $(this).prop('required', false);
        });
    }

    /*
     * menghapus alert validation
     * @param {type} containerId = grup form      * @param {type} notId = data not set, exp = #id1,#id2,.class1
     * @returns {undefined}
     */
    function resetValidationFormList(containerId, notId) {
        $("div[class*=popover]", '#' + containerId).not('.popover-inner, .popover-content').each(function() {
            $(this).remove();
        });
        var strNotId = '';
        if (notId !== undefined && notId !== '') {
            strNotId = strNotId + ', ' + notId;
        }
        $('input,select,textarea', '#' + containerId).not(".select2-input, [id^=s2id_]" + strNotId).each(function() {
            $(this).removeClass('error');
            var divError = $(this).parents("div[class*=error]").eq(0);
            divError.removeClass('error');
        });
    }

    /*
     * @param {type} identitas
     * @returns {undefined}menghapus pesan error validasi berdasarkan identitas tag tertentu
     */
    function resetErrorValidationFieldList(identitas) {
        var parent = $(identitas).parent();
        parent.find('div[class*=popover]').not('.popover-inner, .popover-content').remove();
        $(identitas).removeClass('error');
        var divError = $(identitas).parents("div[class*=error]").eq(0);
        divError.removeClass('error');
    }
</script>

<!-- JS DEKLARATION -->
<script>

    var optionsPaginationList = {//seting pagination
        optionsForRows: [10, 20, 50],
        rowsPerPage: 10,
        firstArrow: (new Image()).src = "<?php echo base_url('assets/img/firstBlue.gif'); ?>",
        prevArrow: (new Image()).src = "<?php echo base_url('assets/img/prevBlue.gif'); ?>",
        lastArrow: (new Image()).src = "<?php echo base_url('assets/img/lastBlue.gif'); ?>",
        nextArrow: (new Image()).src = "<?php echo base_url('assets/img/nextBlue.gif'); ?>",
        topNav: false
    };

</script>

<!-- JS LIST REKAP -->
<script>
    $(document).ready(function() {
        $(document).on("keydown", "input,select,textarea", function(event) {
            if (event.keyCode === 13) {
                var formInput = $('#formListDataKunjungan').find('input,select,textarea');
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

    $(document).on('click', '.close-list-data .listData', function() {
        clearFieldsList('formListDataKunjungan');
        removeRequiredList('formListDataKunjungan');
        resetValidationFormList('formListDataKunjungan');
        $('#datatableListDataKunjunganKunjungan').empty();
        $('#tableListDataKunjungan').tablePagination(optionsPaginationList);
        $('#modalListDataKunjungan').modal('hide');
    });

    /*
     * aksi form di dalam modal 
     */

    $(document).on('change', '#listPoliKunjungan', function() {
        if ($(this).val() !== '') {
            $('#listCekPoliKunjungan').prop('checked', true);
        } else {
            $('#listCekPoliKunjungan').prop('checked', false);
            $(this).removeAttr('required');
            resetErrorValidationFieldList('#listPoliKunjungan');
        }
    });

    $(document).on('click', '#listCekPoliKunjungan', function() {
        if ($(this).is(':checked')) {
            $('#listPoliKunjungan').attr('required', true);
        } else {
            $('#listPoliKunjungan').val('');
            $('#listPoliKunjungan').removeAttr('required');
            resetErrorValidationFieldList('#listPoliKunjungan');
        }
    });
    
    $(document).on('change', '#listNoRmKunjungan', function() {
        if ($(this).val() !== '') {
            $('#listCekNoRmKunjungan').prop('checked', true);
        } else {
            $('#listCekNoRmKunjungan').prop('checked', false);
            $(this).removeAttr('required');
            resetErrorValidationFieldList('#listlistNoRmKunjungan');
        }
    });

    $(document).on('click', '#listCekNoRmKunjungan', function() {
        if ($(this).is(':checked')) {
            $('#listNoRmKunjungan').attr('required', true);
        } else {
            $('#listNoRmKunjungan').val('');
            $('#listNoRmKunjungan').removeAttr('required');
            resetErrorValidationFieldList('#listNoRmKunjungan');
        }
    });

    $(document).on('change', '#listNamaKunjungan', function() {
        if ($(this).val() !== '') {
            $('#listCekNamaKunjungan').prop('checked', true);
        } else {
            $('#listCekNamaKunjungan').prop('checked', false);
            $(this).removeAttr('required');
            resetErrorValidationFieldList('#listNamaKunjungan');
        }
    });

    $(document).on('click', '#listCekNamaKunjungan', function() {
        if ($(this).is(':checked')) {
            $('#listNamaKunjungan').attr('required', true);
        } else {
            $('#listNamaKunjungan').val('');
            $('#listNamaKunjungan').removeAttr('required');
            resetErrorValidationFieldList('#listNamaKunjungan');
        }
    });

    $(document).ready(function() {
        $('#formListDataKunjungan').validate({
            submitHandler: function() {
                $('#datatableListDataKunjunganKunjungan').html('');
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('registrasi/reg_poli/cari_list_kunjungan'); ?>",
                    data: $('#formListDataKunjungan').serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $("#loading").modal('show');
                    },
                    error: function(xhr, status) {
                        bootbox.alert("Terjadi kesalahan format Transfer, Hubungi Administrator");
                        $("#loading").modal('hide');
                    },
                    success: function(response) {
                        $("#loading").modal('hide');
                        if (response['data'] !== null) {
                            var string_tr = '';
                            for (var i = 0; i < response['data'].length; i++) {
                                string_tr += '<tr class="listDataKunjungan" id="listDataKunjungan' + response['data'][i]['mpas_id'] + '" data-id="' + response['data'][i]['mpas_id'] + '">';
                                string_tr += '<td nowrap>' + response['data'][i]['mpoli_nama'] + '</td>';
                                string_tr += '<td nowrap>' + response['data'][i]['mpas_id'] + '</td>';
                                string_tr += '<td>' + response['data'][i]['mpas_nama'] + '</td>';
                                string_tr += '<td nowrap>' + response['data'][i]['mpas_jenis_kelamin'] + '</td>';
                                string_tr += '<td nowrap>' + response['data'][i]['mpas_tanggal_lahir'] + '</td>';
                                string_tr += '<td nowrap>' + response['data'][i]['mpas_alamat'] + '</td>';
                                string_tr += '</tr>';
                            }
                            $('#datatableListDataKunjunganKunjungan').html(string_tr);
                        } else {
                            bootbox.alert(response['message']);
                        }
                        $('#tableListDataKunjungan').tablePagination(optionsPaginationList);
                    }
                });
                return false;
            }
        });
    });
</script>
