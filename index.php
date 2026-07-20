<!DOCTYPE html>
<html lang="en">
<?php require_once("config/server.php") ?>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>SIAP</title>
	<link rel="shortcut icon" href="assets/img/brand.png" type="image/x-icon">

	<!-- lib CSS -->
	<link rel="stylesheet" href="assets/css/adminlte.css">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/overlayscrollbars.min.css">
	<link rel="stylesheet" href="assets/css/simple-datatables.css">
	<link rel="stylesheet" href="assets/css/sweetalert2.min.css">
	<link rel="stylesheet" href="assets/bootstrap-icons/font/bootstrap-icons.min.css">

	<link rel="stylesheet" href="assets/css/custom.css">
	<link rel="stylesheet" href="assets/icon/my_icon.css">

	<!-- lib Modul -->
	<link rel="stylesheet" href="assets/ckeditor5/ckeditor5.css">


</head>

<body class="layout-fixed fixed-header sidebar-expand-lg sidebar-mini app-loaded bg-body-tertiary">
	<div class="app-wrapper">
		<nav class="app-header navbar navbar-expand bg-body-secondary">
			<div class="container-fluid">
				<ul class="navbar-nav">
					<li class="nav-item">
						<button class="nav-link" data-lte-toggle="sidebar" role="button"><i class="bi bi-list"></i></button>
					</li>
					<li class="nav-item d-none d-md-block fw-semibold"><button data-route="" class="nav-link">Sistem Informasi Administrasi Pendidikan</button></li>
				</ul>
				<ul class="navbar-nav ms-auto">
					<li class="nav-item dropdown user-menu">
						<button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
							<img src="assets/img/account.png" alt="User Image" class="user-image shadow-sm" />
							<span class="d-none d-md-inline">Administrator</span>
						</button>
						<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end" style="border-radius: 7px;">
							<li class="user-header text-bg-primary" style="border-top-right-radius: 7px;border-top-left-radius: 7px;">
								<img src="assets/img/account.png" alt="" class="rounded-circle shadow-sm" />
								<p>
									Administrator
									<small>Member since Nov. 2023</small>
								</p>
							</li>
							<li class="user-footer">
								<a href="#" class="btn btn-default btn-flat"><i class="bi bi-person"></i> Profil</a>
								<a href="#" class="btn btn-default btn-flat float-end"><i class="bi bi-door-open"></i> Keluar</a>
							</li>
						</ul>
					</li>
					<!--begin::Fullscreen Toggle-->
					<li class="nav-item">
						<a class="nav-link" href="#" data-lte-toggle="fullscreen">
							<i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
							<i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
						</a>
					</li>
					<!--end::Fullscreen Toggle-->
				</ul>
			</div>
		</nav>
		<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
			<div class="sidebar-brand">
				<a href="?" class="brand-link">
					<img src="assets/img/brand.png" alt="" class="brand-image" />
				</a>
			</div>
			<div class="sidebar-wrapper">
				<nav class="mt-2">
					<ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
						<li class="nav-item">
							<a data-route="" class="nav-link">
								<img src="assets/icon/dashboard.svg" class="nav-icon">
								<p>Dashboard</p>
							</a>
						</li><!--  Dashboard  -->
						<li class="nav-item">
							<a class="nav-link"><i class="nav-icon bi bi-list-task"></i>
								<p>Data Induk
									<i class="nav-arrow bi bi-chevron-right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<!-- <a data-route="siswa" class="nav-link">
										<img src="./assets/icon/local_library.svg" class="nav-icon">
										<p>Siswa</p>
									</a> -->
									<button data-route="siswa" class="nav-link w-100"><img src="./assets/icon/local_library.svg" class="nav-icon">
										<p>Siswa</p>
									</button>
								</li>
								<li class="nav-item">
									<a data-route="guru" class="nav-link">
										<img src="./assets/icon/crowdsource.svg" class="nav-icon">
										<p>Guru</p>
									</a>
								</li>
								<li class="nav-item">
									<a data-route="tendik" class="nav-link">
										<img src="./assets/icon/person_group.svg" class="nav-icon">
										<p>Tendik</p>
									</a>
								</li>
							</ul>
						</li><!--  Data Induk  -->
						<li class="nav-item">
							<a class="nav-link collapsed">
								<img src="assets/icon/book_6.svg" class="nav-icon">
								<p>Akademik
									<i class="nav-arrow bi bi-chevron-right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<!-- <li class="nav-item">
									<a data-route="#" class="nav-link">
										<img src="./assets/icon/local_library.svg" class="nav-icon">
										<p>Siswa</p>
									</a>
								</li> -->
								<li class="nav-item">
									<a data-route="mapel" class="nav-link">
										<img src="./assets/icon/book_open.svg" class="nav-icon">
										<p>Mata Pelajaran</p>
									</a>
								</li>
								<li class="nav-item">
									<a data-route="kelas" class="nav-link">
										<img src="./assets/icon/person_group.svg" class="nav-icon">
										<p>Kelas</p>
									</a>
								</li>
								<li class="nav-item">
									<a data-route="jadwal" class="nav-link">
										<img src="./assets/icon/calendar_month.svg" class="nav-icon">
										<p>Jadwal</p>
									</a>
								</li>
								<!-- <li class="nav-item">
									<a data-route="absensi" class="nav-link">
										<img src="./assets/icon/assignment.svg" class="nav-icon">
										<p>Absensi</p>
									</a>
								</li> -->
								<li class="nav-item">
									<a data-route="jurnal" class="nav-link">
										<img src="./assets/icon/table_chart_view.svg" class="nav-icon">
										<p>Jurnal Mengajar</p>
									</a>
								</li>
								<!-- <li class="nav-item">
									<a data-route="ab_kelas" class="nav-link">
										<img src="./assets/icon/list_alt_check.svg" class="nav-icon">
										<p>Absen Kelas</p>
									</a>
								</li> -->
							</ul>
						</li><!--  Akademik  -->
						<li class="nav-item">
							<a class="nav-link collapsed"><img src="./assets/icon/contract_edit.svg" class="nav-icon">
								<p>Administrasi
									<i class="nav-arrow bi bi-chevron-right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a class="nav-link collapsed"><img src="./assets/icon/schema.svg" class="nav-icon">
										<p>Data Organisasi
											<i class="nav-arrow bi bi-chevron-right"></i>
										</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item">
											<a data-route="staf" class="nav-link"><img src="./assets/icon/productivity.svg" class="nav-icon">
												<p>Staf</p>
											</a>
										</li>
										<li class="nav-item">
											<a data-route="siswa" class="nav-link"><img src="./assets/icon/account_tree.svg" class="nav-icon">
												<p>Siswa</p>
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</li><!--  Administrasi  -->
						<?php if (db_Mytbk() == true): ?>
							<li class="nav-item">
								<a class="nav-link collapsed">
									<img src="assets/img/mytbk.png" class="nav-icon">
									<p>Tes Akademik
										<i class="nav-arrow bi bi-chevron-right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a data-route="mytbk_id" class="nav-link">
											<span class="myicon myicon-identity_platform"></span>
											<p>Identitas</p>
										</a>
									</li>
									<li class="nav-item">
										<a data-route="mytbk_ps" class="nav-link">
											<img src="assets/icon/person_group.svg" class="nav-icon">
											<p>Daftar Peserta</p>
										</a>
									</li>
									<li class="nav-item">
										<a data-route="mytbk_hasil" class="nav-link">
											<img src="assets/icon/analytics.svg" class="nav-icon">
											<p>Hasil Analisa</p>
										</a>
									</li>
								</ul>
							</li>
						<?php endif; ?><!--  Tes Akademik  -->
						<li class="nav-item">
							<a class="nav-link collapsed"><img src="./assets/icon/print.svg" class="nav-icon">
								<p>Cetak<i class="nav-arrow bi bi-chevron-right"></i></p>
							</a>

						</li><!--  Cetak  -->
					</ul>
				</nav>
			</div>
		</aside>
		<main class="app-main mb-3 border-bottom">
			<div class="app-content"></div>
			<div class="progress" id="loadingProgress" role="progressbar" aria-label="Example 1px high" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 2.5px">
				<div class="progress-bar" id="myProgressBar" style="width: 0%"></div>
			</div>
			<!-- <div id="loadingSpinner" class="spinner-container" style="margin-bottom: -5vh;">
				<div id="loadingSpinner" class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div> -->
			<?php require_once("config/server.php") ?>
			<div id="" class="container-fluid">
				<div id="content-route">
					<?php
					// include_once "app/views/dashboard.php" 
					?>
				</div>
			</div>
		</main>
		<footer class="app-footer">
			<strong>
				<?= $buat . $by . $ver_app; ?>
			</strong>
		</footer>
	</div>

</body>

</html>


<!-- JavaScript -->
<!-- lib Javascript -->
<script src="assets/js/adminlte.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/overlayscrollbars.min.js"></script>
<script src="assets/js/simple-datatables.js"></script>
<script src="assets/js/sweetalert2.min.js"></script>
<script src="assets/js/custom.js"></script>

<script>
	const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
	const Default = {
		scrollbarTheme: "os-theme-light",
		scrollbarAutoHide: "leave",
		scrollbarClickScroll: true,
	};
	document.addEventListener("DOMContentLoaded", function() {
		const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
		if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
			OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
				scrollbars: {
					theme: Default.scrollbarTheme,
					autoHide: Default.scrollbarAutoHide,
					clickScroll: Default.scrollbarClickScroll,
				},
			});
		}
	});
</script>