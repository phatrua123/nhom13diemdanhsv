<?php
include 'db_connect.php';

// Lấy danh sách môn học
$sql = "SELECT DISTINCT Tenmh, Mamh FROM monhoc";
$stmt = $conn->query($sql);
$monhocs = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra nếu người dùng đã chọn một môn học và ngày
    if (isset($_POST['mamh']) && isset($_POST['ngaydiemdanh'])) {
        $mamh = $_POST['mamh'];
        $ngaydiemdanh = $_POST['ngaydiemdanh'];

        // Lấy danh sách sinh viên đã điểm danh theo môn học và ngày
        $sql_diemdanh = "SELECT DISTINCT sv.Masv, sv.Hotensv, mh.Tenmh, dd.ngaydiemdanh, dd.comat, dd.vang
                         FROM diemdanh dd
                         JOIN sinhvien sv ON dd.Masv = sv.Masv
                         JOIN thoikhoabieu tkb ON dd.Matkb = tkb.Matkb
                         JOIN lop l ON tkb.Malop = l.Malop
                         JOIN monhoc mh ON l.Mamh = mh.Mamh
                         WHERE l.Mamh = :mamh AND dd.ngaydiemdanh = :ngaydiemdanh";
        $stmt_diemdanh = $conn->prepare($sql_diemdanh);
        $stmt_diemdanh->bindParam(':mamh', $mamh);
        $stmt_diemdanh->bindParam(':ngaydiemdanh', $ngaydiemdanh);
        $stmt_diemdanh->execute();
        $diemdanh_sinhvien = $stmt_diemdanh->fetchAll(PDO::FETCH_ASSOC);

        // Kiểm tra nếu yêu cầu là AJAX
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // Nếu là yêu cầu AJAX, chỉ xuất ra bảng kết quả
            if (!empty($diemdanh_sinhvien)) {
                echo '<table>';
                echo '<thead><tr><th>Mã sinh viên</th><th>Họ và tên</th><th>Môn học</th><th>Ngày điểm danh</th><th>Trạng thái có mặt</th><th>Trạng thái vắng mặt</th></tr></thead><tbody>';
                foreach ($diemdanh_sinhvien as $sinhvien) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($sinhvien['Masv']) . '</td>';
                    echo '<td>' . htmlspecialchars($sinhvien['Hotensv']) . '</td>';
                    echo '<td>' . htmlspecialchars($sinhvien['Tenmh']) . '</td>';
                    echo '<td>' . htmlspecialchars($sinhvien['ngaydiemdanh']) . '</td>';
                    echo '<td>' . htmlspecialchars($sinhvien['comat']) . '</td>';
                    echo '<td>' . htmlspecialchars($sinhvien['vang']) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p>Không có dữ liệu điểm danh cho môn học và ngày này.</p>';
            }
            exit; // Kết thúc script để ngăn chặn việc xuất ra HTML bên dưới
        }
    } else {
        echo '<p>Vui lòng chọn môn học và ngày điểm danh.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <title>Tra cứu điểm danh sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        select, input[type="text"], button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        #result {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tra cứu điểm danh sinh viên</h1>
        <form id="diemdanhForm">
            <label for="mamh">Chọn môn học:</label>
            <select id="mamh" name="mamh">
                <?php foreach ($monhocs as $monhoc): ?>
                    <option value="<?php echo htmlspecialchars($monhoc['Mamh']); ?>"><?php echo htmlspecialchars($monhoc['Tenmh']); ?></option>
                <?php endforeach; ?>
            </select>
            <label for="ngaydiemdanh">Chọn ngày điểm danh:</label>
            <input type="text" id="ngaydiemdanh" name="ngaydiemdanh">
            <button type="submit">Tra cứu</button>
        </form>
        <div id="result"></div>
    </div>

    <script>
        $(function() {
            $("#ngaydiemdanh").datepicker({
                dateFormat: "yy-mm-dd"
            });

            $("#diemdanhForm").submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $("#result").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });
            });
        });
    </script>
</body>
</html>
