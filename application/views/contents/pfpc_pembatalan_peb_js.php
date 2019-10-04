<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/moment/moment.js'); ?>"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>

<script type="text/javascript">
	// Display datatable
	function displayAllData() {
		$.ajax({
			url: "pembatalan_peb_browse",
			method: "POST",
			success: function(result) {
				$('#table-dok-data').DataTable({
					"destroy": true,
					"data": result,
					"columns": [
						{ 
							"data": function (data, type, row) {
								return '<div class="font-weight-bold">' + data.kd_agd + '</div><div class="small">' + data.tanggal + '</div>';
							},
							"width": "5%"
						},
						{ "data": function (data, type, row) {
								return '<div style="width: 15vw;">' + data.no_surat + '</div><div class="small">' + data.tgl_surat + '</div>';
							},
							"width": "5%"
						},
						{ 
							"data": "hal",
							"width": "25%"
						},
						{ 
							"data": "dari",
							"width": "20%"
						},
						{ 
							"data": "sta",
							"width": "15%"
						},
						{ 
							"data": function (data, type, row) {
								if (data.sta == 'Diterima di Loket') {
									return 'Proses';
								} else {
									return 'None';
								}
							},
							"width": "5%"
						}
						// {
						// 	"data": null,
						// 	"render": function (data, type, row) {
						// 		button_edit = "<a href='#' id='" + data.id + "' class='edit-data'><i class='fa fa-edit text-primary' data-toggle='modal' data-target='#modal-tambah'></i></a>";
						// 		button_del = "<a href='#' id='" + data.id + "' class='delete-data'><i class='fa fa-trash text-danger' data-toggle='modal' data-target='#modal-konfirmasi'></i></a>";
						// 		return button_edit + '&nbsp;' + button_del;
						// 	}
						// }
					],
					"order": [[ 0, "desc" ]]
				});
			}
		});
	}

	$(document).ready(function() {
		displayAllData();
	})
</script>

<script type="text/javascript">
	// Menampilkan modal untuk data baru
	$(document).ready(function() {
		$('#modal-tambah').on('shown.bs.modal', function (e) {
			$('#inpId').remove();
			$('#inpNama').val('');
			$('#inpKet').val('');
			$("input[name='tahun']").val('');
			$('#inpAlamat').val('');
			$('#inpStatus').val(1);

			$('button.add-detail').siblings('div').remove();

			var field = 
				'<div class="form-group row">' +
					'<div class="col-sm-11 form-detail">' +
						'<input type="text" class="form-control input-detail" id="detail_0" name="detail_0">' +
					'</div>' +
					'<div class="col-sm-1">' +
						'<button class="btn btn-icon sub-detail"><i class="fa fa-remove"></i></button>' +
					'</div>' +
				'</div>';

			$(field).insertBefore($('.add-detail'));

			$('#btnSimpan').show();
			$('#btnUpdate').hide();
		})
	})
</script>

<script type="text/javascript">
	// Modal form handling
	i = 1;

	function getFormData($form) {
		var unindexed_array = $form.serializeArray();
		var indexed_array = {};

		$.map(unindexed_array, function(n, i) {
			indexed_array[n['name']] = n['value'];
		});

		return indexed_array;
	}

	$(document).ready(function() {
		$(document).on('click', '.add-detail', function(e) {
			e.preventDefault();
			
			var field = 
				'<div class="form-group row">' +
					'<div class="col-sm-11 form-detail">' +
						'<input type="text" class="form-control input-detail" name="detail_' + i + '">' +
					'</div>' +
					'<div class="col-sm-1">' +
						'<button class="btn btn-icon sub-detail"><i class="fa fa-remove"></i></button>' +
					'</div>' +
				'</div>';

			$(field).insertBefore(this);
			i = i+1;
		});

		$(document).on('click', '.sub-detail', function(e) {
			e.preventDefault()
			$(this).parent().parent().remove();
		});

		// Simpan data baru
		$(document).on('click', '#btnSimpan', function() {
			header = getFormData($('#formHeader'));
			pembuat = getFormData($('#formDetail'));

			input = {'header': header, 'pembuat': pembuat};

			$.ajax({
				url: 'simpan_apps',
				method: 'POST',
				data: input,
				success: function () {
					$('#modal-tambah').modal('toggle');

					$('.my-message').html('Apps berhasil disimpan');
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();

					displayAllData();
				}
			})
		});

		// Simpan data update
		$(document).on('click', '#btnUpdate', function() {
			header = getFormData($('#formHeader'));
			pembuat = getFormData($('#formDetail'));

			input = {'header': header, 'pembuat': pembuat};

			$.ajax({
				url: 'update_apps',
				method: 'POST',
				data: input,
				success: function () {
					$('#modal-tambah').modal('toggle');

					$('.my-message').html('Apps berhasil diupdate');
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();

					displayAllData();
				}
			})
		})
	}); 
</script>

<script type="text/javascript">
	// Menampilkan data untuk diedit
	$(document).ready(function() {
		$(document).on('click', '.edit-data', function(e) {
			e.preventDefault();

			var id_data = {'id_data': $(this).attr('id')};

			$.ajax({
				url: 'edit_apps',
				method: 'POST',
				data: id_data,
				success: function(result) {
					var input_id = '<input id="inpId" type="hidden" name="id" value="' + result['id'] + '">';
					$('#formHeader').prepend(input_id);

					$('#inpNama').val(result['nama']);
					$('#inpKet').val(result['keterangan']);
					$('#inpTahun').val(result['tahun']);
					$('#inpAlamat').val(result['alamat']);
					$('#inpStatus').val(1);

					$('button.add-detail').siblings('div').remove();

					$.each(result['pembuat'], function(key, val) {
						var field = 
							'<div class="form-group row">' +
								'<div class="col-sm-11 form-detail">' +
									'<input type="text" class="form-control input-pembuat" id="detail_' + i + '" name="detail_' + i + '" autocomplete="off">' +
								'</div>' +
								'<div class="col-sm-1">' +
									'<button class="btn btn-icon sub-detail"><i class="fa fa-remove"></i></button>' +
								'</div>' +
							'</div>';

						$(field).insertBefore($('.add-detail'));
						$("input[name='detail_" + i + "']").val(val);
						i = i+1;
					});
				}
			})

			$('#btnSimpan').hide();
			$('#btnUpdate').show();
		})
	})
</script>

<script type="text/javascript">
	// Delete data
	$(document).ready(function() {
		$(document).on('click', '.delete-data', function(e) {
			e.preventDefault();

			id_data = {'id_data': $(this).attr('id')};
			name_data = $(this).parent().siblings().first().html();
			$('#pesan-konfirmasi').html('Yakin untuk menghapus aplikasi "'+ name_data + '"?')
		});

		$(document).on('click', '#btnDelConfirm', function() {
			$.ajax({
				url: 'delete_app',
				method: 'POST',
				data: id_data,
				success: function (result) {
					$('#modal-konfirmasi').modal('toggle');

					$('.my-message').html('App berhasil dihapus');
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();

					displayAllData();
				}
			});
		});
	});
</script>