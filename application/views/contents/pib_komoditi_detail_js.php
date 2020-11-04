<script src="<?php echo base_url('assets/libs/echarts-4.9.0/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/js/moment/moment.js'); ?>"></script>

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

		function main(start='', end='') {
			// Get start date
			if (start == '') {
				var staDate = new Date(new Date().getFullYear(), 0, 1);
				var staDate = moment(staDate).format('YYYY-MM-DD');
			} else {
				var staDate = moment(start, 'DD/MM/YYYY');
				var staDate = moment(staDate).format('YYYY-MM-DD');
			}
			
			// Get end date
			if (end=='') {
				var endDate = new Date();
				var endDate = moment(endDate).format('YYYY-MM-DD');
			} else {
				var endDate = moment(end, 'DD/MM/YYYY');
				var endDate = moment(endDate).format('YYYY-MM-DD');
			}

			// Get HS id
			var urlParams = new URLSearchParams(window.location.search);
			var hsid = urlParams.get('hsid');

			// Get data
			$.ajax({
				url: "../get_detail_komoditi",
				method: "GET",
				data: {
					'hsid': hsid,
					'start_date': staDate, 
					'end_date': endDate
				},
				success: function(data) {
					DisplayChart('chart-bar-nilai', data["barHsNilai"]);
					DisplayChart('chart-bar-bm', data["barHsBm"]);
				}
			});
		}

		main();
	});
</script>