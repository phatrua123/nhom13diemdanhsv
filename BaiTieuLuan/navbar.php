<style>
	.collapse a {
		text-indent: 10px;
	}
	nav#sidebar {
		/*background: url(assets/uploads/<?php echo isset($_SESSION['system']['cover_img']) ? $_SESSION['system']['cover_img'] : '' ?>) !important*/
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark'>
	<div class="sidebar-list">
		<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-tachometer-alt"></i></span> Trang chủ</a>
		<div class="mx-2 text-white">Master List</div>
		<a href="index.php?page=students" class="nav-item nav-students"><span class='icon-field'><i class="fa fa-users"></i></span> Sinh Viên</a>
		<a href="index.php?page=diemdanhmon" class="nav-item nav-faculty"><span class='icon-field'><i class="fa fa-user-friends"></i></span> Điểm Danh</a>
		<a href="index.php?page=thongtingiaovien" class="nav-item nav-employees"><span class='icon-field'><i class="fa fa-user-tie"></i></span> Giáo Viên</a>
		<a href="index.php?page=lop" class="nav-item nav-logs"><span class='icon-field'><i class="fa fa-list-alt"></i></span> Lớp</a>
		<a href="index.php?page=xemdiemdanh" class="nav-item nav-logs"><span class='icon-field'><i class="fa fa-list-alt"></i></span> Xem Sinh Viên</a>
		<a href="index.php?page=thongke" class="nav-item nav-thongke"><span class='icon-field'><i class="fa fa-chart-bar"></i></span> Thống Kê</a>
		<a href="index.php?page=ddkhuonmat" class="nav-item nav-nhandienkhuonmat"><span class='icon-field'><i class="fa fa-camera"></i></span> Nhận diện khuôn mặt</a>
		<?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): ?>
			<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
			<!-- <a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs text-danger"></i></span> System Settings</a> -->
		<?php endif; ?>
	</div>
</nav>
<script>
    $(document).ready(function() {
        <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): ?>
            $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active');
        <?php endif; ?>
    });
</script>
<!-- <style>
    nav#sidebar {
        /*background: url(assets/uploads/<?php echo isset($_SESSION['system']['cover_img']) ? $_SESSION['system']['cover_img'] : '' ?>) !important*/
    }
</style> -->
