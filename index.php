<!DOCTYPE html>
<html lang="en">

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

	<!-- lib Modul -->
	<link rel="stylesheet" href="assets/ckeditor5/ckeditor5.css">


</head>

<body class="layout-fixed fixed-header sidebar-expand-lg sidebar-mini app-loaded bg-body-tertiary">
	<div class="app-wrapper">
		<nav class="app-header navbar navbar-expand bg-body-secondary">
			<div class="container-fluid">
				<ul class="navbar-nav">
					<li class="nav-item">
						<button data-page="" class="nav-link" data-lte-toggle="sidebar" role="button"><i class="bi bi-list"></i></button>
					</li>
					<li class="nav-item d-none d-md-block fw-semibold"><button data-page="" class="nav-link">Sistem Informasi Administrasi Pendidikan</button></li>
				</ul>
				<ul class="navbar-nav ms-auto">
					<li class="nav-item dropdown user-menu">
						<button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
							<img src="assets/img/account.png" alt="User Image" class="user-image rounded-circle shadow" />
							<span class="d-none d-md-inline">Administrator</span>
						</button>
						<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
							<li class="user-header text-bg-primary">
								<img src="app/images/account.png" alt="" class="rounded-circle shadow" />
								<p>
									Administrator
									<small>Member since Nov. 2023</small>
								</p>
							</li>
							<li class="user-footer">
								<a href="#" class="btn btn-default btn-flat">Profil</a>
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
							<a data-page="dashboard" data-id="2" class="nav-link">
								<img src="assets/icon/dashboard.svg" class="nav-icon">
								<p>Dashboard</p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link"><i class="nav-icon bi bi-list-task"></i>
								<p>Data Induk
									<i class="nav-arrow bi bi-chevron-right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<!-- <a data-page="v_siswa" class="nav-link">
										<img src="./assets/icon/local_library.svg" class="nav-icon">
										<p>Siswa</p>
									</a> -->
									<button data-page="v_siswa" class="nav-link w-100"><img src="./assets/icon/local_library.svg" class="nav-icon">
										<p>Siswa</p>
									</button>
								</li>
								<li class="nav-item">
									<a data-page="v_guru" class="nav-link">
										<img src="./assets/icon/person_group.svg" class="nav-icon">
										<p>Guru</p>
									</a>
								</li>
								<li class="nav-item">
									<a data-page="v_tendik" class="nav-link">
										<img src="./assets/icon/book_open.svg" class="nav-icon">
										<p>Tendik</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a class="nav-link collapsed">
								<img src="assets/icon/book_6.svg" class="nav-icon">
								<p>Akademik
									<i class="nav-arrow bi bi-chevron-right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<!-- <li class="nav-item">
									<a data-page="#" class="nav-link">
										<img src="./assets/icon/local_library.svg" class="nav-icon">
										<p>Siswa</p>
									</a>
								</li> -->
								<li class="nav-item">
									<a data-page="mapel" class="nav-link">
										<img src="./assets/icon/book_open.svg" class="nav-icon">
										<p>Mata Pelajaran</p>
									</a>
								</li>
								<li class="nav-item">
									<a data-page="kelas" class="nav-link">
										<img src="./assets/icon/person_group.svg" class="nav-icon">
										<p>Kelas</p>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</aside>
		<main class="app-main">
			<div class="app-content"></div>
			<div id="" class="container-fluid">
				<div id="content-page">
					<?php
					// include_once "app/views/dashboard.php" 
					?>
				</div>
			</div>
		</main>
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

<!-- content-page  -->
<script>
	function loadPage(page, pushState = true, id = '') {
		$.ajax({
			type: "POST",
			url: "app/route.php",
			data: {
				page: page,
				id: id
			},
			success: function(res) {
				if (res.trim() === "") {
					$("#content-page").html("<h3 class='text-center text-muted mt-5'>Dalam tahap pengembangan<br>Halaman masih kosong</h3>");
				} else {
					$("#content-page").html(res);
				}
				// Tambah ke riwayat hanya kalau memang dipicu klik, bukan popstate
				if (pushState) {
					history.pushState({
						page: page,
						id: id
					}, "", "?page=" + page + (id ? "&id=" + id : ""));
				}

				// Jika ada datatable di halaman
				if ($(".table").length) {
					// new simpleDatatables.DataTable(".table");
					var dataTable = new simpleDatatables.DataTable(".table", {
						perPageSelect: [5, 10, 25, 50, 100],
						perPage: 10,
						labels: {
							placeholder: "Cari...",
							perPage: " Data per halaman",
							noRows: "Tidak ada data yang ditemukan",
							info: "Menampilkan {start}/{end} dari {rows} Data",
						}
					});
				}

				// Update menu aktif
				updateActiveMenu(page);
			},
			error: function() {
				$("#content-page").html("Terjadi kesalahan memuat halaman.");
			}
		});
	}

	function updateActiveMenu(page) {
		// reset semua menu
		$('.sidebar-menu .nav-link').removeClass('active');
		$('.sidebar-menu li').removeClass('menu-open');

		// aktifkan link sesuai page
		const $link = $(`.sidebar-menu .nav-link[data-page="${page}"]`);
		$link.addClass('active');

		// jika link ada di dalam treeview
		const treeview = $link.closest('.nav-treeview');
		if (treeview.length) {
			treeview.show();
			treeview.prev('.nav-link').removeClass('collapsed');
			treeview.parent('li').addClass('menu-open');
		}
	}

	// Klik link dengan atribut data-page
	$(document).on("click", "nav a", function(e) {
		e.preventDefault();
		let page = $(this).data("page");
		let id = $(this).data("id");
		if (page !== undefined) {
			loadPage(page, true , id);
		} else if (page === '') {
			loadPage('dashboard', true);
		}
	});

	// Klik button dengan atribut data-page
	$(document).on("click", "button[data-page]", function(e) {
		e.preventDefault();
		let page = $(this).data("page");
		let id = $(this).data("id");
		if (page !== undefined) {
			loadPage(page, true , id);
		} else if (page === '') {
			loadPage('dashboard', true);
		}
	});

	// Saat pertama kali load / refresh
	$(document).ready(function() {
		const urlParams = new URLSearchParams(window.location.search);
		let page = urlParams.get("page") || "dashboard"; // default dashboard
		loadPage(page, false); // false -> jangan pushState ulang
	});

	// Navigasi back/forward browser
	window.onpopstate = function(event) {
		if (event.state && event.state.page) {
			loadPage(event.state.page, false); // false -> jangan pushState lagi
		} else {
			loadPage('dashboard', false);
		}
	};
</script>