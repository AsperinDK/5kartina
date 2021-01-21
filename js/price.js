var pc5k = pc5k || {};

$(function() {
	"use strict";

	pc5k.init($('.section-price'));

});

// Инициализация
pc5k.init = function(wrap) {
	wrap = $(wrap);
	var calc_el = $('.price-calc', wrap);
	var preview_el = $('.price-preview', wrap);

	$(calc_el).on('change', 'input',  function() {
		var prm = {};
		if ('type' === $(this).prop('name')) {
			if ('standard' === this.value) {
				prm  = pc5k.getParameters(calc_el, {
					model: 'fs3',
					molding: 1,
					passepartout: 1
				});
			} else if ('modular' === this.value) {
				prm  = pc5k.getParameters(calc_el, {});
			} else if ('foto' === this.value) {
				prm  = pc5k.getParameters(calc_el, {
					model: 'fs3',
					style_art: 1,
					molding: 0,
				});
			}
		} else {
			prm  = pc5k.getParameters(calc_el);
		}
		pc5k.updateForm(calc_el, prm);
		pc5k.updateCanvas(preview_el, prm);
	});

	pc5k.updateCanvas(preview_el, pc5k.getParameters(calc_el));
}

// Получение параметров из формы
pc5k.getParameters = function(wrap, prm_primary) {
	wrap = $(wrap);
	// данные формы
	var i_type =  $('input[name=type]:checked', wrap).val();
	var i_model =  $('input[name=model]:checked', wrap).val();
	var i_style_art =  $('input[name=style_art]:checked', wrap).val();
	var i_molding =  $('input[name=molding]:checked', wrap).val();
	var i_passepartout =  $('input[name=passepartout]:checked', wrap).val();
	var i_size =  $('input[name=size]:checked', wrap).val();

	// данные из параметров
	if (prm_primary) {
		$.each(prm_primary, function(pn, pv) {
			if ('type' === pn) {
				i_type = pv;
			} else if ('model' === pn) {
				i_model = pv;
			} else if ('style_art' === pn) {
				i_style_art = pv;
			} else if ('molding' === pn) {
				i_molding = pv;
			} else if ('passepartout' === pn) {
				i_passepartout = pv;
			} else if ('size' === pn) {
				i_size = pv;
			}
		});
	}

	// собирем значения
	var prm = {};
	// тип картины
	prm.type = i_type;
	if ('undefined' == typeof PRICE_CONFIG.type[i_type]) {
		prm.type = Object.keys(PRICE_CONFIG.type)[0];
	}
	// модель картины
	prm.model = i_model;
	if ('undefined' == typeof PRICE_CONFIG.type[prm.type].model[i_model]) {
		prm.model = Object.keys(PRICE_CONFIG.type[prm.type].model)[0];
	}
	// доп. параметры
	if ('undefined' != typeof PRICE_CONFIG.type[prm.type].model[prm.model].extra) {
		prm.extra = [];
		if (0 <= PRICE_CONFIG.type[prm.type].model[prm.model].extra.indexOf('style_art') && i_style_art) {
			prm.extra.push('style_art');
		}
		if (0 <= PRICE_CONFIG.type[prm.type].model[prm.model].extra.indexOf('molding') && i_molding) {
			prm.extra.push('molding');
		}
		if (0 <= PRICE_CONFIG.type[prm.type].model[prm.model].extra.indexOf('passepartout') && i_passepartout) {
			prm.extra.push('passepartout');
		}
	}
	// размер
	if ('undefined' !== typeof PRICE_CONFIG.type[prm.type].model[prm.model].size[i_size]) {
		prm.size = i_size;
	} else {
		// ищем близкий по площади размер
		var size = null;
		var size_d = null;
		var s = i_size.split('x');
		s = s[0] * s[1];
		$.each(PRICE_CONFIG.type[prm.type].model[prm.model].size, function(i, v) {
			var cs = i.split('x');
			cs = cs[0] * cs[1];
			var d = Math.abs(cs - s);
			if (cs > s) {
				if (d < size_d || !size) {
					size = i;
					size_d = d;
				}
				return false;
			}
			size = i;
			size_d = d;
		});
		prm.size = size;
	}
	
	return prm;
}

// Обновление формы
pc5k.updateForm = function(wrap, prm) {
	var p_type_el = $('.p-type', wrap);
	var p_model_el = $('.p-model', wrap);
	var p_extra_el = $('.p-extra', wrap);
	var p_size_el = $('.p-size', wrap);

	// тип картины
	$('input[name=type]', p_type_el).prop('checked', 0).filter('[value=' + prm.type + ']').prop('checked', 1);

	// модель картины
	var model_list = [];
	$('input[name=model]', p_model_el).each(function() { model_list.push(this.value); });
	if (model_list.join('') !== Object.keys(PRICE_CONFIG.type[prm.type].model).join('')) {
		// прорисовка новых вариантов
		var shape_list_el = $('.shape-list', p_model_el);
		shape_list_el.html('');
		$.each(PRICE_CONFIG.type[prm.type].model, function(code, conf) {
			shape_list_el.append(
				'<label class="value shape">' +
					'<span class="shape-preview ' + code + '"></span>' +
					'<input type="radio" name="model" value="' + code + '">' +
				'</label>'
			);
		});
	}
	$('input[name=model]', p_model_el).prop('checked', 0).filter('[value=' + prm.model + ']').prop('checked', 1);

	// доп. параметры
	if ('undefined' === typeof PRICE_CONFIG.type[prm.type].model[prm.model].extra) {
		$('.value', p_extra_el.hide()).remove();
	} else {
		var extra_list = [];
		$('input', p_extra_el).each(function() { extra_list.push($(this).attr('name')); });
		if (extra_list.join('') !== PRICE_CONFIG.type[prm.type].model[prm.model].extra.join('')) {
			// прорисовка новых вариантов
			$('.value', p_extra_el).remove();
			$.each(PRICE_CONFIG.type[prm.type].model[prm.model].extra, function(i, code) {
				p_extra_el.append(
					'<label class="value">' +
						'<input type="checkbox" name="' + code + '" value="1"> ' +
						('style_art' === code ? 'Арт обработка' :
						('molding' === code ? 'Багетная рамка' :
						('passepartout' === code ? 'Паспарту' :
						code))) +
					'</label>'
				);
			});
		}
		$.each(prm.extra, function(i, code) {
			$('input[name=' + code + ']', p_extra_el).prop('checked', 1);
		})
		p_extra_el.show();
	}

	// размер
	var size_list = [];
	$('input[name=size]', p_size_el).each(function() { size_list.push(this.value); });
	if (size_list.join('') !== Object.keys(PRICE_CONFIG.type[prm.type].model[prm.model].size).join('')) {
		var size_list_el = $('.size-list', p_size_el);
		// прорисовка новых вариантов
		$('.value', size_list_el).remove();
		$.each(PRICE_CONFIG.type[prm.type].model[prm.model].size, function(code, conf) {
			size_list_el.append(
				'<label class="value">' +
					'<input type="radio" name="size" value="' + code + '"> ' +
					conf.txt_1 +
				'</label>'
			);
		});
	}
	$('input[name=size]', p_size_el).prop('checked', 0).filter('[value=' + prm.size + ']').prop('checked', 1);

	// ценник
	var total_el = $('.total', wrap);
	var new_price = PRICE_CONFIG.type[prm.type].model[prm.model].size[prm.size].price;
	if (prm.extra) {
		if (0 <= prm.extra.indexOf('style_art')) {
			new_price += PRICE_CONFIG.type[prm.type].model[prm.model].size[prm.size].price_style_art;
		}
		if (0 <= prm.extra.indexOf('molding')) {
			new_price += PRICE_CONFIG.type[prm.type].model[prm.model].size[prm.size].price_molding;
		}
		if (0 <= prm.extra.indexOf('passepartout')) {
			new_price += PRICE_CONFIG.type[prm.type].model[prm.model].size[prm.size].price_passepartout;
		}
	}

	if (new_price) {
		total_el.html(new_price + ' руб.').show();
	} else {
		total_el.html('').hide();
	}

}

pc5k.updateCanvas = function(wrap, prm) {
	// для кастомного, рисуем средний размер 
	if ('custom' === prm.size) {
		var sl = Object.keys(PRICE_CONFIG.type[prm.type].model[prm.model].size);
		prm.size = sl[parseInt(sl.length / 2) - 1];
	}
	var size = prm.size.split('x');
	// параметры фона
	// для малых картин
	var bg_offset = [20, -100]; // смещение картин от центра
	var bg_img_src = '/img/price/small-bg.jpg';
	var fg_img_src = '/img/price/small-fg.png';
	var bg_pps = 5.4;
	// для больших картин
	if (130 < size[0] || 70 < size[1]) {
		var bg_offset = [0, -150];
		var bg_img_src = '/img/price/big-bg.jpg';
		var fg_img_src = null;
		var bg_pps = 4.4;
	}

	// прорисовка фона
	var canvas = $('canvas', wrap).css('opacity', 0);
	setTimeout(function() {
		var bg_img = new Image();
		bg_img.src = bg_img_src;
		bg_img.onload = function() {
			var bg_size = [bg_img.width, bg_img.height];

			var ctx = canvas.get(0).getContext('2d');
			ctx.drawImage(bg_img, 0, 0, bg_size[0], bg_size[1], 0, 0, bg_size[0], bg_size[1]);

			// прорисовка картины
			pc5k.getPictureCanvas(prm, bg_pps, function(pic_canvs) {
				ctx.drawImage(
					pic_canvs,
					0,0,pic_canvs.width,pic_canvs.height,
					(bg_size[0] - pic_canvs.width) / 2 + bg_offset[0],
					(bg_size[1] - pic_canvs.height) / 2 + bg_offset[1],
					pic_canvs.width,
					pic_canvs.height
				);

				// прорисовка передника
				if (fg_img_src) {
					var fg_img = new Image();
					fg_img.src = fg_img_src;
					fg_img.onload = function() {
						ctx.drawImage(fg_img, 0, 0, bg_size[0], bg_size[1], 0, 0, bg_size[0], bg_size[1]);
						canvas.css('opacity', 1);
					}
				} else {
					canvas.css('opacity', 1);
				}
			});
		}
	}, 100);
}

pc5k.getPictureCanvas = function(prm, pps, end_func) {
	// размер картины
	var size = prm.size.split('x');
	size = [parseInt(size[0]), parseInt(size[1])];
	var shadow_size = 5;
	var border_size = 0;
	var passepartout_size = 0;
	if (prm.extra) {
	 	if (0 <= prm.extra.indexOf('molding')) {
			border_size = 1.5;
		}
		if (0 <= prm.extra.indexOf('passepartout')) {
			passepartout_size = Math.min(size[0], size[1]) / 13;
		}
	}

	// конфиг картины и коэфтцтэнт уменьшения для хъолста
	var conf = PRICE_CONFIG.type[prm.type].model[prm.model].config;
	var scale = 0;
	$.each(conf.modules, function(mi, minfo) {
		scale = scale < minfo.x + minfo.width ? minfo.x + minfo.width : scale;
	});
	scale = size[0] * pps / scale;

	// определяем картинку для примера
	var pic_src = '/img/price/canvas.jpg';
	if ('standard' === prm.type) {
		pic_src = '/img/price/canvas.jpg';
	} else if ('modular' === prm.type) {
		pic_src = '/img/price/canvas-mod.jpg';
	} else if ('foto' === prm.type) {
		pic_src = '/img/price/canvas-foto.jpg';
		if (prm.extra && 0 <= prm.extra.indexOf('style_art')) {
			pic_src = '/img/price/canvas-foto-art.jpg';
		}
	}

	// создаем холст
	var canvas = document.createElement('canvas');
	canvas.width = (size[0] + shadow_size*2 + border_size*2) * pps;
	canvas.height = (size[1] + shadow_size*2 + border_size*2) * pps;
	var ctx = canvas.getContext('2d');

	// прорисовываем модели
	var pic = new Image();
	pic.src = pic_src;
	pic.onload = function() {

		// смещение и коэфицент натягивания картинки на холст
		var pic_offset = [0, 0];
		var pic_scale = Math.max(size[0] * pps / pic.width, size[1] * pps / pic.height);
		if (size[0] * pps / pic.width > size[1] * pps / pic.height) {
			pic_offset[1] = (pic.height - size[1] * pps / pic_scale) / 2
		} else {
			pic_offset[0] = (pic.width - size[0] * pps / pic_scale) / 2
		}

		// рисуем модули
		$.each(conf.modules, function(mi, minfo) {
			// внешняя тень
			ctx.fillStyle = "#eee";
			ctx.shadowColor = 'rgba(0,0,0,0.18)';
			ctx.shadowBlur = 2 * pps;
			ctx.shadowOffsetX = 3 * pps;
			ctx.shadowOffsetY = 0.5 * pps;
			ctx.fillRect(
				Math.ceil(minfo.x * scale + shadow_size * pps),
				Math.ceil(minfo.y * scale + shadow_size * pps),
				Math.floor(minfo.width * scale + border_size * 2 * pps),
				Math.floor(minfo.height * scale + border_size * 2 * pps)
			);
			ctx.shadowBlur = 2 * pps;
			ctx.shadowOffsetX = 2 * pps;
			ctx.shadowOffsetY = 0.3 * pps;
			ctx.fillRect(
				Math.ceil(minfo.x * scale + shadow_size * pps),
				Math.ceil(minfo.y * scale + shadow_size * pps),
				Math.floor(minfo.width * scale + border_size * 2 * pps),
				Math.floor(minfo.height * scale + border_size * 2 * pps)
			);
			ctx.shadowBlur = 1 * pps;
			ctx.shadowOffsetX = 1 * pps;
			ctx.shadowOffsetY = 0;
			ctx.fillRect(
				Math.ceil(minfo.x * scale + shadow_size * pps),
				Math.ceil(minfo.y * scale + shadow_size * pps),
				Math.floor(minfo.width * scale + border_size * 2 * pps),
				Math.floor(minfo.height * scale + border_size * 2 * pps)
			);

			// картина
			ctx.shadowColor = 'transparent';
			ctx.shadowBlur = 0;
			ctx.shadowOffsetX = 0;
			ctx.shadowOffsetY = 0;
			ctx.drawImage(
				pic,
				// откуда вырезаем
				minfo.x * (scale / pic_scale) + pic_offset[0],
				minfo.y * (scale / pic_scale) + pic_offset[1],
				minfo.width * (scale / pic_scale),
				minfo.height * (scale / pic_scale),
				// место куда отрисовываем
				Math.floor(minfo.x * scale + (shadow_size + border_size + passepartout_size) * pps),
				Math.floor(minfo.y * scale + (shadow_size + border_size + passepartout_size) * pps),
				Math.ceil(minfo.width * scale - passepartout_size * 2 * pps),
				Math.ceil(minfo.height * scale - passepartout_size * 2 * pps)
			);

			// рамка
			if (border_size) {
				ctx.strokeStyle = '#222';
				ctx.lineWidth = border_size * pps;
				var border_offset = border_size * pps / 2; // рамка центрируется
				ctx.strokeRect(
					Math.floor(minfo.x * scale + shadow_size * pps + border_offset),
					Math.floor(minfo.y * scale + shadow_size * pps + border_offset),
					Math.floor(minfo.width * scale + border_size * pps),
					Math.floor(minfo.height * scale + border_size * pps)
				);
				ctx.strokeStyle = '#555';
				ctx.lineWidth = border_size * pps / 5;
				ctx.shadowColor = '#000';
				ctx.shadowBlur = 1;
				ctx.strokeRect(
					Math.floor(minfo.x * scale + shadow_size * pps + border_size * pps - border_size * pps / 4),
					Math.floor(minfo.y * scale + shadow_size * pps + border_size * pps - border_size * pps / 4),
					Math.floor(minfo.width * scale + border_size * pps / 4 * 2 + 1),
					Math.floor(minfo.height * scale + border_size * pps / 4 * 2 + 1)
				);
			}

			// внутренняя тень (блики)
			ctx.strokeStyle = 'rgba(255,255,255,0.2)';
			ctx.lineWidth = 0.5 * pps;
			ctx.shadowColor = 'rgba(255,255,255,0.2)';
			ctx.shadowBlur = 0.5 * pps;
			var inner_shadow_coord = [
				[Math.floor(minfo.x * scale + (shadow_size + border_size) * pps), Math.floor(minfo.y * scale + (shadow_size + border_size) * pps)],
				[Math.floor(minfo.x * scale + (shadow_size + border_size) * pps + minfo.width * scale), Math.floor(minfo.y * scale + (shadow_size + border_size) * pps)],
				[Math.floor(minfo.x * scale + (shadow_size + border_size) * pps + minfo.width * scale), Math.floor(minfo.y * scale + (shadow_size + border_size) * pps + minfo.height * scale)],
				[Math.floor(minfo.x * scale + (shadow_size + border_size) * pps), Math.floor(minfo.y * scale + (shadow_size + border_size) * pps + minfo.height * scale)],
			];
			if (border_size) {
				inner_shadow_coord[0][0] -= border_size * pps;
				inner_shadow_coord[0][1] -= border_size * pps;
				inner_shadow_coord[1][0] += border_size * pps;
				inner_shadow_coord[1][1] -= border_size * pps;
				inner_shadow_coord[2][0] += border_size * pps;
				inner_shadow_coord[2][1] += border_size * pps;
				inner_shadow_coord[3][0] -= border_size * pps;
				inner_shadow_coord[3][1] += border_size * pps;
			}
			ctx.beginPath();
		    ctx.moveTo(inner_shadow_coord[3][0], inner_shadow_coord[3][1]);
		    ctx.lineTo(inner_shadow_coord[0][0], inner_shadow_coord[0][1]);
		    ctx.lineTo(inner_shadow_coord[1][0], inner_shadow_coord[1][1]);
		    ctx.stroke();
		    ctx.strokeStyle = 'rgba(0,0,0,0.2)';
			ctx.lineWidth = 0.5 * pps;
			ctx.shadowColor = 'rgba(0,0,0,0.2)';
			ctx.shadowBlur = 0.5 * pps;
			ctx.beginPath();
		    ctx.moveTo(inner_shadow_coord[3][0], inner_shadow_coord[3][1]);
		    ctx.lineTo(inner_shadow_coord[2][0], inner_shadow_coord[2][1]);
		    ctx.lineTo(inner_shadow_coord[1][0], inner_shadow_coord[1][1]);
		    ctx.stroke();
		});

		end_func(canvas);
	}
	
}