<?php
include('../../config/koneksi.php');
$q = isset($_GET['q']) ? $koneksi->real_escape_string($_GET['q']) : '';
$sql = "SELECT REC_ID, POST_CODE, CONCAT_WS('-', upper(KOTA), KECAMATAN) AS TUJUAN 
        FROM tblCityPsb";

if (!empty($q)) {
    $sql .= " WHERE KOTA='$q'";
}
$sql .= " GROUP BY KOTA,KECAMATAN";
$rs = $koneksi->query($sql);
if ($rs === false) {
    echo 'Query error: ' . htmlspecialchars($koneksi->error);
    exit;
}

$result = array();
while ($data = $rs->fetch_object()) {
    $result[] = array(
        'kode' => $data->REC_ID,
        'tujuan' => $data->TUJUAN,
        'post_code' => $data->POST_CODE
    );
}
echo json_encode($result);
?>
