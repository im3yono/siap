<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
  Mata Pelajaran
</div>

<div class="row">
  <div class="col-auto">
    <button class="btn btn-primary" id="tambahData" onclick="viewData('add')"><i class="bi bi-plus-lg"></i> Tambah Data</button>
  </div>
  <div class="col-auto">
    <!-- <button data-route="up_staf" data-id="tendik" type="button" class="btn btn-outline-primary"><i class="bi bi-upload"></i> Upload Data</button> -->
  </div>
</div>



































<!-- Modal -->
<div class="modal fade" id="d_tendik">
  <div class="modal-dialog  modal-dialog-scrollable" id="size">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="d_tendikLabel"></h1>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <div id="viewDataStaf"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
        <button data-route="edt_staf" data-id="" class="btn btn-info" id="md_edit" data-bs-dismiss="modal"></i> <i class="bi bi-pencil"></i> Edit</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  function viewData(title = '', id = '', size = '') {
    $('#size').addClass(size);
    if (title == 'edt') {
      $('#d_tendik').modal('show');
      $('#d_tendikLabel').text('Edit Data Kelas');
      $('#simpan').show();
      $('#md_edit').hide();
    } else if (title == 'edt' && id != '') {
      $('#d_tendik').modal('show');
      $('#d_tendikLabel').text('Edit Data Kelas');
      $('#simpan').hide();
      $('#md_edit').show();
      $('#md_edit').attr('data-id', id);
    }
    // $.ajax({
    // 	type: 'POST',
    // 	url: 'app/modal/m_staf.php',
    // 	data: {
    // 		id: id
    // 	},
    // 	success: function(data) {
    // 		$('#viewDataStaf').html(data);
    // 	}
    // });
  }
</script>