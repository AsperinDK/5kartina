<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/preload.php';
	include 'processor.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<title>Наши контакты</title>
	<? include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
</head>
<body>
	<? include $_SERVER['DOCUMENT_ROOT'] . '/header.php'; ?>

	<section class="about section-margin pb-xl-70">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-xl-6 mb-3 mb-md-0 pb-3 pb-md-0">
					<div class="section-intro mb-4">
						<h2>Наши контакты</h2>
					</div>
					<div class="media contact-info">
						<span class="contact-info__icon"><i class="ti-email"></i></span>
						<div class="media-body">
							<h3><a href="mailto:<?= htmlspecialchars(CONTACT_EMAIL) ?>"><?= htmlspecialchars(CONTACT_EMAIL) ?></a></h3>
							<p>Пишите в любое время</p>
						</div>
					</div>
					<div class="media contact-info">
						<span class="contact-info__icon"><i class="ti-tablet"></i></span>
						<div class="media-body">
							<h3><a href="tel:<?= htmlspecialchars(CONTACT_PHONE) ?>"><?= htmlspecialchars(CONTACT_PHONE_READABLE) ?></a></h3>
							<p>WhatsApp / Viber / Звонки</p>
						</div>
					</div>
					<div class="media contact-info">
						<span class="contact-info__icon"><i class="vk-icon"></i></span>
						<div class="media-body">
							<h3><a href="<?= htmlspecialchars(CONTACT_VK_GROUP_URL) ?>" target="_blank"><?= htmlspecialchars(mb_substr(CONTACT_VK_GROUP_URL, 8)) ?></a></h3>
							<p>Обсуждения и отзывы</p>
						</div>
					</div>
					<div class="media contact-info">
						<span class="contact-info__icon"><i class="ti-instagram"></i></span>
						<div class="media-body">
							<h3><a href="<?= htmlspecialchars(CONTACT_INSTAGRAM_URL) ?>" target="_blank"><?= htmlspecialchars(mb_substr(CONTACT_INSTAGRAM_URL, 12)) ?></a></h3>
							<p>Пишите в Директ</p>
						</div>
					</div>
					<div class="clearfix"></div>
					Процесс производства каждой картины индивидуален, но обычно его можно разделить на этапы:
					<ul style="list-style: decimal; padding-left: 20px;">
						<li>Вы указываете тематику, размер и пожелания по картине, или просто скидываете ваше изображение.</li>
						<li>Мы подготовим несколько вариантов</li>
						<li>Согласовываем итоговый вариант и вносим исправления</li>
						<li>Печатаем на холсте, натягиваем на сосновый подрамник, бережно упаковываем и отправляем посылку</li>
					</ul>
					<p class="text-muted mt-4" style="font-size: 13px; line-height: 150%;">
						Нажимая кнопку «Отправить» Вы соглашаетесь с <a href="/rules/" target="_blank">пользовательским соглашением</a> 
						и даете своё согласие на обработку персональных данных
					</p>
				</div>
				<div class="col-md-6 pl-md-5 pl-xl-0 offset-xl-1 col-xl-5">
					<div class="form-contact-wrapper">
						<h3>Отправка сообщения</h3>
						<?= empty($result['message']) ? '' : '<div class="alert alert-' . ($result['result'] ? 'success' : 'danger') . '">' . implode('<br/>', $result['message']) . '</div>' ?>
						<form class="form-contact contact_form" action="" method="post" id="contactForm" novalidate="novalidate">
							<div class="row" style="margin-bottom: -15px;">
								<div class="col-12">
									<div class="form-group">
										<textarea class="form-control w-100" name="message[text]" cols="30" rows="10" placeholder="Введите сообщение"><?= htmlspecialchars(@$_REQUEST['message']['text']) ?></textarea>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" name="message[name]" type="text" placeholder="Ваше имя" value="<?= htmlspecialchars(@$_REQUEST['message']['name']) ?>">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" name="message[email]" type="email" placeholder="E-mail адрес" value="<?= htmlspecialchars(@$_REQUEST['message']['email']) ?>">
									</div>
								</div>
							</div>
							<div class="form-group form-group-position">
								<button type="submit" class="button border-0">Отправить сообщение</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<? include $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>
</body>
</html>