<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// Menampilkan daftar Plh
		function showListPlh(input = '') {
			$.ajax({
				url: 'daftar_plh',
				method: 'POST',
				data: {'tgl' : input},
				success: function(result) {
					$('#table-plh').DataTable({
						'destroy': true,
						'data': result,
						'columns': [
							{
								'data': 'tgl',
								'width': '15%'
							},
							{'data': 'jabatan'},
							{'data': 'nama'},
							{'data': 'nip'},
							{
								'data': null,
								'render': function (data, type, row) {
									button_edit = "<a href='#' id='" + data.id + "' class='edit-plh'><i class='fa fa-edit text-primary' data-toggle='modal' data-target='#modal-edit'></i></a>";
									button_del = "<a href='#' id='" + data.id + "' class='delete-plh'><i class='fa fa-trash text-danger' data-toggle='modal' data-target='#modal-konfirmasi'></i></a>";

									return button_edit + '&nbsp;' + button_del;
								},
								'width': '5%'
							}
						]
					});
				}
			});
		};

		showListPlh();

		$('#formFilter').submit(function(e) {
			e.preventDefault();
			date = $('#select_date').val();

			showListPlh(date);
		})

		// Mencari pegawai
		$(document).on("paste keyup", ".src-input", function() {
			pegawai = $(this).val();
			var input = $(this);
			var submit = $(this).siblings('.src-submit');
			var display = $(this).siblings('.src-result');
			
			$.ajax({
				url: 'cari_pegawai',
				method: 'POST',
				data: {'pegawai' : pegawai},
				success: function(result) {
					if (input.val() == ""){
						display.empty();
						display.css('display', 'none');	
					} else {
						display.empty();
						display.css('display', 'block');

						$.each(result, function(key, val) {
							display.append("<div class='src-list' id='" + val.id + "'>" + val.nip + " - " + val.nama + "</div>");
						});

						display.children('.src-list').click(function() {
				
							var selected = $(this).html();
							var id = $(this).attr('id');

							input.val(selected);
							submit.val(id);
							display.css('display', 'none');

						})
					}
				}
			})
		});

		// Menyimpan Plh
		$('#formPlh').submit(function(e) {
			e.preventDefault();
			var input = $('#formPlh').serialize();

			$.ajax({
				url: 'simpan_plh',
				method: 'POST',
				data: input,
				success: function() {
					showListPlh();
				}
			})
		})

		// Menampilkan data untuk diedit
		$(document).on('click', '.edit-plh', function (e) {
			e.preventDefault();
			var id_plh = $(this).attr('id');
			$.ajax({
				url: 'plh_show',
				method: 'POST',
				data: {'id': id_plh},
				success: function (result) {
					$('#inpIdPlh').val(result['id']);
					$('#inpJabatan').val(result['ur_jabatan']);
					$('#inpIdPejabat').val(result['plh']);
					$('#inpPlh').val(result['nip'] + ' - ' + result['nama']);
				}
			})
		})

		// Menyimpan update plh
		$(document).on('click', '#modal-edit #btnUpdate', function (e) {
			e.preventDefault();
			var input = $('#formEditPlh').serialize();
			$.ajax({
				url: 'plh_update',
				method: 'POST',
				data: input,
				success: function (result) {
					$('#modal-edit').modal('toggle');
					$('.my-message').html('ST berhasil disimpan');
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();
					showListPlh();
				}
			})
		})

		// Menampilkan konfirmasi hapus plh
		$(document).on('click', '.delete-plh', function (e) {
			e.preventDefault();
			del_id = $(this).attr('id');
			$.ajax({
				url: 'plh_show',
				method: 'POST',
				data: {'id': del_id},
				success: function (result) {
					$('#modal-konfirmasi .modal-body p').html('Yakin untuk menghapus pejabat Plh <strong>' + result['ur_jabatan'] + '</strong> tanggal <strong>' + result['tgl'] + '</strong> ?');
				}
			})
		})

		// Menghapus plh
		$(document).on('click', '#modal-konfirmasi #btnDelConfirm', function (e) {
			$.ajax({
				url: 'plh_delete',
				method: 'POST',
				data: {'id': del_id},
				success: function (result) {
					$('#modal-konfirmasi').modal('toggle');
					$('.my-message').html(result);
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();
					showListPlh();
				}
			})
		})
	})
</script>