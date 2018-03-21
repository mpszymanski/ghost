/*
 * Datepicker
 */
require('@fengyuanchen/datepicker/dist/datepicker.js')

$(function() {
	$('[data-toggle="datepicker"]').datepicker({
		format: 'dd.mm.yyyy'
	})
})

/**
 * Input mask
 */
require('inputmask')
require('inputmask/dist/inputmask/inputmask.date.extensions')
require('inputmask/dist/inputmask/jquery.inputmask.js')

/**
 * Moment.js
 */
moment = require('moment')