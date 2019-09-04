<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/moment/moment.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#table-pfpd-data').DataTable({
			"destroy": true,
			"ajax": {
				"url": 'get_eksportir',
				"type": "POST",
				"dataSrc": ''
			},
			"columns": [
				{ "data": "npwp" },
				{ "data": "nama" },
				{ "data": "jml_dok" }
			],
			"order": [[2, "desc"]]
		});
	});
</script>