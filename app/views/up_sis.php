<?php
require_once "../config/server.php";
require_once "../assets/vendor/autoload.php";
?>





<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
	<div class="col-auto "><button data-page="v_siswa" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</button></div> Upload File Data Siswa
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
						<button onclick="window.location.href='app/file/format upload data siswa.xlsx'" class="btn btn-success">
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
<div class="row border border-dark"></div>
<div class="row">

</div>