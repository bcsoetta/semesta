<script src="<?php echo base_url('assets/libs/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/macarons2.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/infographic.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/vintage.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/shine.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/echarts/theme/roma.js'); ?>"></script>

<script src="<?php echo base_url('assets/libs/jquery/footable/dist/footable-3.1.5.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		function main(input = 'start_date=&end_date=') {

			$.ajax({
				url: "piutang_total",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					$('#table-piutang-total').footable(data);
				}
			});

			// chart jumlah sptnp bulanan
			$.ajax({
				url: "piutang_all",
				method: "POST",
				type: 'json',
				data: input,
				success: function(data) {
					// Initialize after dom ready
					var myChart = echarts.init(document.getElementById('chart-piutang-all'), 'macarons');

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

			// List jumlah piutang tiap status
			$.ajax({
				url: "status_piutang",
				method: "POST",
				type: "json",
				data: input,
				success: function(data) {
					$.each(data, function( index, value ) {
						$('#stat-piutang ' + '#stat' + index).html(value + ' dokumen');
					});
				}
			});

			console.log(input);

		}

		main();

		$('#form_imp').submit(function(event) {
			event.preventDefault();
			date = $('#form_imp').serializeArray();
			main(date);
		});

		$('#stat-piutang .fa-list').click(function(e) {
			e.preventDefault();
			var id = $(this).parent().siblings(":last").attr("id");
			var status = id.replace("stat", "");
			if (window.date === undefined) {
				var date = {start_date: '', end_date: ''};
			} else {
				var date = {start_date: window.date[0]['value'], end_date: window.date[1]['value']};
			};
			var param = { status: status, date: date };

			console.log(param);

			$.ajax({
				url: "list_piutang",
				method: "POST",
				type: "json",
				data: param,
				success: function(data) {
					$('#table-list-piutang').footable(data);
				}
			})

		})

	}); 
</script>