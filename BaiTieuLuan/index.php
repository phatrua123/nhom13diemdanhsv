<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_SESSION['system']['name']) ? $_SESSION['system']['name'] : ''; ?></title>
    <!-- Thêm các thẻ meta, liên kết CSS và script JS -->

    <?php
    // Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng về trang đăng nhập
    if (!isset($_SESSION['username'])) {
        header('location: login.php');
        exit; // Đảm bảo không có mã HTML nào khác được thực thi sau lệnh header
    }

    // Include header và auth.php (nếu cần)
    include('./header.php');
    // include('./auth.php');
    ?>
</head>
<style>
    body {
        background: #80808045;
    }

    .modal-dialog.large {
        width: 80% !important;
        max-width: unset;
    }

    .modal-dialog.mid-large {
        width: 50% !important;
        max-width: unset;
    }

    /* Thêm các style CSS tùy chỉnh nếu cần */
</style>
<body>
    <?php include 'topbar.php'; ?>
    <?php include 'navbar.php'; ?>
    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white"></div>
    </div>

    <main id="view-panel">
        <?php
        // Kiểm tra và lấy trang cần hiển thị, mặc định là trang 'home'
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        // Bao gồm nội dung của trang hiện tại
        include $page . '.php';
        ?>
    </main>

    <!-- Thêm các script JS -->
    <script>
        // Định nghĩa các hàm JS và sự kiện
        // Ví dụ:
        // function myFunction() {
        //     // Code xử lý
        // }
    </script>
</body>
</html>
