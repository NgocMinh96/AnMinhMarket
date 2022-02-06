//DEFAULT
$(function () {
	"use strict";
	// new PerfectScrollbar(".header-message-list"), new PerfectScrollbar(".header-notifications-list"), 
	$(".mobile-search-icon").on("click", function () {
		$(".search-bar").addClass("full-search-bar")
	}), $(".search-close").on("click", function () {
		$(".search-bar").removeClass("full-search-bar")
	}), $(".mobile-toggle-menu").on("click", function () {
		$(".wrapper").addClass("toggled")
	}), $(".toggle-icon").click(function () {
		$(".wrapper").hasClass("toggled") ? ($(".wrapper").removeClass("toggled"), $(".sidebar-wrapper").unbind("hover")) : ($(".wrapper").addClass("toggled"), $(".sidebar-wrapper").hover(function () {
			$(".wrapper").addClass("sidebar-hovered")
		}, function () {
			$(".wrapper").removeClass("sidebar-hovered")
		}))
	}), $(document).ready(function () {
		$(window).on("scroll", function () {
			$(this).scrollTop() > 300 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
		}), $(".back-to-top").on("click", function () {
			return $("html, body").animate({
				scrollTop: 0
			}, 600), !1
		})
	}), $(function () {
		for (var e = window.location, o = $(".metismenu li a").filter(function () {
			let pathName = '/' + e.pathname.split('/').slice(1, 3).join('/')
			// console.log(e)
			return this.href == e.origin + pathName
		}).addClass("").parent().addClass("mm-active"); o.is("li");) o = o.parent("").addClass("mm-show").parent("").addClass("mm-active")
	}), $(function () {
		$("#menu").metisMenu()
	}), $(".chat-toggle-btn").on("click", function () {
		$(".chat-wrapper").toggleClass("chat-toggled")
	}), $(".chat-toggle-btn-mobile").on("click", function () {
		$(".chat-wrapper").removeClass("chat-toggled")
	}), $(".email-toggle-btn").on("click", function () {
		$(".email-wrapper").toggleClass("email-toggled")
	}), $(".email-toggle-btn-mobile").on("click", function () {
		$(".email-wrapper").removeClass("email-toggled")
	}), $(".compose-mail-btn").on("click", function () {
		$(".compose-mail-popup").show()
	}), $(".compose-mail-close").on("click", function () {
		$(".compose-mail-popup").hide()
	}), $(".switcher-btn").on("click", function () {
		$(".switcher-wrapper").toggleClass("switcher-toggled")
	}), $(".close-switcher").on("click", function () {
		$(".switcher-wrapper").removeClass("switcher-toggled")
	}), $("#lightmode").on("click", function () {
		$("html").attr("class", "light-theme")
	}), $("#darkmode").on("click", function () {
		$("html").attr("class", "dark-theme")
	}), $("#semidark").on("click", function () {
		$("html").attr("class", "semi-dark")
	}), $("#minimaltheme").on("click", function () {
		$("html").attr("class", "minimal-theme")
	}), $("#headercolor1").on("click", function () {
		$("html").addClass("color-header headercolor1"), $("html").removeClass("headercolor2 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")
	}), $("#headercolor2").on("click", function () {
		$("html").addClass("color-header headercolor2"), $("html").removeClass("headercolor1 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")
	}), $("#headercolor3").on("click", function () {
		$("html").addClass("color-header headercolor3"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")
	}), $("#headercolor4").on("click", function () {
		$("html").addClass("color-header headercolor4"), $("html").removeClass("headercolor1 headercolor2 headercolor3 headercolor5 headercolor6 headercolor7 headercolor8")
	}), $("#headercolor5").on("click", function () {
		$("html").addClass("color-header headercolor5"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor3 headercolor6 headercolor7 headercolor8")
	}), $("#headercolor6").on("click", function () {
		$("html").addClass("color-header headercolor6"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor3 headercolor7 headercolor8")
	}), $("#headercolor7").on("click", function () {
		$("html").addClass("color-header headercolor7"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor3 headercolor8")
	}), $("#headercolor8").on("click", function () {
		$("html").addClass("color-header headercolor8"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor3")
	})

	$('[data-bs-toggle="popover"]').popover();
	$('[data-bs-toggle="tooltip"]').tooltip();

	// sidebar colors 


	$('#sidebarcolor1').click(theme1);
	$('#sidebarcolor2').click(theme2);
	$('#sidebarcolor3').click(theme3);
	$('#sidebarcolor4').click(theme4);
	$('#sidebarcolor5').click(theme5);
	$('#sidebarcolor6').click(theme6);
	$('#sidebarcolor7').click(theme7);
	$('#sidebarcolor8').click(theme8);

	function theme1() {
		$('html').attr('class', 'color-sidebar sidebarcolor1');
	}

	function theme2() {
		$('html').attr('class', 'color-sidebar sidebarcolor2');
	}

	function theme3() {
		$('html').attr('class', 'color-sidebar sidebarcolor3');
	}

	function theme4() {
		$('html').attr('class', 'color-sidebar sidebarcolor4');
	}

	function theme5() {
		$('html').attr('class', 'color-sidebar sidebarcolor5');
	}

	function theme6() {
		$('html').attr('class', 'color-sidebar sidebarcolor6');
	}

	function theme7() {
		$('html').attr('class', 'color-sidebar sidebarcolor7');
	}

	function theme8() {
		$('html').attr('class', 'color-sidebar sidebarcolor8');
	}


});

//---------------CUSTOM---------------//

//change background colors
var bgColor = localStorage.getItem("SwitchBG") == null ? localStorage.setItem("SwitchBG", "light") : localStorage.getItem("SwitchBG");

if (bgColor == 'dark') {
	$("#SwitchBG").prop('checked', true)
	$("html").attr("class", "dark-theme")
} else if (bgColor == 'light') {
	$("#SwitchBG").prop('checked', false)
	$("html").attr("class", "light-theme")
}


$("#SwitchBG").click(function () {
	var checkState = $("#SwitchBG").is(":checked") ? true : false;
	if (checkState == true) {
		$("html").attr("class", "dark-theme")
		localStorage.setItem("SwitchBG", "dark");
	} else {
		$("html").attr("class", "light-theme")
		localStorage.setItem("SwitchBG", "light");
	}
})

//select2
$('.single-select').select2({
	theme: 'bootstrap4',
	width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
	placeholder: $(this).data('placeholder'),
	allowClear: Boolean($(this).data('allow-clear')),
	minimumResultsForSearch: -1,
});

$('.multiple-select').select2({
	theme: 'bootstrap4',
	width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
	placeholder: $(this).data('placeholder'),
	allowClear: Boolean($(this).data('allow-clear')),
});

$('select[name="category"]').select2({
	theme: 'bootstrap4',
	width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
	placeholder: $(this).data('placeholder'),
	allowClear: Boolean($(this).data('allow-clear')),
});

$('select[name="author"]').select2({
	theme: 'bootstrap4',
	width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
	placeholder: $(this).data('placeholder'),
	allowClear: Boolean($(this).data('allow-clear')),
});

// $('b[role="presentation"]').hide();


// checked all
$("#check-all").change((function () {
	var t = this.checked;
	$('input[name="checkbox[]"]').each((function () {
		this.checked = t
	}))
}))


// notifications
function round_noti(type, message, position = 'top center') {
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
			break
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
	});
}

// sweetalert2
function setSwal(t = 'Bạn có đồng ý xóa dữ liệu này ?', n = "question") {
	let bg = $('html').hasClass('dark-theme') == true ? '#283046' : '#fff'
	return Swal.fire({
		customClass: {
			title: 'h5 text-secondary',
			confirmButton: 'btn btn-primary',
			cancelButton: 'btn btn-danger ms-1',
		},
		title: t,
		width: 250,
		background: bg,
		icon: n,
		showCancelButton: true,
		confirmButtonText: "Đồng ý",
		cancelButtonText: "Không",
		buttonsStyling: false,
		// showClass: {
		//     popup: 'animated animate__fadeIn'
		// },
		// hideClass: {
		//     popup: 'animated animate__fadeOut'
		// }
	})
}

//destroy submit form
function destroy(path) {
	return setSwal().then((result) => {
		if (result.isConfirmed) {
			// console.log(path)
			$('#destroy').attr('action', path)
			$('#destroy').submit()
		}
	})
}

//update submit form
function update(path) {
	$('#update').submit()
}

$(".toggle-logo").click(function () {
	$(".wrapper").hasClass("toggled")
		? ($(".wrapper").removeClass("toggled"), $(".sidebar-wrapper").unbind("hover"))
		: ($(".wrapper").addClass("toggled"), $(".sidebar-wrapper").hover(function () {
			$(".wrapper").addClass("sidebar-hovered")
			$(".icon-logo").addClass("d-none")
			$(".toggle-logo img").removeClass("d-none")
		}, function () {
			$(".wrapper").removeClass("sidebar-hovered")
			$(".icon-logo").removeClass("d-none")
			$(".toggle-logo img").addClass("d-none")
			if (!$(".wrapper").hasClass("toggled")) {
				$(".icon-logo").addClass("d-none")
				$(".toggle-logo img").removeClass("d-none")
			}
		}))
})

function chuyenso(conso) {
	var s09 = ["", " một", " hai", " ba", " bốn", " năm", " sáu", " bảy", " tám", " chín"];
	var lop3 = ["", ' triệu', " nghìn", ' tỷ', ","];

	if (conso == "") {
		kq = "";
	} else if (conso != "") {
		if (conso < 0) {
			dau = "<span class='text-danger'>âm </span>";
			conso = conso.toString().replace("-", "");
		} else {
			dau = "";
		};

		var conso = String(conso);
		var sochuso = conso.length % 9;

		if (sochuso >= 0) {
			var sk = "0";
			conso = String(sk.repeat(9 - (sochuso % 12))) + conso;
			docso = "";
			i = 0;
			lop = 1;

			do {
				n1 = conso.substr(i, 1);
				n2 = conso.substr(i + 1, 1);
				n3 = conso.substr(i + 2, 1);
				// var baso = conso.substr(i, 3)

				i += 3;

				if (n1 + n2 + n3 == "000") {
					if (docso != "" && lop == 3 && (conso.length - i) > 2) {
						s123 = " tỷ";
					} else {
						s123 = '';
					};
				} else {
					if (n1 == 0) {
						if (docso == "") {
							s1 = "";
						} else {
							s1 = " không trăm";
						};
					} else {
						s1 = s09[n1] + ' trăm';
					};

					if (n2 == 0) {
						if (s1 == "" || n3 == 0) {
							s2 = "";
						} else {
							s2 = ' linh';
						};
					} else {
						if (n2 == 1) {
							s2 = " mười";
						} else {
							s2 = s09[n2] + ' mươi';
						};
					};

					if (n3 == 1) {
						if (n2 == 1 || n2 == 0) {
							s3 = " một";
						} else {
							s3 = " mốt";
						};
					} else if (n3 == 5 && n2 != 0) {
						s3 = " lăm";
					} else {
						s3 = s09[n3];
					};

					if (i > conso.length - 1) {
						s123 = s1 + s2 + s3;
					} else {
						s123 = s1 + s2 + s3 + lop3[lop];
					};
				};
				lop += 1;
				if (lop > 3) {
					lop = 1;
				};
				docso = docso + s123;
			}
			while (i < conso.length);
			if (docso == "") {
				kq = "không";
			} else {
				docso = String(docso);
				docso = docso.trim();
				kq = dau + docso.substr(0, 1).toUpperCase() + docso.substr(1, docso.length - 1) + " đồng.";
			};
		};
	} else {
		kq = conso;
	};
	return kq
}