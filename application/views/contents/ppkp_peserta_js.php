<script>
	
var pid = "<?php echo $_GET['pid']; ?>";
var base_url = "<?php echo base_url(); ?>";

$("#user_search_btn").on("click", function(e) {
	e.preventDefault();
	var search = $("#myInput").val();
	loadPagination(0, search, pid);
});

// Detect pagination click
$('#pagination').on('click', 'a', function (e) {
	e.preventDefault();
	var pageno = $(this).attr('data-ci-pagination-page');
	var search = $("#myInput").val();
	loadPagination(pageno, search, pid);
});

loadPagination(0, "", pid);
// Load pagination
function loadPagination(pagno, search, pid) {
	$.ajax({
		url: '<?=base_url()?>umum/load_user_for_pagination/' + pagno + '?&search=' + search + '&pid=' + pid,
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
		var nama = result[index].nama;
		var nip = result[index].nip;
		var kehadiran = result[index].kehadiran;
		var pre = result[index].pre_test;
		var post = result[index].post_test;
		var sel = post - pre;
		sno += 1;
		var uli = "";

		uli += "<li class='list-item'>" +
			"<div class='m-y-sm pull-right'>";
				if (kehadiran == 'Y') {
					uli += "<a class='btn btn-xs white btn-icon p-score' tbid='"+id+"'>" +
						"<i class='fa fa-pencil p-score'></i>" +
					"</a>" +
					"<a class='btn btn-xs white btn-icon btn-hadir' tbid='"+id+"'>" +
						"<i class='fa fa-times p-hadir'></i>" +
					"</a>";
				} else if (kehadiran == 'N') {
					uli += "<a class='btn btn-xs white btn-icon p-score p-score-hide' tbid='"+id+"'>" +
						"<i class='fa fa-pencil p-score'></i>" +
					"</a>" +
					"<a class='btn btn-xs white btn-icon btn-thadir' tbid='"+id+"'>" +
						"<i class='fa fa-check p-thadir'></i>" +
					"</a>";
				} else {
					uli += "<a class='btn btn-xs white btn-icon p-score p-score-hide' tbid='"+id+"'>" +
						"<i class='fa fa-pencil p-score'></i>" +
					"</a>" +
					"<a class='btn btn-xs white btn-icon btn-thadir' tbid='"+id+"'>" +
						"<i class='fa fa-check p-thadir'></i>" +
					"</a>";
				}

			uli += "</div>" + 
			
			"<span class='list-left'>";

			if (kehadiran == 'N') {
				uli += "<span class='w-40 circle danger avatar'>";
			} else if (kehadiran == 'Y') {
				uli += "<span class='w-40 circle success avatar'>";
			} else {
				uli += "<span class='w-40 circle danger avatar'>";
			}
				
			uli += "<span>" + nama.charAt(0) + "</span>";

			if (kehadiran == "Y") {
				uli += "<i class='on b-white'></i>";
			} else {
				uli += "<i class='busy b-white'></i>";
			}
			uli += "</span>" +
			"</span>" +
			"<div class='list-body'>" +
				"<div><span href>" + nama + "</span></div>";

				if (post >= 7) {
				  	uli += "<small class='text-muted text-ellipsis'>" + nip + " <span class='efektif'>(E)</span>" + "</small>";
				} else if (post == 6) {
					if (sel >= 2) {
						uli += "<small class='text-muted text-ellipsis'>" + nip + " <span class='efektif'>(E)</span>" + "</small>";
					} else {
						uli += "<small class='text-muted text-ellipsis'>" + nip + " <span class='tefektif'>(TE)</span>" + "</small>";
					}
				} else if (post == 5) {
					if (sel >= 3) {
						uli += "<small class='text-muted text-ellipsis'>" + nip + " <span class='efektif'>(E)</span>" + "</small>";
					} else {
						uli += "<small class='text-muted text-ellipsis'>" + nip + " <span class='tefektif'>(TE)</span>" + "</small>";
					}
				} else {
				  	uli += "<small class='text-muted text-ellipsis'>" + nip + " <span class='tefektif'>(TE)</span>" + "</small>";
				}
				

			+ "</div>" +
		"</li>";
		$('#myList').append(uli);
	}
}

$(document).on('click', '.btn-hadir', function(e) {
	e.preventDefault();
	$(this).parent().siblings('.list-left').children('span').removeClass('success').addClass('danger');
	$(this).parent().siblings('.list-left').find('i').removeClass('on').addClass('busy');
	$(this).parent().siblings('.list-body').children('small').find('span').text('(TE)');
	$(this).parent().siblings('.list-body').children('small').find('span').css( "color", "red" );
	$(this).removeClass('btn-hadir').addClass('btn-thadir');
	$(this).find('i').removeClass('fa-times p-hadir').addClass('fa-check p-thadir');
	$(this).siblings('.p-score').hide();

	var text_hadir = $(".hadir").text();
	var num_hadir = parseInt(text_hadir, 10);
	var new_hadir = num_hadir - 1;

	var text_tidak_hadir = $(".tidak_hadir").text();
	var num_tidak_hadir = parseInt(text_tidak_hadir, 10);
	var new_tidak_hadir = num_tidak_hadir + 1;

	$(".hadir").text(new_hadir);
	$(".tidak_hadir").text(new_tidak_hadir);

	var tbid = $(this).attr('tbid');
    var dstr = 'tbid=' + tbid;

    $.ajax({
		url: '<?php echo base_url(); ?>umum/absen_tidak_hadir',
		method: 'POST',
		data: dstr,
		success: function(data) {
			console.log(data);
		},
		error: function(data) {
			console.log(data);
		}
	});  

});

$(document).on('click', '.btn-thadir', function(e) {
	e.preventDefault();
	$(this).parent().siblings('.list-left').children('span').removeClass('danger').addClass('success');
	$(this).parent().siblings('.list-left').find('i').removeClass('busy').addClass('on');
	$(this).parent().siblings('.list-body').children('small').find('span').text('(TE)');
	$(this).parent().siblings('.list-body').children('small').find('span').css( "color", "red" );
	$(this).removeClass('btn-thadir').addClass('btn-hadir');
	$(this).find('i').removeClass('fa-check p-thadir').addClass('fa-times p-hadir');
	$(this).siblings('.p-score-hide').removeClass('p-score-hide');
	$(this).siblings('.p-score').show();

	var text_hadir = $(".hadir").text();
	var num_hadir = parseInt(text_hadir, 10);
	var new_hadir = num_hadir + 1;

	var text_tidak_hadir = $(".tidak_hadir").text();
	var num_tidak_hadir = parseInt(text_tidak_hadir, 10);
	var new_tidak_hadir = num_tidak_hadir - 1;

	$(".hadir").text(new_hadir);
	$(".tidak_hadir").text(new_tidak_hadir);

	var tbid = $(this).attr('tbid');
    var dstr = 'tbid=' + tbid;
    
 	$.ajax({
		url: '<?php echo base_url(); ?>umum/absen_hadir',
		method: 'POST',
		data: dstr,
		success: function(data) {
			console.log(data);
		},
		error: function(data) {
			console.log(data);
		}
	});  

});

var modal2 = document.getElementById('myModal2');
var span2 = document.getElementsByClassName("close")[1];

$(document).on('click', '.p-score', function(e) {
	e.preventDefault();
	modal2.style.display = "block";

	var tbid = $(this).attr('tbid');
    var dstr = 'tbid=' + tbid;
    
 	$.ajax({
		url: '<?php echo base_url(); ?>umum/scoring',
		method: 'POST',
		data: dstr,
		dataType: "json",
		success: function(data) {
			console.log(data);
			$("#scoring-title").text(data.nama + " / " + data.nip);
			$("#tbid").val(data.id);
			$("#pre-test").val(data.pre_test);
			$("#post-test").val(data.post_test);
		},
		error: function(data) {
			console.log(data);
		}
	});  
});

$("#btn-scoring").click(function() {
	var pre_test = $("#pre-test").val();
	var post_test = $("#post-test").val();
	var tbid = $("#tbid").val();
	var dstr = 'pre_test=' + pre_test + '&post_test=' + post_test + '&tbid=' + tbid;

	$.ajax({
		url: '<?php echo base_url(); ?>umum/scoring_',
		method: 'POST',
		data: dstr,
		success: function(data) {
			console.log(data);
			location.reload();
		},
		error: function(data) {
			console.log(data);
		}
	});

});

span2.onclick = function () {
	modal2.style.display = "none";
	location.reload();
}
window.onclick = function (event) {
	if (event.target == modal2) {
		modal2.style.display = "none";
		location.reload();
	}
}

$("#privref_search_btn").on("click", function(e) {
	e.preventDefault();
	var search = $("#privref_search").val();
	loadPaginationPrivref(0, search, pid);
});

$('#paginationz').on('click', 'a', function (e) {
	e.preventDefault();
	var pageno = $(this).attr('data-ci-pagination-page');
	var search = $("#privref_search").val();
	loadPaginationPrivref(pageno, search, pid);
});

$("#myBtnRef").on("click", function(e) {
	e.preventDefault();
	loadPaginationPrivref(0, "", pid);
});

function loadPaginationPrivref(pagno, search, pid) {
	$.ajax({
		url: '<?=base_url()?>umum/load_privils_ref_for_pagination/' + pagno + '?&search=' + search + '&pid=' + pid,
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
		console.log(result);
		sno += 1;
		var uli = "";
		if (result[x].nama != null || result[x].nama == "") {
			if (result[x].kehadiran !== 'nan') {
				uli += "<li class='list-item'>" +
					"<div class='pull-right'>" +
						"<span class='btn btn-xs white btn-icon dis-privil-btn' nip='"+result[x].nip+"' priv_name='"+result[x].nama+"'>" +
							"<i class='fa fa-trash dis-privil'></i>" +
						"</span>" +
					"</div>" + 
					"<div class='list-body'>" +
						"<div>- &nbsp;</i><span>" + result[x].nama + "</span></div>" +
					"</div>" +
				"</li>";
			} else if (result[x].kehadiran == 'nan') {
				uli += "<li class='list-item'>" +
					"<div class='pull-right'>" +
						"<span class='btn btn-xs white btn-icon add-privil-btn' nip='"+result[x].nip+"' priv_name='"+result[x].nama+"'>" +
							"<i class='fa fa-plus add-privil'></i>" +
						"</span>" +
					"</div>" + 
					"<div class='list-body'>" +
						"<div>- &nbsp;</i><span>" + result[x].nama + "</span></div>" +
					"</div>" +
				"</li>";
			} else {
				uli += "<li class='list-item'>" +
					"<div class='pull-right'>" +
						"<span class='btn btn-xs white btn-icon nan-privil-btn' nip='"+result[x].nip+"' priv_name='"+result[x].nama+"'>" +
							"<i class='fa fa-plus nan-privil'></i>" +
						"</span>" +
					"</div>" + 
					"<div class='list-body'>" +
						"<div>- &nbsp;</i><span>" + result[x].nama + "</span></div>" +
					"</div>" +
				"</li>";
			}
			
		} else {
			uli += "<li class='list-item'>" +
				"<div class='pull-right'>" +
					"<span class='btn btn-xs white btn-icon nan-privil-btn' nip='"+result[x].nip+"' priv_name='"+result[x].nama+"'>" +
						"<i class='fa fa-check nan-privil'></i>" +
					"</span>" +
				"</div>" + 
				"<div class='list-body'>" +
					"<div>- &nbsp;</i><span>" + result[x].nama + "</span></div>" +
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
    var nama = $(this).attr("priv_name");
    var nip = $(this).attr("nip");
    var data_str = 'pid=' + pid + '&nama=' + nama + '&nip=' + nip;
    $.ajax({
		url: '<?php echo base_url(); ?>umum/tambah_peserta_ppkp',
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
	$(this).append("<i class='fa fa-plus add-privil'></i>");
	$(this).removeClass('dis-privil-btn').addClass('add-privil-btn');
    var nama = $(this).attr("priv_name");
    var nip = $(this).attr("nip");
    var data_str = 'pid=' + pid + '&nama=' + nama + '&nip=' + nip;
    $.ajax({
		url: '<?php echo base_url(); ?>umum/hapus_peserta_ppkp',
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

var modal1 = document.getElementById('myModal');
var btn1 = document.getElementById("myBtnRef");
var span1 = document.getElementsByClassName("close")[0];
btn1.onclick = function () {
	modal1.style.display = "block";
}
span1.onclick = function () {
	modal1.style.display = "none";
	location.reload();
}
window.onclick = function (event) {
	if (event.target == modal1) {
		modal1.style.display = "none";
		location.reload();
	}
}

</script>

