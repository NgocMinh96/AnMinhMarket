$('.single-select').select2({
	theme: 'bootstrap4',
	width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
	placeholder: $(this).data('placeholder'),
	allowClear: Boolean($(this).data('allow-clear')),
	minimumResultsForSearch: -1,
});

$('.province-select').select2({
	theme: 'bootstrap4',
	width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
	placeholder: $(this).data('placeholder'),
	allowClear: Boolean($(this).data('allow-clear')),
	placeholder: "Chọn Tỉnh/Thành",
});
$('.district-select').select2({
	theme: 'bootstrap4',
	width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
	placeholder: $(this).data('placeholder'),
	allowClear: Boolean($(this).data('allow-clear')),
	placeholder: "Chọn Quận/Huyện",
});
$('.ward-select').select2({
	theme: 'bootstrap4',
	width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
	placeholder: $(this).data('placeholder'),
	allowClear: Boolean($(this).data('allow-clear')),
	placeholder: "Chọn Phường/Xã",
});

function round_noti(type, message, position = 'top center', img = '') {
	switch (type) {
		case "success":
			icon = 'bx bx-check-circle';
			break;
		case "info":
			icon = 'bx bx-info-circle';
			break;
		case "warning":
			icon = 'bx bx-bolt-circle';
			break;
		case "error":
			icon = 'bx bx-x-circle';
			break;
		default:
			icon = '';
	}
	Lobibox.notify(type, {
		// title: 'Thông báo !',
		pauseDelayOnHover: true,
		size: 'mini',
		rounded: true,
		icon: icon,
		delayIndicator: false,
		continueDelayOnInactiveTab: false,
		position: position,
		msg: message,
		sound: false,
		width: 300,
		img: img,
	});
}

