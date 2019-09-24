<script type="text/javascript">
	$(document).ready(function () {
		// Menampilkan semua fitur dalam semesta
		function ListAplikasi() {
			$.ajax({
				url: 'feature_list',
				method: 'POST',
				type: 'json',
				success: function (result) {
					$('#list-aplikasi').empty();
					$.each(result, function (key, val) {
						var desc = val['description'];
						var id = val['id'];
						var status = val['status'];
						if (status == 1) {
							var label = '<span class="label success pos-rlt m-r-xs">active</span>';
						} else {
							var label = '<span class="label pos-rlt m-r-xs">disabled</span>';
						}
						var item = '<div id="feature_' + id + '" class="list-group-item b-l-primary" data-toggle="collapse" data-target="#subfeature_' + id + '">' +
								'<span class="list-description">' + label + '&nbsp' + desc + '</span>' +
								'<span class="pull-right text-primary">' +
									'<a id="' + id + '" class="edit-fitur">' +
										'<i class="fa fa-edit text-primary"></i>' +
									'</a>' +
								'</span>' +
							'</div>' +
							'<div id="subfeature_' + id + '" class="collapse list-subfeature" >' + 
								'<div class="list-group-item wrap default-feature">Aplikasi ini tidak memiliki role</div>' + 
								'<div id="btn" class="list-group-item wrap">' +
									'<button class="btn btn-sm info btn-tambah">+ Tambah role</button>' +
								'</div>' + 
							'</div>';
						$('#list-aplikasi').append(item);
						// ListSubFeature(id);
					});
				}
			});
		}

		// function ListSubFeature(id) {
		// 	$.ajax({
		// 		url: 'subfeature_list',
		// 		method: 'POST',
		// 		type: 'json',
		// 		data: {'id': id},
		// 		success: function (result) {
		// 			if (result.length > 0) {
		// 				$('#subfeature_' + id + ' .default-feature').remove();
		// 				$.each(result, function (key, val) {
		// 					var id = val['id'];
		// 					var desc = val['description'];
		// 					var url = val['url'];
		// 					if (val['have_view'] == 1) {
		// 						var view = '<span class="label success pos-rlt m-r-xs">view</span>';
		// 					} else {
		// 						var view = '<span class="label pos-rlt m-r-xs">non-view</span>';
		// 					}
		// 					if (val['status'] == 1) {
		// 						var status = '<span class="label success pos-rlt m-r-xs">active</span>';
		// 					} else {
		// 						var status = '<span class="label pos-rlt m-r-xs">disabled</span>';
		// 					}
		// 					var item = '<div class="list-group-item wrap">' + 
		// 							'<div class="col-sm-4">' + desc + '</div>' +
		// 							'<div class="col-sm-3">' + url + '</div>' +
		// 							'<div class="col-sm-2">' + view + '</div>' +
		// 							'<div class="col-sm-2">' + status + '</div>' +
		// 							'<div class="col-sm-1">' +
		// 								'<a id="' + id + '" class="edit-subfitur">' +
		// 									'<i class="fa fa-edit text-primary"></i>' +
		// 								'</a>' +
		// 							'</div>' +
		// 						'</div>';
		// 					$(item).insertBefore($('#btn'));
		// 					// $('#subfeature_' + id).append(item);
		// 				})		
		// 			}
		// 		}
		// 	})
		// }

		ListAplikasi();

		// Menampilkan menu membuat role baru
		$(document).on('click', '#btn-tambah-role', function (e) {
			e.preventDefault();
			$('#form-role inpNama').val();
			$('#form-role inpStatus').val('1');
			$('#modal-role').modal('toggle');
		});

		// Menyimpan role
		$(document).on('click', '#modal-role #btn-simpan', function (e) {
			e.preventDefault();
			var input = $('#form-role').serializeArray();
			$.ajax({
				url: 'role_save',
				method: 'POST',
				type: 'json',
				data: input,
				success: function (result) {
					if (result['status'] == 1) {
						$('.my-message').removeClass('primary danger').addClass('primary');
						$('#modal-role').modal('toggle');
					} else {
						$('.my-message').removeClass('primary danger').addClass('danger');
					}
					$('.my-message').html(result['message']);
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();
					ListAplikasi();
				}
			})
		});

		// Menampilakn menu tambah role untuk aplikasi
		$(document).on('click', '.list-subfeature .btn-tambah', function (e) {
			e.preventDefault();
			var options = 'test';
			var app_id = $(this).parent().parent().attr('id');
			var app_id = app_id.replace('subfeature_', '');
			// ListRoles(function (output) {
			// 	$.each(output, function (key, val) {
			// 		var role_id = val['id'];
			// 		var role_nm = val['role'];
			// 		var option = '<option value="' + role_id + '">' + role_nm + '</option>';
			// 		options = 'test_func';
			// 		console.log(options);
			// 	})
			// });
			var roles = function () {
			    var tmp = null;
			    $.ajax({
					url: 'role_list',
					method: 'POST',
					type: 'json',
					success: function (result) {
						// handleData(result);
						tmp = result;
					}
				});
			    return tmp;
			}();
			console.log(roles);
			var form = '<div class="list-group-item wrap">' +
					'<form id="form-feature" action="#">' +
						'<input id="inpAppId" type="hidden" name="parent_id" value="' + app_id + '">' +
						'<div class="form-group col-md-4 mb-0">' + 
							'<select id="inpRole" type="text" name="role" class="form-control form-control-sm">' +
							'</select>' +
						'</div>' +
						'<div class="form-group col-md-2 mb-0">' + 
							'<select type="text" name="have_view" class="form-control form-control-sm">' +
								'<option value="0">Non-view</option>' +
								'<option value="1">View</option>' +
							'</select>' +
						'</div>' +
						'<div class="form-group col-md-3 mb-0">' + 
							'<input type="text" name="url" class="form-control form-control-sm" placeholder="url fitur">' +
						'</div>' +
						'<div class="form-group col-md-2 mb-0">' + 
							'<select type="text" name="status" class="form-control form-control-sm">' +
								'<option value="1">Active</option>' +
								'<option value="0">Disabled</option>' +
							'</select>' +
						'</div>' +
						'<button id="btn-simpan" class="btn btn-sm primary">Simpan</button>'
					'</form>'
				'</div>';
			$(form).insertBefore($(this).parent());
		});

		// Mendapatkan semua role
		function ListRoles() {
			var data = {'id': 1, 'var': 'test'};
			$.ajax({
				url: 'role_list',
				method: 'POST',
				type: 'json',
				success: function (result) {
					// handleData(result);
					data = result;
				}
			});
			return data;
		};

		// Menyimpan fitur baru
		$(document).on('click', '#form-feature > #btn-simpan', function (e) {
			e.preventDefault();
			var input = $(this).parent().serializeArray();
			$.ajax({
				url: 'subfeature_save',
				method: 'POST',
				type: 'json',
				data: input,
				success: function (result) {
					if (result['status'] == 1) {
						$('.my-message').removeClass('primary danger').addClass('primary');
					} else {
						$('.my-message').removeClass('primary danger').addClass('danger');
					}
					$('.my-message').html(result['message']);
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();
					ListAplikasi();
				}
			})
		})

	});
</script>