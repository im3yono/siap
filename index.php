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
	<link rel="stylesheet" href="assets/css/custom.css">

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
							<img src="assets/img/account.png" alt="User Image" class="user-image rounded-circle shadow" />
							<span class="d-none d-md-inline">Administrator</span>
						</button>
						<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
							<li class="user-header text-bg-primary">
								<img src="assets/img/account.png" alt="" class="rounded-circle shadow" />
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
							<a data-route="" class="nav-link">
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
								<li class="nav-item">
									<a data-route="absensi" class="nav-link">
										<img src="./assets/icon/assignment.svg" class="nav-icon">
										<p>Absensi</p>
									</a>
								</li>
								<li class="nav-item">
									<a data-route="jurnal" class="nav-link">
										<img src="./assets/icon/table_chart_view.svg" class="nav-icon">
										<p>Jurnal Mengajar</p>
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
			<div class="progress" id="loadingProgress" role="progressbar" aria-label="Example 1px high" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 2.5px">
				<div class="progress-bar" id="myProgressBar" style="width: 0%"></div>
			</div>
			<!-- <div id="loadingSpinner" class="spinner-container" style="margin-bottom: -5vh;">
				<div id="loadingSpinner" class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div> -->
			<div id="" class="container-fluid">
				<div id="content-route">
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

<!-- content-route  -->
<!-- <script>
	function loadRoute(route, pushState = true, id = '') {
		$.ajax({
			type: "POST",
			url: "app/route.php",
			data: {
				route: route,
				id: id
			},
			success: function(res) {
				if (res.trim() === "") {
					$("#content-route").html("<h3 class='text-center text-muted mt-5'>Dalam tahap pengembangan<br>Halaman masih kosong</h3>");
				} else {
					$("#content-route").html(res);
				}
				// Tambah ke riwayat hanya kalau memang dipicu klik, bukan popstate
				if (pushState) {
					history.pushState({
						route: route,
						id: id
					}, "", "?route=" + route + (id ? "&id=" + id : ""));
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
				updateActiveMenu(route);
				hideLoading();
			},
			error: function() {
				$("#content-route").html("Terjadi kesalahan memuat halaman.");
			}
		});
	}

	function hideLoading() {
		setTimeout(function() {
			document.getElementById("loadingSpinner").style.display = "none";
			document.getElementById("content-route").style.display = "block";
		}, 300);
	}

	function showLoading() {
		document.getElementById("loadingSpinner").style.display = "flex";
		document.getElementById("content-route").style.display = "none";
	}

	function updateActiveMenu(route) {
		// reset semua menu
		$('.sidebar-menu .nav-link').removeClass('active');
		$('.sidebar-menu li').removeClass('menu-open');

		// aktifkan link sesuai route
		const $link = $(`.sidebar-menu .nav-link[data-route="${route}"]`);
		$link.addClass('active');

		// jika link ada di dalam treeview
		const treeview = $link.closest('.nav-treeview');
		if (treeview.length) {
			treeview.show();
			treeview.prev('.nav-link').removeClass('collapsed');
			treeview.parent('li').addClass('menu-open');
		}
	}

	// Klik link dengan atribut data-route
	$(document).on("click", "nav a", function(e) {
		e.preventDefault();
		let route = $(this).data("route");
		let id = $(this).data("id");
		if (route !== undefined) {
			showLoading();
			loadRoute(route, true, id);
		} else if (route === '') {
			showLoading();
			loadRoute('dashboard', true);
		}
	});

	// Klik button dengan atribut data-route
	$(document).on("click", "button[data-route]", function(e) {
		e.preventDefault();
		let route = $(this).data("route");
		let id = $(this).data("id");
		if (route !== undefined) {
			showLoading();
			loadRoute(route, true, id);
		} else if (route === '') {
			showLoading();
			loadRoute('dashboard', true);
		}
	});

	// Saat pertama kali load / refresh
	$(document).ready(function() {
		const urlParams = new URLSearchParams(window.location.search);
		let route = urlParams.get("route") || "dashboard"; // default dashboard
		let id = urlParams.get("id") || "";

		loadRoute(route, false, id); // false -> jangan pushState ulang
	});

	// Navigasi back/forward browser
	window.onpopstate = function(event) {
		if (event.state && event.state.route) {
			loadRoute(event.state.route, false); // false -> jangan pushState lagi
		} else {
			loadRoute('dashboard', false);
		}
	};
</script> -->


<!-- <script>
	document.addEventListener("DOMContentLoaded", function() {
		const progressBar = document.getElementById("myProgressBar");
		let width = 0;
		const duration = 3000; // 3 seconds
		const interval = 10;
		const step = 100 / (duration / interval);
		const timer = setInterval(() => {
			width += step;
			if (width >= 100) {
				width = 100;
				clearInterval(timer);
			}
			progressBar.style.width = width + "%";
			progressBar.parentElement.setAttribute("aria-valuenow", Math.round(width));
		}, interval);
	});
</script>
<script>
	function loadRoute(route, pushState = true, id = '') {
		$.post("app/route.php", {
				route,
				id
			})
			.done(res => {
				$("#content-route").html(res.trim() ||
					"<h3 class='text-center text-muted mt-5'>Dalam tahap pengembangan<br>Halaman masih kosong</h3>");

				if (pushState) {
					history.pushState({
						route,
						id
					}, "", `?route=${route}${id ? "&id=" + id : ""}`);
				}

				if ($(".table").length) {
					new simpleDatatables.DataTable(".table", {
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

				updateActiveMenu(route);
				hideLoading();
			})
			.fail(() => $("#content-route").html("Terjadi kesalahan memuat halaman."));
	}

	const hideLoading = () => setTimeout(() => {
		$("#loadingSpinner").hide();
		$("#content-route").show();
	}, 300);

	const showLoading = () => {
		$("#loadingSpinner").css("display", "flex");
		$("#content-route").hide();
	};

	function updateActiveMenu(route) {
		$(".sidebar-menu .nav-link").removeClass("active");
		$(".sidebar-menu li").removeClass("menu-open");

		const $link = $(`.sidebar-menu .nav-link[data-route="${route}"]`).addClass("active");
		const treeview = $link.closest(".nav-treeview");
		if (treeview.length) {
			treeview.show()
				.prev(".nav-link").removeClass("collapsed")
				.parent("li").addClass("menu-open");
		}
	}

	$(document).on("click", "nav a, button[data-route]", function(e) {
		e.preventDefault();
		const route = $(this).data("route");
		const id = $(this).data("id");
		if (route === undefined) return;
		showLoading();
		loadRoute(route, true, id);
	});

	// Saat pertama kali load / refresh
	$(document).ready(() => {
		const urlParams = new URLSearchParams(window.location.search);
		const route = urlParams.get("route") || "dashboard";
		const id = urlParams.get("id") || "";
		loadRoute(route, false, id);
	});

	// Navigasi back/forward browser
	window.onpopstate = e => {
		loadRoute((e.state && e.state.route) || "dashboard", false, e.state?.id || "");
	};
</script> -->

<script>
	function loadRoute(route, pushState = true, id = '') {
		$.post("app/route.php", {
				route,
				id
			})
			.done(res => {
				$("#content-route").html(res.trim() ||
					"<h3 class='text-center text-muted mt-5'>Dalam tahap pengembangan<br>Halaman belum dapat di tampilkan</h3>");

				if (pushState) {
					history.pushState({
						route,
						id
					}, "", `?route=${route}${id ? "&id=" + id : ""}`);
				}

				if ($(".table").length) {
					new simpleDatatables.DataTable(".table", {
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

				updateActiveMenu(route);
				hideLoading();
			})
			.fail(() => $("#content-route").html("Terjadi kesalahan memuat halaman."));
	}

	// Ganti spinner -> progress bar
	let progressInterval;

	const hideLoading = () => {
		clearInterval(progressInterval);
		$("#myProgressBar").css("width", "100%");
		setTimeout(() => {
			$("#loadingProgress").hide();
			$("#content-route").show();
			// Reset ke 0% setelah bar disembunyikan, jadi tidak kelihatan "mundur"
			$("#myProgressBar").css("width", "0%");
		}, 900); // kasih delay agar user lihat sebentar 100%
	};


	const showLoading = () => {
		$("#loadingProgress").show();
		$("#content-route").hide();
		let width = 0;
		const interval = 20; // ms
		const step = 2; // naik 2% setiap 20ms

		progressInterval = setInterval(() => {
			if (width < 90) { // tahan di 90%, sisanya nunggu selesai
				width += step;
				$("#myProgressBar").css("width", width + "%");
				$("#loadingProgress").attr("aria-valuenow", width);
			}
		}, interval);
	};

	function updateActiveMenu(route) {
		$(".sidebar-menu .nav-link").removeClass("active");
		$(".sidebar-menu li").removeClass("menu-open");

		const $link = $(`.sidebar-menu .nav-link[data-route="${route}"]`).addClass("active");
		const treeview = $link.closest(".nav-treeview");
		if (treeview.length) {
			treeview.show()
				.prev(".nav-link").removeClass("collapsed")
				.parent("li").addClass("menu-open");
		}
	}

	$(document).on("click", "nav a, button[data-route]", function(e) {
		e.preventDefault();
		const route = $(this).data("route");
		const id = $(this).data("id");
		if (route === undefined) return;
		showLoading();
		loadRoute(route, true, id);
	});

	// Saat pertama kali load / refresh
	$(document).ready(() => {
		const urlParams = new URLSearchParams(window.location.search);
		const route = urlParams.get("route") || "dashboard";
		const id = urlParams.get("id") || "";
		loadRoute(route, false, id);
	});

	// Navigasi back/forward browser
	window.onpopstate = e => {
		loadRoute((e.state && e.state.route) || "dashboard", false, e.state?.id || "");
	};
</script>
<!-- end content-route  -->