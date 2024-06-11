<?php
// Bao gồm kết nối cơ sở dữ liệu
include 'db_connect.php';

// Kiểm tra xem có tham số matkb trên URL không
if (!isset($_GET['matkb'])) {
    echo "Thiếu thông tin matkb.";
    exit();
}

$matkb = $_GET['matkb'];

// Truy vấn để lấy thông tin sinh viên của môn học có matkb tương ứng
$sql_students = "SELECT sv.Masv, sv.Hotensv 
                 FROM sinhvien sv
                 JOIN thanhvienlop tvl ON sv.Masv = tvl.Masv
                 JOIN thoikhoabieu tkb ON tvl.Malop = tkb.Malop
                 WHERE tkb.matkb = :matkb";
$stmt_students = $conn->prepare($sql_students);
$stmt_students->bindParam(':matkb', $matkb);
$stmt_students->execute();
$students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

// Xử lý dữ liệu khi submit form điểm danh
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ngaydiemdanh'])) {
    $ngaydiemdanh = $_POST['ngaydiemdanh'];
    foreach ($students as $student) {
        $masv = $student['Masv'];
        if (isset($_POST[$masv])) {
            // Kiểm tra xem sinh viên đã được điểm danh trong ngày chưa
            $sql_check = "SELECT * FROM diemdanh WHERE Masv = :masv AND ngaydiemdanh = :ngaydiemdanh";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bindParam(':masv', $masv);
            $stmt_check->bindParam(':ngaydiemdanh', $ngaydiemdanh);
            $stmt_check->execute();
            $result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if (!$result_check) {
                $diemdanh = $_POST[$masv];
                // Thực hiện câu lệnh SQL để cập nhật điểm danh
                $sql_insert = "INSERT INTO diemdanh (matkb, ngaydiemdanh, comat, vang, Masv)
                               VALUES (:matkb, :ngaydiemdanh, :comat, :vang, :masv)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bindParam(':matkb', $matkb);
                $stmt_insert->bindParam(':ngaydiemdanh', $ngaydiemdanh);

                if ($diemdanh == 'C') {
                    $stmt_insert->bindValue(':comat', 'C');
                    $stmt_insert->bindValue(':vang', '');
                } elseif ($diemdanh == 'V') {
                    $stmt_insert->bindValue(':comat', '');
                    $stmt_insert->bindValue(':vang', 'V');
                } else {
                    $stmt_insert->bindValue(':comat', '');
                    $stmt_insert->bindValue(':vang', '');
                }

                $stmt_insert->bindParam(':masv', $masv);
                $stmt_insert->execute();
            } else {
                echo "Sinh viên có Mã SV " . $masv . " đã điểm danh trong ngày hôm nay.";
                exit();
            }
        }
    }
    echo "Đã điểm danh thành công.";
}

// Xử lý khi nhấn nút "Điểm danh khuôn mặt"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['diemdanh_khuonmat'])) {
    $script_dir = 'C:\\Users\\acer\\Documents\\ltmnm\\doannhom\\BaiTieuLuan\\BaiTieuLuan';
    $python_path = 'C:\\Users\\acer\\AppData\\Local\\Programs\\Python\\Python312\\python.exe';

    $command = escapeshellcmd("$python_path $script_dir\\03_face_recognition.py");
    exec($command, $output, $return_var);

    if ($return_var != 0) {
        echo "Có lỗi xảy ra khi chạy tập lệnh Python.";
        exit();
    } else {
        // Xử lý kết quả nhận diện khuôn mặt và thực hiện điểm danh tự động
        echo "<script>
            var recognizedNames = " . json_encode($output) . ";
            document.addEventListener('DOMContentLoaded', function() {
                recognizedNames.forEach(function(name) {
                    if (name === 'Phat') {
                        document.querySelector('input[name=\"R001\"][value=\"C\"]').checked = true;
                    } else if (name === 'Nhan') {
                        document.querySelector('input[name=\"R002\"][value=\"C\"]').checked = true;
                    }
                });
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Điểm danh</title>
</head>
<body>
    <h1>Điểm danh lớp học</h1>

    <form method="post" action="">
        <label for="ngaydiemdanh">Ngày điểm danh:</label>
        <input type="date" id="ngaydiemdanh" name="ngaydiemdanh" required><br><br>

        <table border="1">
            <tr>
                <th>Mã SV</th>
                <th>Họ tên</th>
                <th>Có mặt</th>
                <th>Vắng</th>
            </tr>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?php echo htmlspecialchars($student['Masv']); ?></td>
                <td><?php echo htmlspecialchars($student['Hotensv']); ?></td>
                <td><input type="radio" name="<?php echo $student['Masv']; ?>" value="C" <?php echo (isset($_POST[$student['Masv']]) && $_POST[$student['Masv']] == 'C') ? 'checked' : ''; ?>></td>
                <td><input type="radio" name="<?php echo $student['Masv']; ?>" value="V" <?php echo (isset($_POST[$student['Masv']]) && $_POST[$student['Masv']] == 'V') ? 'checked' : ''; ?>></td>
            </tr>
            <?php endforeach; ?>
        </table><br>

        <input type="submit" value="Điểm danh">
    </form>

    <form method="post" action="">
        <input type="hidden" name="diemdanh_khuonmat" value="1">
        <button type="submit">Điểm danh khuôn mặt</button>
    </form>
</body>
</html>
