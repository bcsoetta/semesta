<!-- echarts -->
<script src="<?php echo base_url('assets/libs/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		jenis_chart = [
			{
				'jenis': 'bm',
				'chart': 'chart-kategori-bm-bulan'
			},
			{
				'jenis': 'nilai_pabean',
				'chart': 'chart-kategori-nilai-bulan'
			},
			{
				'jenis': 'jml_dok',
				'chart': 'chart-kategori-dok-bulan'
			},
			{
				'jenis': 'berat',
				'chart': 'chart-kategori-berat-bulan'
			}
		];

		start_date = '';
		end_date = '';
		// console.log(start_date, end_date);

		function main(start_date, end_date) {

			// table detail penerimaan - berat
			$.ajax({
				url: "terminal_komoditi_summary",
				method: "POST",
				type: 'json',
				data: {'start_date':start_date, 'end_date':end_date},
				success: function(result) {
					$('.tbl-last-detail').html(result['year']['last']);
					$('.tbl-this-detail').html(result['year']['this']);
					$('#table-komoditi').DataTable({
						"destroy": true,
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
							{ "data": "bm" },
							{ 
								"data": null, 
								"render": function function_name(data, type, row) {
									button_dtl = "<a id='" + data.kategori + "' class='detil-barang'><i class='fa fa-line-chart text-primary' data-toggle='modal' data-target='#modal-detail'></i></a>";
									return button_dtl;
								},
								"createdCell" : function (td, cellData, row, col) {
									$(td).css('textAlign', 'center');
								}
							},
						],
						"order": [[ 2, "desc" ]]
					});
				}
			});

			$.each(jenis_chart, function (key,value) {
				// chart kategori bulanan
				$.ajax({
					url: "terminal_kategori_bulan",
					method: "POST",
					type: 'json',
					data: {'jenis': value['jenis'], 'start_date':start_date, 'end_date':end_date},
					success: function(data) {
						// Initialize after dom ready
						var myChart = echarts.init(document.getElementById(value['chart']));

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
			});

		}

		main(start_date, end_date);

		$('#form_imp').submit(function(event) {
			event.preventDefault();
			start_date = $('input[name="start_date"]').val();
			end_date = $('input[name="end_date"]').val();
			main(start_date, end_date);
		});

		$(document).on('click', '.detil-barang', function(e) {
			e.preventDefault();
			console.log('click', start_date);
			komoditi = $(this).attr('id');

			// Chart komoditi
			$.ajax({
				url: 'terminal_komoditi_detail',
				method: 'POST',
				data: {'komoditi': komoditi, 'start_date':start_date, 'end_date':end_date},
				success: function (data) {
					$('#modal-detail .modal-title').html('Detail ' + komoditi);

					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-kategori-detil'));

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

			// Table komoditi
			$.ajax({
				url: 'terminal_komoditi_table',
				method: 'POST',
				data: {'komoditi': komoditi, 'start_date':start_date, 'end_date':end_date},
				success: function (result) {
					console.log(result);
					$('#table-komoditi-detail').DataTable({
						"destroy": true,
						"data": result,
						"pageLength": 5,
						"columns": [
							{ "data": "dok" },
							{ "data": "terminal" },
							{ "data": "no_cd_pibk" },
							{ "data": "tgl" },
							{ "data": "urbar" }
						],
						"order": [[ 3, "desc" ], [ 2, "desc" ]]
					})
				}
			})
		});

}); 
</script>