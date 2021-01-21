<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/preload.php';
	include 'processor.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<title>Оформление заявки</title>
	<? include $_SERVER['DOCUMENT_ROOT'] . '/head.php'; ?>
	<? if (!empty($result['result'])) { ?>
		<script type="text/javascript">
        	if ('undefined' !== typeof ym) {
        		ym(49642810,'reachGoal','add-discount');
        	}
		</script>
	<? } ?>
</head>
<body>
	<? include $_SERVER['DOCUMENT_ROOT'] . '/header.php'; ?>

	<section class="discount section-margin pb-xl-70">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="section-intro mb-4">
						<h2 class="mb-4">Заполни и получи скидку 10%</h2>
						<p>Чем подробнее вы заполните заявку, тем лучшие эскизы мы подготовим</p>
					</div>
					<form action="" method="POST" novalidate="novalidate">
						<?= empty($result['message']) ? '' : '<div class="alert alert-' . ($result['result'] ? 'success' : 'danger') . '">' . implode('<br/>', $result['message']) . '</div>' ?>
						<div class="form-group">
							<h4><div class="num">1.</div> Картину какой тематики вы бы хотели?</h4>
							<textarea class="form-control" name="request[theme]" placeholder="Например: рассвет на природе"><?= htmlspecialchars(@$_REQUEST['request']['theme']) ?></textarea>
						</div>
						<div class="form-group">
							<h4><div class="num">2.</div>Какие цвета вам хотелось бы видеть в картине?</h4>
							<textarea class="form-control" name="request[color]" placeholder="Например: с зеленой травой и ярко оранжевым солнцем"><?= htmlspecialchars(@$_REQUEST['request']['color']) ?></textarea>
						</div>
						<div class="form-group">
							<h4><div class="num">3.</div>Примерные размеры</h4>
							<textarea class="form-control" name="request[size]" placeholder="Например: 100 х 60 см."><?= htmlspecialchars(@$_REQUEST['request']['size']) ?></textarea>
						</div>
						<div class="form-group">
							<h4><div class="num">4.</div>Дополнительные пожелания</h4>
							<textarea class="form-control" name="request[comment]" placeholder="Например: багет серебристого цвета"><?= htmlspecialchars(@$_REQUEST['request']['comment']) ?></textarea>
						</div>
						<div class="form-group">
							<h4><div class="num">5.</div>Как с вами связяться</h4>
							<div class="form-row">
								<div class="col-sm-6">
									<input class="form-control" type="text" name="request[phone]" value="<?= htmlspecialchars(@$_REQUEST['request']['phone']) ?>" placeholder="+7 (999) 888-77-66">
								</div>
								<div class="col-sm-6">
									<label class="form-check form-check-inline">
										<input class="form-check-input" type="checkbox" name="request[viber]" value="1" <?= empty($_REQUEST['request']['viber']) ? '' : 'checked="checked"' ?>>
										<div class="form-check-label">Viber</div>
									</label>
									<label class="form-check form-check-inline">
										<input class="form-check-input" type="checkbox" name="request[whatsapp]" value="1" <?= empty($_REQUEST['request']['whatsapp']) ? '' : 'checked="checked"' ?>>
										<div class="form-check-label">WhatsApp</div>
									</label>
								</div>
							</div>
						</div>
						<p class="text-muted">
							Нажимая кнопку «Отправить» Вы соглашаетесь с <a href="/rules/" target="_blank">пользовательским соглашением</a> 
							и даете своё согласие на обработку персональных данных
						</p>
						<button type="submit" class="button mt-4">Отправить сообщение</button>
					</form>
				</div>
				<div class="d-none d-lg-block col-lg-6 pl-lg-5 col-xl-5 offset-xl-1 pl-xl-0">
					<div class="discount-bg"></div>
				</div>
			</div>
		</div>
	</section>

	<? include $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>
</body>
</html>