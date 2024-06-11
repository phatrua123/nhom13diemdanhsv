<?php
// Include database connection
include 'db_connect.php';

// Check if the 'id' parameter is present in the GET request
if (!isset($_GET['id'])) {
    // Redirect to the students page if 'id' is not set
    header("Location: index.php?page=students");
    exit(); // Ensure no further code is executed
}

// Fetch student information based on 'id'
$sql = "SELECT * FROM SinhVien WHERE Masv = ?";
$stm = $conn->prepare($sql);
$stm->execute([$_GET['id']]);
$student = $stm->fetch(PDO::FETCH_OBJ);

// Check if the student exists
if (!$student) {
    // Redirect to the students page if the student does not exist
    header("Location: index.php?page=students");
    exit();
}

// Handle form submission to update student information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve form data
        $ten = $_POST['ten'];
        $gioitinh = $_POST['gioitinh'];
        $diachi = $_POST['diachi'];
        $ngaysinh = $_POST['ngaysinh'];
        $id = $_POST['id'];

        // Prepare update SQL query
        $sql = "UPDATE sinhvien SET Hotensv = :ten, GioiTinh = :gioitinh, Diachi = :diachi, Ngaysinh = :ngaysinh WHERE Masv = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':gioitinh', $gioitinh);
        $stmt->bindParam(':diachi', $diachi);
        $stmt->bindParam(':ngaysinh', $ngaysinh);
        $stmt->bindParam(':id', $id);

        // Execute the update query
        if ($stmt->execute()) {
            // Redirect to the students page upon successful update
            header("Location: index.php?page=students");
            exit();
        } else {
            echo 'Cập nhật thông tin sinh viên thất bại';
        }
    } catch (PDOException $e) {
        echo 'Lỗi: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sinh Viên</title>
    <!-- Add CSS for better styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
            color: #333;
        }
        input[type="text"],
        input[type="date"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sửa Sinh Viên</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . htmlspecialchars($_GET['id'])); ?>">
            <!-- Fields for displaying and editing student information -->
            <label for="ten">Họ và Tên:</label>
            <input type="text" name="ten" value="<?php echo htmlspecialchars($student->Hotensv); ?>" required>

            <label for="gioitinh">Giới Tính:</label>
            <input type="text" name="gioitinh" value="<?php echo htmlspecialchars($student->GioiTinh); ?>" required>

            <label for="diachi">Địa Chỉ:</label>
            <input type="text" name="diachi" value="<?php echo htmlspecialchars($student->Diachi); ?>" required>

            <label for="ngaysinh">Ngày Sinh:</label>
            <input type="date" name="ngaysinh" value="<?php echo htmlspecialchars($student->Ngaysinh); ?>" required>

            <!-- Hidden field to store the student ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($student->Masv); ?>">

            <!-- Submit button to save changes -->
            <input type="submit" value="Lưu Thay Đổi">
        </form>
    </div>
</body>
</html>
