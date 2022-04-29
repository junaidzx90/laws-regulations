const lr = new Vue({
	el: "#laws_regulations",
	data: {
		isDisabled: true,
		documents: [],
		filterYear: '',
		filterMinistry: '',
		currentpage: 1,
		max_pages: 0,
		isMobile: false,
		currentSelected: 'All',
		searchTerms: '',
		isSearchhResults: false
	},
	methods: {
		searchLrDocument: function (which) {
			switch (which) {
				case 'search':
					if (this.searchTerms !== "") {
						this.getFilterData('');
						this.isSearchhResults = true;
					}
					break;
				case 'clear':
					if (this.searchTerms !== "") {
						this.searchTerms = '';
						this.getFilterData('');
						this.isSearchhResults = false;
					}
					break;
			}
			
		},
		mobileMinistrySelector: function() {
			this.isMobile = true;
			jQuery('.lr_ministries .ministrySelectBox').addClass('openSelectItems');
		},
		loadmoreDocs: function () {
			this.searchTerms = '';
			let page = this.currentpage + 1;
			this.getFilterData('', page);
			this.currentpage += 1;
		},
		downloadFile: function (file, id, event) {
			jQuery.ajax({
				type: "post",
				url: lr_ajax.ajaxurl,
				data: {
					action: "download_a_file",
					id: id
				},
				beforeSend: () =>{
					jQuery(event.target).prop('disabled', true);
				},
				dataType: "json",
				success: function (response) {
					jQuery(event.target).removeAttr('disabled');

					if (response.success) {
						let field = lr.documents.find(el => el['id'] === id);
						field.downloads = response.success;
						
						let pdfLink = document.createElement('a');
						pdfLink.href = file;
						pdfLink.download = (new Date()).getTime()+'.pdf';
						pdfLink.dispatchEvent(new MouseEvent('click'));
					}
				}
			});
		},
		nFormatter: function(num, digits) {
			const lookup = [
			  { value: 1, symbol: "" },
			  { value: 1e3, symbol: "k" },
			  { value: 1e6, symbol: "M" },
			  { value: 1e9, symbol: "G" },
			  { value: 1e12, symbol: "T" },
			  { value: 1e15, symbol: "P" },
			  { value: 1e18, symbol: "E" }
			];
			const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
			var item = lookup.slice().reverse().find(function(item) {
			  return num >= item.value;
			});
			return item ? (num / item.value).toFixed(digits).replace(rx, "$1") + item.symbol : "0";
		},
		filterDocuments: function (filterType, search, event) {
			this.currentpage = 1;
			this.searchTerms = '';
			this.isSearchhResults = false;

			let targettext = jQuery(event.target).text();
			switch (filterType) {
				case 'ministry':
					this.filterMinistry = search;

					jQuery(document).find('.lr_ministries .lractive').removeClass('lractive');
					jQuery(event.target).addClass('lractive');

					this.getFilterData('', 1, targettext);
					break;
				case 'year':
					this.filterYear = search;

					jQuery(document).find('.lr_years .lractive').removeClass('lractive');
					jQuery(event.target).addClass('lractive');

					this.getFilterData('', 1);
					break;
			}
		},
		getFilterData: function (isfilter, page = 1, targettext = '') { 
			jQuery.ajax({
				type: "get",
				url: lr_ajax.ajaxurl,
				data: {
					action: "get_laws_regulations_documents",
					nonce: lr_ajax.nonce,
					ministry: lr.filterMinistry,
					year: lr.filterYear,
					searchTerms: lr.searchTerms,
					isfilter: isfilter,
					page: page
				},
				beforeSend: () => {
					lr.isDisabled = true;
				},
				dataType: "json",
				success: function (response) {
					lr.isDisabled = false;

					if (lr.isMobile) {
						jQuery('.lr_ministries .ministrySelectBox').removeClass('openSelectItems');
					}
					if (targettext !== "") {
						lr.currentSelected = targettext;	
					}

					if (response.documents) {
						if (page > 1) {
							response.documents.forEach(element => {
								lr.documents.push(element);
							});
						} else {
							lr.documents = response.documents;
						}
					}
					
					if (response.maxpages) {
						lr.max_pages = response.maxpages
					}

					jQuery([document.documentElement, document.body]).animate({
						scrollTop: jQuery(".lr_documents").offset().top-100
					}, 500);
				}
			});
		},
	},
	computed: {
		
	},
	updated: function () {
		jQuery(document).on('click', function (e) {
			if (jQuery(e.target).hasClass('ministrySelectBox')) {
				jQuery('.lr_ministries .ministrySelectBox').removeClass('openSelectItems');
			}
		});
	},
	mounted: function () {
		let lrResults = new Promise((resolve, reject) => {
			jQuery.ajax({
				type: "get",
				url: lr_ajax.ajaxurl,
				data: {
					action: "get_laws_regulations_documents",
					nonce: lr_ajax.nonce,
					isfilter: 'false'
				},
				dataType: "json",
				success: function (response) {
					resolve(response);
				}
			});
		});

		lrResults.then(response => {
			lr.isDisabled = false;
			
			if (response.documents) {
				lr.documents = response.documents;
			}
			if (response.maxpages) {
				lr.max_pages = response.maxpages
			}
		})
	}
});