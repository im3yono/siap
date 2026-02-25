// Fungsi Hanya huruf dan angka
function inKarakter(input) {
  input.value = input.value.replace(/[^a-zA-Z0-9]/g, "");
}

// Notifikasi mengguanakan SweetAlert2
function notif(icon, title, text, konfirmasi = "", page = "") {
  if (konfirmasi == "") {
    Swal.fire({
      icon: icon,
      title: title,
      text: text,
    });
  } else {
    Swal.fire({
      icon: icon,
      title: title,
      text: text,
    }).then((result) => {
      if (result.isConfirmed) {
        if (page == "") {
          r_halaman();
        } else {
          window.location = "?route=" + page;
        }
      }
    });
  }
}

// Fungsi preview gambar fleksibel
function imagePreview(idInput, idImg) {
  const $input = $(idInput);
  const $img = $(idImg);
  const originalSrc = $img.attr("src") || "";

  $input.on("change", function () {
    const files = this.files;

    // Jika tidak ada file, kembalikan ke gambar awal
    if (!files || !files.length) {
      $img.attr("src", originalSrc);
      return;
    }

    const file = files[0];

    // Validasi tipe file
    if (!file.type.match("image.*")) {
      notif("error", "Gagal!", "File harus berupa gambar (jpg, jpeg, png).");
      $(this).val("");
      $img.attr("src", originalSrc);
      return;
    }

    // Tampilkan preview
    const reader = new FileReader();
    reader.onload = function (e) {
      $img.attr("src", e.target.result);
    };
    reader.readAsDataURL(file);
  });
}

function loadRoute(route, pushState = true, id = "") {
  $.post("app/route.php", {
    route,
    id,
  })
    .done((res) => {
      $("#content-route").html(res.trim() || "<h3 class='text-center text-muted mt-5'>Dalam tahap pengembangan<br>Halaman belum dapat di tampilkan</h3>");

      if (pushState) {
        history.pushState(
          {
            route,
            id,
          },
          "",
          `?route=${route}${id ? "&id=" + id : ""}`,
        );
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
          },
        });
      }
      if ($("#table2").length) {
        new simpleDatatables.DataTable("#table2", {
          perPageSelect: [5, 10, 25, 50, 100],
          perPage: 10,
          labels: {
            placeholder: "Cari...",
            perPage: " Data per halaman",
            noRows: "Tidak ada data yang ditemukan",
            info: "Menampilkan {start}/{end} dari {rows} Data",
          },
        });
      }

      updateActiveMenu(route);
      hideLoading();
    })
    .fail(() => $("#content-route").html("Terjadi kesalahan memuat halaman."));
  // console.clear();
  // console.log('SIAP (Sistem Infomasi Administrasi Pendidikan)');
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
    if (width < 90) {
      // tahan di 90%, sisanya nunggu selesai
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
    treeview.show().prev(".nav-link").removeClass("collapsed").parent("li").addClass("menu-open");
  }
}

// Proses Navigasi Halaman
$(document).on("click", "nav a, button[data-route]", function (e) {
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

function r_halaman() {
  const urlParams = new URLSearchParams(window.location.search);
  const route = urlParams.get("route") || "dashboard";
  const id = urlParams.get("id") || "";
  loadRoute(route, false, id);
}

// Navigasi back/forward browser
window.onpopstate = (e) => {
  loadRoute((e.state && e.state.route) || "dashboard", false, e.state?.id || "");
};

// Fungsi khusus untuk tombol kembali
$(document).on("click", "button[data-back]", function (e) {
  e.preventDefault();
  window.history.back();
});
