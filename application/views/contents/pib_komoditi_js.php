<!-- echarts -->
<script src="<?php echo base_url('assets/libs/echarts-4.9.0/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts-4.9.0/theme/inspired.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		function DisplayChart(chartName, data) {
			// Initialize after dom ready
			var myChart = echarts.init(document.getElementById(chartName));

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
		};

		function DisplayTable(tableName, data) {
			tableElement = document.getElementById(tableName);
			$(tableElement).DataTable({
				"destroy": true,
				"scrollX": true,
				'fixedColumns': {
					'leftColumns': 1
				},
				"data": data,
				"columns": [
					{ "data": "hs" },
					{ "data": "jml_pib" },
					{ "data": "nilai" },
					{ "data": "bm" },
					{ "data": "ppn" },
					{ "data": "pph" },
					{ "data": "ppnbm" },
					{ "data": "bm_bebas" },
					{ "data": "ppn_bebas" },
					{ "data": "pph_bebas" },
					{ "data": "ppnbm_bebas" },
					{ "data": "bm_tangguh" },
					{ "data": "ppn_tangguh" },
					{ "data": "pph_tangguh" },
					{ "data": "ppnbm_tangguh" },
					{ "data": "bm_dp" },
					{ "data": "ppn_dp" },
					{ "data": "pph_dp" },
					{ "data": "ppnbm_dp" }
				],
				"columnDefs": [
					{ "searchable": false, "targets": [ 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18 ] },
					{ "className": "text-right", "targets": [ 4,5,6,8,9,10,12,13,14,16,17 ] },
					{ "className": "border-left", "targets": [ 0 ] },
					{ "className": "border-left text-right", "targets": [ 1,2,3,7,11,15 ] },
					{ "className": "border-right text-right", "targets": [ 18 ] },
					{ "render": $.fn.dataTable.render.number('.', ',', 2, ''), "targets": [ 2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18 ] }
				],
				"order": [[ 2, "desc" ]]
			});
		};

		$.ajax({
			url: "get_komoditi",
			method: "POST",
			// data: input,
			success: function(data) {
				DisplayChart('chart-pie-nilai', data["pieHsNilai"]);
				DisplayChart('chart-stack-nilai', data["stackHsNilai"]);
				DisplayChart('chart-pie-bm', data["pieHsBm"]);
				DisplayChart('chart-stack-bm', data["stackHsBm"]);
				DisplayTable('table-data-hs', data["tableHs"]);
			}
		});

	});
</script>