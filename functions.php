<?php

/**
 * Расчет размеров и цен модели
 *
 * @return array если не указан $pic_code, вернет конфиги всех картин
 * @param string $model_num
 */
function getPictureModelSize($model_num) {
	if (!isset($GLOBALS['PICTURE_MODELS'][$model_num])) {
		return FALSE;
	}
	$minfo = $GLOBALS['PICTURE_MODELS'][$model_num];

	// Расчет основных параметров модели (ширина, высота, периметр, площадь)
	$minfo['width'] = 0;
	$minfo['height'] = 0;
	$minfo['perimeter'] = 0;
	$minfo['square'] = 0;
	foreach ($minfo['modules'] as $mconf) {
		$minfo['width'] = $mconf['x'] + $mconf['width'] > $minfo['width'] ? $mconf['x'] + $mconf['width'] : $minfo['width'];
		$minfo['height'] = $mconf['y'] + $mconf['height'] > $minfo['height'] ? $mconf['y'] + $mconf['height'] : $minfo['height'];
		$minfo['perimeter'] += $mconf['width'] * 2 + $mconf['height'] * 2;
		$minfo['square'] += ($mconf['width'] + (PICTURE_CREASE_SIZE + PICTURE_DEPTH_SIZE) * 2) * ($mconf['height'] + (PICTURE_CREASE_SIZE + PICTURE_DEPTH_SIZE) * 2);
	}

	// Переводим размеры из сантиметров в метры
	$minfo['width'] = $minfo['width'] / 100;
	$minfo['height'] = $minfo['height'] / 100;
	$minfo['perimeter'] = $minfo['perimeter'] / 100;
	$minfo['square'] = $minfo['square'] / 10000;
	$minfo['max_width'] = $minfo['max_width'] / 100;
	$minfo['min_width'] = $minfo['min_width'] / 100;

	// Максимальная ширина
 	$max_width = $minfo['max_width'];
	// Минимальная ширина
	$min_width = $minfo['min_width'];
	// Размеры
	$sizes = array();
	$width = $min_width;
	while ($width <= $max_width) {
		// высота для этого шага
		$height = $width/($minfo['width']/$minfo['height']);
		// рассчитываем периметр и площадь
		$perimeter = 0;
		$square = 0;
		foreach ($minfo['modules'] as $mconf) {
			$w = $mconf['width'] * $width / $minfo['width'];
			$h = $mconf['height'] * $width / $minfo['width'];
			$perimeter += ($w * 2 + $h * 2) / 100;
			$square += (($w + (PICTURE_CREASE_SIZE + PICTURE_DEPTH_SIZE) * 2) * ($h + (PICTURE_CREASE_SIZE + PICTURE_DEPTH_SIZE) * 2)) / 10000;
		}
		// рассчитываем цену
		$price =
			$perimeter * PRICE_BATTEN + // рейка
			$square * PRICE_CANVAS + 	// печать холста
			$square * PRICE_STRETCH +	// натяжка холста
			PRICE_STATIC				// прочие
		;
		$price = $price + $price * PRICE_PROFIT / 100;
		// округляем цену до кратности 50
		$price = round($price/50)*50;
		// высота и ширина в сантиметрах, округленные
		$width_sm = round($width*100);
		$height_sm = round($height*100);
		// текстовое представление размера
		$size_txt = 'Малый';
		if (0.4 < $square) {
			$size_txt = 'Средний';
		}
		if (0.8 < $square) {
			$size_txt = 'Большой';
		}
		// вносим в конфиг
		$sizes[$width_sm . 'x' . $height_sm] = array(
			'code' => $width_sm . 'x' . $height_sm,
			'price' => $price,
			'price_molding' => 300,
			'price_passepartout' => 200,
			'price_style_art' => 300,
			'txt_1' => $width_sm . ' x ' . $height_sm . ' см.',
			'txt_2' => $size_txt,
		);
		// уменьшаем ширину для следующего размера
		if ($width == $max_width) {
			break;
		} else {
			$width = round($width + 0.1, 1);
			$width = $width > $max_width ? $max_width : $width;
		}
	}
	return $sizes;
}

/**
 * переадресация на новый URL
 * @return bool
 * @param string $url
 * @param string $status
 */
function redirect($url, $status = '') {
    if (!is_string($url)) {
        return FALSE;
    } elseif (headers_sent()) {
        exit('<html><head><meta http-equiv="refresh" content="0;url=' . htmlspecialchars($url) . '"></head><body>redirect to <a href="' . htmlspecialchars($url) . '">' . $url . '</a></body></html>');
    } else {
        if ($status) {
            header($status);
        }
        header("Location: {$url}");
        exit;
    }
}

function getText4Num($num, $variants) {
    if (
            !is_scalar($num) || !is_array($variants) ||
            !isset($variants[0], $variants[1], $variants[2])
    ):
        return FALSE;
    endif;

    $numi = intval($num);
    $numf = floatval($num);
    $num10 = intval(intval($numi % 100) / 10);
    $num01 = intval(intval($numi % 100) % 10);
    if ($numi != $numf) {
        return $variants[1];
    } else if ((1 == $num10) || (4 < $num01) || (0 == $num01)) {
        return $variants[2];
    } else if (1 == $num01) {
        return $variants[0];
    } else {
        return $variants[1];
    }
}

/**
 * Трнслитерация
 */
function translit($string) {
    $replace = array(
        "'" => "",
        "," => "_",
        "`" => "",
        " " => "-",
        "а" => "a", "А" => "a",
        "б" => "b", "Б" => "b",
        "в" => "v", "В" => "v",
        "г" => "g", "Г" => "g",
        "д" => "d", "Д" => "d",
        "е" => "e", "Е" => "e",
        "ж" => "zh", "Ж" => "zh",
        "з" => "z", "З" => "z",
        "и" => "i", "И" => "i",
        "й" => "y", "Й" => "y",
        "к" => "k", "К" => "k",
        "л" => "l", "Л" => "l",
        "м" => "m", "М" => "m",
        "н" => "n", "Н" => "n",
        "о" => "o", "О" => "o",
        "п" => "p", "П" => "p",
        "р" => "r", "Р" => "r",
        "с" => "s", "С" => "s",
        "т" => "t", "Т" => "t",
        "у" => "u", "У" => "u",
        "ф" => "f", "Ф" => "f",
        "х" => "h", "Х" => "h",
        "ц" => "c", "Ц" => "c",
        "ч" => "ch", "Ч" => "ch",
        "ш" => "sh", "Ш" => "sh",
        "щ" => "sch", "Щ" => "sch",
        "ъ" => "", "Ъ" => "",
        "ы" => "y", "Ы" => "y",
        "ь" => "", "Ь" => "",
        "э" => "e", "Э" => "e",
        "ю" => "yu", "Ю" => "yu",
        "я" => "ya", "Я" => "ya",
        "і" => "i", "І" => "i",
        "ї" => "yi", "Ї" => "yi",
        "є" => "e", "Є" => "e"
    );
    return $str = @iconv("UTF-8", "UTF-8//IGNORE", strtr($string, $replace));
}


/**
 * Трнслитерация в URL
 */
function translitToUrl($string) {
	$string = translit($string);
	// в нижний регистр
    $string = strtolower($string);
    // заменям все ненужное нам на "-"
    $string = preg_replace('~[^-a-z0-9_]+~ui', '-', $string);
    // заменям подряд идущие "-" на 1 символ
    $string = preg_replace('~-+~ui', '-', $string);
    // удаляем начальные и конечные '-'
    $string = trim($string, "-");

    return $string;
}
