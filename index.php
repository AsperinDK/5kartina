<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/preload.php';
	include 'processor.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<title>Печать на холсте под заказ</title>
	<meta name="Keywords" content="фото холст печать цена купить доставка заказ">
	<meta name="description" content="Печать на холсте по индивидуальному изображению. Модульные картины, фото на холсте, репродукции. Натяжка на подрамник. Оформление в багет, рамку. С доставкой по всей России.">
	<? include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
	<script type="text/javascript">
		var PRICE_CONFIG = <?= json_encode($price_config) ?>;
	</script>
</head>
<body>
	<? include $_SERVER['DOCUMENT_ROOT'] . '/header.php'; ?>

	<section class="hero-banner">
		<div class="hero-wrapper">
			<?
				// Порядок вывода
				$hero_list = array(
					'Модульные картины' => '/img/versions/1.jpg',
					'Фото на холсте' => '/img/versions/2.jpg',
					'Репродукции' => '/img/versions/3.jpg',
					'Постеры' => '/img/versions/4.jpg',
				);
				// Меняем порядок для разных кампаний
				if (isset($_GET['foto'])) {
					$hero_list = array_merge(array_slice($hero_list, 1, 1), $hero_list);
				} elseif (isset($_GET['poster'])) {
					$hero_list = array_merge(array_slice($hero_list, 3, 1), $hero_list);
				}
			?>
			<div class="hero-left">
				<div class="maw">
					<h1 class="hero-title mb-3 mb-xl-2">Печать на холсте <span class="d-inline-block">под заказ</span></h1>
					<div class="hero-list mb-4">
						<?
							$first = TRUE;
							foreach ($hero_list as $name => $img_src) {
								print '<li' . ($first ? ' class="active"' : '') . '><i class="ti-check-box"></i> ' . htmlspecialchars($name) . '</li>';
								$first = FALSE;
							}
						?>
					</div>
					<a class="button button-hero button-shadow" href="/#price">Подробнее</a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="hero-right">
				<div class="owl-carousel owl-theme hero-carousel">
					<?
						foreach ($hero_list as $name => $img_src) {
							print '<div class="hero-carousel-item"><img class="img-fluid" src="' . htmlspecialchars($img_src) . '" alt=""></div>';
						}
					?>
				</div>
			</div>
		</div>
	</section>
	
	<div id="price"></div>
	<section class="section-price section-margin pb-xl-70">
		<div class="price-left">
			<div class="price-preview">
				<canvas width="1000" height="960">Обновите браузер</canvas>
			</div>
		</div>
		<div class="price-right">
			<div class="section-intro mb-lg-4">
				<h4 class="intro-title">Прайс-лист</h4>
				<h2>Цены и размеры</h2>
			</div>
			<?
				// Порядок вывода видов картин
				$price_type_list = array(
					'Модульная' => 'modular',
					'По фото' => 'foto',
					'Постер' => 'standard',
				);
				// Меняем порядок для разных кампаний
				if (isset($_GET['foto'])) {
					$price_type_list = array_merge(array_slice($price_type_list, 1, 1), $price_type_list);
				} elseif (isset($_GET['poster'])) {
					$price_type_list = array_merge(array_slice($price_type_list, 2, 1), $price_type_list);
				}
			?>
			<div class="price-calc p-6">
				<div class="item p-type">
					<div class="title">Тип картины</div>
					<?
						$type_active = reset($price_type_list);
						foreach ($price_type_list as $type_name => $type_code) {
							print '<label class="value"><input type="radio" name="type" value="' . htmlspecialchars($type_code) . '"' . ($type_active === $type_code ? ' checked="checked"' : '') . '> ' . htmlspecialchars($type_name) . '</label>';
						}
					?>
				</div>
				<div class="item p-model">
					<div class="title">Форма</div>
					<div class="shape-list">
						<?
							$model_active = key($price_config['type'][$type_active]['model']);
							if ('foto' === $type_active) {
								$model_active = 'fs3';
							}
							if ('standard' === $type_active) {
								$model_active = 'fs3';
							}
							foreach ($price_config['type'][$type_active]['model'] as $model_code => $model_conf) {
								print '<label class="value shape"><span class="shape-preview ' . htmlspecialchars($model_code) . '"></span><input type="radio" name="model" value="' . htmlspecialchars($model_code) . '"' . ($model_active === $model_code ? ' checked="checked"' : '') . '></label>';
							}
						?>
					</div>
				</div>
				<div class="item p-extra"<?= isset($price_config['type'][$type_active]['model'][$model_active]['extra']) ? '' : ' style="display:none"' ?>>
					<div class="title">Дополнительно</div>
					<?
						if (isset($price_config['type'][$type_active]['model'][$model_active]['extra'])) {
							foreach ($price_config['type'][$type_active]['model'][$model_active]['extra'] as $extra_code) {
								$extra_name = $extra_code;
								$extra_name = 'style_art' === $extra_name ? 'Арт обработка' : $extra_name;
								$extra_name = 'molding' === $extra_name ? 'Багетная рамка' : $extra_name;
								$extra_name = 'passepartout' === $extra_name ? 'Паспарту' : $extra_name;
								$extra_checked = FALSE;
								if ('foto' === $type_active && 'style_art' === $extra_code) {
									$extra_checked = TRUE;
								}
								if ('standard' === $type_active && 'molding' === $extra_code) {
									$extra_checked = TRUE;
								}
								if ('standard' === $type_active && 'passepartout' === $extra_code) {
									$extra_checked = TRUE;
								}
								print '<label class="value"><input type="checkbox" name="' . $extra_code . '" value="1"' . ($extra_checked ? ' checked="checked"' : '') . '> ' . htmlspecialchars($extra_name) . '</label>';
							}
						}
					?>
				</div>
				<div class="item p-size">
					<div class="title">Размеры и цены</div>
					<div class="size-list">
						<?
							$size_active = key($price_config['type'][$type_active]['model'][$model_active]['size']);
							if ('foto' === $type_active) {
								$size_active = '60x60';
							} elseif ('standard' === $type_active) {
								$size_active = '60x60';
							}
							foreach ($price_config['type'][$type_active]['model'][$model_active]['size'] as $size_code => $size_conf) {
								print '<label class="value"><input type="radio" name="size" value="' . htmlspecialchars($size_code) . '"' . ($size_active === $size_code ? ' checked="checked"' : '') . '> ' . htmlspecialchars($size_conf['txt_1']) . '</label>';
							}
						?>
					</div>
				</div>
				<div class="actions mt-3 mt-lg-4">
					<?
						$size_conf = $price_config['type'][$type_active]['model'][$model_active]['size'][$size_active];
						$price = $size_conf['price'];
						if ('foto' === $type_active) {
							$price += $size_conf['price_style_art'];
						} elseif ('standard' === $type_active) {
							$price += $size_conf['price_molding'];
							$price += $size_conf['price_passepartout'];
						}
					?>
					<div class="total"><?= htmlspecialchars($price) ?> руб.</div>
					<button class="button button-shadow open-request-modal">Оформить заявку</button>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</section>

	<section class="section-margin delivery-short">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-xl-5">
					<div class="section-intro mb-lg-4">
						<h4 class="intro-title">По всей России</h4>
						<h2>Бесплатная доставка</h2>
					</div>
					<p>
						Такими транспортными команиями как «Почта России», «Деловые линии», «ПЭК» и «DPD».
					</p>
					<p>
						Весь процесс занимает от 4 до 6 дней (2 дня на изготовление и 2-4 дня на доставку).
					</p>
					<a class="button button-shadow mt-2 mt-lg-4" href="/delivery/">Подробнее</a>
				</div>
				<div class="d-none d-lg-block col-lg-6 pl-lg-5 pl-xl-0 offset-xl-1 col-xl-6">
					<img src="/img/delivery-map.jpg" style="width: 100%;" alt="">
				</div>
			</div>
			<div class="mt-xl-4" style="height: 1px;"></div>
		</div>
	</section>

	<section class="bg-lightGray section-padding">
		<div class="container">
			<div class="section-intro mb-75px">
				<h4 class="intro-title">Примеры картин</h4>
				<h2>Довольные клиенты это главное</h2>
			</div>
			<div class="owl-carousel owl-theme featured-carousel">
				<div class="card-blog">
					<img class="card-img rounded-0" src="img/example/1.jpg" alt="">
					<div class="blog-body">
						<ul class="blog-info">
							<li>Размер: 80 x 48 см.</li>
							<li class="pc"><?=
								$price_config['type']['foto']['model']['fs1']['size']['80x48']['price'] +
								$price_config['type']['foto']['model']['fs1']['size']['80x48']['price_style_art']
							?> ₽</li>
						</ul>
						<h3>Иван, <span class="d-inline-block">г. Санкт-Петербург</span></h3>
					</div>
				</div>
				<div class="card-blog">
					<img class="card-img rounded-0" src="img/example/2.jpg" alt="">
					<div class="blog-body">
						<ul class="blog-info">
							<li>Размер: 70 x 45 см.</li>
							<li class="pc"><?= $price_config['type']['modular']['model']['fm1']['size']['70x45']['price'] ?> ₽</li>
						</ul>
						<h3>Анна, <span class="d-inline-block">г. Симферополь</span></h3>
					</div>
				</div>
				<div class="card-blog">
					<img class="card-img rounded-0" src="img/example/3.jpg" alt="">
					<div class="blog-body">
						<ul class="blog-info">
							<li>Размер: 160 x 102 см.</li>
							<li class="pc"><?= $price_config['type']['modular']['model']['fm1']['size']['160x102']['price'] ?> ₽</li>
						</ul>
						<h3>Дарья, <span class="d-inline-block">г. <?= empty($ipgeo_city) ? 'Казань' : htmlspecialchars($ipgeo_city) ?></span></h3>
					</div>
				</div>
				<div class="card-blog">
					<img class="card-img rounded-0" src="img/example/4.jpg" alt="">
					<div class="blog-body">
						<ul class="blog-info">
							<li>Размер: 45 x 45 см.</li>
							<li class="pc"><?= $price_config['type']['modular']['model']['fm1']['size']['60x38']['price'] ?> ₽</li>
						</ul>
						<h3>Сергей, <span class="d-inline-block">г. Новосибирск</span></h3>
					</div>
				</div>
				<div class="card-blog">
					<img class="card-img rounded-0" src="img/example/5.jpg" alt="">
					<div class="blog-body">
						<ul class="blog-info">
							<li>Размер: 65 x 65 см.</li>
							<li class="pc"><?= $price_config['type']['foto']['model']['fs3']['size']['60x60']['price'] ?> ₽</li>
						</ul>
						<h3>Дмитрий, <span class="d-inline-block">г. Красноуфимск</span></h3>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section-padding">
		<div class="container">
			<div class="row no-gutters">
				<div class="col-sm">
					<img class="card-img offer-image-position rounded-0" src="img/production.jpg" alt="">
				</div>
				<div class="col-sm">
					<div class="offer-card offer-card-position">
						<h3>Заполни анкету <span class="d-inline-block">и получи скидку</span></h3>
						<h2><span style="font-family: sans-serif;">-</span> 10%</h2>
						<a href="/discount/" class="button">Заполнить анкету</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section-margin">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-xl-7 mb-5 mb-md-0 pb-5 pb-md-0">
					<div id="listing_vk_comments"></div>
				</div>
				<div class="col-md-6 col-xl-4 offset-xl-1 pl-md-5 pl-xl-0">
					<div class="section-intro mb-lg-4">
						<h4 class="intro-title">Отзывы</h4>
						<h2>Пишите, мы ответим быстро</h2>
					</div>
					<p class="mb-4">
						Мы не делаем одинаковых картин. Все изображения мы закупаем 
						у талантливых художников и фотографов на таких профессиональных
						площадках как «Adobe Stock», «Shutterstock» и «Depositphotos».
					</p>
					<a href="/discount/"class="button open-request-modal">Оформить заявку</a>
				</div>
			</div>
		</div>
	</section>

	<? include $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>
	<script src="js/price.js"></script>
</body>
</html>