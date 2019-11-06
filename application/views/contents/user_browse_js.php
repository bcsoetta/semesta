<script>

$("#user_search_btn").on("click", function(e) {
	e.preventDefault();
	var search = $("#myInput").val();
	loadPagination(0, search);
});

$('#pagination').on('click', 'a', function (e) {
	e.preventDefault();
	var pageno = $(this).attr('data-ci-pagination-page');
	var search = $("#myInput").val();
	loadPagination(pageno, search);
});

loadPagination(0, "");

function loadPagination(pagno, search) {
	$.ajax({
		url: '<?=base_url()?>user/load_user_for_pagination/' + pagno + '?&search=' + search,
		type: 'get',
		dataType: 'json',
		success: function (response) {
			$('#pagination').html(response.pagination);
			createTable(response.result, response.row);
		}
	});
}

// Create table list
function createTable(result, sno) {
	sno = Number(sno);
	var base_url = "<?php echo base_url(); ?>";
	$('#myList').empty();
	for (index in result) {
		var user_id = result[index].user_id;
		var role = result[index].role;
		var name = result[index].name;
		var status = result[index].status;
		sno += 1;
		var uli = "";
		uli += "<li class='list-item'>" +
			"<div class='m-y-sm pull-right'>" + 
				"<a class='btn btn-xs white btn-icon p-privil' href='" + base_url + "user/privil4/?uid=" + user_id + "'>" +
					"<i class='fa fa-user p-privil'></i>" +
				"</a>" +
				"<a class='btn btn-xs white btn-icon p-edit' href='" + base_url + "user/update/?uid=" + user_id + "'>" +
					"<i class='fa fa-pencil p-edit'></i>" +
				"</a>" +
			"</div>" + 
			
			"<span class='list-left'>";

			if (role == 'default') {
				uli += "<span class='w-40 circle accent avatar'>";
			} else if (role == 'administrator') {
				uli += "<span class='w-40 circle success avatar'>";
			} else if (role == 'kasi') {
				uli += "<span class='w-40 circle warn avatar'>";
			} else if (role == 'kabid') {
				uli += "<span class='w-40 circle warning avatar'>";
			} else {
				uli += "<span class='w-40 circle danger avatar'>";
			}
				
			uli += "<span>" + name.charAt(0) + "</span>";

			if (status == 100) {
				uli += "<i class='on b-white'></i>";
			} else {
				uli += "<i class='busy b-white'></i>";
			}
			uli += "</span>" +
			"</span>" +
			"<div class='list-body'>" +
				"<div><span href>" + name + "</span></div>" +
				"<small class='text-muted text-ellipsis'>" + role + "</small>" +
			"</div>" +
		"</li>";
		$('#myList').append(uli);
	}
}

</script>

