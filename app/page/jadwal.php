<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
	Jadwal Mengajar
</div>

<div class="row">
	<div class="col">
		<button type="button" class="btn btn-outline-primary" onclick="viewData('add')"><i class="bi bi-plus-lg"></i> Tambah Jadwal</button>
	</div>
	<div class="col"></div>
</div>











<!-- Modal -->
<div class="modal fade" id="md_jdwl">
	<div class="modal-dialog modal-xl modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="d_title"></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="viewData"></div>
			</div>
			<div class="modal-footer">
				<!-- <button data-route="edt_staf" data-id="" class="btn btn-info" id="md_edit" data-bs-dismiss="modal"></i> <i class="bi bi-pencil"></i> Edit</button> -->
				<button type="button" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>




<!-- JavaScript -->
<script>
	function viewData(prd) {
		$('#md_jdwl').modal('show');
		// $('#md_edit').attr('data-id', id);
		if (prd == 'add') {
			$('#d_title').text('Tambah Data Jadwal Mengajar');
			$('.modal-dialog').addClass('modal-lg');
			$('.btn-close').hide();
		}
		$.ajax({
			type: 'POST',
			url: 'app/modal/m_jadwal',
			data: {
				prd: prd
			},
			success: function(data) {
				$('#viewData').html(data);
			}
		});
	}
</script>