<?php
require_once '../../config/server.php'; // sesuaikan path


$id_kls = $_POST['id_kls'] ?? '';

$d_sis = db_Proses($pdo_conn, "SELECT * FROM tb_dsis WHERE kls = ? ORDER BY nm ASC", [$id_kls]);
?>
<tr class="table-info">
	<td colspan="" align="end">#</td>
	<td colspan="2" align="end">Terapkan ke semua siswa >></td>
	<td colspan="">
		<select name="hdr" id="hdr" class="form-select form-select-sm">
			<option value="" selected disabled>-- Pilih --</option>
			<option value="H">Hadir</option>
			<option value="I">Izin</option>
			<option value="S">Sakit</option>
			<option value="A">Alpa</option>
		</select>
	</td>
	<td colspan=""><input type="number" name="nil" id="nil" class="form-control form-control-sm" style="width: 100px; text-align: right;" value="0"></td>
	<td><input type="text" name="k_sis" id="k_sis" class="form-control form-control-sm" style="width: 300px;"></td>
</tr>
<?php
while ($r = $d_sis->fetch(PDO::FETCH_ASSOC)):
	$data[] = $r;
endwhile;
foreach ($data as $i => $r): ?>
	<tr>
		<td align="end"><?= $notbl++; ?></td>
		<td>
			<input type="hidden" name="siswa[<?= $i ?>][nipd]" value="<?= $r['nipd']; ?>">
			<?= $r['nipd'] . ' / ' . $r['nisn']; ?>
		</td>
		<td><?= $r['nm']; ?></td>
		<td>
			<select name="siswa[<?= $i ?>][hadir]" class="form-select form-select-sm" style="width: 100px;">
				<option value="" selected disabled>-- Pilih --</option>
				<option value="H">Hadir</option>
				<option value="I">Izin</option>
				<option value="S">Sakit</option>
				<option value="A">Alpa</option>
			</select>
		</td>
		<td>
			<input type="number" name="siswa[<?= $i ?>][nilai]" class="form-control form-control-sm"
				style="width: 100px; text-align: right;" value="0">
		</td>
		<td>
			<input type="text" name="siswa[<?= $i ?>][ket]" class="form-control form-control-sm"
				style="width: 300px;" maxlength="30">
		</td>
	</tr>
<?php endforeach; ?>
?>
<script>
	$(document).ready(function() {
		$('#hdr').on('change', function() {
			var hadirValue = $(this).val();
			$('select[name^="siswa["][name$="[hadir]"]').val(hadirValue);
		})
	})
	$('#nil').on('input', function() {
		var nilValue = $(this).val();
		$('input[name^="siswa["][name$="[nilai]"]').val(nilValue);
	});
	$('#k_sis').on('input', function() {
		var ketValue = $(this).val();
		$('input[name^="siswa["][name$="[ket]"]').val(ketValue);
	});
</script>