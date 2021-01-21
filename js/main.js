$(function() {
	"use strict";

	var nav_offset_top = $('header').height() + 50;
	/*-------------------------------------------------------------------------------
	  Navbar 
	-------------------------------------------------------------------------------*/

	//* Navbar Fixed  
	function navbarFixed() {
		if ($('.header_area').length) {
			$(window).scroll(function() {
				var scroll = $(window).scrollTop();
				if (scroll >= nav_offset_top) {
					$(".header_area").addClass("navbar_fixed");
				} else {
					$(".header_area").removeClass("navbar_fixed");
				}
			});
		};
	};
	navbarFixed();


	//------- mailchimp --------//  
	function mailChimp() {
		$('#mc_embed_signup').find('form').ajaxChimp();
	}
	mailChimp();


	//------- Плавный скролл к прайсу на главной -------//
	if ('/' === document.location.pathname) {
		$('a[href="/#price"]').on('click', function(e) {
			e.preventDefault();
			$("html, body").stop().animate({scrollTop: $('#price').offset().top }, 500, 'swing');
		});
	}


	//------- Окно обратный звонок -------//
	$(".open-request-modal").on('click', function(e) {
		e.preventDefault();
		var form = $(
			'<form action="/discount/" class="request-modal" method="post" novalidate="novalidate" autocomplete="off">' +
				'<h2>Укажите свой телефон</h2>' +
				'<div class="form-group">' +
					'<input type="text" name="request[phone]" value="" placeholder="+7 (999) 888-77-66" />' +
					'<p>Нажимая кнопку «Отправить» Вы соглашаетесь с <a href="/rules/" target="_blank">пользовательским соглашением</a> и даете своё согласие на обработку персональных данных</p>' +
				'</div>' +
				'<button type="submit" class="button">Отправить</button>' +
				'<button class="close-request">Закрыть</button>' +
			'</form>'
		);
		// инициализация
		$.magnificPopup.open({
			items: { src: form },
			focus: 'input',
			mainClass: 'mfp-fade',
			removalDelay: 160,
		});

		// закрытие
		$('.close-request', form).on('click', function(e) {
			e.preventDefault();
			$.magnificPopup.close();
		});
		// отправка данных
		form.on('submit', function(e) {
			e.preventDefault();
			$('.text-danger', form).remove();
			if ('' === $.trim($('input', form).val())) {
				$('h2', form).after('<div class="text-danger">Забыли указать телефон</div>');
				$('input', form).eq(0).focus();
			} else {
				$('input', form).prop('readonly', 1).css('opacity', '0.5');
				$('button[type=submit]', form).prop('disabled', 1).text('Отправляем...').css('opacity', '0.5');
				$.ajax({
                    url: form.prop('action'),
                    type: form.prop('method'),
                    dataType: 'json',
                    data: {
                        'response_type': 'json',
                        'request[phone]': $('input[name="request[phone]"]', form).val(),
                    },
                    complete: function(jqXHR, status) {
                        if ('success' !== status) {
                            form.append('<div class="status-no"><div class="text"><i class="ti-face-sad"></i> Не удалось</div></div>');
							setTimeout(function() {
								$.magnificPopup.close();
							}, 2000);
                        }
                    },
                    success: function (data) {
                        if (!data.result) {
                        	form.append('<div class="status-no"><div class="text"><i class="ti-face-sad"></i> Не удалось</div></div>');
							setTimeout(function() {
								$.magnificPopup.close();
							}, 2000);
                        } else {
                        	// событие в метрике
                        	if ('undefined' !== typeof ym) {
                        		ym(49642810,'reachGoal','add-request');
                        	}
                            form.append('<div class="status-ok"><div class="text"><i class="ti-check-box"></i> Отправлено</div></div>');
							setTimeout(function() {
								$.magnificPopup.close();
							}, 2000);
                        }
                    }
                });
			}
		});
	});



	/*-------------------------------------------------------------------------------
	  featured slider
	-------------------------------------------------------------------------------*/
	if ($('.featured-carousel').length) {
		$('.featured-carousel').owlCarousel({
			loop: false,
			margin: 30,
			items: 1,
			nav: true,
			dots: false,
			responsiveClass: true,
			slideSpeed: 300,
			paginationSpeed: 500,
			navText: ["<div class='left-arrow'><i class='ti-angle-left'></i></div>", "<div class='right-arrow'><i class='ti-angle-right'></i></div>"],
			responsive: {
				768: {
					items: 2
				},
				1100: {
					items: 3
				}
			}
		})
	}



	/*-------------------------------------------------------------------------------
	  featured slider
	-------------------------------------------------------------------------------*/
	if ($('.hero-carousel').length) {
		// инициализируем
		var owl = $('.hero-carousel').owlCarousel({
			loop: true,
			margin: 30,
			items: 1,
			nav: false,
			dots: false,
			responsiveClass: true,
			slideSpeed: 300,
			paginationSpeed: 500
		});

		// автопрокрутка
		var busy = false;
		var auto_scroll_interval = setInterval(function() {
			if (!busy) {
				owl.trigger('next.owl.carousel', 500);
			}
		}, 2000);

		// переключаем при наведении
		var hover_to = null;
		var hero_list_li = $('.hero-list li');
		hero_list_li.on('mouseover', function(e) {
			owl.trigger('to.owl.carousel', [$(e.target).index(), 300]);
			busy = true;
			clearTimeout(hover_to);
			hover_to = setTimeout(function() {
				busy = false;
			}, 5000);
		});

		// подсвечивание активных
		owl.on('changed.owl.carousel', function(event) {
			hero_list_li.removeClass('active').eq(event.item.index - 2).addClass('active');
		})

	}


	/*-------------------------------------------------------------------------------
	  Инициализация Вк комментариев на главной
	-------------------------------------------------------------------------------*/
	if ($('#listing_vk_comments').length) {
		var vk_opt = {
			limit: 10,
			attach: '*',
			autoPublish: 1,
			pageUrl: document.location.protocol + '//' + document.location.host
		};
		if ('undefined' !== typeof VK && VK._apiId) {
			VK.Widgets.Comments("listing_vk_comments", vk_opt);
		} else {
			$(document).on('VkApiLoad', function() {
				VK.Widgets.Comments("listing_vk_comments", vk_opt, 1);
			});
		}
	}

});