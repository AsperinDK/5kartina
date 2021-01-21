<?php

// Режим сайта
define('SITE_MODE', '5kartina.ru' === $_SERVER['HTTP_HOST'] ? 'PRODUCTION' : 'DEV');

// Общие данные
define('COMPANY_NAME', '5kartina.ru');
define('COMPANY_START_DATE', '2017-11-04 00:00:00');

// Контактные данные
define('CONTACT_PHONE', '79991454609');
define('CONTACT_PHONE_READABLE', '+' . mb_substr(CONTACT_PHONE, 0, 1) . ' (' . mb_substr(CONTACT_PHONE, 1, 3) . ') ' . mb_substr(CONTACT_PHONE, 4, 3) . '-' . mb_substr(CONTACT_PHONE, 7, 2) . '-' . mb_substr(CONTACT_PHONE, 9, 2));
define('CONTACT_EMAIL', 'support@5kartina.ru');
define('CONTACT_VK_GROUP_ID', '165674491');
define('CONTACT_VK_GROUP_URL', 'https://vk.com/kartina_foto');
define('CONTACT_VK_APP_ID', '6618076');
define('CONTACT_VK_APP_SECRET', '3bkNi67EmladrfVbBglT');
define('CONTACT_INSTAGRAM_URL', 'https://www.instagram.com/5kartina/');

// Настройка отправки почты
define('EMAIL_SMTP_URL', 'ssl://smtp.yandex.ru');
define('EMAIL_SMTP_PORT', 465);
define('EMAIL_NOTIFIER', 'notifier@5kartina.ru');
define('EMAIL_NOTIFIER_PASS', 'WW68xbN3ZyWk9uo91iGq');

// Цены 
define('PRICE_BATTEN', 90); 	// рейка, 1м.
define('PRICE_CANVAS', 870); 	// печать холста 1 кв.м.
define('PRICE_STRETCH', 700); 	// натяжка холста 1 кв.м.
define('PRICE_PROFIT', 0); 	// прибыль, %
define('PRICE_STATIC', 1000); 	// статичные расходы (50 упаковка + 50 крепеж + 500 реклама + 400 доставка)

// Доп. параметры картин
define('PICTURE_CREASE_SIZE', 3); // Размер заворота, см.
define('PICTURE_DEPTH_SIZE', 2); // Размер толщины рамок картин, см.

// Выводится пользователю при системных ошибках
define('SYSTEM_ERROR_TEXT', 'Пожалуйста, попробуйте еще раз, и если ошибка повториться, сообщите нам на ' . CONTACT_EMAIL);

// Mysql
if ('DEV' === SITE_MODE) {
	define('MYSQL_HOST', 'localhost');
	define('MYSQL_USERNAME', 'root');
	define('MYSQL_PASSWD', 'asperin');
	define('MYSQL_DBNAME', 'ipgeobase');
} else {
	define('MYSQL_HOST', 'localhost');
	define('MYSQL_USERNAME', 'u0521603_default');
	define('MYSQL_PASSWD', '5LUq_JT3');
	define('MYSQL_DBNAME', 'u0521603_default');
}

// Конфиг версий картин с эталонными размерами
$GLOBALS['PICTURE_MODELS'] = array(
	'5.1' => array(
		'model_num' => '5.1',
		'max_width' => 200,
		'min_width' => 100,
		'modules' => array(
			array('x' => 0, 'y' => 10, 'width' => 25, 'height' => 50),
			array('x' => 27, 'y' => 5, 'width' => 25, 'height' => 60),
			array('x' => 54, 'y' => 0, 'width' => 25, 'height' => 70),
			array('x' => 81, 'y' => 5, 'width' => 25, 'height' => 60),
			array('x' => 108, 'y' => 10, 'width' => 25, 'height' => 50),
		),
	),
	'5.2' => array(
		'model_num' => '5.2',
		'max_width' => 200,
		'min_width' => 100,
		'modules' => array(
			array('x' => 0, 'y' => 0, 'width' => 59, 'height' => 40),
            array('x' => 64, 'y' => 0, 'width' => 41, 'height' => 25),
            array('x' => 0, 'y' => 45, 'width' => 27, 'height' => 25),
            array('x' => 32, 'y' => 45, 'width' => 27, 'height' => 25),
            array('x' => 64, 'y' => 30, 'width' => 41, 'height' => 40),
		),
	),
	'4.1' => array(
		'model_num' => '4.1',
		'max_width' => 160,
		'min_width' => 80,
		'modules' => array(
			array('x' => 0, 'y' => 5, 'width' => 25, 'height' => 65),
			array('x' => 27, 'y' => 0, 'width' => 25, 'height' => 65),
			array('x' => 54, 'y' => 5, 'width' => 25, 'height' => 65),
			array('x' => 81, 'y' => 0, 'width' => 25, 'height' => 65),
		),
	),
	'4.2' => array(
		'model_num' => '4.2',
		'max_width' => 200,
		'min_width' => 90,
		'modules' => array(
			array('x' => 0, 'y' => 12.5, 'width' => 30, 'height' => 40),
			array('x' => 32, 'y' => 0, 'width' => 25, 'height' => 60),
			array('x' => 59, 'y' => 5, 'width' => 25, 'height' => 60),
			array('x' => 86, 'y' => 12.5, 'width' => 30, 'height' => 40),
		),
	),
	'3.1' => array(
		'model_num' => '3.1',
		'max_width' => 170,
		'min_width' => 60,
		'modules' => array(
			array('x' => 0, 'y' => 0, 'width' => 30, 'height' => 60),
			array('x' => 32, 'y' => 0, 'width' => 30, 'height' => 60),
			array('x' => 64, 'y' => 0, 'width' => 30, 'height' => 60),
		),
	),
	'3.2' => array(
		'model_num' => '3.2',
		'max_width' => 150,
		'min_width' => 70,
		'modules' => array(
			array('x' => 0, 'y' => 5, 'width' => 25, 'height' => 50),
			array('x' => 27, 'y' => 0, 'width' => 30, 'height' => 60),
			array('x' => 59, 'y' => 5, 'width' => 25, 'height' => 50),
		),
	),
	'1.1' => array(
		'model_num' => '1.1',
		'max_width' => 120,
		'min_width' => 50,
		'modules' => array(
			array('x' => 0, 'y' => 0, 'width' => 40, 'height' => 24),
		),
	),
	'1.2' => array(
		'model_num' => '1.2',
		'max_width' => 120,
		'min_width' => 40,
		'modules' => array(
			array('x' => 0, 'y' => 0, 'width' => 50, 'height' => 40),
		),
	),
	'1.3' => array(
		'model_num' => '1.3',
		'max_width' => 120,
		'min_width' => 40,
		'modules' => array(
			array('x' => 0, 'y' => 0, 'width' => 40, 'height' => 40),
		),
	),
	'1.4' => array(
		'model_num' => '1.4',
		'max_width' => 100,
		'min_width' => 40,
		'modules' => array(
			array('x' => 0, 'y' => 0, 'width' => 40, 'height' => 50),
		),
	),
	'1.5' => array(
		'model_num' => '1.5',
		'max_width' => 70,
		'min_width' => 30,
		'modules' => array(
			array('x' => 0, 'y' => 0, 'width' => 24, 'height' => 40),
		),
	),
);