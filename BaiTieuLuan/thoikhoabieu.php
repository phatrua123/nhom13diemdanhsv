<?php
include 'db_connect.php';

$matkb = isset($_GET['matkb']) ? $_GET['matkb'] : '';

$sql = "SELECT * FROM thoikhoabieu WHERE matkb = :matkb";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':matkb', $matkb);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo "Không tìm thấy thông tin thời khóa biểu.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin thời khóa biểu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            width: 60%;
            margin: auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            margin-top: 0;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thông tin thời khóa biểu</h2>
        <div class="info">
            <p><strong>Mã thời khóa biểu:</strong> <?php echo $result['matkb']; ?></p>
            <p><strong>Mã lớp:</strong> <?php echo $result['Malop']; ?></p>
            <p><strong>Ngày bắt đầu:</strong> <?php echo $result['ngaybatdau']; ?></p>
            <p><strong>Ngày kết thúc:</strong> <?php echo $result['ngayketthuc']; ?></p>
        </div>
        <!-- Thêm các thông tin khác cần thiết từ cơ sở dữ liệu nếu có -->
    </div>
</body>
</html>

<?php
$conn = null; // Đóng kết nối
?>
