<!-- echarts -->
<script src="<?php echo base_url('assets/libs/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/macarons2.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/infographic.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/vintage.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/shine.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/roma.js'); ?>"></script>

<script src="<?php echo base_url('assets/libs/echarts/world.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		function main(input = 'start_date=&end_date=') {

			// chart jumlah peb berdasarkan jenis ekspor
			$.ajax({
				url: "jenis_ekspor",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-jenis'), 'macarons');

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

			// chart jumlah peb berdasarkan kategori ekspor
			$.ajax({
				url: "kategori_ekspor",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-kategori'), 'macarons');

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

			// chart perbandingan devisa - netto
			$.ajax({
				url: "nilai_tonase",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-tonase'), 'macarons');

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

			// chart rata-rata devisa/netto
			$.ajax({
				url: "rata_nilai_tonase",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-rata-tonase'), 'macarons');

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

			// chart eksportir terbesar
			$.ajax({
				url: "eksportir",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-eksportir'), 'macarons');

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

			// map negara penerima
			$.ajax({
				url: "negara_penerima",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-negara'), 'macarons');

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

			// chart negara penerima terbesar
			$.ajax({
				url: "negara_penerima_top",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-negara-top'), 'macarons');

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

		$('#form_filter').submit(function(event) {
			
			event.preventDefault();
			var input = $('#form_filter').serialize();
			main(input);
		});

	}); 
</script>