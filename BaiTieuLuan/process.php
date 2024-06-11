<?php
include 'db_connect.php';

if (isset($_POST['subject'])) {
    $selectedSubject = $_POST['subject'];
    $sql = "
        SELECT sv.Hotensv,
               SUM(CASE WHEN dd.comat = 'C' THEN 1 ELSE 0 END) as soComat,
               SUM(CASE WHEN dd.vang = 'V' THEN 1 ELSE 0 END) as soVang
        FROM diemdanh dd
        JOIN sinhvien sv ON dd.Masv = sv.Masv
        JOIN thoikhoabieu tkb ON dd.matkb = tkb.matkb
        JOIN lop l ON tkb.Malop = l.Malop
        JOIN monhoc mh ON l.Mamh = mh.Mamh
        WHERE mh.Tenmh = :subject
        GROUP BY sv.Hotensv
        ORDER BY sv.Hotensv
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':subject', $selectedSubject);
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        $totalClasses = $row['soComat'] + $row['soVang'];
        $percentComat = ($totalClasses > 0) ? round(($row['soComat'] / $totalClasses) * 100, 2) : 0;
        $percentVang = 100 - $percentComat;
        
        echo "<tr>";
        echo "<td>" . htmlspecialchars($selectedSubject) . "</td>"; // Môn học đã chọn
        echo "<td>" . htmlspecialchars($row['Hotensv']) . "</td>";
        echo "<td>" . htmlspecialchars($row['soComat']) . "</td>";
        echo "<td>" . htmlspecialchars($row['soVang']) . "</td>";
        echo "<td>" . htmlspecialchars($percentComat) . "%</td>";
        echo "<td>" . htmlspecialchars($percentVang) . "%</td>";
        echo "</tr>";
    }
}

// Đóng kết nối
$conn = null;
?>
