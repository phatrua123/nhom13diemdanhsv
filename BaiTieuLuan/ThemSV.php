<?php
include 'db_connect.php';
$Masv = $_POST['Masv']??'';
$Hotensv= $_POST['Hotensv']??'';
echo '<pre>'; 
if($Masv=='')
{
    header('location:index.php?page=students'); exit;

}
$GioiTinh = $_POST['GioiTinh']??'';
$Diachi = $_POST['Diachi']??'';
$Ngaysinh = $_POST['Ngaysinh']??'';
$sql = "insert into sinhvien (Masv, Hotensv,GioiTinh,Diachi,Ngaysinh) values(?,?,?,?,?)";
$stm = $conn ->prepare($sql);
$arrparam=[$Masv, $Hotensv,$GioiTinh,$Diachi,$Ngaysinh];
// print_r($arrparam); \exit;
$stm->execute($arrparam);
$n = $stm->rowCount();
?>
<script>
    alert('Da Them+<?php echo $n ?> dong');
    window.location='index.php?page=students';
</script>