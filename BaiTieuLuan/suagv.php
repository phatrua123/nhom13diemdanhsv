<?php
// Include file kết nối CSDL
include 'db_connect.php';

// Kiểm tra xem có tham số id được truyền qua URL không
if(isset($_GET['id'])) {
    // Lấy id của giáo viên từ URL
    $id = $_GET['id'];

    // Truy vấn để lấy thông tin của giáo viên dựa trên id
    $sql = "SELECT * FROM giaovien WHERE Magv = ?";
    $stm = $conn->prepare($sql);
    $stm->execute([$id]);

    // Kiểm tra xem có giáo viên nào được tìm thấy không
    if ($stm->rowCount() > 0) {
        // Lấy thông tin của giáo viên từ kết quả trả về
        $teacher = $stm->fetch(PDO::FETCH_OBJ);
    } else {
        // Nếu không tìm thấy giáo viên, chuyển hướng về trang danh sách giáo viên
        header("Location: index.php");
        exit();
    }
} else {
    // Nếu không có tham số id trong URL, chuyển hướng về trang danh sách giáo viên
    header("Location: index.php");
    exit();
}

// Xử lý dữ liệu gửi từ form sửa thông tin giáo viên
if(isset($_POST['submit'])) {
    // Kiểm tra xem các trường thông tin có được gửi đi không
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['ngaysinh']) && isset($_POST['gioitinh']) && isset($_POST['type'])) {
        // Lấy dữ liệu từ form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $ngaysinh = $_POST['ngaysinh'];
        $gioitinh = $_POST['gioitinh'];
        $type = $_POST['type'];

        // Truy vấn cập nhật thông tin giáo viên vào CSDL
        $sql = "UPDATE giaovien SET name = ?, email = ?, ngaysinh = ?, gioitinh = ?, type = ? WHERE Magv = ?";
        $stm = $conn->prepare($sql);
        $result = $stm->execute([$name, $email, $ngaysinh, $gioitinh, $type, $id]);

        // Kiểm tra kết quả của truy vấn
        if($result) {
            // Nếu cập nhật thành công, chuyển hướng về trang danh sách giáo viên
            header("Location: index.php?page=thongtingiaovien");
            exit();
        } else {
            // Nếu có lỗi xảy ra, hiển thị thông báo lỗi
            $error_message = "Có lỗi xảy ra, vui lòng thử lại sau.";
        }
    } else {
        // Nếu các trường thông tin không được gửi đi, hiển thị thông báo lỗi
        $error_message = "Vui lòng điền đầy đủ thông tin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin giáo viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.container {
    width: 80%;
    margin: 20px auto;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

form input[type="text"],
form input[type="email"],
form select,
form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

form input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #0056b3;
}

.error-message {
    color: #ff0000;
    margin-bottom: 10px;
}

.success-message {
    color: #28a745;
    margin-bottom: 10px;
}

/* Hiệu ứng hover cho nút quay lại */
.back-btn {
    background-color: #dc3545;
    transition: background-color 0.3s ease;
}

.back-btn:hover {
    background-color: #c82333;
    transition: background-color 0.3s ease;
}

/* Nút quay lại */
.back-btn a {
    text-decoration: none;
    color: #fff;
    font-weight: bold;
}

/* Hiệu ứng hover cho nút quay lại */
.back-btn a:hover {
    color: #fff;
}

    </style>
</head>
<body>
    <h2>Sửa thông tin giáo viên</h2>
    <?php if(isset($error_message)): ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="name">Tên:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $teacher->name; ?>"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $teacher->email; ?>"><br>
        <label for="ngaysinh">Ngày Sinh:</label><br>
        <input type="date" id="ngaysinh" name="ngaysinh" value="<?php echo $teacher->ngaysinh; ?>"><br>
        <label for="gioitinh">Giới Tính:</label><br>
        <select id="gioitinh" name="gioitinh">
            <option value="Nam" <?php if($teacher->gioitinh == 'Nam') echo 'selected'; ?>>Nam</option>
            <option value="Nữ" <?php if($teacher->gioitinh == 'Nữ') echo 'selected'; ?>>Nữ</option>
        </select><br>
        <label for="type">Loại:</label><br>
        <select id="type" name="type">
            <option value="1" <?php if($teacher->type == 1) echo 'selected'; ?>>Admin</option>
            <option value="2" <?php if($teacher->type == 2) echo 'selected'; ?>>Staff</option>
            <option value="3" <?php if($teacher->type == 3) echo 'selected'; ?>>Unknown</option>
        </select><br><br>
        <input type="submit" name="submit" value="Lưu">
    </form>
</body>
</html>
