<script src="<?php echo base_url('assets/libs/jquery/select2/dist/js/select2.js'); ?>"></script>
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
						var app_id = val['id'];
						var status = val['status'];
						if (status == 1) {
							var label = '<span class="label success pos-rlt m-r-xs">active</span>';
						} else {
							var label = '<span class="label pos-rlt m-r-xs">disabled</span>';
						}
						var roles = ListAppRole(app_id);
						if (roles.length > 0) {
							role_ls = '';
							$.each(roles, function (key, val) {
								role_id = val['id'];
								feature_ls = '';
								$.each(val['features'], function (key, val) {
									feature_item = '<span class="label pos-rlt m-r-xs dark">' + val + '</span>'
									feature_ls = feature_ls + feature_item;
								})
								role_item = '<div id="' + role_id + '" class="list-group-item wrap detail-role">' +
										'<div class="col-md-2">' + val['role'] + '</div>' +
										'<div class="col-md-9 feature_url"><div>' + 
											feature_ls + 
										'</div></div>' +
										'<div class="col-md-1 feature_button">' +
											'<a class="edit-role-features">' +
												'<i class="fa fa-edit text-primary"></i>' +
											'</a>' +
										'</div>' +
									'</div>';
								role_ls = role_ls + role_item;
							})
						} else {
							role_ls = '<div class="list-group-item wrap default-feature">Aplikasi ini tidak memiliki role</div>';
						}
						var item = '<div id="feature_' + app_id + '" class="list-group-item b-l-primary" data-toggle="collapse" data-target="#detail_feature_' + app_id + '">' +
								'<span class="list-description">' + label + '&nbsp' + desc + '</span>' +
								'<span class="pull-right text-primary">' +
									'<a id="' + app_id + '" class="edit-fitur">' +
										'<i class="fa fa-edit text-primary"></i>' +
									'</a>' +
								'</span>' +
							'</div>' +
							'<div id="detail_feature_' + app_id + '" class="collapse list-subfeature" >' + 
								role_ls + 
								'<div id="btn" class="list-group-item wrap">' +
									'<button class="btn btn-sm info btn-tambah">+ Tambah role</button>' +
								'</div>' + 
							'</div>';
						$('#list-aplikasi').append(item);
					});
				}
			});
		}

		function ListAppRole(app_id) {
			$.ajax({
				async: false,
				url: 'role_list_used',
				method: 'POST',
				type: 'json',
				data: {'app_id': app_id},
				success: function (result) {
					data = result;
				}
			})
			return data;
		}

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
			var role_opt = '';
			var feat_opt = '';
			var app_id = $(this).parent().parent().attr('id');
			var app_id = app_id.replace('detail_feature_', '');
			var roles = ListRoles(app_id);
			$.each(roles, function (key, val) {
				var role_id = val['id'];
				var role_nm = val['role'];
				var option = '<option value="' + role_id + '">' + role_nm + '</option>';
				role_opt = role_opt + option;
			});
			var features = ListSubFeature(app_id);
			$.each(features, function (key, val) {
				var feat_id = val['id'];
				var feat_nm = val['url'];
				var option = '<option value="' + feat_id + '">' + feat_nm + '</option>'
				feat_opt = feat_opt + option;
			})
			var form = '<div class="list-group-item wrap">' +
					'<form id="form-feature" action="#">' +
						'<input id="inpAppId" type="hidden" name="app" value="' + app_id + '">' +
						'<div class="form-group col-md-2 mb-0">' + 
							'<select id="inpRole" name="role" class="form-control form-control-sm">' +
								role_opt +
							'</select>' +
						'</div>' +
						'<div class="form-group col-md-9 mb-0">' + 
							'<select id="inpFeature" name="feature[]" class="form-control form-control-sm" multiple="multiple">' +
								feat_opt +
							'</select>' +
						'</div>' +
						'<button id="btn-simpan" class="btn btn-sm primary">Simpan</button>'
					'</form>'
				'</div>';
			$(form).insertBefore($(this).parent());
			$('#form-feature #inpFeature').select2({
				closeOnSelect:false,
				placeholder:'Pilih feature'
			});
		});

		// Mendapatkan semua role yang belum didaftarkan dalam aplikasi
		function ListRoles(app_id) {
			var data = null;
			$.ajax({
				async: false,
				url: 'role_list_unused',
				method: 'POST',
				type: 'json',
				data: {'app_id': app_id},
				success: function (result) {
					data = result;
				}
			});
			return data;
		};

		// Mendapatkan feature berdasarkan aplikasi
		function ListSubFeature(id) {
			var data = null;
			$.ajax({
				async: false,
				url: 'subfeature_list',
				method: 'POST',
				type: 'json',
				data: {'id': id},
				success: function (result) {
					data = result;
				}
			});
			return data;
		};

		// Menyimpan fitur role
		$(document).on('click', '#form-feature > #btn-simpan', function (e) {
			e.preventDefault();
			var input = $(this).parent().serializeArray();
			$.ajax({
				url: 'role_feature_save',
				method: 'POST',
				type: 'json',
				data: input,
				success: function (result) {
					if (result['status'] == 1) {
						$('.my-message').removeClass('primary danger').addClass('primary');
						ListAplikasi();
					} else {
						$('.my-message').removeClass('primary danger').addClass('danger');
					}
					$('.my-message').html(result['message']);
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();
				}
			})
		})

		// Menampilkan menu edit role's features
		$(document).on('click', '.edit-role-features', function (e) {
			e.preventDefault();
			var role_detail = $(this).parent().parent();
			var app_id = $(this).parent().parent().parent().attr('id').replace('detail_feature_', '');
			var role_id = $(this).parent().parent().attr('id');
			var input = {'app_id': app_id, 'role_id': role_id};
			$.ajax({
				url: 'role_feature_list',
				method: 'POST',
				type: 'json',
				data: input,
				success: function (result) {
					var feat_opt = '';
					
					$.each(result, function (key, val) {
						var feat_id = val['id'];
						var feat_nm = val['url'];
						if (val['selected'] == 1) {
							var selected = 'selected';
						} else {
							var selected = '';
						}
						var option = '<option value="' + feat_id +'" ' + selected + '>' + feat_nm + '</option>'
						feat_opt = feat_opt + option;
					})
					var form = '<form id="form-edit-role">' + 
							'<div class="form-group mb-0">' + 
								'<select id="inpFeature" name="feature[]" class="form-control form-control-sm" multiple="multiple">' +
									feat_opt +
								'</select>' +
							'</div>' +
						'</form>';
					var button = '<div class="btn-role-group">' +
							'<a class="btn-role-simpan" title="Simpan">' +
								'<i class="fa fa-save text-info"></i>' +
							'</a>' +
							'&nbsp&nbsp' +
							'<a class="btn-role-batal" title="Batal">' +
								'<i class="fa fa-ban text-danger"></i>' +
							'</a>' +
						'</div>';
					role_detail.children('.feature_url').children('div').css({'display': 'none'});
					role_detail.children('.feature_url').append(form);
					role_detail.children('.feature_button').children('.edit-role-features').css({'display': 'none'});
					role_detail.children('.feature_button').append(button);
					$('#form-edit-role #inpFeature').select2({closeOnSelect:false});
				}
			})
		})

		// Menyimpan edit role
		$(document).on('click', '.btn-role-simpan', function (e) {
			e.preventDefault();
			var role = $(this).parent().parent().parent();
			var app_id = role.parent().attr('id').replace('detail_feature_', '');
			var role_id = role.attr('id');
			var features = role.find('#form-edit-role').serializeArray();
			var input = [
				{
					'name': 'app_id',
					'value': app_id
				},
				{
					'name': 'role_id',
					'value': role_id
				}
			];
			$.each(features, function (key, val) {
				var name = val.name;
				var value = val.value;
				input.push({'name': name, 'value': value});
			})
			console.log(input);
			$.ajax({
				url: 'role_feature_update',
				method: 'POST',
				type: 'json',
				data: input,
				success: function (result) {
					if (result['status'] == 1) {
						$('.my-message').removeClass('primary danger').addClass('primary');
						ListAplikasi();
					} else {
						$('.my-message').removeClass('primary danger').addClass('danger');
					}
					$('.my-message').html(result['message']);
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();
				}
			})
		})

		// Membatalkan edit role
		$(document).on('click', '.btn-role-batal', function (e) {
			e.preventDefault();
			var role_detail = $(this).parent().parent().parent();
			role_detail.find('#form-edit-role').remove();
			role_detail.find('.feature_url').children('div').css({'display': 'block'});
			role_detail.find('.btn-role-group').remove();
			role_detail.find('.feature_button').children('.edit-role-features').css({'display': 'block'});
		})

	});
</script>