<?php
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('Laporan Bos K1');
$pdf->SetSubject('Laporan Bos K1');
$pdf->SetKeywords('Laporan Bos K1');
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
$pdf->SetFont('times', '', 11, '', 'false');
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('L', 'A4');
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
            <td colspan="7" style="text-align: center"><h4><?php echo!empty($dataCetak['TITLE']) ? $dataCetak['TITLE'] : ''; ?></h4></td>
        </tr>
        <tr>
            <td colspan="2">Nama Sekolah</td>
            <td colspan="5">: <?php echo!empty($dataCetak['NAMA_SEKOLAH']) ? $dataCetak['NAMA_SEKOLAH'] : ''; ?></td>
        </tr>
        <tr>
            <td colspan="2">Desa/kelurahan</td>
            <td colspan="5">: <?php
echo!empty($dataCetak['KELURAHAN']) ? $dataCetak['KELURAHAN'] : '';
echo ' / ';
echo!empty($dataCetak['KECAMATAN']) ? $dataCetak['KECAMATAN'] : '';
?>
            </td>
        </tr>
        <tr>
            <td colspan="2">Kabupaten</td>
            <td colspan="5">: <?php echo!empty($dataCetak['KABUPATEN']) ? $dataCetak['KABUPATEN'] : ''; ?></td>
        </tr>
        <tr>
            <td colspan="2">Propinsi</td>
            <td colspan="5">: <?php echo!empty($dataCetak['PROVINSI']) ? $dataCetak['PROVINSI'] : ''; ?></td>
        </tr>
        <tr style="background-color: #A3CCD8; font-weight: bold; text-align: center">
            <th class="cellBorder">Tanggal</th>
            <th class="cellBorder">No Kode</th>
            <th class="cellBorder">No Bukti</th>
            <th class="cellBorder">Uraian</th>
            <th class="cellBorder">Penerimaan (Rp)</th>
            <th class="cellBorder">Pengeluaran (Rp)</th>
            <th class="cellBorder">Saldo (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalPenerimaan = 0;
        $totalPengeluaran = 0;
        $saldo = 0;
        if (!empty($dataDetail)) {
            $i = 0;
            while ($i < count($dataDetail)) {
                $no++;
                $totalPenerimaan += intval($dataDetail[$i]['JUMLAH_PENERIMAAN']);
                $totalPengeluaran += intval($dataDetail[$i]['JUMLAH_PENGELUARAN']);
                $saldo = $dataDetail[$i]['JUMLAH_SALDO'];
                $strRow = '';
                $strRow .= '<tr>';
                $strRow .= '<td class="cellBorder">' . $dataDetail[$i]['TGL'] . '</td>';
                $strRow .= '<td class="cellBorder">' . $dataDetail[$i]['NO_BUKTI'] . '</td>';
                $strRow .= '<td class="cellBorder">' . $dataDetail[$i]['NO_KODE'] . '</td>';
                $strRow .= '<td class="cellBorder">' . $dataDetail[$i]['URAIAN'] . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right">' . number_format($dataDetail[$i]['JUMLAH_PENERIMAAN'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right">' . number_format($dataDetail[$i]['JUMLAH_PENGELUARAN'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right">' . number_format($dataDetail[$i]['JUMLAH_SALDO'], 2) . '</td>';
                $strRow .= '</tr>';
                echo $strRow;
                $i++;
            }
        }
        $strRow = '';
        $strRow .= '<tr style="background-color: #A3CCD8; font-weight: bold">';
        $strRow .= '<td class="cellBorder" colspan="4" style="text-align: right">TOTAL</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right">' . number_format($totalPenerimaan, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right">' . number_format($totalPengeluaran, 2) . '</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right">' . number_format($saldo, 2) . '</td>';
        $strRow .= '</tr>';
        echo $strRow;
        ?>
    </tbody>
</table>
<br/>
<br/>
<table border="0" cellpadding="2">
    <tbody>
        <tr style="text-align: center">
            <td style="width: 10%"></td>
            <td style="width: 30%">
                Mengetahui
                <br/>
                <br/>
                <br/>
                <br/>
                <?php echo!empty($dataCetak['NAMA_KETUA']) ? $dataCetak['NAMA_KETUA'] : '(.......................................................)'; ?>
                <br/>
                <?php echo!empty($dataCetak['NIP_KETUA']) ? $dataCetak['NIP_KETUA'] : ''; ?>
            </td>
            <td style="width: 20%"></td>
            <td style="width: 30%">
                 Bendahara
                <br/>
                <br/>
                <br/>
                <br/>
                <?php echo!empty($dataCetak['NAMA_BENDAHARA']) ? $dataCetak['NAMA_BENDAHARA'] : '(.......................................................)'; ?>
                <br/>
                <?php echo!empty($dataCetak['NIP_BENDAHARA']) ? $dataCetak['NIP_BENDAHARA'] : ''; ?>
            </td>
            <td style="width: 10%"></td>
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
$pdf->Output('Laporan_Bos_K1.pdf', 'I');
?>
