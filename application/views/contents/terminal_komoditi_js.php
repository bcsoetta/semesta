<!-- echarts -->
<script src="<?php echo base_url('assets/libs/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		function main(input = 'start_date=&end_date=') {

			// table detail penerimaan - berat
			$.ajax({
				url: "terminal_komoditi_summary",
				method: "POST",
				type: 'json',
				data: input,
				success: function(result) {
					$('.tbl-last-detail').html(result['year']['last']);
					$('.tbl-this-detail').html(result['year']['this']);
					$('#table-komoditi').DataTable({
						"data": result['value'],
						"columnDefs": [
							{
								"targets": [1,2,3,4,5,6,7,8],
								"createdCell" : function (td, cellData, row, col) {
									$(td).css('textAlign', 'right');
									$(td).css('padding-right', '50px');
								}
							},
							{
								"targets": [3,4,5,6,7,8],
								"render": $.fn.dataTable.render.number('.', ',', 2)
							}
						],
						"columns": [
							{ "data": "kategori" },
							{ "data": "jml_dok_last" },
							{ "data": "jml_dok" },
							{ "data": "berat_last" },
							{ "data": "berat" },
							{ "data": "nilai_pabean_last" },
							{ "data": "nilai_pabean" },
							{ "data": "bm_last" },
							{ "data": "bm" }
						],
						"order": [[ 2, "desc" ]]
					});
				}
			});

		}

		main();

		$('#form_imp').submit(function(event) {
			event.preventDefault();
			var input = $('#form_imp').serialize();
			main(input);
		});

}); 
</script>