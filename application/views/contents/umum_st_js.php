
<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/moment/moment.js'); ?>"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>

<script type="text/javascript">
	// Display datatable
	
		function displayAllData() {
			$.ajax({
				url: "get_st_all",
				method: "POST",
				success: function(result) {
					data = result;

					$.fn.dataTable.moment( 'DD-MM-YYYY' );

					$('#table-pfpd-data').DataTable({
						"destroy": true,
						"data": data,
						"columns": [
							{ "data": "jenis_st" },
							{
								"data": null,
								"render": function function_name(data, type, row) {
									switch(data.jenis_st) {
										case 'KK':
											var agenda = '/KPU.03/';
											break;

										case 'KBU':
											var agenda = '/KPU.03/BG.01/';
											break;
										default:
											var agenda = 'AGENDA TIDAK DITEMUKAN';
									};
									return 'ST-' + data.no + agenda + data.tahun;
								}
							},
							{ "data": "tanggal" },
							{ "data": "hal" },
							{ 
								"data": null, 
								"render": function function_name(data, type, row) {
									button_st = "<a href='preview_st/?id_st=" + data.id + "' id='btn-modal-preview' class='btn btn-sm blue' target='_blank'>ST</a>";

									if (data.spd == '1') {
										button_spd = "<a href='preview_spd/?id_st=" + data.id + "' id='btn-modal-preview' class='btn btn-sm blue' target='_blank' disabled=''>SPD</a>";
									} else {
										button_spd = "<button class='btn btn-sm dark' disabled=''>SPD</button>";
									}

									button_edit = "<a href='#' id='" + data.id + "' class='edit-st'><i class='fa fa-edit text-primary' data-toggle='modal' data-target='#modal-tambah'></i></a>";
									button_del = "<a href='#' id='" + data.id + "' class='delete-st'><i class='fa fa-trash text-danger' data-toggle='modal' data-target='#modal-konfirmasi'></i></a>";

									return button_st + '&nbsp;' + button_spd + '&nbsp;&nbsp;&nbsp;' + button_edit + '&nbsp;' + button_del;
								}
							},
							{
								"data": "created_at",
								"visible": false
							}
						],
						"order": [[ 5, "desc" ]]
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
			$('div#noSt').remove();

			$('#inpJenisSt').val('1');
			GetPejabat();
			$('#pejabat').attr('disabled', true);
			// $("#inpPlh").prop("checked", false);
			$('#inpHal').val('');
			$("input[name='tgl_tugas_start'").val('');
			$("input[name='tgl_tugas_end'").val('');
			$("input[name='wkt_tugas_start'").val('');
			$("input[name='wkt_tugas_end'").val('');
			$('#inpTempat').val('');
			$('#inpKota').val('');
			$('#inpDipa').val(1);
			$('#inpSpd').attr('checked', 'checked');

			$('button.add-pegawai').siblings('div').remove();

			var field = 
				'<div class="form-group row">' +
					'<div class="col-sm-11 form-pegawai">' +
						'<input type="text" class="form-control input-pegawai" id="pegawai_0" placeholder="Nama/NIP Pegawai" autocomplete="off">' +
						'<input type="text" class="id-pegawai" name="id_pegawai_0" style="display: none">' +
						'<div id="src_result_pegawai_0" class="src-result box"></div>' +
					'</div>' +
					'<div class="col-sm-1">' +
						'<button class="btn btn-icon sub-pegawai"><i class="fa fa-remove"></i></button>' +
					'</div>' +
				'</div>';

			$(field).insertBefore($('.add-pegawai'));

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
		$(document).on('click', '.add-pegawai', function(e) {
			e.preventDefault();
			
			var field = 
				'<div class="form-group row">' +
					'<div class="col-sm-11 form-pegawai">' +
						'<input type="text" class="form-control input-pegawai" id="pegawai_' + i + '" placeholder="Nama/NIP Pegawai" autocomplete="off">' +
						'<input type="text" class="id-pegawai" name="id_pegawai_' + i + '" style="display: none">' +
						'<div id="src_result_pegawai_' + i + '" class="src-result box"></div>' +
					'</div>' +
					'<div class="col-sm-1">' +
						'<button class="btn btn-icon sub-pegawai"><i class="fa fa-remove"></i></button>' +
					'</div>' +
				'</div>';

			$(field).insertBefore(this);
			i = i+1;
		});

		$(document).on('click', '.sub-pegawai', function() {
			// Remove deleted input from 'exclude'
			deletedId = $(this).parent().siblings(".form-pegawai").children("input[class='id-pegawai']").val();
			exclude = jQuery.grep(exclude, function(value) {
				return value != deletedId;
			});

			$(this).parent().parent().remove();
		});

		// Simpan ST baru
		$(document).on('click', '#btnSimpan', function() {
			header = getFormData($('#formStHeader'));
			pegawai = getFormData($('#formStPegawai'));

			input = {'header': header, 'pegawai': pegawai};

			$.ajax({
				url: 'simpan_st',
				method: 'POST',
				data: input,
				success: function () {
					$('#modal-tambah').modal('toggle');

					$('#inpJenisSt').val('KK');

					$('.my-message').html('ST berhasil disimpan');
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();

					displayAllData();
				}
			})
		});

		// Simpan ST update
		$(document).on('click', '#btnUpdate', function() {
			header = getFormData($('#formStHeader'));
			pegawai = getFormData($('#formStPegawai'));

			input = {'header': header, 'pegawai': pegawai};

			$.ajax({
				url: 'update_st',
				method: 'POST',
				data: input,
				success: function () {
					$('#modal-tambah').modal('toggle');

					$('#inpJenisSt').val('KK');

					$('.my-message').html('ST berhasil diupdate');
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();

					displayAllData();
				}
			})
		})
	}); 
</script>

<script type="text/javascript">
	// Menampilkan data ST untuk diedit
	$(document).ready(function() {
		$(document).on('click', '.edit-st', function(e) {
			e.preventDefault();

			var st_id = {'id_st': $(this).attr('id')};

			$.ajax({
				url: 'edit_st',
				method: 'POST',
				data: st_id,
				success: function(result) {

					$('div#noSt').remove();

					var inpStId = 
						'<div id="noSt" class="form-group row">' +
							'<label for="inpHal" class="col-sm-2 form-control-label">No ST</label>' +
							'<div class="col-sm-10">' +
								'<input name="inpNoSt" type="text" class="form-control" disabled="" value="' + result['st_header']['no_st'] + '">' +
							'</div>' +
							'<input name="id_st" type="text" value="' + result['st_header']['id'] + '" style="display: none;">' +
						'</div>';

					if (result['st_header']['jenis_st'] == 'KK') {
						var jenis_st = '1';
					} else if (result['st_header']['jenis_st'] == 'KBU') {
						var jenis_st = '10';
					}

					$('#formStHeader').prepend(inpStId);

					$('#inpJenisSt').val(jenis_st);

					if (result['st_header']['plh'] == '0') {
						$("#inpPlh").prop("checked", false);
						$('#pejabat').attr('disabled', true);
						GetPejabat();
					} else {
						$("#inpPlh").prop("checked", true);
						$('#pejabat').attr('disabled', false);
						$('#pejabat').val(result['st_header']['nip'] + ' - ' + result['st_header']['nama']);
						$("input[name='id_pejabat']").val(result['st_header']['id_pejabat']);
					}

					$('#inpHal').val(result['st_header']['hal']);
					$("input[name='tgl_tugas_start'").val(result['st_header']['tgl_tugas_start']);
					$("input[name='tgl_tugas_end'").val(result['st_header']['tgl_tugas_end']);
					$("input[name='wkt_tugas_start'").val(result['st_header']['wkt_tugas_start']);
					$("input[name='wkt_tugas_end'").val(result['st_header']['wkt_tugas_end']);
					$('#inpTempat').val(result['st_header']['tempat_tugas']);
					$('#inpKota').val(result['st_header']['kota_tugas']);
					$('#inpDipa').val(result['st_header']['dipa']);

					if (result['st_header']['spd'] == '0') {
						$('#inpSpd').removeAttr('checked');
					} else {
						$('#inpSpd').attr('checked', 'checked');
					}

					$('button.add-pegawai').siblings('div').remove();

					$.each(result['st_detail'], function(key, val) {
						var field = 
							'<div class="form-group row">' +
								'<div class="col-sm-11 form-pegawai">' +
									'<input type="text" class="form-control input-pegawai" id="pegawai_' + i + '" placeholder="Nama/NIP Pegawai" autocomplete="off">' +
									'<input type="text" class="id-pegawai" name="id_pegawai_' + i + '" style="display: none">' +
									'<div id="src_result_pegawai_' + i + '" class="src-result box"></div>' +
								'</div>' +
								'<div class="col-sm-1">' +
									'<button class="btn btn-icon sub-pegawai"><i class="fa fa-remove"></i></button>' +
								'</div>' +
							'</div>';

						$(field).insertBefore($('.add-pegawai'));

						$('#pegawai_' + i).val(val['nip'] + ' - ' + val['nama']);
						$("input[name='id_pegawai_" + i + "']").val(val['id_pegawai']);

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
	// Delete ST
	exclude = ['0'];

	$(document).ready(function() {
		$(document).on('click', '.delete-st', function(e) {
			e.preventDefault();

			st_id = {'id_st': $(this).attr('id')};
		});

		$(document).on('click', '#btnDelConfirm', function() {
			$.ajax({
				url: 'delete_st',
				method: 'POST',
				data: st_id,
				success: function () {
					$('#modal-konfirmasi').modal('toggle');

					$('.my-message').html('ST berhasil dihapus');
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();

					displayAllData();
				}
			});
		});
	});
</script>

<script type="text/javascript">
	// Edit pejabat ST
	function GetPejabat() {
		jabatan = $('#inpJenisSt').val();

		input = {'jabatan': jabatan};

		$.ajax({
			url: "get_pejabat",
			method: "POST",
			data: input,
			success: function (result) {
				$('#pejabat').val(result.nip + ' - ' + result.nama);
				$("input[name='id_pejabat']").val(result.id);

				if (result.plh == 1) {
					$('#inpPlh').prop('checked', true);
				} else {
					$('#inpPlh').prop('checked', false);
				}
			}
		});
	};

	$(document).ready(function() {
		GetPejabat();

		$('#inpJenisSt').change(function() {
			GetPejabat();
		});

	});
</script>

<script type="text/javascript">
	// Edit detail petugas
	$(document).ready(function() {
		
		function SearchPegawai(element, input, exclude) {
			var inputId = '#' + element;
			var resultId = '#src_result_' + element;
			var resultList = resultId + ' .src-list';
			var inputName = 'id_' + element;

			$.ajax({
				url: "cari_pegawai",
				method: "POST",
				data: {
					"pegawai": input,
					"exclude": exclude
				},
				type: 'json',
				success: function(result) {
					
					if ($(inputId).val() == ""){
						$(resultId).empty();
						$(resultId).css('display', 'none');	
					} else {
						$(resultId).empty();
						$(resultId).css('display', 'block');

						$.each(result, function(key, val) {
							$(resultId).append("<div class='src-list' id='" + val.id + "'>" + val.nip + " - " + val.nama + "</div>");
						});

						$(resultList).click(function() {
				
							var selected = $(this).html();
							var id = $(this).attr('id');

							$(inputId).val(selected);
							$("input[name='" + inputName + "']").val(id);
							$(resultId).css('display', 'none');

							exclude.push(id);
						})
					}
				}
			})
		}

		$(document).on("paste keyup", ".input-pejabat", function() {
			input = $(this).val();
			SearchPegawai('pejabat', input, ['0']);
		});

		$(document).on("paste keyup", ".input-pegawai", function() {
			element = $(this).attr('id');
			input = $(this).val();

			// Remove current edited input from 'exclude'
			currentId = $("input[name='id_" + element + "']").val();
			exclude = jQuery.grep(exclude, function(value) {
				return value != currentId;
			});

			SearchPegawai(element, input, exclude);
		});
	});
</script>