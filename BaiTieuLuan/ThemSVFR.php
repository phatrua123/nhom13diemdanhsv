<style>
    form {
        display: flex;
        flex-direction: column;
        max-width: 300px;
        margin-bottom: 20px;
    }

    form input[type="text"], form select {
        margin-bottom: 10px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    form input[type="submit"] {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>
<?php
include 'db_connect.php';
$stm=$conn->query('select * from sinhvien');
$data1=$stm->fetchAll(PDO::FETCH_OBJ);
?>
<form action="ThemSV.php" method="post" enctype="multipart/form-data">
    MaSV <input type="text" name="Masv" id=""> <br>
    HoTenSV <input type="text" name="Hotensv" id=""><br>
    GioiTinh <input type="text" name="GioiTinh" id=""><br>
    Diachi <input type="text" name="Diachi" id=""><br>
    Ngaysinh <input type="text" name="Ngaysinh" id=""><br>
    <input type="submit" value="them">
</form>