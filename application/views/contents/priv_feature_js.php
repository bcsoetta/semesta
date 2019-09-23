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
							'<div id="subfeature_' + id + '" class="collapse" >' + 
								'<button id="btn-simpan" class="btn btn-md info">Simpan</button>' +
							'</div>';
						$('#list-aplikasi').append(item);
						ListSubFeature(id);
					});
				}
			});
		}

		function ListSubFeature(id) {
			$.ajax({
				url: 'subfeature_list',
				method: 'POST',
				type: 'json',
				data: {'id': id},
				success: function (result) {
					console.log(result);
					if (result.length > 0) {
						$.each(result, function (key, val) {
							var desc = val['description'];
							var item = '<div class="list-group-item wrap">' + 
									'<div>' + desc + '</div>' +
								'</div>';
							$('#subfeature_' + id).append(item);
						})		
					}
					
				}
			})
		}

		ListAplikasi();

		// Menambah fitur
		$(document).on('click', '#form-simpan-fitur #btn-simpan', function (e) {
			e.preventDefault();
			var input = $('#form-simpan-fitur').serializeArray();
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

		// Menampilkan fitur untuk diupdate
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

		// Menyimpan update fitur
		$(document).on('click', '#modal-edit #btn-simpan', function (e) {
			e.preventDefault();
			var input = $('#formEdit').serializeArray();
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

		// $(document).on('click', '#list-aplikasi .list-description', function () {
		// 	console.log('klik');
		// })
	});
</script>