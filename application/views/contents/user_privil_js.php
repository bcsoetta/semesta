<script>

var uid = "<?php echo $_GET['uid']; ?>";
var base_url = "<?php echo base_url(); ?>";

$("#user_search_btn").on("click", function(e) {
	e.preventDefault();
	var search = $("#myInput").val();
	loadPagination(0, search, uid);
});

$('#paginationx').on('click', 'a', function (e) {
	e.preventDefault();
	var pageno = $(this).attr('data-ci-pagination-page');
	var search = $("#myInput").val();
	loadPagination(pageno, search, uid);
});

loadPagination(0, "", uid);

function loadPagination(pagno, search, uid) {
	$.ajax({
		url: '<?=base_url()?>user/load_privils_for_pagination/' + pagno + '?&search=' + search + '&uid=' + uid,
		type: 'get',
		dataType: 'json',
		success: function (response) {
			$('#paginationx').html(response.pagination);
			createTable(response.result, response.row);
		}
	});
}

function createTable(result, sno) {
	sno = Number(sno);
	$('#myList').empty();
	for (x in result) {
		sno += 1;
		var uli = "";
		uli += "<li class='list-item'>" +
			"<div class='pull-right'>" + 
				"<span class='btn btn-xs white btn-icon p-remove' uid='"+result[x].user_id+"' menu_id='"+result[x].menu_id+"'>" +
					"<i class='fa fa-trash p-edit'></i>" +
				"</span>" +
			"</div>" + 
			"<div class='list-body'>" +
				"<div>- &nbsp;</i><span>" + result[x].menu_parent + "/" + result[x].menu_child + "</span></div>" +
			"</div>" +
		"</li>";
		$('#myList').append(uli);
	}
}

$("#privref_search_btn").on("click", function(e) {
	e.preventDefault();
	var search = $("#privref_search").val();
	loadPaginationPrivref(0, search, uid);
});

$('#paginationz').on('click', 'a', function (e) {
	e.preventDefault();
	var pageno = $(this).attr('data-ci-pagination-page');
	var search = $("#privref_search").val();
	loadPaginationPrivref(pageno, search, uid);
});

$("#myBtnRef").on("click", function(e) {
	e.preventDefault();
	loadPaginationPrivref(0, "", uid);
});

function loadPaginationPrivref(pagno, search, uid) {
	$.ajax({
		url: '<?=base_url()?>user/load_privils_ref_for_pagination/' + pagno + '?&search=' + search + '&uid=' + uid,
		type: 'get',
		dataType: 'json',
		success: function (response) {
			$('#paginationz').html(response.pagination);
			createTableRef(response.result, response.row);
		}
	});
}

function createTableRef(result, sno, privils) {
	sno = Number(sno);
	$('#myListRef').empty();
	for (x in result) {
		sno += 1;
		var uli = "";
		if (result[x].menu_idx != null || result[x].menu_idx == "") {
			if (result[x].status == 100) {
				uli += "<li class='list-item'>" +
					"<div class='pull-right'>" +
						"<span class='btn btn-xs white btn-icon dis-privil-btn' uid='"+uid+"' menu_id='"+result[x].menu_id+"'>" +
							"<i class='fa fa-trash dis-privil'></i>" +
						"</span>" +
					"</div>" + 
					"<div class='list-body'>" +
						"<div>- &nbsp;</i><span>" + result[x].menu_parent + "/" + result[x].menu_child + "</span></div>" +
					"</div>" +
				"</li>";
			} else if (result[x].status == 400) {
				uli += "<li class='list-item'>" +
					"<div class='pull-right'>" +
						"<span class='btn btn-xs white btn-icon ena-privil-btn' uid='"+uid+"' menu_id='"+result[x].menu_id+"'>" +
							"<i class='fa fa-plus ena-privil'></i>" +
						"</span>" +
					"</div>" + 
					"<div class='list-body'>" +
						"<div>- &nbsp;</i><span>" + result[x].menu_parent + "/" + result[x].menu_child + "</span></div>" +
					"</div>" +
				"</li>";
			} else {
				uli += "<li class='list-item'>" +
					"<div class='pull-right'>" +
						"<span class='btn btn-xs white btn-icon nan-privil-btn' uid='"+uid+"' menu_id='"+result[x].menu_id+"'>" +
							"<i class='fa fa-check nan-privil'></i>" +
						"</span>" +
					"</div>" + 
					"<div class='list-body'>" +
						"<div>- &nbsp;</i><span>" + result[x].menu_parent + "/" + result[x].menu_child + "</span></div>" +
					"</div>" +
				"</li>";
			}
			
		} else {
			uli += "<li class='list-item'>" +
				"<div class='pull-right'>" +
					"<span class='btn btn-xs white btn-icon add-privil-btn' uid='"+uid+"' menu_id='"+result[x].menu_id+"'>" +
						"<i class='fa fa-plus add-privil'></i>" +
					"</span>" +
				"</div>" + 
				"<div class='list-body'>" +
					"<div>- &nbsp;</i><span>" + result[x].menu_parent + "/" + result[x].menu_child + "</span></div>" +
				"</div>" +
			"</li>";
		}
		
		$('#myListRef').append(uli);
	}
}

$(document).on('click', '.add-privil-btn', function() {
	$(this).find('.fa').remove();
	$(this).append("<i class='fa fa-trash dis-privil'></i>");
	$(this).removeClass('add-privil-btn').addClass('dis-privil-btn');
    var uid = $(this).attr("uid");
    var menu_id = $(this).attr("menu_id");
    var data_str = 'uid=' + uid + '&menu_id=' + menu_id;
    $.ajax({
		url: '<?php echo base_url(); ?>user/privil4_activate',
		method: 'POST',
		data: data_str,
		success: function(data) {
			console.log(data);
		},
		error: function(data) {
			console.log(data);
		}
	});  
});

$(document).on('click', '.dis-privil-btn', function() {
	$(this).find('.fa').remove();
	$(this).append("<i class='fa fa-plus ena-privil'></i>");
	$(this).removeClass('dis-privil-btn').addClass('ena-privil-btn');
    var uid = $(this).attr("uid");
    var menu_id = $(this).attr("menu_id");
    var data_str = 'uid=' + uid + '&menu_id=' + menu_id;
    $.ajax({
		url: '<?php echo base_url(); ?>user/privil4_disable',
		method: 'POST',
		data: data_str,
		success: function(data) {
			console.log(data);
		},
		error: function(data) {
			console.log(data);
		}
	});
});

$(document).on('click', '.ena-privil-btn', function() {
	$(this).find('.fa').remove();
	$(this).append("<i class='fa fa-trash dis-privil'></i>");
	$(this).removeClass('ena-privil-btn').addClass('dis-privil-btn');
    var uid = $(this).attr("uid");
    var menu_id = $(this).attr("menu_id");
    var data_str = 'uid=' + uid + '&menu_id=' + menu_id;
    
    $.ajax({
		url: '<?php echo base_url(); ?>user/privil4_enable',
		method: 'POST',
		data: data_str,
		success: function(data) {
			console.log(data);
		},
		error: function(data) {
			console.log(data);
		}
	});
});

$(document).on('click', '.p-remove', function() {
    var uid = $(this).attr("uid");
    var menu_id = $(this).attr("menu_id");
    var data_str = 'uid=' + uid + '&menu_id=' + menu_id;

    $.ajax({
		url: '<?php echo base_url(); ?>user/privil4_disable',
		method: 'POST',
		data: data_str,
		success: function(data) {
			console.log(data);
			window.location.href = "<?php echo base_url(); ?>" + "user/privil4/?uid=" + uid;
		},
		error: function(data) {
			console.log(data);
		}
	});
});

var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtnRef");
var span = document.getElementsByClassName("close")[0];
btn.onclick = function () {
	modal.style.display = "block";
}
span.onclick = function () {
	modal.style.display = "none";
	location.reload();
}
window.onclick = function (event) {
	if (event.target == modal) {
		modal.style.display = "none";
		location.reload();
	}
}

</script>

