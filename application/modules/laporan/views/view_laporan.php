<style>
    .labelField{
        width: 180px;
    }
</style>

<div class="row-fluid">
    <form class="form well form-inline" method="POST" id="formLaporan" action="<?php echo site_url('laporan/laporan/cetakLaporanPdf'); ?>">
        <div class="row-fluid">
            <div class="span12">
                <table>
                    <tr>
                        <td class="labelField">Jenis Laporan</td>
                        <td>
                            <?php dropDownJenisLaporan('name="jenisLaporan" id="jenisLaporan" required', $defaultJenisLaporan); ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="labelField">Tahun Ajaran</td>
                        <td><?php dropDownTahunAjaran('name="tahunAjaran" id="tahunAjaran" class="tahunAjaran" required', $defaultTahunAjaran); ?></td>
                    </tr>
                    <tr>
                        <td class="labelField">Triwulan</td>
                        <td><?php dropDownTriwulan('name="triwulan" id="triwulan" class="triwulan" required', $defaultTriwulan) ?></td>
                        <td></td>
                    </tr>
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
                            <button type="submit" id="btnTampilkan" class="btn btn-primary"><i class="icon icon-white icon-download-alt"></i>Tampilkan</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
</div>
<div class="row-fluid">
    <div class="span12">
        <div style="height:430px">
            <iframe id="targetFrame" src="<?php echo (!empty($iframe_url)) ? $iframe_url : ''; ?>" width="100%" height="100%" scrolling="NO" frameborder="0" ></iframe>
        </div>
    </div>
</div>

<!-- JS Deklarasi -->
<script>
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
    
        $(document).on("keydown", "input,select,textarea", function(event) {
            if (event.keyCode === 13) {
                var formInput = $('#formLaporan').find('input,select,textarea, button, checkbox');
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
        
    });
</script>

<!-- JS function Content -->
<script>

</script>

<!-- Js Aksi -->
<script>

</script>