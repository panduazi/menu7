<?php
include('../../config/koneksi.php');
$q = isset($_GET['q']) ? $koneksi->real_escape_string($_GET['q']) : '';
$sql = "SELECT * FROM tblCity";
if (!empty($q)) {
    $sql .= " WHERE CityName='$q'";
}
$sql .= " ORDER BY CityName";
$rs = $koneksi->query($sql);
if ($rs === false) {
    echo 'Query error: ' . htmlspecialchars($koneksi->error);
    exit;
}
$result = array();
while ($data = $rs->fetch_object()) {
    $result[] = array(
        'kode' => $data->CityId,
        'tujuan' => $data->CityName,
        'post_code' => $data->CityCountry
    );
}
echo json_encode($result);
?>
