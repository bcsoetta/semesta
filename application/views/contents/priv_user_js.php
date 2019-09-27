<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>
<script>
$(document).ready(function () {
	var uid = "<?php echo $_GET['uid']; ?>";
	var base_url = "<?php echo base_url(); ?>";

	// Load user id ke input
	$('#inpUid').val(uid);

	// Mengambil daftar aplikasi yang belum terdaftar untuk user
	function GetAppsList(user_id) {
		$.ajax({
			url: '<?=base_url()?>user/user_unregistered_app/',
			method: 'POST',
			type: 'json',
			data: {'uid': user_id},
			success: function (result) {
				$('#selApp').empty();
				var options = '<option class="select-placeholder" value="" disabled="" selected="" hidden="">pilih aplikasi</option>';
				$.each(result, function (key, val) {
					var option = '<option value="' + val['id'] + '">' + val['description'] + '</option>';
					options = options + option;
				});
				$('#selApp').append(options);
			}
		})
	}

	function DisplayUserPrivs(user_id) {
		$.ajax({
			url: '<?=base_url()?>user/user_privilege_list/',
			method: 'POST',
			type: 'json',
			data: {'uid': user_id},
			success: function (result) {
				console.log(result);
				DisplayTableUserPrivs(result);
			}
		})
	}

	function DisplayTableUserPrivs(data) {
		$('#table-priv-data').DataTable({
			"destroy": true,
			"bLengthChange": false,
			"bFilter": false,
			"data": data,
			"columns": [
				{ "data": "app" },
				{ "data": "role" },
				{ 
					"data": null, 
					"render": function function_name(data, type, row) {
						button_edit = "<a href='#' id='" + data.id + "' class='edit-st'><i class='fa fa-edit text-primary' data-toggle='modal' data-target='#modal-tambah'></i></a>";
						button_del = "<a href='#' id='" + data.id + "' class='delete-st'><i class='fa fa-trash text-danger' data-toggle='modal' data-target='#modal-konfirmasi'></i></a>";

						return button_edit + '&nbsp;' + button_del;
					}
				}
			]
		});
	}

	DisplayUserPrivs(uid);
	GetAppsList(uid);

	// Mengambil daftar role berdasarkan aplikasi
	$(document).on('change', '#selApp', function (argument) {
		var app_id = $(this).val();
		$.ajax({
			url: '<?=base_url()?>user/role_list_by_app/',
			method: 'POST',
			type: 'json',
			data: {'app_id': app_id},
			success: function (result) {
				$('#selRole').empty();
				if (result.length > 0) {
					var options = '<option class="select-placeholder" value="" selected="" hidden="">pilih role</option>';
					$.each(result, function (key, val) {
						var option = '<option value="' + val['id'] + '">' + val['role'] + '</option>';
						options = options + option;
					});
					$('#selRole').append(options);
					$('#selRole').prop('disabled', false);
				} else {
					$('#selRole').prop('disabled', true);
				}
				
			}
		})
	})

	// Menyimpan role untuk user
	$(document).on('click', '#btn-simpan-role', function (e) {
		e.preventDefault();
		var input = $('#form-tambah-role').serializeArray();
		$.ajax({
			url: '<?=base_url()?>user/user_privilege_save/',
			method: 'POST',
			type: 'json',
			data: input,
			success: function (result) {
				if (result['status'] == 1) {
					$('.my-message').removeClass('primary danger').addClass('primary');
					GetAppsList(uid);
					$('#selRole').empty();
					$('#selRole').prop('disabled', true);
				} else {
					$('.my-message').removeClass('primary danger').addClass('danger');
				}
				$('.my-message').html(result['message']);
				$('.my-message').css('display', 'block');
				$('.my-message').delay(3000).fadeOut();
			}
		})
	})
})
</script>