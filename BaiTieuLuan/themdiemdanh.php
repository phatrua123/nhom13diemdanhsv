<?php
// Kết nối vào cơ sở dữ liệu
include 'db_connect.php';

// Lấy danh sách các môn học từ cơ sở dữ liệu
$sql = "SELECT DISTINCT Tenmh FROM monhoc";
$stmt = $conn->query($sql);
$monhocs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Khởi tạo biến để lưu thông báo
$message = '';

// Xử lý khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy tên môn học được chọn từ form
    $selected_monhoc = $_POST['tenmh'];

    // Lấy MaLop từ bảng lop dựa vào Tenmh
    $sql_malop = "SELECT Malop FROM lop WHERE Mamh = (SELECT Mamh FROM monhoc WHERE Tenmh = :tenmh)";
    $stmt_malop = $conn->prepare($sql_malop);
    $stmt_malop->bindParam(':tenmh', $selected_monhoc);
    $stmt_malop->execute();
    $malop = $stmt_malop->fetchColumn();

    // Thêm dữ liệu điểm danh cho sinh viên trong môn học có MaLop tương ứng
    $sql_insert = "INSERT INTO diemdanh (matkb, ngaydiemdanh, diemdanh1, diemdanh2, ghichu, Masv)
                   SELECT tkb.matkb, :ngaydiemdanh, 'P', 'P', 'Buổi học mới', sv.Masv
                   FROM thoikhoabieu tkb
                   JOIN thanhvienlop tvl ON tkb.Malop = tvl.Malop
                   JOIN sinhvien sv ON tvl.Masv = sv.Masv
                   WHERE tkb.Malop = :malop";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bindParam(':ngaydiemdanh', date('Y-m-d')); // Lấy ngày hiện tại
    $stmt_insert->bindParam(':malop', $malop);
    if ($stmt_insert->execute()) {
        $message = "Đã thêm dữ liệu điểm danh thành công cho môn học $selected_monhoc.";
    } else {
        $message = "Có lỗi xảy ra khi thêm dữ liệu điểm danh.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm điểm danh</title>
</head>
<body>
    <h2>Thêm điểm danh</h2>
    <form method="post">
        <label for="tenmh">Chọn môn học:</label>
        <select name="tenmh" id="tenmh">
            <?php foreach ($monhocs as $monhoc) : ?>
                <option value="<?php echo htmlspecialchars($monhoc['Tenmh']); ?>"><?php echo htmlspecialchars($monhoc['Tenmh']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Thêm điểm danh</button>
    </form>
    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>
