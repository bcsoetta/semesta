<script src="<?php echo base_url('assets/libs/js/moment/moment.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/jquery/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>

<script>

var base_url = "<?php echo base_url(); ?>";

$('#datetimepicker1').datetimepicker({
	format: 'DD-MM-YYYY'
});

$('#datetimepicker2').datetimepicker({
	format: 'DD-MM-YYYY'
});


$("#user_search_btn").on("click", function(e) {
	e.preventDefault();
	var search = $("#myInput").val();
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	loadPagination(0, search, tglawal, tglakhir);
});

$('#pagination').on('click', 'a', function (e) {
	e.preventDefault();
	var pageno = $(this).attr('data-ci-pagination-page');
	var search = $("#myInput").val();
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	loadPagination(pageno, search, tglawal, tglakhir);
});

loadPagination(0, "", "", "");

function loadPagination(pagno, search, tglawal, tglakhir) {
	$.ajax({
		url: '<?=base_url()?>umum/load_ppkp_for_pagination/' + pagno + '?&search=' + search + '&tglawal=' + tglawal + '&tglakhir=' + tglakhir,
		type: 'get',
		dataType: 'json',
		success: function (response) {
			$('#pagination').html(response.pagination);
			createTable(response.result, response.row);
		}
	});
}

function createTable(result, sno) {
	sno = Number(sno);
	var base_url = "<?php echo base_url(); ?>";
	$('#myList').empty();
	// console.log(score);
	for (index in result) {
		// console.log(result);
		var id = result[index].ppkp_id;
		var tema = result[index].tema;
		var tempat = result[index].tempat;
		var tanggal = result[index].tanggal;
		var waktu_mulai = result[index].waktu_mulai;
		var waktu_selesai = result[index].waktu_selesai;
		var jum_peserta = result[index].jum_peserta;
		var nomor_surat = result[index].nomor_surat;
		var tanggal_surat = result[index].tanggal_surat;
		var penyelenggara = result[index].penyelenggara;
		var status = result[index].status;
		var post = result[index].post_test;
		var pre = result[index].pre_test;
		var sel = post - pre;
		sno += 1;
		var uli = "";

		uli += "<li class='list-item'>" +
			"<div class='m-y-sm pull-right'>" +
				"<a href='"+base_url+"umum/ppkp_update?pid="+id+"' class='btn btn-xs white btn-icon btn-update' tbid='"+id+"'>" +
					"<i class='fa fa-pencil p-score'></i>" +
				"</a>" +
				"<a href='"+base_url+"umum/ppkp?pid="+id+"' class='btn btn-xs white btn-icon btn-detil' tbid='"+id+"'>" +
					"<i class='fa fa-file-text-o p-hadir'></i>" +
				"</a>" +
			"</div>" +

			"<span class='list-left'>";

			if (status == 'Closed') {
				uli += "<span class='w-40 circle danger avatar'>";
			} else if (status == 'Open') {
				uli += "<span class='w-40 circle success avatar'>";
			} else {
				uli += "<span class='w-40 circle danger avatar'>";
			}
				
			uli += "<span>" + tema.charAt(0) + "</span>";

			if (status == "Open") {
				uli += "<i class='on b-white'></i>";
			} else {
				uli += "<i class='busy b-white'></i>";
			}
			uli += "</span>" +
			"</span>" +
			"<div class='list-body'>" +
				"<div><span href>" + tema + "</span></div>";

				if (post >= 7) {
				  	uli += "<small class='text-muted text-ellipsis'>" + nomor_surat + ' TGL. ' + tanggal_surat + "</small>";
				} else if (post == 6) {
					if (sel >= 2) {
						uli += "<small class='text-muted text-ellipsis'>" + nomor_surat + ' TGL. ' + tanggal_surat + "</small>";
					} else {
						uli += "<small class='text-muted text-ellipsis'>" + nomor_surat + ' TGL. ' + tanggal_surat + "</small>";
					}
				} else if (post == 5) {
					if (sel >= 3) {
						uli += "<small class='text-muted text-ellipsis'>" + nomor_surat + ' TGL. ' + tanggal_surat + "</small>";
					} else {
						uli += "<small class='text-muted text-ellipsis'>" + nomor_surat + ' TGL. ' + tanggal_surat + "</small>";
					}
				} else {
				  	uli += "<small class='text-muted text-ellipsis'>" + nomor_surat + ' TGL. ' + tanggal_surat + "</small>";
				}
				
			+ "</div>" +
		"</li>";

		$('#myList').append(uli);
	}
}

</script>

