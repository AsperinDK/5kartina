<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/preload.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<title>Доставка и оплата</title>
	<? include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
</head>
<body>
	<? include $_SERVER['DOCUMENT_ROOT'] . '/header.php'; ?>

	<section class="about section-margin pb-xl-70">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-xl-6 mb-3 mb-md-0 pb-3 pb-md-0">
					<div class="section-intro mb-4">
						<h2>Доставка и оплата</h2>
					</div>

					<h3>Стоимость доставки</h3>
					<p>Бесплатно до <?
						$last_day_time = mktime(0,0,0, date("n") + 1, -1);
						$month_list = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
						print date('j', $last_day_time) . ' ' . $month_list[date('n', $last_day_time) - 1];
					?></p>

					<h3>Срок доставки и изготовления</h3>
					<p>Весь процесс занимает от 4 до 6 рабочих дней. 2 дня на производство и 2-4 дня на доставку.</p>

					<h3>Регионы доставки</h3>
					<p>По всей России</p>

					<h3>Транспортные компании</h3>
					<p>«Почта России», «Деловые линии», «ПЭК», «DPD»</p>

					<h3>Откуда отправляем</h3>
					<p>Республика Марий Эл, г. Йошкар-ола</p>

					<h3>Можно ли ускорить процесс?</h3>
					<p>
						Если дело срочное, то мы можем поработать в выходные и отправить посылку самой быстрой транспортной компанией.
					</p>
				</div>
				<div class="col-md-6 pl-md-5 pl-xl-0 offset-xl-1 col-xl-5">
					<div class="delivery-bg"></div>
				</div>
			</div>
		</div>
	</section>

	<? include $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>
</body>
</html>