<?php
include 'db_connect.php';

// Truy vấn để lấy danh sách các môn học và mã thời khóa biểu tương ứng
$sql_subjects = "SELECT tkb.Matkb, mh.Mamh, mh.Tenmh
                 FROM thoikhoabieu tkb
                 JOIN lop l ON tkb.Malop = l.Malop
                 JOIN monhoc mh ON l.Mamh = mh.Mamh";
$stmt_subjects = $conn->query($sql_subjects);
$subjects = $stmt_subjects->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách môn học</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
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
        .btn {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function redirectToDiemDanh(matkb) {
            window.location.href = "diemdanh.php?matkb=" + encodeURIComponent(matkb);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Danh sách môn học</h2>
        <table>
            <thead>
                <tr>
                    <th>Mã môn học</th>
                    <th>Tên môn học</th>
                    <th>Mã thời khóa biểu</th>
                    <th>Điểm danh</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($subject['Mamh']); ?></td>
                        <td><?php echo htmlspecialchars($subject['Tenmh']); ?></td>
                        <td><?php echo htmlspecialchars($subject['Matkb']); ?></td>
                        <td>
                            <button class="btn" onclick="redirectToDiemDanh('<?php echo htmlspecialchars($subject['Matkb']); ?>')">Điểm danh</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
