<?php
include('../../config/koneksi.php');

// Get the raw POST data
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Escape the values to prevent SQL injection
$escapeData = [];
foreach ($data as $key => $value) {
    $escapeData[$key] = mysqli_real_escape_string($koneksi, $value);
}

// Check if the ConnoteNo already exists
$checkSql = "SELECT COUNT(*) FROM tblConnote_odisys WHERE ConnoteNo = '{$escapeData['ConnoteNo']}'";
$result = mysqli_query($koneksi, $checkSql);
$row = mysqli_fetch_array($result);

if ($row[0] > 0) {
    // ConnoteNo already exists
    echo json_encode(["error" => true, "message" => "ConnoteNo already exists"]);
} else {
    // Construct the SQL query
    $sql = "INSERT INTO tblConnote_odisys (
        ConnoteNo, ConnoteDate, ConnoteOrig, ConnoteDest,ConnoteDestFirst, ConnoteCustNo, ConnoteCustAddr1,
        ConnoteCustName, ConnoteRecvName, ConnoteRecvAddr1, ConnoteRecvReff, ConnoteContents,
        ConnoteType, ConnoteService, ConnoteQty, ConnoteWeight, ConnoteBillAmount, ConnoteBillDisc,
        ConnoteBillPack, ConnoteBillInsurance, ConnoteBillOther, ConnoteBillTax, ConnoteCost,
        ConnoteCost1, ConnoteCost2, ConnoteCost3, ConnoteCourierPickup, ConnoteCourierDeli,
        ConnoteCreateBy, ConnoteModiBy
    ) VALUES (
        '{$escapeData['ConnoteNo']}', '{$escapeData['ConnoteDate']}', '{$escapeData['ConnoteOrig']}',
        '{$escapeData['ConnoteDest']}',  '{$escapeData['ConnoteDest']}','{$escapeData['ConnoteCustNo']}', '{$escapeData['ConnoteCustAddr']}',
        '{$escapeData['ConnoteCustName']}', '{$escapeData['ConnoteRecvName']}', '{$escapeData['ConnoteRecvAddr']}',
        '{$escapeData['ConnoteRecvReff']}', '{$escapeData['ConnoteContents']}', '{$escapeData['ConnoteType']}',
        '{$escapeData['ConnoteService']}', '{$escapeData['ConnoteQty']}', '{$escapeData['ConnoteWeight']}',
        '{$escapeData['ConnoteBillAmount']}', '{$escapeData['ConnoteBillDisc']}', '{$escapeData['ConnoteBillPack']}',
        '{$escapeData['ConnoteBillInsurance']}', '{$escapeData['ConnoteBillOther']}', '{$escapeData['ConnoteBillTax']}',
        '{$escapeData['ConnoteCost0']}', '{$escapeData['ConnoteCost1']}', '{$escapeData['ConnoteCost2']}', '{$escapeData['ConnoteCost3']}',
        '{$escapeData['ConnoteCourierPickup']}', '{$escapeData['ConnoteCourierDeli']}', '{$escapeData['CreateBy']}',
        '{$escapeData['ModiBy']}'
    )";

    // Execute the query
    if (mysqli_query($koneksi, $sql)) {
        echo json_encode(["error" => false, "message" => "Data inserted successfully"]);
    } else {
        echo json_encode(["error" => true, "message" => "Error: " . mysqli_error($koneksi)]);
    }
}

// Close the connection
mysqli_close($koneksi);
?>