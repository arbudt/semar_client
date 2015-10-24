<style>
    .labelField{
        width: 180px;
    }
</style>

<div class="row-fluid" style="margin-top: 8px;">
    <div class="span12">
        <table>
            <tr>
                <td class="labelField">Tanggal</td>
                <td>
                    <div id="datePickerTanggalAwal" class="input-append date">
                        <input class="input input-small" data-format="dd-MM-yyyy" type="text" name="tanggalAwal" id="tanggalAwal" value="<?php echo $defaultTanggalAwal; ?>" >
                        <span class="add-on">
                            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                        </span>
                    </div>
                    sd
                    <div id="datePickerTanggalAkhir" class="input-append date">
                        <input class="input input-small" data-format="dd-MM-yyyy" type="text" name="tanggalAkhir" id="tanggalAkhir" value="<?php echo $defaultTanggalAkhir; ?>" >
                        <span class="add-on">
                            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                        </span>
                    </div>
                </td>
                <td>
                    <button type="submit" id="btnTampilkan" class="btn btn-info"><i class="icon icon-white icon-search"></i>Tampilkan</button>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row-fluid" style="max-height: 290px !important; overflow: auto">

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Nama User</th>
                <th>Nama Modul</th>
                <th>Aktifitas</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody id="dataTableTransaksi">
        </tbody>
    </table>
</div>
<!-- JS Deklarasi -->
<script>
    var loopLog;
    $(document).ready(function(){
        $('#datePickerTanggalAwal').datetimepicker({
            language: 'pt-BR',
            autoclose: true
        });

        $(document).on('focus', '#tanggalAwal', function() {
            $(this).mask("99-99-9999");
        });

        $('#datePickerTanggalAkhir').datetimepicker({
            language: 'pt-BR',
            autoclose: true
        });

        $(document).on('focus', '#tanggalAkhir', function() {
            $(this).mask("99-99-9999");
        });

        loopLog = setInterval(function() {
            getAllData();
        }, 5000);
    });
</script>

<!-- JS function Content -->
<script>

    $(document).on('click', '#btnTampilkan', function(){
        getAllData();
    });
    /*
     *mengambil data 
     */
    function getAllData(){
        var tglAwal = $('#tanggalAwal').val();
        var tglAkhir = $('#tanggalAkhir').val();
        if(tglAwal.length && tglAkhir.length){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('log/log/getDataLog') ?>",
                data: {tglAwal:tglAwal, tglAkhir:tglAkhir},
                dataType: 'json',
                beforeSend: function(xhr) {
//                    showProgressBar('proses ambil data');
                },
                error: function(xhr, status) {
//                    hideProgressBar();
                    alert(status);
                },
                success: function(response) {
                    generateDataTable(response, true);
//                    hideProgressBar();
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
                var strRow = '<tr class="rowDataTable" id="rowDataTable'+response['data'][i]['KODE_LOG']+'" data-id-trans="'+response['data'][i]['KODE_LOG']+'">';
                strRow += '<td>'+response['data'][i]['WAKTU']+'</td>';
                strRow += '<td>'+response['data'][i]['NAMA_USER']+'</td>';
                strRow += '<td>'+response['data'][i]['MODUL']+'</td>';
                strRow += '<td>'+response['data'][i]['AKTIFITAS']+'</td>';
                strRow += '<td>'+response['data'][i]['KETERANGAN']+'</td>';
                strRow += '</tr>';
                $('#dataTableTransaksi').append(strRow);
            }
        } else {
            if(showMsg === true){
                alert(response['message']);
            }
        }
    }
    
</script>
