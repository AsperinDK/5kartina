<?php

include $_SERVER['DOCUMENT_ROOT'] . '/preload.php';

if (!empty($_REQUEST['calc']) && is_array($_REQUEST['calc'])) {
	// Расчитываем периметр и площадь для печати
	$P = 0;
	$S = 0;
	foreach ($_REQUEST['calc'] as $part_k => $part_info) {
		$w = isset($part_info['w']) && is_numeric($part_info['w']) ? floatval($part_info['w']) : 0;
		$h = isset($part_info['h']) && is_numeric($part_info['h']) ? floatval($part_info['h']) : 0;
		if ($w && $h) {
			$P += $w*2 + $h*2;
			$S += ($w + (PICTURE_CREASE_SIZE + PICTURE_DEPTH_SIZE) * 2) * ($h + (PICTURE_CREASE_SIZE + PICTURE_DEPTH_SIZE) * 2);
		}
	}

	// Переводим размеры из сантиметров в метры
	$P = $P / 100;
	$S = $S / 10000;

	$CLEAR_PRICE = 
		$P * PRICE_BATTEN +		// рейка
		$S * PRICE_CANVAS + 	// печать холста
		$S * PRICE_STRETCH +	// натяжка холста
		PRICE_STATIC			// прочие
	;
}

?><!DOCTYPE html>
<html>
<head>
	<title>Калькулятор</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="icon" href="/img/favicon.png" type="image/png">
	<link rel="stylesheet" href="/vendors/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="/css/style.css">
	<style type="text/css">
		body {
			font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
			background-color: #fafafa;
		}
		.calc {
			margin: 80px auto;
			max-width: 580px;
			padding: 40px;
			-webkit-box-shadow: 0 0 10px #ddd;
			box-shadow: 0 0 10px #ddd;
			background-color: #fff;
			counter-reset: calc_part;
		}
		.calc h3 {
			margin: 0 0 30px 0;
			text-align: center;
		}
		.calc .part {
			display: flex;
			vertical-align: middle;
			justify-content: space-between;
			margin-bottom: 20px;
		}
		.calc .part .w-wrap,
		.calc .part .h-wrap {
			width: 100%;
		}
		.calc .part input {
			width: 100%;
			padding: 0 10px;
		}
		.calc .part .w-wrap:before {
			counter-increment: calc_part;
			content: counter(calc_part) ".";
			display: block;
			float: left;
			color: #999;
			width: 20px;
			margin-left: -20px;
			line-height: 40px;
		}
		.calc .part .sep {
			line-height: 40px;
			color: #aaa;
			padding: 0 20px;
		}
		.calc button {
			width: 100%;
		}
		.calc .report {
			border-top: 1px solid #ddd;
			margin-top: 20px;
			padding-top: 10px;
		}
		.calc .report .prop {
			display: inline-flex;
			vertical-align: middle;
			margin-top: 10px;
			width: 49%;
		}
		.calc .report .prop .name {
			width: 100px;
			color: #999;
			text-align: right;
			padding: 4px 10px 0 0;
			font-size: 14px;
		}
		.calc .report .prop .value {
			font-size: 18px;
		}
		.calc .price {
			font-size: 36px;
			margin-top: 20px;
			padding-top: 20px;
			border-top: 1px solid #ddd;
			text-align: right;
		}
	</style>
</head>
<body>
	<form action="" class="calc" autocomplete="off" method="POST">
		<h3>Калькулятор цены</h3>
		<div class="part">
			<div class="w-wrap"><input type="text" name="calc[0][w]" value="<?= htmlspecialchars(@$_REQUEST['calc']['0']['w']) ?>" placeholder="Ширина, см."></div>
			<div class="sep">x</div>
			<div class="h-wrap"><input type="text" name="calc[0][h]" value="<?= htmlspecialchars(@$_REQUEST['calc']['0']['h']) ?>" placeholder="Высота, см."></div>
		</div>
		<div class="part">
			<div class="w-wrap"><input type="text" name="calc[1][w]" value="<?= htmlspecialchars(@$_REQUEST['calc']['1']['w']) ?>" placeholder="Ширина, см."></div>
			<div class="sep">x</div>
			<div class="h-wrap"><input type="text" name="calc[1][h]" value="<?= htmlspecialchars(@$_REQUEST['calc']['1']['h']) ?>" placeholder="Высота, см."></div>
		</div>
		<div class="part">
			<div class="w-wrap"><input type="text" name="calc[2][w]" value="<?= htmlspecialchars(@$_REQUEST['calc']['2']['w']) ?>" placeholder="Ширина, см."></div>
			<div class="sep">x</div>
			<div class="h-wrap"><input type="text" name="calc[2][h]" value="<?= htmlspecialchars(@$_REQUEST['calc']['2']['h']) ?>" placeholder="Высота, см."></div>
		</div>
		<div class="part">
			<div class="w-wrap"><input type="text" name="calc[3][w]" value="<?= htmlspecialchars(@$_REQUEST['calc']['3']['w']) ?>" placeholder="Ширина, см."></div>
			<div class="sep">x</div>
			<div class="h-wrap"><input type="text" name="calc[3][h]" value="<?= htmlspecialchars(@$_REQUEST['calc']['3']['h']) ?>" placeholder="Высота, см."></div>
		</div>
		<div class="part">
			<div class="w-wrap"><input type="text" name="calc[4][w]" value="<?= htmlspecialchars(@$_REQUEST['calc']['4']['w']) ?>" placeholder="Ширина, см."></div>
			<div class="sep">x</div>
			<div class="h-wrap"><input type="text" name="calc[4][h]" value="<?= htmlspecialchars(@$_REQUEST['calc']['4']['h']) ?>" placeholder="Высота, см."></div>
		</div>
		<button type="submit" class="btn btn-primary-fill">Расчитать</button>
		<? if (!empty($P)) { ?>
			<div class="report">
				<div class="prop">
					<div class="name">Периметр</div>
					<div class="value" style="color: #999"><?= $P ?> м.</div>
				</div>
				<div class="prop">
					<div class="name">Площадь</div>
					<div class="value" style="color: #999"><?= $S ?> кв.м.</div>
				</div>
				<div class="details">
					<div class="prop">
						<div class="name">Подрамник</div>
						<div class="value"><?= round($P * PRICE_BATTEN) ?> руб.</div>
					</div>
					<div class="prop">
						<div class="name">Холст</div>
						<div class="value"><?= round($S * PRICE_CANVAS) ?> руб.</div>
					</div>
					<div class="prop">
						<div class="name">Натяжка</div>
						<div class="value"><?= round($S * PRICE_STRETCH) ?> руб.</div>
					</div>
					<div class="prop">
						<div class="name">Статика</div>
						<div class="value"><?= round(PRICE_STATIC) ?> руб.</div>
					</div>
					<div class="prop">
						<div class="name">Наценка <?= PRICE_PROFIT ?>%</div>
						<div class="value"><?= round($CLEAR_PRICE * PRICE_PROFIT / 100) ?> руб.</div>
					</div>
					<div class="prop">
						<div class="name">Без округл.</div>
						<div class="value"><?= round($CLEAR_PRICE + $CLEAR_PRICE * PRICE_PROFIT / 100) ?> руб.</div>
					</div>
				</div>
				<div class="price">= <?
					$PRICE = $CLEAR_PRICE + $CLEAR_PRICE * PRICE_PROFIT / 100;
					// округляем цену до кратности 50
					$PRICE = round($PRICE/50)*50;
					print($PRICE);
				?> руб.</div>
			</div>
		<? } ?>
	</form>
</body>
</html>