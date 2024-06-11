<?php
include 'db_connect.php';

// Kiểm tra xem người dùng đã submit form chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $id = $_POST['id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Truy vấn để lấy mật khẩu hiện tại của người dùng
    $stmt = $conn->prepare("SELECT password FROM giaovien WHERE Magv = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $current_password = $row['password'];

    // Kiểm tra xem mật khẩu cũ nhập vào có khớp với mật khẩu hiện tại không
    if ($current_password !== $old_password) {
        $error_message = "Bạn đã nhập sai mật khẩu cũ!";
    } else {
        // Kiểm tra xác nhận mật khẩu mới
        if ($new_password !== $confirm_password) {
            $error_message = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
        } else {
            // Mã hóa mật khẩu mới
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Cập nhật mật khẩu mới đã mã hóa vào cơ sở dữ liệu
            $update_stmt = $conn->prepare("UPDATE giaovien SET password = ? WHERE Magv = ?");
            $update_stmt->execute([$hashed_password, $id]);
            $success_message = "Đổi mật khẩu thành công!";
            
            // Chuyển hướng về trang index.php?page=thongtingiaovien
            header("Location: index.php?page=thongtingiaovien");
            exit(); // Đảm bảo không có mã HTML nào được gửi sau khi chuyển hướng
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-top: 0;
        }
        .form-container input {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-container button {
            width: 100%;
            padding: 8px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        .success {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Đổi Mật Khẩu</h2>
        <?php
        // Hiển thị thông báo lỗi nếu có
        if (isset($error_message)) {
            echo '<div class="error">' . $error_message . '</div>';
        }

        // Hiển thị thông báo thành công nếu có
        if (isset($success_message)) {
            echo '<div class="success">' . $success_message . '</div>';
        }
        ?>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <label for="old_password">Mật khẩu cũ:</label>
            <input type="password" name="old_password" id="old_password" required>
            <label for="new_password">Mật khẩu mới:</label>
            <input type="password" name="new_password" id="new_password" required>
            <label for="confirm_password">Xác nhận mật khẩu mới:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <button type="submit">Đổi Mật Khẩu</button>
        </form>
    </div>
</body
