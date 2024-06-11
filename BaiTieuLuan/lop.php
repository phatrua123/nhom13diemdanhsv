<?php
include 'db_connect.php';

// Initialize search parameter
$ten = isset($_GET['ten']) ? $_GET['ten'] : '';
$tenParam = "%$ten%";

// Prepare SQL query based on search parameter
if (empty($ten)) {
    $sql = "SELECT lop.*, thoikhoabieu.matkb, thoikhoabieu.ngaybatdau, thoikhoabieu.ngayketthuc 
            FROM lop
            LEFT JOIN thoikhoabieu ON lop.Malop = thoikhoabieu.Malop";
    $stm = $conn->query($sql);
} else {
    $sql = "SELECT lop.*, thoikhoabieu.matkb, thoikhoabieu.ngaybatdau, thoikhoabieu.ngayketthuc 
            FROM lop
            LEFT JOIN thoikhoabieu ON lop.Malop = thoikhoabieu.Malop
            WHERE lop.TenLop LIKE ?";
    $stm = $conn->prepare($sql);
    $stm->execute([$tenParam]);
}

// Check if any data is returned
if ($stm->rowCount() > 0) {
    $data = $stm->fetchAll(PDO::FETCH_OBJ);
} else {
    $data = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý lớp học</title>
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
        <a href="index.php?page=themlop" class="button add">
            <i class="fas fa-plus"></i> Thêm lớp học
        </a>
        <form action="index.php" method="get" class="search-form">
            <input type="hidden" name="page" value="lop">
            <label for="ten">Tên lớp:</label>
            <input type="text" name="ten" id="ten" value="<?php echo htmlspecialchars($ten); ?>">
            <input type="submit" value="Tìm">
        </form>

        <table class="student-table">
            <thead>
                <tr>
                    <th>Mã lớp</th>
                    <th>Mã môn học</th>
                    <th>Mã giáo viên</th>
                    <th>Tên lớp</th>
                    <th>Tham gia</th>
                    <th>Kết thúc</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Thời khóa biểu</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row->Malop); ?></td>
                        <td><?php echo htmlspecialchars($row->Mamh); ?></td>
                        <td><?php echo htmlspecialchars($row->Magv); ?></td>
                        <td><?php echo htmlspecialchars($row->TenLop); ?></td>
                        <td><?php echo htmlspecialchars($row->Thamgia); ?></td>
                        <td><?php echo htmlspecialchars($row->Ketthuc); ?></td>
                        <td><?php echo isset($row->ngaybatdau) ? htmlspecialchars($row->ngaybatdau) : 'N/A'; ?></td>
                        <td><?php echo isset($row->ngayketthuc) ? htmlspecialchars($row->ngayketthuc) : 'N/A'; ?></td>
                        <td>
                            <a href="index.php?page=thoikhoabieu&matkb=<?php echo htmlspecialchars($row->matkb); ?>">
                                <?php echo htmlspecialchars($row->matkb); ?>
                            </a>
                        </td>
                        <td>
                            <a href="index.php?page=sualop&Malop=<?php echo htmlspecialchars($row->Malop); ?>" class="button edit">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <form method="post" action="index.php?page=xoalop" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lớp học này?');" class="delete-form">
                                <input type="hidden" name="Malop" value="<?php echo htmlspecialchars($row->Malop); ?>">
                                <button type="submit" class="button delete">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
