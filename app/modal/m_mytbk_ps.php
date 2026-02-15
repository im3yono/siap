<?php


$prd = $_POST['prd'];


if ($prd == 'sycn'): ?>

  <form method="post">
		<div class="row gap-3 justify-content-center">
			<div class="col-11">
				<label for="syn" class="form-label">Data Singkron</label>
				<select class="form-select" name="syn" id="syn" required>
					<option selected disabled value="">--Pilih--</option>
					<option value="1">Semua siswa</option>
					<option value="2">Semua siswa kecuali tingkat akhir</option>
					<option value="3">Semua siswa tingkat akhir</option>
					<!-- <option value="3">Ujian Semester Ganjil</option>
					<option value="4">Ujian Semester Ganap</option> -->
				</select>
			</div>
			<div class="col-11">
				<label for="no_ps" class="form-label">Format Nama Pengguna</label>
				<input type="text" class="form-control" name="no_ps" id="no_ps" placeholder="isi awalan nama pengguna tanpa spasi" required>
			</div>
			<div class="col-12 text-center pt-3">
				<button type="button" class="btn btn-outline-primary">Kirim</button>
			</div>
		</div>
  </form>


<?php
endif;
