<?php
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('Laporan Buku Pembantu Pajak');
$pdf->SetSubject('Laporan Buku Pembantu Pajak');
$pdf->SetKeywords('Laporan Buku Pembantu Pajak');
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
            <td colspan="6" style="text-align: center"><h4><?php echo!empty($dataCetak['TITLE']) ? $dataCetak['TITLE'] : ''; ?></h4></td>
        </tr>
        <tr>
            <td colspan="1">Nama Sekolah</td>
            <td colspan="5">: <?php echo!empty($dataCetak['NAMA_SEKOLAH']) ? $dataCetak['NAMA_SEKOLAH'] : ''; ?></td>
        </tr>
        <tr>
            <td colspan="1">Desa/kelurahan</td>
            <td colspan="5">: <?php
echo!empty($dataCetak['KELURAHAN']) ? $dataCetak['KELURAHAN'] : '';
echo ' / ';
echo!empty($dataCetak['KECAMATAN']) ? $dataCetak['KECAMATAN'] : '';
?>
            </td>
        </tr>
        <tr>
            <td colspan="1">Kabupaten</td>
            <td colspan="5">: <?php echo!empty($dataCetak['KABUPATEN']) ? $dataCetak['KABUPATEN'] : ''; ?></td>
        </tr>
        <tr>
            <td colspan="1">Propinsi</td>
            <td colspan="5">: <?php echo!empty($dataCetak['PROVINSI']) ? $dataCetak['PROVINSI'] : ''; ?></td>
        </tr>
        <tr style="background-color: #A3CCD8; font-weight: bold; text-align: center">
            <th class="cellBorder" rowspan="2" style="width: 30px;">No</th>
            <th class="cellBorder" rowspan="2" style="width: 80px;">Tanggal</th>
            <th class="cellBorder" rowspan="2" style="width: 200px;">Uraian</th>
            <th class="cellBorder" colspan="5" style="width: 350px;">Penerimaan(Rp)</th>
            <th class="cellBorder" colspan="5" style="width: 350px;">Penyetoran(Rp)</th>
        </tr>
        <tr style="background-color: #A3CCD8; font-weight: bold; text-align: center">
            <th class="cellBorder" style="width: 70px;">PPn</th>
            <th class="cellBorder" style="width: 70px;">PPh 21</th>
            <th class="cellBorder" style="width: 70px;">PPh 22</th>
            <th class="cellBorder" style="width: 70px;">PPh 23</th>
            <th class="cellBorder" style="width: 70px;">Jumlah</th>
            <th class="cellBorder" style="width: 70px;">PPn</th>
            <th class="cellBorder" style="width: 70px;">PPh 21</th>
            <th class="cellBorder" style="width: 70px;">PPh 22</th>
            <th class="cellBorder" style="width: 70px;">PPh 23</th>
            <th class="cellBorder" style="width: 70px;">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalPenerimaan = 0;
        $totalPengeluaran = 0;
        if (!empty($dataDetail)) {
            $i = 0;
            $no = 0;
            while ($i < count($dataDetail)) {
                $no++;
                $totalPenerimaan += intval($dataDetail[$i]['JUMLAH_PPN21']);
                $totalPengeluaran += intval($dataDetail[$i]['JUMLAH_TOTAL']);
                $strRow = '';
                $strRow .= '<tr>';
                $strRow .= '<td class="cellBorder" style="text-align: center; width: 30px;">' . $no . '</td>';
                $strRow .= '<td class="cellBorder" style="width: 80px;">' . $dataDetail[$i]['TGL'] . '</td>';
                $strRow .= '<td class="cellBorder" style="width: 200px;">' . $dataDetail[$i]['URAIAN'] . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format(0, 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['JUMLAH_PPN21'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format(0, 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format(0, 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['JUMLAH_PPN21'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['JUMLAH_PPN'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['JUMLAH_PPN21'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['JUMLAH_PPN22'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['JUMLAH_PPN23'], 2) . '</td>';
                $strRow .= '<td class="cellBorder" style="text-align: right; width: 70px;">' . number_format($dataDetail[$i]['JUMLAH_TOTAL'], 2) . '</td>';
                $strRow .= '</tr>';
                echo $strRow;
                $i++;
            }
        }
        $strRow = '';
        $strRow .= '<tr style="background-color: #A3CCD8; font-weight: bold">';
        $strRow .= '<td class="cellBorder" colspan="3" style="text-align: right; width: 310px;">TOTAL</td>';
        $strRow .= '<td class="cellBorder" colspan="5" style="text-align: right; width: 350px;">' . number_format($totalPenerimaan, 2) . '</td>';
        $strRow .= '<td class="cellBorder" colspan="5" style="text-align: right; width: 350px;">' . number_format($totalPengeluaran, 2) . '</td>';
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
$pdf->Output('Laporan_buku_pembantu_pajak.pdf', 'I');
?>
