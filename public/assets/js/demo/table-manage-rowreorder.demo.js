/*
Template Name: Paisaley - Responsive Admin Dashboard Template
Author: Paisaley
Website: http://www.Paisaley.com/
*/

var handleDataTableRowReorder = function() {
	"use strict";
    
	if ($('#data-table-rowreorder').length !== 0) {
		$('#data-table-rowreorder').DataTable({
			responsive: true,
			rowReorder: true
		});
	}
};

var TableManageRowReorder = function () {
	"use strict";
	return {
		//main function
		init: function () {
			handleDataTableRowReorder();
		}
	};
}();

$(document).ready(function() {
	TableManageRowReorder.init();
});