<link rel="stylesheet" href="<?php echo base_url('assets/libs/jquery/summernote/dist/summernote.css'); ?>" type="text/css" />
<script src="<?php echo base_url('assets/libs/jquery/summernote/dist/summernote.js'); ?>"></script>

<script>

	$(document).ready(function() {

		$('#summernote').summernote({
			toolbar: [
				['style', ['bold', 'italic', 'underline', 'clear']],
				['font', ['strikethrough', 'superscript', 'subscript']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']]
			],
			tabsize: 2,
        	height: 300
		});

		$(".btn-publish").on("click", function() {
			var guide_title = $("#guide_title").val();
			var markupStr = $('#summernote').summernote('code');
			var guide_content = $('.note-editable').html();
			var data = 'guide_title=' + guide_title + '&guide_content=' + guide_content;

			if (guide_title == "" || guide_content == "" || guide_content == "<p><br></p>") {
				alert("Tidak boleh ada yang kosong..");
				return false;
			}
			
			$.ajax({
				url: 'create_',
				method: 'POST',
				data: data,
				success: function(data) {
					$(".btn-publish-info").show();
					setTimeout(function() { $(".btn-publish-info").hide(); }, 2500);
					console.log(data);
				},
				error: function(data) {
					console.log(data);
				}
			})
		});
	});
</script>