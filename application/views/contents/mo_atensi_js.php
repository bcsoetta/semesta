<script src="<?php echo base_url('assets/libs/jquery/footable/dist/footable-3.1.5.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/moment/moment.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$.ajax({
			url: "DataAtensi",
			method: "POST",
			type: 'json',
			success: function(data) {

				data['columns'][1]['formatter'] = function(value){
					return moment(value).format('DD-MM-YYYY');
				};

				data['columns'][5]['formatter'] = function(value){
					return moment(value).format('DD-MM-YYYY');
				};

				jQuery(function($){
					$('#table-atensi').footable(data);
				});

			}
		});
	}); 
</script>