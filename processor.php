<?php

// Подготовка конфига для прайса
$price_config = array(
	'type' => array(
		'standard' => array(
			'model' => array(
				'fs1' => array(
					'config' => $GLOBALS['PICTURE_MODELS']['1.1'],
					'size' => getPictureModelSize('1.1'),
					'extra' => array('molding', 'passepartout'),
				),
				'fs3' => array(
					'config' => $GLOBALS['PICTURE_MODELS']['1.3'],
					'size' => getPictureModelSize('1.3'),
					'extra' => array('molding', 'passepartout'),
				),
				'fs5' => array(
					'config' => $GLOBALS['PICTURE_MODELS']['1.5'],
					'size' => getPictureModelSize('1.5'),
					'extra' => array('molding', 'passepartout'),
				),
			),
		),
		'modular' => array(
			'model' => array(
				'fm1' => array(
					'config' => $GLOBALS['PICTURE_MODELS']['3.1'],
					'size' => getPictureModelSize('3.1'),
				),
				'fm2' => array(
					'config' => $GLOBALS['PICTURE_MODELS']['3.2'],
					'size' => getPictureModelSize('3.2'),
				),
				'fm3' => array(
					'config' => $GLOBALS['PICTURE_MODELS']['4.1'],
					'size' => getPictureModelSize('4.1'),
				),
				'fm4' => array(
					'config' => $GLOBALS['PICTURE_MODELS']['5.1'],
					'size' => getPictureModelSize('5.1'),
				),
			),
		),
		'foto' => array(
			'model' => array(
				'fs1' => array(
					'config' => $GLOBALS['PICTURE_MODELS']['1.1'],
					'size' => getPictureModelSize('1.1'),
					'extra' => array('style_art', 'molding'),
				),
				'fs3' => array(
					'config' => $GLOBALS['PICTURE_MODELS']['1.3'],
					'size' => getPictureModelSize('1.3'),
					'extra' => array('style_art', 'molding'),
				),
				'fs5' => array(
					'config' => $GLOBALS['PICTURE_MODELS']['1.5'],
					'size' => getPictureModelSize('1.5'),
					'extra' => array('style_art', 'molding'),
				),
			),
		),
	),
);

// Ограничим колличество на четное
foreach ($price_config['type'] as $type => $tc) {
	foreach ($tc['model'] as $model => $mc) {
		if ('modular' === $type) {
			$price_config['type'][$type]['model'][$model]['size'] = array_slice($mc['size'], 0, 11);
		} else {
			$price_config['type'][$type]['model'][$model]['size'] = array_slice($mc['size'], 0, 7);
		}
		$price_config['type'][$type]['model'][$model]['size']['custom'] = array(
			'code' => 'custom',
			'price' => 0,
			'price_molding' => 0,
			'price_passepartout' => 0,
			'price_style_art' => 0,
			'txt_1' => 'Свой размер',
			'txt_2' => 'Свой размер',
		);
	}
}

// Определим город по IP
$ipgeo_city = NULL;
$mysqli = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWD, MYSQL_DBNAME);
$mysqli->set_charset("utf8");
if (!$mysqli->connect_error) {
	$ip_summ = explode('.', $_SERVER['REMOTE_ADDR']);
	$ip_summ = $ip_summ[0]*256*256*256 + $ip_summ[1]*256*256 + $ip_summ[2]*256 + $ip_summ[3];
	if (
		FALSE !== ($qr = $mysqli->query($q = "
			SELECT * FROM `ipgeobase`
			WHERE
				`block_start` < " . $mysqli->real_escape_string($ip_summ) . "
				AND
				`block_end` > " . $mysqli->real_escape_string($ip_summ) . "
		"))
		&&
		FALSE !== ($row = $qr->fetch_assoc())
	) {
		$ipgeo_city = $row['city_name'];
	}
}