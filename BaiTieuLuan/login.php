<?php
session_start();

include("db_connect.php");

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare the SQL statement with placeholders
    $query = "SELECT * FROM giaovien WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);

    // Execute the prepared statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Đăng nhập thành công, lưu thông tin người dùng vào session
        $_SESSION["username"] = $username;
        header("Location: index.php"); // Chuyển hướng đến trang chính
        exit; // Đảm bảo không có mã HTML nào khác được thực thi sau lệnh header
    } else {
        $error = "Tên người dùng hoặc mật khẩu không đúng";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- Thêm liên kết tới Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('img/b.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
        .login-container {
            margin-top: 5%;
        }
        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-header img {
            max-width: 100%;
        }
        .login-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .forgot-password {
            display: block;
            margin-top: 10px;
            text-align: center;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="login-header">
                    <img src="img/images.png" alt="vnEdu">
                </div>
                <div class="login-form">
                    <h2 class="text-center">Đăng nhập</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="username">Tên người dùng:</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </div>
                        <div class="forgot-password">
                            <a href="forgot_password.php">Bạn quên mật khẩu?</a>
                        </div>
                    </form>

                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Thêm liên kết tới Bootstrap JavaScript (nếu cần) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
