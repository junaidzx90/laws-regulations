jQuery(function( $ ) {
	'use strict';

	function lr_pdf_view(pFile) {
		let filename = '', canvas;
		filename = pFile.split('/').pop()

		let pdfjsLib = window['pdfjs-dist/build/pdf'];

		// The workerSrc property shall be specified.
		pdfjsLib.GlobalWorkerOptions.workerSrc = 'pdf.warker.js';
		canvas = document.createElement("CANVAS");
		let pdfDoc = null,
		scale = 1, viewport,
		ctx = canvas.getContext('2d');
		
		function renderPage() {
			// Using promise to fetch the page
			pdfDoc.getPage(1).then(function (page) {
				viewport = page.getViewport({ scale: scale });
				canvas.height = viewport.height;
				canvas.width = viewport.width;
		
				// Render PDF page into canvas context
				let renderContext = {
					canvasContext: ctx,
					viewport: viewport
				};
				let renderTask = page.render(renderContext);
				// Wait for rendering to finish
				renderTask.promise.then(function () {
					$('#lr_pdf_view').attr("src", canvas.toDataURL('image/jpeg'));
				});
			});
		}

		pdfjsLib.getDocument(pFile).promise.then(function (pdfDoc_) {
			pdfDoc = pdfDoc_;
			renderPage();
		});
	}

	function loadFile() {
		let pdfFile, selectedFile;
		// If the frame already exists, re-open it.
		if ( pdfFile ) {
			pdfFile.open();
			return;
		}
		//Extend the wp.media object
		pdfFile = wp.media.frames.file_frame = wp.media({
			title: 'Choose PDF',
			button: {
				text: 'Choose PDF'
			},
			library: {
				type: ['application/pdf']
			},
			multiple: false
		});

		//When a file is selected, grab the URL and set it as the text field's value
		pdfFile.on('select', function() {
			selectedFile = pdfFile.state().get('selection').first().toJSON();
			lr_pdf_view(selectedFile.url);
			$('#lr_document_file').val(selectedFile.url);
		});

		//Open the uploader dialog
		pdfFile.open();
	}
	
	if ($(document).find('#lr_document_file').length > 0) {
		if ($('#lr_document_file').val() !== "") {
			lr_pdf_view($('#lr_document_file').val());
		}
	}

	$('.lr_document_btn').on("click", ()=>{
		loadFile();
	});

	$('#lr_static_color').wpColorPicker();
	$('#lr_selected_color').wpColorPicker();
	$('#lr_section_heading_text_color').wpColorPicker();
	$('#lr_doc_title_color').wpColorPicker();
	$('#lr_doc_date_color').wpColorPicker();
	$('#lr_loadmore_btn_bg_color').wpColorPicker();
	$('#lr_download_counter_font_color').wpColorPicker();

});
