<script>

	// $(document).ready(function(){
	// 	$("#myInput").on("keyup", function() {
	// 		var value = $(this).val().toLowerCase();
	// 		$("#myList li").filter(function() {
	// 			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	// 		});
	// 	});
	// });

	$("#user_search_btn").on("click", function(e) {
		e.preventDefault();
		var search = $("#myInput").val();
		loadPagination(0, search);
	});

	// Detect pagination click
	$('#pagination').on('click', 'a', function (e) {
		e.preventDefault();
		var pageno = $(this).attr('data-ci-pagination-page');
		var search = $("#myInput").val();
		loadPagination(pageno, search);
	});

	loadPagination(0, "");
	// Load pagination
	function loadPagination(pagno, search) {
		$.ajax({
			url: '<?=base_url()?>guide/load_guide_for_pagination/' + pagno + '?&search=' + search,
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
			var id = result[index].id;
			var guide_title = result[index].guide_title;
			var name = result[index].name;
			var guide_date = result[index].guide_date;
			var guide_status = result[index].guide_status;
			sno += 1;
			var uli = "";
			uli += "<li class='list-item'>" +
				"<div class='m-y-sm pull-right'>" + 
					"<a class='btn btn-xs white btn-icon p-edit' href='" + base_url + "guide/update/?gid=" + id + "'>" +
						"<i class='fa fa-pencil p-edit'></i>" +
					"</a>" +
				"</div>" +
				"<div class='list-body guide_list'>" +
					"<div><a href='" + base_url + "guide/read/?gid=" + id + "'>" + guide_title + "</a></div>" +
					"<small class='text-muted guide_content'>" + '<span class="label purple">' + guide_status + '</span> ' + "</small>" +
				"</div>" +
			"</li>";
			$('#myList').append(uli);
		}
	}


</script>

