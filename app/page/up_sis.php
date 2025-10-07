<?php
require_once "../config/server.php";
require_once "../assets/vendor/autoload.php";
?>





<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
	<div class="col-auto "><button onclick="history.go(-1);" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</button></div> Upload File Data Siswa
</div>
<div class="row mt-3 p-3">
	<div class="col-12">
		<div class="card card-outline card-warning">
			<div class="card-header">
				<h3 class="card-title">Download Format Upload</h3>
				<!-- /.card-tools -->
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<div class="row">
					<div class="col-auto">
						<img src="assets/img/Ms_Excel.png" alt="Ms_Excel" style="width: 120px; height: 120px;">
					</div>
					<div class="col">
						<p>Silahkan download format upload data siswa pada link dibawah ini: <strong>Jangan melakukan perubahan pada struktur file agar proses upload berjalan dengan baik.</strong></p>
						<button onclick="window.location.href='app/file/fu_data siswa.xlsx'" class="btn btn-success">
							<i class="bi bi-download"></i> Download Format Upload
						</button>
					</div>
				</div>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
</div>
<div class="row border border-dark my-3"></div>
<div class="row g-3">
	<div class="col-auto">
		<div class="input-group">
			<input type="file" class="form-control" id="up_sis" name="up_sis" accept=".xlsx">
			<button class="btn btn-outline-primary" type="button" id="btn_up_sis" onclick="upData()">Upload</button>
		</div>
	</div>
	<div class="col-12">
		<div class="progress">
			<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
		</div>
	</div>
</div>

<script>
	function upData() {
		let file = $("#up_sis").prop("files")[0];
		if (!file) {
			alert("Pilih file terlebih dahulu!");
			return;
		}
		let formData = new FormData();
		formData.append("file", file);

		$.ajax({
			type: "POST",
			url: "app/proses/up_dsis.php",
			data: formData,
			processData: false,
			contentType: false,
			xhr: function() {
				let xhr = new XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(event) {
					if (event.lengthComputable) {
						let percentComplete = (event.loaded / event.total) * 100;
						$(".progress-bar").css("width", percentComplete + "%");
						$(".progress-bar").attr("aria-valuenow", percentComplete);
						$(".progress-bar").text(Math.round(percentComplete) + "%");
					}
				}, false);
				return xhr;
			},
			success: function(response) {
				// console.log(response);
				setTimeout(() => {
					Swal.fire("Sukses", response, "success");
				}, 1000);
			},
			error: function() {
				Swal.fire("Error", "Terjadi kesalahan saat mengupload file.", "error");
				$(".progress-bar").css("width", "0%");
				$(".progress-bar").attr("aria-valuenow", 0);
				$(".progress-bar").text("0%");
			}
		});
	}
</script>