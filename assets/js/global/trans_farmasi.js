
// 	fungsi set separator
function setRmSeparator($inputObj) {
	var getRm = $inputObj.val();
	if(getRm.indexOf('.') === -1 && getRm.length){
		s1 = getRm.substring(0,2);
		s2 = getRm.substring(2,4);
		s3 = getRm.substring(4,6);
		s4 = getRm.substring(6,8);
		newVal = s1+'.'+s2+'.'+s3+'.'+s4;
		$inputObj.val(newVal);
	};
}; // end of setRMSeparator

// fungsi format no rm
function rmFormater($inputObj) {
	var noRm = $inputObj.val();
	$inputObj.val(noRm.padding('00000000','left'));
	setRmSeparator($inputObj);
}; // end of rmFormatter


$(document).ready(function() {
	// $(document).on('mousedown','select[multiple][data-without-ctrl="true"] option', function(e){
	// 	if (e.which === 1) {
	// 		$(this).prop('selected', !$(this).prop('selected'));
	// 		return false;
	// 	};
	// });

	// masking tanggal
	$('.tanggal').each(function(index, el) {
		if ($(this).data('format')) {
			$(this).mask($(this).data('format').replace(/[a-zA-Z]/g, '9'));
		}
		else {
			$(this).mask("99-99-9999 99:99");
		};
	});
	$('.data-mask').each(function() {
		$(this).mask($(this).data('mask'));
	});
	$('input.inputmask').each(function() {
		$(this).inputmask();
	});
	$('.date').datetimepicker({
		autoclose: true
	});

	$('select[readonly]').each(function(index, el) {
		$(this).children('option:not(:selected)').prop('disabled', true);
	});

	$('#notifikasi').prop('title', 'Klik untuk menutup notifikasi')
	.on('click', function(event) {
		$(this).fadeOut('500');
	});

	$(document).on('click', '#notifikasi button.close', function(event) {
		event.preventDefault();
		$('#notifikasi').fadeOut('500');
	});
	
	$('#loading').on('hidden', function () {
		$('#loading-notif').text('');
	});

	//auto input enter
	$(document).on('keydown', 'input,select,textarea', function(event) {
		if (!event.altKey && !event.shiftKey && !event.ctrlKey && event.keyCode === 13 && !$(this).hasClass('handsontableInput') && !$(this).hasClass('excludeInput')) {
			//event.preventDefault();
			var formInput = $(document).find('input,select,textarea').not('.handsontableInput');
			var idx = formInput.index(this);
			if (idx > -1 && (idx + 1 < formInput.length)) {
				var nextInput = formInput[idx + 1];
				while ((nextInput.disabled || nextInput.type === 'hidden' || nextInput.readOnly) && (idx + 1 < formInput.length) && typeof nextInput !== 'undefined') {
					idx++;
					nextInput = formInput[idx + 1];
				};
				try{
					if (nextInput.type == 'text') {
						nextInput.select();
					}
					else {
						nextInput.focus();
					};
				}
				catch(e){
				}
			};
			//return false;
		};
	});

	excludedKeyCode = [
		8, // backspace
		90, // z undo
		88, // x cut
		67, // c copy
		86, // v paste
		37, // left
		38, // up
		39, // right
		40, // bottom
		33, // pg-up
		34, // pg-down
		35, // end
		36, // home
		45, // insert
		46, // delete
		112,113,114,115,116,117,118,119,120,121,122,123, // F1-F12
	];
	// hotkey event handler
	// by nanda
	$(document).on('keydown', function(evt) {
		// disable fungsi default browser utk tombol ctrl dan alt
		// console.log(evt.keyCode);
		if ((evt.ctrlKey || evt.altKey) && $.inArray(evt.keyCode, excludedKeyCode) == -1) {
			evt.preventDefault();
			// change all combination key from alt to ctrl or use both
			// alt+t or ctrl+t
			if (evt.keyCode === 84) {
				$('#btnAksiTambah:not(:disabled)').trigger('click');
			};
			// alt+u or ctrl+u
			if (evt.keyCode === 85) {
				$('#btnAksiUbah:not(:disabled)').trigger('click');
			};
			// alt+h or ctrl+h
			if (evt.keyCode === 72) {
				$('#btnAksiHapus:not(:disabled)').trigger('click');
			};
			// alt+s or ctrl+s
			if (evt.keyCode === 83) {
				$('#btnAksiSimpan:not(:disabled)').trigger('click');
			};
			// alt+c or ctrl+f
			if ((evt.altKey && evt.keyCode === 67) || (evt.ctrlKey && evt.keyCode === 70)) {
				$('#btnAksiCari:not(:disabled)').trigger('click');
			};
			// alt+k or ctrl+p
			if ((evt.altKey && evt.keyCode === 75) || (evt.ctrlKey && evt.keyCode === 80)) {
				$('#btnAksiCetak:not(:disabled)').trigger('click');
			};
			// alt+d or ctrl+d
			if ((evt.altKey && evt.keyCode === 68) || (evt.ctrlKey && evt.keyCode === 68)) {
				$('#btnAksiDownload:not(:disabled)').trigger('click');
			};
			// alt+b or ctrl+'+' // tambah barang on handsontable
			if ((evt.altKey && evt.keyCode === 66) || (evt.ctrlKey && evt.keyCode === 187) || (evt.ctrlKey && evt.keyCode === 13)) {
				$('.btnAksiBarang:not(:disabled)').trigger('click');
				$('#btnTambah:not(:disabled)').trigger('click');
			};
			// ctrl+'-' or ctrl+del// tambah barang on handsontable
			if ((evt.ctrlKey && evt.keyCode === 189) || (evt.ctrlKey && evt.keyCode === 46)) {
				$('#btnHapus:not(:disabled)').trigger('click');
			};
		};
		if ($('#wrapperReadonly').is(':visible')) {
			if (evt.keyCode == 9 || evt.keyCode == 13) {
				evt.preventDefault();
			};
		};
	});

});