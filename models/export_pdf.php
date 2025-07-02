<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';
use Dompdf\Dompdf;

$kw   = $_GET['keyword'] ?? '';
$esc  = $conn->real_escape_string($kw);
// Query sama seperti di AJAX, tapi untuk PDF
$sql = "
  SELECT k.id, k.nama, k.kelamin, k.tanggal_lahir,
         k.email, k.telephone,
         g.pokok, g.lembur, g.pajak, g.asuransi,
         (g.pokok + g.lembur - g.pajak - g.asuransi) AS total
  FROM karyawan k
  LEFT JOIN gaji g ON k.gaji = g.id
  WHERE k.nama LIKE '%{$esc}%'
     OR k.email LIKE '%{$esc}%'
";
$res  = $conn->query($sql);

// Bangun HTML
$html = '<h3>Laporan Karyawan</h3>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
$html .= '<thead><tr>
            <th>ID</th><th>Nama</th><th>Kelamin</th>
            <th>Tgl Lahir</th><th>Email</th><th>Telepon</th>
            <th>Pokok</th><th>Lembur</th><th>Pajak</th>
            <th>Asuransi</th><th>Total</th>
          </tr></thead><tbody>';
while ($r = $res->fetch_assoc()) {
    $html .= '<tr>
        <td>'.$r['id'].'</td>
        <td>'.htmlspecialchars($r['nama']).'</td>
        <td>'.htmlspecialchars($r['kelamin']).'</td>
        <td>'.$r['tanggal_lahir'].'</td>
        <td>'.htmlspecialchars($r['email']).'</td>
        <td>'.htmlspecialchars($r['telephone']).'</td>
        <td>'.number_format($r['pokok'],2,',','.').'</td>
        <td>'.number_format($r['lembur'],2,',','.').'</td>
        <td>'.number_format($r['pajak'],2,',','.').'</td>
        <td>'.number_format($r['asuransi'],2,',','.').'</td>
        <td>'.number_format($r['total'],2,',','.').'</td>
    </tr>';
}
$html .= '</tbody></table>';

// Render PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('laporan_karyawan_'.date('Ymd_His').'.pdf');
