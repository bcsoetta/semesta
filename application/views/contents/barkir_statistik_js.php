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

			$.ajax({
				url: "jalur_total",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					$.each(data, function( index, value ) {
						$('#' + index).html(value);
					});
				}
			});

			// chart jumlah barkir bulanan
			$.ajax({
				url: "jalur",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-jalur'), 'macarons');

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

			// chart jumlah tonase dan nilai pib
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

			// chart rata-rata devisa per tonase
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

			// chart jumlah barang kiriman per pjt
			$.ajax({
		    url: "pjt",
		    method: "POST",
		    type: 'json',
		    data: input,
		    success: function(data) {
		      // Initialize after dom ready
		      var myChart = echarts.init(document.getElementById('chart-pjt'), 'macarons');
					
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

		  // chart jumlah barang kiriman per negara eksportir
			$.ajax({
		    url: "negara_pengirim",
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

		  // chart negara eksportir terbesar
			$.ajax({
		    url: "negara_pengirim_top",
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

		  console.log(input);

		}

		main();

		$('#form_imp').submit(function(event) {
			
			event.preventDefault();
			var input = $('#form_imp').serialize();
			main(input);
		});

	});
</script>