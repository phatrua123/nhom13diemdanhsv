<?php
include 'db_connect.php';

try {
    // Truy vấn để lấy dữ liệu số buổi có mặt và vắng mặt theo từng môn và từng sinh viên
    $sql = "
        SELECT mh.Tenmh, sv.Hotensv,
               SUM(CASE WHEN dd.comat = 'C' THEN 1 ELSE 0 END) as soComat,
               SUM(CASE WHEN dd.vang = 'V' THEN 1 ELSE 0 END) as soVang
        FROM diemdanh dd
        JOIN sinhvien sv ON dd.Masv = sv.Masv
        JOIN thoikhoabieu tkb ON dd.matkb = tkb.matkb
        JOIN lop l ON tkb.Malop = l.Malop
        JOIN monhoc mh ON l.Mamh = mh.Mamh
        GROUP BY mh.Tenmh, sv.Hotensv
        ORDER BY mh.Tenmh, sv.Hotensv
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}

// Đóng kết nối
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách số buổi có mặt và vắng mặt của sinh viên theo môn học</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
    <div class="container">
        <h2>Danh sách số buổi có mặt và vắng mặt của sinh viên theo môn học</h2>
        <select id="subjectSelect">
            <option value="">Chọn môn học</option>
            <?php
            include 'db_connect.php';

            try {
                // Truy vấn để lấy danh sách các môn học từ cơ sở dữ liệu
                $sql = "SELECT * FROM monhoc";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Hiển thị các môn học trong combobox
                foreach ($subjects as $subject) {
                    echo "<option value='" . htmlspecialchars($subject['Tenmh']) . "'>" . htmlspecialchars($subject['Tenmh']) . "</option>";
                }
            } catch (PDOException $e) {
                echo "Lỗi: " . $e->getMessage();
            }

            // Đóng kết nối
            $conn = null;
            ?>
        </select>
        <table id="attendanceTable" class="display">
            <thead>
                <tr>
                    <th>Môn học</th>
                    <th>Sinh viên</th>
                    <th>Số buổi có mặt</th>
                    <th>Số buổi vắng mặt</th>
                    <th>% Buổi có mặt</th>
                    <th>% Buổi vắng mặt</th>
                </tr>
            </thead>
            <tbody>
                <!-- Các dòng sẽ được thêm thông qua AJAX -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#subjectSelect').change(function() {
                var selectedSubject = $(this).val();
                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: { subject: selectedSubject },
                    success: function(response) {
                        $('#attendanceTable tbody').html(response);
                        $('#attendanceTable').DataTable();
                    }
                });
            });
        });
    </script>
</body>
</html>

