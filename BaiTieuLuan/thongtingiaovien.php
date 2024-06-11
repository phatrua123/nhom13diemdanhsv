<?php
include 'db_connect.php';

$ten = isset($_GET['ten']) ? $_GET['ten'] : '';
$ten = "%$ten%";

$sql = "SELECT * FROM giaovien WHERE name LIKE ?";
$stm = $conn->prepare($sql);
$stm->execute([$ten]);

// Kiểm tra xem có dữ liệu được trả về không
if ($stm->rowCount() > 0) {
    // Nếu có dữ liệu, gán giá trị vào biến $data
    $data = $stm->fetchAll(PDO::FETCH_OBJ);
} else {
    // Nếu không có dữ liệu, gán giá trị mảng rỗng cho biến $data
    $data = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 95%;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .teacher-info {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid transparent;
            margin: 10px;
            transition: all 0.3s ease;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 220px;
        }
        .teacher-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        }
        .teacher-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
            object-fit: cover;
        }
        .teacher-info h3 {
            margin: 0;
            color: #333;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .teacher-info p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        .button {
            padding: 8px 16px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            background-color: #007bff;
            transition: background-color 0.3s ease;
        }
        .button i {
            margin-right: 6px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .change-password {
            margin-top: 20px;
            text-align: center;
        }
        .change-password input {
            padding: 8px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php foreach($data as $item): ?>
            <div class="teacher-info">
                <img src="img/giaovien.jpg" alt="Giáo viên">
                <p><strong>Email:</strong> <?php echo $item->email ?></p>
                <p><strong>Tên:</strong> <?php echo $item->name ?></p>
                <p><strong>Ngày Sinh:</strong> <?php echo $item->ngaysinh ?></p>
                <p><strong>Giới Tính:</strong> <?php echo $item->gioitinh ?></p>
                <p><strong>Loại:</strong> <?php echo $item->type == 1 ? 'Admin' : ($item->type == 2 ? 'Staff' : 'Unknown'); ?></p>
                <a href="suagv.php?id=<?php echo $item->Magv ?>" class="button edit">
                    <i class="fas fa-edit"></i> Sửa
                </a>
                <a href="doimk.php?id=<?php echo $item->Magv ?>" class="button change-password">
                    <i class="fas fa-key"></i> Đổi Mật Khẩu
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
