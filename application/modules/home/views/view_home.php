<style>
    .labelField{
        width: 160px;
    }
    .uraian{
        width: 300px;
        height: 40px;
        resize: none       
    }
    table tr td{
        font-weight: bold;
        color: #000000;
        font-size: large;
    }
</style>

<div class="row-fluid">
    <div class="span3"></div>
    <div class="span6" style="text-align: left">
        <table class="table">
            <tbody>
                <tr>
                    <td colspan="2" style="text-align: center">
                        <img src="<?php echo base_url('assets/images/logokabupaten.jpg');?>" alt="LOGO" width="150" style="margin-top: 2px;"></img>
                    </td>
                </tr>
                <tr>
                    <td>NAMA SEKOLAH</td>
                    <td>: <?php echo getValueIdentitasByKey('nama_sekolah'); ?></td>
                </tr>
                <tr>
                    <td>STATUS SEKOLAH</td>
                    <td>: <?php echo getValueIdentitasByKey('status_sekolah'); ?></td>
                </tr>
                <tr>
                    <td>NSS</td>
                    <td>: <?php echo getValueIdentitasByKey('nss'); ?></td>
                </tr>
                <tr>
                    <td>DESA/KELURAHAN</td>
                    <td>: <?php echo getValueIdentitasByKey('desa'); ?></td>
                </tr>
                <tr>
                    <td>KECAMATAN</td>
                    <td>: <?php echo getValueIdentitasByKey('kecamatan'); ?></td>
                </tr>
                <tr>
                    <td>KABUPATEN</td>
                    <td>: <?php echo getValueIdentitasByKey('kabupaten'); ?></td>
                </tr>
                <tr>
                    <td>KODE POS</td>
                    <td>: <?php echo getValueIdentitasByKey('kode_pos'); ?></td>
                </tr>
                <tr>
                    <td>TELP</td>
                    <td>: <?php echo getValueIdentitasByKey('telp'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="span3"></div>
</div>
