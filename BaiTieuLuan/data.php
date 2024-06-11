<?php
include 'db_connect.php';

// Lấy danh sách các môn học
$sql = "SELECT DISTINCT Tenmh, Mamh FROM monhoc";
$stmt = $conn->query($sql);
$monhocs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kiểm tra nếu người dùng đã chọn một môn học
if (isset($_POST['mamh'])) {
    $mamh = $_POST['mamh'];

    // Lấy danh sách sinh viên đã điểm danh theo môn học
    $sql_diemdanh = "SELECT DISTINCT sv.Masv, sv.Hotensv, mh.Tenmh, dd.ngaydiemdanh, dd.comat, dd.vang
                     FROM diemdanh dd
                     JOIN sinhvien sv ON dd.Masv = sv.Masv
                     JOIN thoikhoabieu tkb ON dd.Matkb = tkb.Matkb
                     JOIN lop l ON tkb.Malop = l.Malop
                     JOIN monhoc mh ON l.Mamh = mh.Mamh
                     WHERE l.Mamh = :mamh";
    $stmt_diemdanh = $conn->prepare($sql_diemdanh);
    $stmt_diemdanh->bindParam(':mamh', $mamh);
    $stmt_diemdanh->execute();
    $diemdanh_sinhvien = $stmt_diemdanh->fetchAll(PDO::FETCH_ASSOC);

    // Tạo mảng để nhóm sinh viên theo ngày điểm danh
    $diemdanh_theo_ngay = array();
    foreach ($diemdanh_sinhvien as $sinhvien) {
        $ngay = $sinhvien['ngaydiemdanh'];
        if (!isset($diemdanh_theo_ngay[$ngay])) {
            $diemdanh_theo_ngay[$ngay] = array();
        }
        $diemdanh_theo_ngay[$ngay][] = $sinhvien;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Xem điểm danh</title>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    $("#datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText, inst) {
            var selectedDate = dateText;
            $.ajax({
                type: "POST",
                url: "xemdiemdanh.php", // Đường dẫn tới trang xemdiemdanh.php hoặc tương tự
                data: { selectedDate: selectedDate },
                success: function(response) {
                    $("#result").html(response);
                }
            });
        }
    });
});
</script>
</head>
<body>
    <div class="container">
        <h2>Xem điểm danh theo ngày</h2>
        <label for="datepicker">Chọn ngày:</label>
        <input type="text" id="datepicker">
        <div id="result"></div>
    </div>
    <div class="container">
        <h2>Danh sách sinh viên đã điểm danh theo môn học</h2>
        <form action="" method="post" class="form-group">
            <label for="mamh">Chọn môn học:</label>
            <select name="mamh" id="mamh">
                <option value="">Chọn môn học</option>
                <?php foreach ($monhocs as $monhoc) : ?>
<option value="<?php echo $monhoc['Mamh']; ?>"><?php echo $monhoc['Tenmh']; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Xem danh sách</button>
        </form>

        <?php if (isset($diemdanh_theo_ngay) && !empty($diemdanh_theo_ngay)) : ?>
            <h3>Danh sách sinh viên đã điểm danh theo ngày</h3>
            <?php foreach ($diemdanh_theo_ngay as $ngay => $sinhviens) : ?>
                <h4>Ngày <?php echo $ngay; ?></h4>
                <ul>
                    <?php foreach ($sinhviens as $sinhvien) : ?>
                        <li><?php echo $sinhvien['Masv']; ?> - <?php echo $sinhvien['Hotensv']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>