<?php
include 'db_connect.php';

try {
    // Truy vấn để đếm số lượng sinh viên có mặt và vắng mặt
    $sql_comat = "SELECT COUNT(*) as soComat FROM diemdanh WHERE comat = 'C'";
    $sql_vang = "SELECT COUNT(*) as soVang FROM diemdanh WHERE vang = 'V'";
    
    $stmt_comat = $conn->prepare($sql_comat);
    $stmt_vang = $conn->prepare($sql_vang);
    
    $stmt_comat->execute();
    $stmt_vang->execute();
    
    $soComat = $stmt_comat->fetch(PDO::FETCH_ASSOC)['soComat'];
    $soVang = $stmt_vang->fetch(PDO::FETCH_ASSOC)['soVang'];
    
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}

// Đóng kết nối
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biểu đồ thống kê sinh viên có mặt và vắng mặt</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container {
            width: 60%;
            margin: auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="thongkesv.php"><b>Thong ke sinh vien</b></a>
        <h2>Biểu đồ thống kê sinh viên có mặt và vắng mặt</h2>
        <canvas id="myChart"></canvas>

    </div>

    <script>
        <?php
        // Chuyển đổi dữ liệu từ PHP sang JavaScript
        $soComatJS = json_encode($soComat);
        $soVangJS = json_encode($soVang);
        ?>

        const data = {
            labels: ['Có mặt', 'Vắng mặt'],
            datasets: [{
                label: 'Số lượng sinh viên',
                data: [<?php echo $soComatJS; ?>, <?php echo $soVangJS; ?>],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Biểu đồ thống kê sinh viên có mặt và vắng mặt'
                    }
                }
            },
        };

        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
</body>
</html>
