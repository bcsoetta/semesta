<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/moment/moment.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		startYear = new Date(new Date().getFullYear(), 0, 1);
		dateNow = Date.now();

		function convertDate(inputFormat) {
			function pad(s) { return (s < 10) ? '0' + s : s; }
			var d = new Date(inputFormat);
			return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
		}

		function dmyToYmd(dmyDate) {
			var ymdDate = dmyDate.split("/").reverse().join("-");
			return ymdDate;
		}

		sy = convertDate(startYear);
		dn = convertDate(dateNow);

		$('#form_filter #start_date').val(sy);
		$('#form_filter #end_date').val(dn);

		function displayTable(jalur = '0', start_date = sy, end_date = dn) {
			$('#table-pfpd-data').DataTable({
				"destroy": true,
				"ajax": {
					"url": 'pfpd_data',
					"type": "POST",
					"data": {
						"jalur": jalur,
						"start_date": start_date,
						"end_date": end_date
					},
					"dataSrc": ''
				},
				"columns": [
					{ "data": "Nama" },
					{ "data": "Jml PIB" },
					{ "data": "Jml SPTNP" },
					{ "data": "Hit Rate" },
					{ "data": "BM Hit", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' ) }
				]
			});
		}
		
		$('#form_filter').submit(function(event) {
			event.preventDefault();
			var jalur = document.getElementById("form_filter")[0].value;
			var start_date = document.getElementById("form_filter")[1].value;
			var end_date = document.getElementById("form_filter")[2].value;

			var sd = dmyToYmd(start_date);
			var ed = dmyToYmd(end_date);

			displayTable(jalur, sd, ed);
		});

		displayTable();
	});
</script>