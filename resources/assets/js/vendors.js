/*
 * Datepicker
 */
require('@fengyuanchen/datepicker/dist/datepicker.js');

$(function() {
	$('[data-toggle="datepicker"]').datepicker({
		format: 'dd.mm.yyyy'
	})
})