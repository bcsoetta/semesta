<script src="<?php echo base_url('assets/libs/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/macarons2.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/infographic.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/vintage.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/shine.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/roma.js'); ?>"></script>

<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		function main(input = 'start_date=&end_date=') {

			// Table penerimaan per bulan
			$('#table-penerimaan-bulan').DataTable({
				"searching" : false,
				"lengthChange": false,
				"paging": false,
				"ordering": false,
				"bInfo": false,
				"columnDefs": [ {
					"targets": "_all",
					"createdCell": function (td, cellData, rowData, row, col) {
						$(td).css('padding', '5px')
					}
				} ],
				"ajax": {
					"url": 'penerimaan_bulanan_table',
					"type": "POST",
					"dataSrc": ''
				},
				"columns": [
					{ "data": "tgl" },
					{ "data": "bm" },
					{ "data": "bm_target" },
					{ "data": "bm_kumulatif" },
					{ "data": "bm_target_kumulatif" }
				],
				"order": [[ 0 ]]
			});

			// chart jumlah sptnp bulanan
			$.ajax({
				url: "penerimaan_bulanan",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-penerimaan-bulan'));

					// Get data from ajax
					var option = data;

					// Load data into the ECharts instance 
					myChart.setOption(option);

					// Resize chart
					$(function () {

						// Resize chart on menu width change and window resize
						$(window).on('resize', resize);
						$(".menu-toggle").on('click', resize);

						// Resize function
						function resize() {
							setTimeout(function() {

								// Resize chart
								myChart.resize();
							}, 200);
						}
					});
				}
			});

		}

		main();

		$('#form_imp').submit(function(event) {
			event.preventDefault();
			date = $('#form_imp').serializeArray();
			main(date);
		});

	}); 
</script>