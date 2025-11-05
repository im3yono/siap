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
