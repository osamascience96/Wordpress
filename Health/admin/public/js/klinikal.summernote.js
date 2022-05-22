$(document).ready(function() {
	"use strict";
	$('.summernote').summernote({
		disableDragAndDrop: true,
		dialogsFade: true,
		height: 600,
		emptyPara: '',
		fontsize: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '30', '36', '48', '64'],
		toolbar: [
		['style', ['style']],
		['font', ['bold', 'underline', 'clear']],
		['fontname', ['fontname']],
		['fontsize', ['fontsize']],
		['color', ['color']],
		['para', ['ul', 'ol', 'paragraph']],
		['table', ['table']],
		['insert', ['link', 'image', 'video']],
		['view', ['fullscreen', 'codeview', 'help']]
		],
		buttons: {
			image: function() {
				var imageButton = $.summernote.ui.button({
					contents: '<i class="note-icon-picture" />',
					tooltip: $.summernote.lang[$.summernote.options.lang].image.image,
					click: function () {
						$("#media-upload .media-all").addClass('summernote-active');
						$("#media-upload").modal('show');
					}
				});
				return imageButton.render();
			}
		}
	});

	$('#media-upload').on('click', '.summernote-active .picture img', function(e) {
		e.preventDefault();
		$('.summernote').summernote('insertImage', $(this).attr('src'));
		$('#media-upload').modal('hide');
	});

	$('.mail-summernote').summernote({
		disableDragAndDrop: true,
		dialogsFade: true,
		height: 300,
		emptyPara: '',
		fontsize: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '30', '36', '48', '64'],
	});

});