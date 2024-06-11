<?php
include 'db_connect.php';

// Initialize search parameters
$masv = isset($_GET['masv']) ? $_GET['masv'] : '';
$ten = isset($_GET['ten']) ? $_GET['ten'] : '';

$masvParam = "%$masv%";
$tenParam = "%$ten%";

// Prepare SQL query based on search parameters
if (empty($masv) && empty($ten)) {
    $sql = "SELECT * FROM sinhvien";
    $stm = $conn->prepare($sql);
    $stm->execute();
} else {
    $sql = "SELECT * FROM sinhvien WHERE Masv LIKE ? AND Hotensv LIKE ?";
    $stm = $conn->prepare($sql);
    $stm->execute([$masvParam, $tenParam]);
}

// Check if any data is returned
if ($stm->rowCount() > 0) {
    // If data exists, assign it to $data
    $data = $stm->fetchAll(PDO::FETCH_OBJ);
} else {
    // If no data, assign an empty array to $data
    $data = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 2px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .student-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        .student-table th,
        .student-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .student-table th {
            background-color: #f2f2f2;
        }
        .student-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .student-table tbody tr:hover {
            background-color: #f2f2f2;
        }
        .button {
            padding: 6px 12px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .button i {
            margin-right: 6px;
        }
        .button.add {
            background-color: #28a745;
        }
        .button.edit {
            background-color: #007bff;
        }
        .button.delete {
            background-color: #dc3545;
        }
        .delete-form {
            display: inline-block;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="ThemSVFR.php" class="button add">
            <i class="fas fa-plus"></i> Thêm mới
        </a>
        <form action="index.php" method="get" class="search-form">
            <input type="hidden" name="page" value="students">
            <label for="masv">Mã SV</label>
            <input type="text" name="masv" id="masv" value="<?php echo htmlspecialchars($masv); ?>">
            <label for="ten">Tên</label>
            <input type="text" name="ten" id="ten" value="<?php echo htmlspecialchars($ten); ?>">
            <input type="submit" value="Tìm">
        </form>

        <table id="SinhVien" class="student-table">
            <thead>
                <tr>
                    <th>Mã SV</th>
                    <th>Họ và Tên</th>
                    <th>Giới Tính</th>
                    <th>Địa Chỉ</th>
                    <th>Ngày Sinh</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item->Masv); ?></td>
                        <td><?php echo htmlspecialchars($item->Hotensv); ?></td>
                        <td><?php echo htmlspecialchars($item->GioiTinh); ?></td>
                        <td><?php echo htmlspecialchars($item->Diachi); ?></td>
                        <td><?php echo htmlspecialchars($item->Ngaysinh); ?></td>
                        <td>
                            <form method="post" action="xoasv.php" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');" class="delete-form">
                                <input type="hidden" name="Masv" value="<?php echo htmlspecialchars($item->Masv); ?>">
                                <button type="submit" class="button delete">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            </form>
                            <a href="suasv.php?id=<?php echo htmlspecialchars($item->Masv); ?>" class="button edit">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
