/*
Template Name: Paisaley - Responsive Admin Dashboard Template
Author: Paisaley
Website: http://www.Paisaley.com/
*/

var handleDataTableResponsive = function() {
	"use strict";

	if ($('#data-table-responsive').length !== 0) {
		$('#data-table-responsive').DataTable({
			responsive: true
		});
	}
};

var TableManageResponsive = function () {
	"use strict";
	return {
		//main function
		init: function () {
			handleDataTableResponsive();
		}
	};
}();

$(document).ready(function() {
	TableManageResponsive.init();
});