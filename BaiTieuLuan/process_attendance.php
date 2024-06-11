<?php
include 'db_connect.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['masv'])) {
    $masv = $data['masv'];
    $ngaydiemdanh = date('Y-m-d');

    // Giả định `matkb` là mã thời khóa biểu cần điểm danh
    $matkb = 1; // Thay đổi tùy vào logic thực tế của bạn

    $sql = "INSERT INTO diemdanh (matkb, ngaydiemdanh, comat, vang, ghichu, Masv)
            VALUES (:matkb, :ngaydiemdanh, 'P', 'P', '', :masv)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':matkb', $matkb);
    $stmt->bindParam(':ngaydiemdanh', $ngaydiemdanh);
    $stmt->bindParam(':masv', $masv);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Điểm danh thành công cho sinh viên: ' . $masv]);
    } else {
        echo json_encode(['message' => 'Lỗi khi điểm danh sinh viên: ' . $masv]);
    }
} else {
    echo json_encode(['message' => 'Dữ liệu không hợp lệ']);
}
?>
