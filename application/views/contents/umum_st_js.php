
<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/moment/moment.js'); ?>"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	// Get user role
	var role = '<?php echo $role; ?>';

	// Display datatable
	function displayAllData() {
		$.ajax({
			url: "get_st_all",
			method: "POST",
			data: {'role': role},
			success: function(result) {
				$.fn.dataTable.moment( 'DD-MM-YYYY' );
				DisplayDatatable(result);
			}
		});
	}

	function DisplayDatatable(data) {
		$('#table-pfpd-data').DataTable({
			"destroy": true,
			"data": data,
			"columns": [
				{ "data": "jenis_st" },
				{ "data": "no_st" },
				{ "data": "tgl" },
				{ "data": "hal" },
				{ "data": "status" },
				{ "data": "button" },
				{ 
					"data": "created_at",
					"visible": false
				}
			],
			"order": [[ 6, "desc" ]]
		});
	}

	displayAllData();

	// Menampilkan modal untuk data baru
	$('#modal-tambah').on('shown.bs.modal', function (e) {
		exclude = ['0'];
		i = 1;
		$('div#noSt').remove();

		$('#inpJenisSt').val('1');
		GetPejabat();
		$('#pejabat').attr('disabled', true);
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

	// Modal form handling
	function getFormData($form) {
		var unindexed_array = $form.serializeArray();
		var indexed_array = {};

		$.map(unindexed_array, function(n, i) {
			indexed_array[n['name']] = n['value'];
		});

		return indexed_array;
	}

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

				$('.my-message').html('ST berhasil diupdate');
				$('.my-message').css('display', 'block');
				$('.my-message').delay(3000).fadeOut();

				displayAllData();
			}
		})
	})

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

	// Delete ST
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

	// Approve ST
	$(document).on('click', '.ok-st', function (e) {
		e.preventDefault();
		var st_id = $(this).attr('id');
		var st_status = $(this).children('.status-st').val();
		$.ajax({
			url: 'st_approve',
			method: 'POST',
			data: {'st_id': st_id, 'st_status': st_status},
			success: function (result) {
				displayAllData();
			}
		})
	})

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
					$('#inpHidPlh').val(1);
				} else {
					$('#inpPlh').prop('checked', false);
					$('#inpHidPlh').val(0);
				}
			}
		});
	};

	$('#inpJenisSt').change(function() {
		GetPejabat();
	});

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

	// Advance search
	$(document).ready(function (argument) {
		// Open search form
		$(document).on('click', '#btn-open-adv-src', function (e) {
			e.preventDefault();
			$('#adv-src').css('display', 'block');
			$(this).attr('id', 'btn-close-adv-src');
		})

		// Close search form
		$(document).on('click', '#btn-close-adv-src', function (e) {
			e.preventDefault();
			$('#adv-src').css('display', 'none');
			$(this).attr('id', 'btn-open-adv-src');
		})

		// Submit search
		$(document).on('click', '#btn-adv-src', function (e) {
			e.preventDefault();
			var input = $('#form-adv-src').serializeArray();
			$.ajax({
				url: 'st_search',
				method: 'POST',
				type: 'json',
				data: input,
				success: function (result) {
					DisplayDatatable(result);
				}
			})
		})

		$(document).on('click', '#btn-clr-src', function (e) {
			e.preventDefault();
			$('#form-adv-src #srcJenisSt').val('');
			$('#form-adv-src #srcTglStSta').val('');
			$('#form-adv-src #srcTglStEnd').val('');
			$('#form-adv-src #srcDipa').val('');
			$('#form-adv-src #srcHal').val('');
			$('#form-adv-src #srcTempat').val('');
			$('#form-adv-src #srcKota').val('');
			$('#form-adv-src #srcNama').val('');
			displayAllData();
		})
	})
});
</script>