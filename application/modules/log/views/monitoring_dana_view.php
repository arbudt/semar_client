<script type="text/javascript" src="<?php echo base_url() ?>assets/js/highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/highcharts/js/modules/exporting.js"></script>

<style>
    .labelField{
        width: 180px;
    }
</style>

<div class="row-fluid" style="margin-top: 8px;">
    <form class="form well form-inline" method="POST" id="formMonitoring" action="<?php echo site_url('log/monitoring_dana/chart'); ?>">
        <div class="row-fluid">
            <div class="span12">
                <table>
                    <tr>
                        <td class="labelField">Tahun Ajaran</td>
                        <td><?php dropDownTahunAjaran('name="tahunAjaran" id="tahunAjaran" class="tahunAjaran" required', $defaultTahunAjaran); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="labelField">Triwulan</td>
                        <td><?php dropDownTriwulan('name="triwulan" id="triwulan" class="triwulan" required', $defaultTriwulan) ?></td>
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
    <div class="span12 well">
        <div id="grafikBos" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
    </div>
</div>

<script>
    $(function () {
        var danaPenerimaan = '<?php echo!empty($danaPenerimaan) ? $danaPenerimaan : 0; ?>';
        var danaPengeluaran = '<?php echo!empty($danaPengeluaran) ? $danaPengeluaran : 0; ?>';
        var persenPenerimaan = parseFloat('<?php echo!empty($persenPenerimaan) ? $persenPenerimaan : 100; ?>');
        var persenPengeluaran = parseFloat('<?php echo!empty($persenPengeluaran) ? $persenPengeluaran : 0; ?>');
        var tahun = $('#tahunAjaran  option:selected').text();
        var triwulan = $('#triwulan  option:selected').text();
        var kodeTahun = $('#tahunAjaran').val();
        var kodeTriwulan = $('#triwulan').val();
        if(kodeTahun.length && kodeTriwulan.length){
            $('#grafikBos').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 1,//null,
                plotShadow: false
            },
            title: {
                text: 'Persentasi Penggunaan Dana BOS <br/>Tahun '+tahun+' '+triwulan
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                    type: 'pie',
                    name: 'Persentase',
                    data: [
                        ['Penerimaan Rp '+danaPenerimaan+' ', persenPenerimaan],
                        ['Pengeluaran Rp '+danaPengeluaran+' ', persenPengeluaran]
                    ]
                }]
        });
        }
        
    });
</script>