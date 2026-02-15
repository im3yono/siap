<?php
require_once "../../config/server.php";

$prd = $_POST['prd'] ?? '';



if ($prd == 'add'): ?>
	<form method="post" id="f_jdwl" enctype="multipart/form-data">
		<div class="row g-2">
			<div class="col-12 col-6">Nama</div>
			<div class="col-12 col-6">table</div>
		</div>
	</form>

<?php
endif;

?>