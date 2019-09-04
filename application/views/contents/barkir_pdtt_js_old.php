<!-- echarts -->
<script src="<?php echo base_url('assets/libs/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/macarons2.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/infographic.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/vintage.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/shine.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/roma.js'); ?>"></script>
<!-- footable -->
<script src="<?php echo base_url('assets/libs/jquery/footable/dist/footable-3.1.5.js'); ?>"></script>

<!-- search pdtt -->
<script type="text/javascript">
	$('#src_pdtt').on("paste keyup", function() {
		$.ajax({
			url: "pdtt_search",
			method: "POST",
			data: {
				"pdtt": $('#src_pdtt').val(),
			},
			type: 'json',
			success: function(result) {
				if ($("#src_pdtt").val() == ""){
					$("#src_result").empty();
					$("#src_result").css('display', 'none');	
				} else {
					$("#src_result").empty();
					$("#src_result").css('display', 'block');
					var obj = JSON.parse(result);
					$.each(obj, function(key, val) {
						$("#src_result").append("<div class='src-list' id='" + val.nip + "'>" + val.nip + " - " + val.nama + "</div>");
					});

					$('.src-list').click(function() {
			
						var selected = $(this).html();
						var id = $(this).attr('id');

						$("#src_pdtt").val(selected);
						$("#id_pdtt").val(id);
						$("#src_result").css('display', 'none');
					})
				}
			}
		})
	})
</script>

<script type="text/javascript">
	$(document).ready(function() {
		function pdtt_jalur(input = 'start_date=&end_date=') {
			// chart jumlah barkir bulanan
			$.ajax({
				url: "pdtt_jalur",
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
		}

		function pdtt_penerimaan(input = 'start_date=&end_date=') {
			// chart jumlah tonase dan nilai pib
			$.ajax({
				url: "pdtt_penerimaan",
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
		}

		function pdtt_detil(input = 'start_date=&end_date=') {
			// table detil pdtt
			$.ajax({
				url: "pdtt_detil",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					$('#table-detil tbody').empty();

					$('#table-detil').footable(data);
				}
			});
		}

		$('#form_imp').submit(function(event) {
			event.preventDefault();
			var input = $('#form_imp').serialize();
			pdtt_jalur(input);
			pdtt_penerimaan(input);
			pdtt_detil(input);
		});

	}); 
</script>