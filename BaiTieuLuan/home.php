<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Overflow</title>
    <style>
        /* Đảm bảo hình ảnh tràn viền khung hình */
        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto; /* Căn giữa hình ảnh */
            overflow: hidden; /* Đảm bảo hình ảnh không bị tràn ra ngoài khung */
        }
    </style>
</head>
<body>
    <!-- Hình ảnh tràn viền khung hình -->
    <img src="img/home.jpg" alt="Example Image">
</body>
</html>
