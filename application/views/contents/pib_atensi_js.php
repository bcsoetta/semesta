
<script src="<?php echo base_url('assets/libs/jquery/footable/dist/footable-3.1.5.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/moment/moment.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$.ajax({
			url: "atensi_master",
			method: "POST",
			type: 'json',
			success: function(data) {

				data['columns'][2]['formatter'] = function(value){
					return moment(value).format('DD-MM-YYYY');
				};

				jQuery(function($){
					$('#table-atensi').footable(data);
				});

				$('#table-atensi > tbody  > tr').each(function() {
					$(this).attr({
						"data-toggle": "modal",
						"data-target": "#modal-detil"
					});
				})

			}
		});
	}); 
</script>

<script type="text/javascript">
	$(document).on('click', '#table-atensi a.footable-page-link', function() {
		$('#table-atensi > tbody  > tr').each(function() {
			$(this).attr({
				"data-toggle": "modal",
				"data-target": "#modal-detil"
			});
		});
	})
</script>

<script type="text/javascript">

	$(document).on("click", "#table-atensi tbody tr", function() {
		$('#modal-detil #header-pib #netto-dtl-li').css('display', 'none');

		var input = {
			car: $(this).children('.att_car').text(),
			group: $(this).children('.att_group').text()
		};

		$.ajax({
			url: "atensi_detil",
			method: "POST",
			type: 'json',
			data: input,
			success: function(data) {

				$('#modal-detil #no_aju').html(data['header']['car']);
				$('#modal-detil #no_pib').html(data['header']['NO_PIB'] + ' / ' + data['header']['TGL_PIB']);
				$('#modal-detil #jalur').html(': ' + data['header']['JLR']);
				$('#modal-detil #nm_imp').html(': ' + data['header']['NM_IMP']);
				$('#modal-detil #npwp_imp').html(': ' + data['header']['WP_IMP']);
				$('#modal-detil #netto').html(': ' + data['header']['NETTO_HDR'] + ' kg');
				$('#modal-detil #bruto').html(': ' + data['header']['BRUTO_HDR'] + ' kg');


				if (data['header']['netto_dtl'] > 0) {
					$('#modal-detil #header-pib #netto-dtl-li').css('display', '');
					$('#modal-detil #netto-dtl').html(': ' + data['header']['netto_dtl'] + ' kg (' + data['header']['counted_item'] + ' item)');
					console.log(data['header']['netto_dtl']);
				};

				$('#table-detil').footable(data['barang']);
			}
		});


	})
	
</script>