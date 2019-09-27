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
								'<div class="list-group-item wrap default-feature">Aplikasi ini belum memiliki fitur</div>' + 
								'<div id="btn' + id + '" class="list-group-item wrap">' +
									'<button class="btn btn-sm info btn-tambah">+ Tambah fitur</button>' +
								'</div>' + 
							'</div>';
						$('#list-aplikasi').append(item);
						ListSubFeature(id);
					});
				}
			});
		}

		function ListSubFeature(app_id) {
			$.ajax({
				url: 'subfeature_list',
				method: 'POST',
				type: 'json',
				data: {'id': app_id},
				success: function (result) {
					if (result.length > 0) {
						$('#subfeature_' + app_id + ' .default-feature').remove();
						$.each(result, function (key, val) {
							var feat_id = val['id'];
							var desc = val['description'];
							var url = val['url'];
							if (val['have_view'] == 1) {
								var view = '<span class="label success pos-rlt m-r-xs">view</span>';
							} else {
								var view = '<span class="label pos-rlt m-r-xs">non-view</span>';
							}
							if (val['status'] == 1) {
								var status = '<span class="label success pos-rlt m-r-xs">active</span>';
							} else {
								var status = '<span class="label pos-rlt m-r-xs">disabled</span>';
							}
							var item = '<div class="list-group-item wrap">' + 
									'<div class="col-sm-4">' + desc + '</div>' +
									'<div class="col-sm-3">' + url + '</div>' +
									'<div class="col-sm-2">' + view + '</div>' +
									'<div class="col-sm-2">' + status + '</div>' +
									'<div class="col-sm-1">' +
										'<a id="' + feat_id + '" class="edit-subfitur">' +
											'<i class="fa fa-edit text-primary"></i>' +
										'</a>' +
									'</div>' +
								'</div>';
							$('#btn' + app_id).before(item);
						})		
					}
				}
			})
		}

		ListAplikasi();

		// Menambah aplikasi
		$(document).on('click', '#form-simpan-app #btn-simpan', function (e) {
			e.preventDefault();
			var input = $('#form-simpan-app').serializeArray();
			$.ajax({
				url: 'feature_save',
				method: 'POST',
				type: 'json',
				data: input,
				success: function (result) {
					$('#inp-nm-fitur').val('');
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
			});
		});

		// Menampilkan aplikasi untuk diupdate
		$(document).on('click', '.edit-fitur', function (e) {
			e.preventDefault();
			var id = $(this).attr('id');
			$.ajax({
				url: 'feature_show',
				method: 'POST',
				type: 'json',
				data: {'id': id},
				success: function (result) {
					var id = result[0]['id'];
					var desc = result[0]['description'];
					var stat = result[0]['status'];
					$('#modal-edit #inpId').val(id);
					$('#modal-edit #inpNama').val(desc);
					if (stat == 1) {
						$('#modal-edit #inpStatus').prop("checked", true);	
					} else {
						$('#modal-edit #inpStatus').prop("checked", false);
					}
					$('#modal-edit').modal('toggle');		
				}
			});
		});

		// Menyimpan update aplikasi
		$(document).on('click', '#modal-edit #btn-simpan', function (e) {
			e.preventDefault();
			var input = $('#form-edit-app').serializeArray();
			$.ajax({
				url: 'feature_update',
				method: 'POST',
				type: 'json',
				data: input,
				success: function (result) {
					$('#inp-nm-fitur').val('');
					if (result['status'] == 1) {
						$('#modal-edit').modal('toggle');	
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

		// Menampilakn menu tambah fitur
		$(document).on('click', '.list-subfeature .btn-tambah', function (e) {
			e.preventDefault();
			var app_id = $(this).parent().parent().attr('id');
			var app_id = app_id.replace('subfeature_', '');
			var form = '<div class="list-group-item wrap">' +
					'<form id="form-feature" action="#">' +
						'<input id="inpAppId" type="hidden" name="parent_id" value="' + app_id + '">' +
						'<div class="form-group col-md-4 mb-0">' + 
							'<input type="text" name="description" class="form-control form-control-sm" placeholder="deskripsi fitur">' +
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