<!-- echarts -->
<script src="<?php echo base_url('assets/libs/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/macarons2.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/infographic.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/vintage.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/shine.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/roma.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		function main(input = 'start_date=&end_date=') {

			$.ajax({
				url: "penerimaan_total",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					$.each(data, function(key, value) {
						$('#nilai_'.concat(key)).html(value);
					})
				}
			});

			// chart jumlah penerimaan pib bulanan
			$.ajax({
				url: "penerimaan_bulan",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-penerimaan'), 'macarons');

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

		  // chart penerimaan importir terbesar
			$.ajax({
		    url: "penerimaan_top",
		    method: "POST",
		    type: 'json',
		    data: input,
		    success: function(data) {
		      // Initialize after dom ready
		      var myChart = echarts.init(document.getElementById('chart-imp'), 'macarons');
					
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

		  // chart bea masuk importir terbesar
			$.ajax({
		    url: "bm_top",
		    method: "POST",
		    type: 'json',
		    data: input,
		    success: function(data) {
		      // Initialize after dom ready
		      var myChart = echarts.init(document.getElementById('chart-bm'), 'macarons');
					
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
			var input = $('#form_imp').serialize();
			main(input);
		});

	}); 
</script>