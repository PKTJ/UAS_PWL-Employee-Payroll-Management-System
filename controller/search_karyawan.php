<?php
require __DIR__ . '/../config.php';
$kw = $conn->real_escape_string($_GET['keyword'] ?? '');
$sql = "
  SELECT k.id, k.nama, k.kelamin, k.tanggal_lahir,
         k.email, k.telephone,
         g.pokok, g.lembur, g.pajak, g.asuransi,
         (g.pokok + g.lembur - g.pajak - g.asuransi) AS total
  FROM karyawan k
  LEFT JOIN gaji g ON k.gaji = g.id
  WHERE k.nama LIKE '%{$kw}%'
     OR k.email LIKE '%{$kw}%'
";
$res = $conn->query($sql);
$out = [];
while ($r = $res->fetch_assoc()) {
    $out[] = $r;
}
header('Content-Type: application/json');
echo json_encode($out);
