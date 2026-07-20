	<?php require_once "../config/server.php"; ?>

	<style>
		.table-sync {
			--bs-table-color-type: initial;
			--bs-table-bg-type: initial;
			--bs-table-color-state: initial;
			--bs-table-bg-state: initial;
			--bs-table-color: var(--bs-emphasis-color);
			--bs-table-bg: var(--bs-body-bg);
			--bs-table-border-color: var(--bs-border-color);
			--bs-table-accent-bg: transparent;
			--bs-table-striped-color: var(--bs-emphasis-color);
			--bs-table-striped-bg: rgba(var(--bs-emphasis-color-rgb), 0.05);
			--bs-table-active-color: var(--bs-emphasis-color);
			--bs-table-active-bg: rgba(var(--bs-emphasis-color-rgb), 0.1);
			--bs-table-hover-color: var(--bs-emphasis-color);
			--bs-table-hover-bg: rgba(var(--bs-emphasis-color-rgb), 0.075);
			width: 100%;
			margin-bottom: 1rem;
			vertical-align: top;
			border-color: var(--bs-table-border-color);
		}

		.table-sync> :not(caption)>*>* {
			padding: 0.5rem 0.5rem;
			color: var(--bs-table-color-state, var(--bs-table-color-type, var(--bs-table-color)));
			background-color: var(--bs-table-bg);
			border-bottom-width: var(--bs-border-width);
			box-shadow: inset 0 0 0 9999px var(--bs-table-bg-state, var(--bs-table-bg-type, var(--bs-table-accent-bg)));
		}

		.table-sync>tbody {
			vertical-align: inherit;
		}

		.table-sync>thead {
			vertical-align: middle;
		}

		table tbody tr td {
			vertical-align: middle;
		}

		.table-responsive th:nth-child(1),
		.table-responsive td:nth-child(1) {
			min-width: 30px;
			text-align: center;
		}

		.table-responsive th:nth-child(2),
		.table-responsive td:nth-child(2) {
			min-width: 100px;
			text-align: center;
		}

		.table-responsive th:nth-child(3),
		.table-responsive td:nth-child(3) {
			min-width: 180px;
			max-width: 230px;
			text-align: start;
		}

		.table-responsive th:nth-child(4),
		.table-responsive td:nth-child(4) {
			min-width: 150px;
			text-align: start;
		}

		.table-responsive th:nth-child(5),
		.table-responsive td:nth-child(5) {
			min-width: 120px;
			text-align: start;
		}

		.table-responsive th:nth-child(6),
		.table-responsive td:nth-child(6) {
			min-width: 50px;
			text-align: center;
		}

		.table-responsive th:nth-child(7),
		.table-responsive td:nth-child(7) {
			min-width: 50px;
			text-align: center;
		}

		.table-responsive th:nth-child(8),
		.table-responsive td:nth-child(8) {
			min-width: 100px;
			text-align: center;
		}

		.table-responsive th:nth-child(9),
		.table-responsive td:nth-child(9) {
			min-width: 150px;
			max-width: 150px;
			text-align: center;
		}

		.table-responsive th:nth-child(10),
		.table-responsive td:nth-child(10) {
			min-width: 80px;
			text-align: center;
		}

		.table-responsive th:nth-child(11),
		.table-responsive td:nth-child(11) {
			min-width: 70px;
			max-width: 70px;
			text-align: center;
		}

		.table-responsive th:nth-child(12),
		.table-responsive td:nth-child(12) {
			min-width: 70px;
			max-width: 70px;
			text-align: center;
		}

		.table-responsive th:nth-child(13),
		.table-responsive td:nth-child(13) {
			max-width: 155px;
			text-align: center;
		}

		.table-responsive th:nth-child(14),
		.table-responsive td:nth-child(14) {
			min-width: 70px;
			text-align: center;
		}
	</style>
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
		<div class="col-auto ">
			<button  class="btn btn-outline-dark" data-back><span class="myicon myicon-arrow_back"></span> Kembali</button>
		</div>
		<div class="col">
			Singkronisasi Data Peserta Asesmen</div>
	</div>


	<div class="row my-3 mx-2 p-2 border-bottom">
		<div class="col-auto">
			<div class="input-group mb-3">
				<label class="input-group-text" for="kls">Kelas</label>
				<select class="form-select" id="kls" name="kls">
					<option value="all">Semua</option>
					<?php
					$tkt = db_Proses($pdo_conn, "SELECT tkt FROM tb_kls GROUP BY tkt ORDER BY tkt ASC");
					while ($r = $tkt->fetch(PDO::FETCH_ASSOC)):
						echo '<option value="' . $r['tkt'] . '">' . $r['tkt'] . '</option>';
					endwhile; ?>
				</select>
			</div>
		</div>
		<div class="col-auto">
			<div class="input-group mb-3">
				<label class="input-group-text" for="rombel">Rombel</label>
				<select class="form-select" id="rombel" name="rombel">
					<option value="all">Semua</option>
					<?php
					$kls = db_Proses($pdo_conn, "SELECT kls FROM tb_kls WHERE sts_kls = ? ORDER BY kls ASC", ['R']);
					while ($r = $kls->fetch(PDO::FETCH_ASSOC)):
						echo '<option value="' . $r['kls'] . '">' . $r['kls'] . '</option>';
					endwhile; ?>
				</select>
			</div>
		</div>
		<div class="col-auto">
			<button type="button" class="btn btn-primary" id="tampil">Tampilkan</button>
		</div>
		<div class="col-auto" id="loading" style="display: none;">
			<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span>
			</div>
		</div>
	</div>

	<div id="dataPeserta"></div>


	<!-- Modal -->
	<div class="modal fade" id="modal">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="md_title">Modal title</h1>
					<!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
				</div>
				<div class="modal-body">
					<div id="isi"></div>
				</div>
				<!-- <div class="modal-footer">
				<button type="button" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
			</div> -->
			</div>
		</div>
	</div>

	<script>
		function modalShow(title, isi, data = []) {
			$('#modal').modal('show');
			$('#md_title').text(title);

			if (isi == 'NSRIP') {
				$('#modal').addClass('modal-lg');
			} else {
				$('#modal').removeClass('modal-lg');
			}

			$.ajax({
				url: 'app/modal/m_mytbk_ps',
				type: 'POST',
				data: {
					md: isi,
					data: data
				},
				success: function(res) {
					$('#isi').html(res);
				}
			})
		}

		$('#kls').change(function() {
			let rombel = $(this).val();
			$.ajax({
				url: 'app/proses/pr_mytbk',
				type: 'POST',
				data: {
					prd: 'get_kls',
					rombel: rombel
				},
				success: function(res) {
					$('#rombel').html(res);
				}
			})
		})

		$('#tampil').click(function() {
			let kls = $('#kls').val();
			let rombel = $('#rombel').val();

			$('#loading').show();

			$.ajax({
				url: 'app/table/t_mytbk_ps',
				type: 'POST',
				data: {
					prd: 'd_peserta',
					kls: kls,
					rombel: rombel
				},
				success: function(res) {
					$('#loading').hide();
					$('#dataPeserta').html(res);
				},
				error: function() {
					$('#dataPeserta').html('<div class="alert alert-danger">Gagal memuat data</div>');
				}
			})
		})
	</script>