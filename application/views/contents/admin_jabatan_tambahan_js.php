<script src="<?php echo base_url('assets/libs/jquery/datatables/js/datatables.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// Menampilkan daftar Plh
		function showDataTable() {
			$.ajax({
				url: 'jabatan_tambahan_list',
				method: 'POST',
				success: function(result) {
					$('#table-pejabat-tambahan').DataTable({
						'destroy': true,
						'data': result,
						'columns': [
							{'data': 'level'},
							{'data': 'jabatan'},
							{'data': 'nama'},
							{'data': 'nip'},
							{
								'data': null,
								'render': function (data, type, row) {
									button_del = "<a id='" + data.id + "' class='delete-data'><i class='fa fa-trash text-danger' data-toggle='modal' data-target='#modal-konfirmasi'></i></a>";

									return button_del;
								},
								'width': '5%'
							}
						]
					});
				}
			});
		};

		showDataTable();

		// $('#formFilter').submit(function(e) {
		// 	e.preventDefault();
		// 	date = $('#select_date').val();

		// 	showListPlh(date);
		// })

		// Mencari pegawai
		// $(document).on("paste keyup", ".src-input", function() {
		// 	pegawai = $(this).val();
		// 	var input = $(this);
		// 	var submit = $(this).siblings('.src-submit');
		// 	var display = $(this).siblings('.src-result');
			
		// 	$.ajax({
		// 		url: 'cari_pegawai',
		// 		method: 'POST',
		// 		data: {'pegawai' : pegawai},
		// 		success: function(result) {
		// 			if (input.val() == ""){
		// 				display.empty();
		// 				display.css('display', 'none');	
		// 			} else {
		// 				display.empty();
		// 				display.css('display', 'block');

		// 				$.each(result, function(key, val) {
		// 					display.append("<div class='src-list' id='" + val.id + "'>" + val.nip + " - " + val.nama + "</div>");
		// 				});

		// 				display.children('.src-list').click(function() {
				
		// 					var selected = $(this).html();
		// 					var id = $(this).attr('id');

		// 					input.val(selected);
		// 					submit.val(id);
		// 					display.css('display', 'none');

		// 				})
		// 			}
		// 		}
		// 	})
		// });

		// Menyimpan Plh
		$(document).on('click', '#formPejabatTambahan #btnSubmit', function(e) {
			e.preventDefault();
			var input = $('#formPejabatTambahan').serialize();

			$.ajax({
				url: 'jabatan_tambahan_save',
				method: 'POST',
				data: input,
				success: function(result) {
					if (result['status'] == 1) {
						$('.my-message').removeClass('warning').addClass('primary');
					} else {
						$('.my-message').removeClass('primary').addClass('warning');
					}
					$('.my-message').html(result['message']);
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();
					
					showDataTable();
				}
			})
		})

		// Menampilkan konfirmasi hapus plh
		$(document).on('click', '.delete-data', function (e) {
			e.preventDefault();
			del_id = $(this).attr('id');
			$.ajax({
				url: 'jabatan_tambahan_show',
				method: 'POST',
				data: {'id': del_id},
				success: function (result) {
					$('#modal-konfirmasi .modal-body p').html('Yakin untuk menghapus pejabat <strong>' + result['jabatan'] + '</strong> di <strong>' + result['level'] + '</strong> ?');
				}
			})
		})

		// Menghapus plh
		$(document).on('click', '#modal-konfirmasi #btnDelConfirm', function (e) {
			$.ajax({
				url: 'jabatan_tambahan_delete',
				method: 'POST',
				data: {'id': del_id},
				success: function (result) {
					if (result['status'] == 1) {
						$('.my-message').removeClass('warning').addClass('primary');
					} else {
						$('.my-message').removeClass('primary').addClass('warning');
					}
					$('.my-message').html(result['message']);
					$('.my-message').css('display', 'block');
					$('.my-message').delay(3000).fadeOut();

					$('#modal-konfirmasi').modal('toggle');
					
					showDataTable();
				}
			})
		})
	})
</script>