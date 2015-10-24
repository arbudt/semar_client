<?php
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('Realisasi Penggunaan Dana');
$pdf->SetSubject('Realisasi Penggunaan Dana');
$pdf->SetKeywords('Realisasi Penggunaan Dana');
// set default header data
//$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(5, 10, 5, TRUE);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
}
// ---------------------------------------------------------   
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('times', '', 9, '', 'false');
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('L', 'F4');
// set text shadow effect
ob_start();
?>
<style>
    .bottomBorder{
        border-bottom-style: solid;
    }
    .cellHeader{
        text-align: center;
        font-weight: bold;
    }
    .cellBorder{
        border-left-style: solid;
        border-top-style: solid;
        border-right-style: solid;
        border-bottom-style: solid;
    }
</style>
<table border="0" cellpadding="2">
    <thead>
        <tr>
            <td colspan="16" style="text-align: center;"><h4><?php echo!empty($dataCetak['TITLE']) ? $dataCetak['TITLE'] : ''; ?></h4></td>
        </tr>
        <tr>
            <td colspan="2" style="">Nama Sekolah</td>
            <td colspan="14">: <?php echo!empty($dataCetak['NAMA_SEKOLAH']) ? $dataCetak['NAMA_SEKOLAH'] : ''; ?></td>
        </tr>
        <tr>
            <td colspan="2">Desa/kelurahan</td>
            <td colspan="14">: <?php
echo!empty($dataCetak['KELURAHAN']) ? $dataCetak['KELURAHAN'] : '';
echo ' / ';
echo!empty($dataCetak['KECAMATAN']) ? $dataCetak['KECAMATAN'] : '';
?>
            </td>
        </tr>
        <tr>
            <td colspan="2">Kabupaten</td>
            <td colspan="14">: <?php echo!empty($dataCetak['KABUPATEN']) ? $dataCetak['KABUPATEN'] : ''; ?></td>
        </tr>
        <tr>
            <td colspan="2">Propinsi</td>
            <td colspan="14">: <?php echo!empty($dataCetak['PROVINSI']) ? $dataCetak['PROVINSI'] : ''; ?></td>
        </tr>
        <tr>
            <td colspan="16">&nbsp;</td>
        </tr>
        <tr style="background-color: #A3CCD8; font-weight: bold; text-align: center;">
            <th rowspan="3" class="cellBorder" style="width: 30px;">No</th>
            <th rowspan="3" class="cellBorder" style="width: 70px;">No Kode</th>
            <th rowspan="3" class="cellBorder" style="width: 170px;">Uraian</th>
            <th colspan="12" class="cellBorder" style="width: 850px;">Penggunaan Dana Bersumber</th>
        </tr>
        <tr style="background-color: #A3CCD8; font-weight: bold; text-align: center">
            <th colspan="3" class="cellBorder" style="width: 210px;">Bantuan Operasional Sekolah (BOS)</th>
            <th colspan="4" class="cellBorder" style="width: 280px;">Sumber Pendapatan Sekolah</th>
            <th colspan="3" class="cellBorder" style="width: 210px;">Sumber Pendapatan Lain</th>
            <th rowspan="2" class="cellBorder" style="width: 70px;">Lain</th>
            <th rowspan="2" class="cellBorder" style="width: 80px;">Jumlah</th>
        </tr>
        <tr style="background-color: #A3CCD8; font-weight: bold; text-align: center">
            <th class="cellBorder" style="width: 70px;">Pusat</th>
            <th class="cellBorder" style="width: 70px;">Provinsi</th>
            <th class="cellBorder" style="width: 70px;">Kab/Kota</th>
            <th class="cellBorder" style="width: 70px;">Infak Jum'at</th>
            <th class="cellBorder" style="width: 70px;">Infak Raport</th>
            <th class="cellBorder" style="width: 70px;">Sumbahangan Suka Rela</th>
            <th class="cellBorder" style="width: 70px;">Tinggalan Kelas VI</th>
            <th class="cellBorder" style="width: 70px;">BSM</th>
            <th class="cellBorder" style="width: 70px;">Ruko</th>
            <th class="cellBorder" style="width: 70px;">Dudi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $danaLain = 0;
        $danaTotal = 0;
        $danaBosPusat = 0;
        $danaBosProvinsi = 0;
        $danaBosKota = 0;
        $danaInfakJumat = 0;
        $danaInfakRaport = 0;
        $danaSukaRela = 0;
        $danaTinggalanKelas = 0;
        $danaBsm = 0;
        $danaRuko = 0;
        $danaDudi = 0;
        if (!empty($dataDetail)) {
            $i = 0;
            $no = 0;
            while ($i < count($dataDetail)) {
                $no++;
                $danaLain += intval($dataDetail[$i]['DANA_LAIN']);
                $danaTotal += intval($dataDetail[$i]['TOTAL_DANA']);
                $danaBosPusat += intval($dataDetail[$i]['DANA_BOS_PUSAT']);
                $danaBosProvinsi += intval($dataDetail[$i]['DANA_BOS_PROVINSI']);
                $danaBosKota += intval($dataDetail[$i]['DANA_BOS_KOTA']);
                $danaInfakJumat += intval($dataDetail[$i]['DANA_INFAK_JUMAT']);
                $danaInfakRaport += intval($dataDetail[$i]['DANA_INFAK_RAPORT']);
                $danaSukaRela += intval($dataDetail[$i]['DANA_SUKA_RELA']);
                $danaTinggalanKelas += intval($dataDetail[$i]['DANA_TINGGALAN_KELAS']);
                $danaBsm += intval($dataDetail[$i]['DANA_BSM']);
                $danaRuko += intval($dataDetail[$i]['DANA_RUKO']);
                $danaDudi += intval($dataDetail[$i]['DANA_DUDI']);
                $strRow = '';
                $strRow .= '<tr>';
                $strRow .= '<td class="cellBorder" style="text-align: center; width: 30px;">' . $no . '</td>';
                $strRow .= '<td class="cellBorder" style="width: 70px;">' . $dataDetail[$i]['NO_KODE'] . '</td>';
                $strRow .= '<td class="cellBorder" style="width: 170px;">' . $dataDetail[$i]['URAIAN'] . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['DANA_BOS_PUSAT'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['DANA_BOS_PROVINSI'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['DANA_BOS_KOTA'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['DANA_INFAK_JUMAT'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['DANA_INFAK_RAPORT'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['DANA_SUKA_RELA'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['DANA_TINGGALAN_KELAS'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['DANA_BSM'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['DANA_RUKO'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['DANA_DUDI'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['DANA_LAIN'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 80px;">' . number_format($dataDetail[$i]['TOTAL_DANA'], 2) . '</td>';
                $strRow .= '</tr>';
                echo $strRow;
                $i++;
            }
        }
        $strRow = '';
        $strRow .= '<tr style="font-weight: bold;">';
        $strRow .= '<td colspan="3" class="cellBorder" style="text-align: right; width: 270px;">TOTAL</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($danaBosPusat, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($danaBosProvinsi, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($danaBosKota, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($danaInfakJumat, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($danaInfakRaport, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($danaSukaRela, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($danaTinggalanKelas, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($danaBsm, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($danaRuko, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($danaDudi, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($danaLain, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right; width: 80px;">' . number_format($danaTotal, 2) . '</td>';
        $strRow .= '</tr>';
        echo $strRow;
        ?>
    </tbody>
</table>  

<br/>
<br/>
<table border="0" cellpadding="2">
    <tbody>
        <tr>
            <td style="text-align: right"><?php echo 'Imogiri,' . date('d M Y'); ?></td>
        </tr>
        <tr style="text-align: center">
            <td style="width: 5%"></td>
            <td style="width: 20%">
                &nbsp;<br/>
                Komite Sekolah
                <br/>
                <br/>
                <br/>
                <br/>
                <?php echo!empty($dataCetak['NAMA_KOMITE']) ? $dataCetak['NAMA_KOMITE'] : '(.......................................................)'; ?>
                <br/>
            </td>
            <td style="width: 20%"></td>
            <td style="width: 20%">
                Mengetahui<br/>
                Kepala Sekolah
                <br/>
                <br/>
                <br/>
                <br/>
                <?php echo!empty($dataCetak['NAMA_KETUA']) ? $dataCetak['NAMA_KETUA'] : '(.......................................................)'; ?>
                <br/>
                <?php echo!empty($dataCetak['NIP_KETUA']) ? $dataCetak['NIP_KETUA'] : ''; ?>
            </td>
            <td style="width: 10%"></td>
            <td style="width: 20%">
                &nbsp;<br/>
                Bendahara
                <br/>
                <br/>
                <br/>
                <br/>
                <?php echo!empty($dataCetak['NAMA_BENDAHARA']) ? $dataCetak['NAMA_BENDAHARA'] : '(.......................................................)'; ?>
                <br/>
                <?php echo!empty($dataCetak['NIP_BENDAHARA']) ? $dataCetak['NIP_BENDAHARA'] : ''; ?>
            </td>
            <td style="width: 5%"></td>
        </tr>
    </tbody>
</table>
<?php
$content = ob_get_contents();
ob_end_clean();
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);
// ---------------------------------------------------------   
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Realisasi_penggunaan_dana.pdf', 'I');
?>
