<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Masv'])) {
    try {
        $masv = $_POST['Masv'];

        $sql = 'DELETE FROM sinhvien WHERE Masv = :Masv';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Masv', $masv);

        if ($stmt->execute()) {
            // Output success message
            echo 'Đã xóa thành công sinh viên có mã sinh viên: ' . $masv;
            echo '<br>';
            // JavaScript code to redirect back to the previous page
            echo '<script>window.history.back();</script>';
            exit; // Stop further execution
        } else {
            echo 'Xóa sinh viên thất bại';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid request method';
}
?>
