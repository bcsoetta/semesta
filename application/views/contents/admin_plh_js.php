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
							{'data': 'jabatan'},
							{'data': 'nama'},
							{'data': 'nip'}
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
		$(document).on("paste keyup", ".input-pejabat", function() {
			pegawai = $(this).val();
			
			$.ajax({
				url: 'cari_pegawai',
				method: 'POST',
				data: {'pegawai' : pegawai},
				success: function(result) {
					if ($('#pejabat').val() == ""){
						$('#src_result_pejabat').empty();
						$('#src_result_pejabat').css('display', 'none');	
					} else {
						$('#src_result_pejabat').empty();
						$('#src_result_pejabat').css('display', 'block');

						$.each(result, function(key, val) {
							$('#src_result_pejabat').append("<div class='src-list' id='" + val.id + "'>" + val.nip + " - " + val.nama + "</div>");
						});

						$('#src_result_pejabat .src-list').click(function() {
				
							var selected = $(this).html();
							var id = $(this).attr('id');

							$('#pejabat').val(selected);
							$("input[name='id_pejabat']").val(id);
							$('#src_result_pejabat').css('display', 'none');

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
	})
</script>