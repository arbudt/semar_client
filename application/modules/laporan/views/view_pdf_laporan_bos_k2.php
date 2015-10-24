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
            <td colspan="7" style="text-align: center;"><h4><?php echo!empty($dataCetak['TITLE']) ? $dataCetak['TITLE'] : ''; ?></h4></td>
        </tr>
        <tr>
            <td colspan="2" style="">Nama Sekolah</td>
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
        <tr>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr style="background-color: #A3CCD8; font-weight: bold; text-align: center">
            <th class="cellBorder">Tanggal</th>
            <th class="cellBorder">Triwulan</th>
            <th class="cellBorder">Sumber Dana</th>
            <th class="cellBorder">No Urut</th>
            <th class="cellBorder">No Kode</th>
            <th class="cellBorder">Uraian</th>
            <th class="cellBorder">Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalUang = 0;
        if (!empty($dataDetail)) {
            foreach ($dataDetail as $row) {
                $no++;
                $totalUang += intval($row->HARGA);
                $strRow = '';
                $strRow .= '<tr>';
                $strRow .= '<td class="cellBorder">' . $row->TGL . '</td>';
                $strRow .= '<td class="cellBorder">' . $row->NAMA_TRIWULAN . '</td>';
                $strRow .= '<td class="cellBorder">' . $row->NAMA_SUMBER_DANA . '</td>';
                $strRow .= '<td class="cellBorder">' . $row->NO_URUT . '</td>';
                $strRow .= '<td class="cellBorder">' . $row->NO_KODE . '</td>';
                $strRow .= '<td class="cellBorder">' . $row->URAIAN . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right">' . number_format($row->HARGA, 2) . '</td>';
                $strRow .= '</tr>';
                echo $strRow;
            }
        }
        $strRow = '';
        $strRow .= '<tr style="background-color: #A3CCD8; font-weight: bold">';
        $strRow .= '<td class="cellBorder" colspan="6" style="text-align: right">TOTAL</td>';
        $strRow .= '<td class="cellBorder" style="text-align: right">' . number_format($totalUang, 2) . '</td>';
        $strRow .= '</tr>';
        echo $strRow;
        ?>
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
