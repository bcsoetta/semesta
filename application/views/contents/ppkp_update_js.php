<script src="<?php echo base_url('assets/libs/js/moment/moment.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>

<script>

$(document).ready(function() {

	$('#datetimepicker1').datetimepicker({
		format: 'DD-MM-YYYY h:mm A'
		
	});

	$('#datetimepicker2').datetimepicker({
		format: 'DD-MM-YYYY h:mm A'
	});

	$('#datetimepicker3').datetimepicker({
		format: 'DD-MM-YYYY'
	});

	$('#datetimepicker4').datetimepicker({
		format: 'DD-MM-YYYY'
	});
});
	
</script>