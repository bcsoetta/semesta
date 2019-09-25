<script>
$(document).ready(function () {
	var uid = "<?php echo $_GET['uid']; ?>";
	var base_url = "<?php echo base_url(); ?>";

	// Mengambil daftar aplikasi yang belum terdaftar untuk user
	$.ajax({
		url: '<?=base_url()?>user/user_unregistered_app/',
		method: 'POST',
		type: 'json',
		data: {'uid': uid},
		success: function (result) {
			// console.log(result);
			$('#selApp').empty();
			var options = '<option class="select-placeholder" value="" disabled="" selected="" hidden="">pilih aplikasi</option>';
			$.each(result, function (key, val) {
				var option = '<option value="' + val['id'] + '">' + val['description'] + '</option>';
				options = options + option;
			});
			$('#selApp').append(options);
		}
	})

	// Mengambil daftar role berdasarkan aplikasi
	$(document).on('change', '#selApp', function (argument) {
		var app_id = $(this).val();
		$.ajax({
			url: '<?=base_url()?>user/role_list_by_app/',
			method: 'POST',
			type: 'json',
			data: {'app_id': app_id},
			success: function (result) {
				console.log(result);
			}
		})
		// console.log(app_id);
	})

	// Menyimpan role untuk user
	$(document).on('click', '#btn-simpan-role', function (e) {
		e.preventDefault();
		var input = $('#form-tambah-role').serializeArray();
		$.ajax({
			url: 'user_privilege_save',
			method: 'POST',
			type: 'json',
			data: input,
			success: function (result) {
				console.log(result);
			}
		})
	})
})
</script>