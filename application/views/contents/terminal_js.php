<!-- echarts -->
<script src="<?php echo base_url('assets/libs/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		function main(input = 'start_date=&end_date=') {

			// total penerimaan per pungutan
			$.ajax({
				url: "terminal_penerimaan_total",
				method: "POST",
				type: 'json',
				data: input,
				success: function(result) {
					$('#table-penerimaan-total tbody').empty();
					$.each(result, function (key, val) {
						var data = `
							<tr>
								<td>${key}</td>
								<td>${val}</td>
							</tr>
						`;
						$('#table-penerimaan-total tbody').append(data);
					})
				}
			});

			// chart jumlah penerimaan pib bulanan
			$.ajax({
				url: "terminal_penerimaan_all",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-penerimaan'));

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

			// total penerimaan per dokumen
			$.ajax({
				url: "terminal_penerimaan_dok_total",
				method: "POST",
				type: 'json',
				data: input,
				success: function(result) {
					$('#table-penerimaan-dokumen-total tbody').empty();
					$.each(result, function (key, val) {
						var data = `
							<tr>
								<td>${key}</td>
								<td>${val}</td>
							</tr>
						`;
						$('#table-penerimaan-dokumen-total tbody').append(data);
					})
				}
			});

			// chart jumlah penerimaan terminal bulanan per dokumen
			$.ajax({
				url: "terminal_penerimaan_dok_all",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-penerimaan-dokumen'));

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

			// chart perbandingan netto - bm
			$.ajax({
				url: "terminal_penerimaan_berat",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {

					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-netto-bm'));

					// Get data from ajax
					var option = data;

					// Load data into the ECharts instance 
					myChart.setOption(option, true);

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

			// total jumlah per dokumen
			$.ajax({
				url: "terminal_jumlah_dok_total",
				method: "POST",
				type: 'json',
				data: input,
				success: function(result) {
					$('#table-dokumen-total tbody').empty();
					$.each(result, function (key, val) {
						var data = `
							<tr>
								<td>${key}</td>
								<td>${val}</td>
							</tr>
						`;
						$('#table-dokumen-total tbody').append(data);
					})
				}
			});

			// chart perbandingan netto - bm
			$.ajax({
				url: "terminal_jumlah_dok_bulan",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {

					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-dokumen-bulan'));

					// Get data from ajax
					var option = data;

					// Load data into the ECharts instance 
					myChart.setOption(option, true);

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

			// table detail penerimaan - berat
			$.ajax({
				url: "terminal_penerimaan_berat_detail",
				method: "POST",
				type: 'json',
				data: input,
				success: function(result) {
					$('#tbl-last-detail').html(result['year']['last']);
					$('#tbl-curr-detail').html(result['year']['curr']);
					$('#table-netto-bm').DataTable({
						"destroy": true,
						"paging": false,
						"searching": false,
						"bInfo" : false,
						"data": result['value'],
						"columns": [
							{ 
								"data": "order",
								"visible": false
							},
							{ "data": "bulan" },
							{ 
								"data": "bm_last",
								"defaultContent": ""
							},
							{ 
								"data": "bm_last_kum",
								"defaultContent": ""
							},
							{ 
								"data": "nilai_last",
								"defaultContent": ""
							},
							{ 
								"data": "nilai_last_kum",
								"defaultContent": ""
							},
							{ 
								"data": "berat_last",
								"defaultContent": ""
							},
							{ 
								"data": "berat_last_kum",
								"defaultContent": ""
							},
							{ 
								"data": "bm_curr",
								"defaultContent": ""
							},
							{ 
								"data": "bm_curr_kum",
								"defaultContent": ""
							},
							{ 
								"data": "nilai_curr",
								"defaultContent": ""
							},
							{ 
								"data": "nilai_curr_kum",
								"defaultContent": ""
							},
							{ 
								"data": "berat_curr",
								"defaultContent": ""
							},
							{ 
								"data": "berat_curr_kum",
								"defaultContent": ""
							}
							
						],
						"order": [[ 0, "asc" ]]
					});
					// console.log(result);
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