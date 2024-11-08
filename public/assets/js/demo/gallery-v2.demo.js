/*
Template Name: Paisaley - Responsive Admin Dashboard Template
Author: Paisaley
Website: http://www.Paisaley.com/
*/

var handleSuperboxGallery = function() {
	"use strict";
	$('.superbox').SuperBox({
		background : '#242a30',
		border : 'rgba(0,0,0,0.1)',
		xColor : '#a8acb1',
		xShadow : 'embed'
	});
};


var GalleryV2 = function () {
	"use strict";
	return {
		//main function
		init: function () {
			handleSuperboxGallery();
		}
	};
}();

$(document).ready(function() {
	GalleryV2.init();
});