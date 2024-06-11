<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Điểm danh bằng nhận diện khuôn mặt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        h1 {
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        button {
            padding: 10px 20px;
            margin-bottom: 10px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 200px;
            margin-bottom: 20px;
        }
        pre {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 5px;
            max-width: 400px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>Điểm danh bằng nhận diện khuôn mặt</h1>
    <form action="ddkhuonmat.php" method="post">
        <button type="submit" name="action" value="attendance">Điểm danh</button>
        
        <label for="monhoc">Chọn môn học:</label>
        <select id="monhoc" name="monhoc">
            <option value="1">Ngôn ngữ lập trình</option>
            <option value="2">Thiết kế Web</option>
            <option value="3">Lập trình web</option>
            <option value="4">Hệ thống thông tin</option>
            <option value="5">Lập trình mã nguồn mở</option>
        </select>
    </form>
    <?php
    // Bao gồm kết nối cơ sở dữ liệu
    include 'db_connect.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];
        $output = '';
        $command = '';
        $script_dir ='C:\\Users\\acer\\Documents\\ltmnm\\doannhom\\BaiTieuLuan\\BaiTieuLuan';

    // Đường dẫn tới Python 3.12.
    $python_path = 'C:\\Users\\acer\\AppData\\Local\\Programs\\Python\\Python312\\python.exe';

        // Mã sinh viên cố định và tên sinh viên
        $masv = 'R001';
        $hotensv = 'Tran Van A';
        $monhoc = isset($_POST['monhoc']) ? $_POST['monhoc'] : '';
        $ngaydiemdanh = date('Y-m-d');
        $comat = 'C';
        $vang = '';
        $ghichu = '';
        // Kiểm tra xem người dùng đã chọn môn học "Ngôn ngữ lập trình" hay không
        if ($monhoc === '1') {
            // Sử dụng đường dẫn tuyệt đối và phiên bản Python chính xác
            switch ($action) {

                case 'attendance':
$command = escapeshellcmd($python_path . ' ' . $script_dir . '\\03_face_recognition.py');
                    // Kiểm tra xem sinh viên đã được điểm danh hôm nay chưa
                    $stmt = $conn->prepare("SELECT * FROM diemdanh WHERE Masv = ? AND matkb = ? AND ngaydiemdanh = ?");
                    $stmt->execute([$masv, $monhoc, $ngaydiemdanh]);
                    if ($stmt->rowCount() === 0) {
                        // Nếu chưa, thêm bản ghi mới
                        $stmt = $conn->prepare("INSERT INTO diemdanh (matkb, ngaydiemdanh, comat, vang, ghichu, Masv) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$monhoc, $ngaydiemdanh, $comat, $vang, $ghichu, $masv]);
                        $output = 'Điểm danh thành công cho sinh viên ' . $hotensv . ' vào ngày ' . $ngaydiemdanh;
                    } else {
                        $output = 'Sinh viên ' . $hotensv . ' đã được điểm danh hôm nay.';
                    }
                    break;
            }
        }

         else {
            $output = 'Bạn không học môn này.';
        }

        if ($command) {
            $output .= shell_exec($command . ' 2>&1'); // Redirect stderr to stdout for error messages
            echo "<pre>$output</pre>";
        } else {
            echo 'Bạn không có học môn này ';
        }
    }
    ?>
</body>
</html>