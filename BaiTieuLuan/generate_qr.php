<?php
// Kết nối đến cơ sở dữ liệu
include 'db_connect.php';

// Tải thư viện tạo mã QR
require 'vendor/autoload.php';
use Endroid\QrCode\QrCode;

// Lấy danh sách sinh viên từ cơ sở dữ liệu
$sql = "SELECT Masv FROM sinhvien";
$stmt = $conn->query($sql);
$sinhviens = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Thư mục để lưu các mã QR
$qrCodeDirectory = 'qrcodes/';

// Tạo mã QR cho mỗi sinh viên và lưu vào thư mục
foreach ($sinhviens as $sinhvien) {
    $masv = $sinhvien['Masv'];
    $qrCode = new QrCode($masv);
    
    // Thiết lập kích thước mã QR
    $qrCode->setSize(300);
    
    // Đường dẫn lưu trữ mã QR
    $qrCodePath = $qrCodeDirectory . $masv . '.png';
    
    // Lưu mã QR vào tệp PNG
    $qrCode->writeFile($qrCodePath);
    
    echo "QR code generated for $masv at $qrCodePath<br>";
}

// Đóng kết nối cơ sở dữ liệu
$conn = null;
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        #reader {
            width: 500px;
            margin: auto;
        }
    </style>
</head>
<body>
    <h1>Scan QR Code</h1>
    <div id="reader"></div>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);
            
            // Gửi mã sinh viên lên server để ghi nhận điểm danh
            fetch('process_attendance.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ masv: decodedText })
            }).then(response => response.json())
              .then(data => {
                  alert(data.message);
              })
              .catch(error => {
                  console.error('Error:', error);
              });
        }

        function onScanFailure(error) {
            console.warn(`Code scan error = ${error}`);
        }

        let html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start({ facingMode: "environment" }, {
            fps: 10,
            qrbox: 250
        }, onScanSuccess, onScanFailure);
    </script>
</body>
</html>
