<?php

$result = array(
	'result' => FALSE,
	'data' => NULL,
	'message' => array(),
);

if (!empty($_SESSION['request_send_success'])) {
	$result['result'] = TRUE;
	$result['message'][] = 'Заявка отправлена. Скоро наш менеджер свяжется с вами.';
	unset($_SESSION['request_send_success']);
}

if (isset($_POST['request']) && is_array($_POST['request'])) {
	$theme = isset($_POST['request']['theme']) && is_string($_POST['request']['theme']) ? trim($_POST['request']['theme']) : '';
	$color = isset($_POST['request']['color']) && is_string($_POST['request']['color']) ? trim($_POST['request']['color']) : '';
	$size = isset($_POST['request']['size']) && is_string($_POST['request']['size']) ? trim($_POST['request']['size']) : '';
	$comment = isset($_POST['request']['comment']) && is_string($_POST['request']['comment']) ? trim($_POST['request']['comment']) : '';
	$phone = isset($_POST['request']['phone']) && is_string($_POST['request']['phone']) ? trim($_POST['request']['phone']) : '';
	$phone_extra = array();
	if (isset($_POST['request']['viber']) && $_POST['request']['viber']) {
		$phone_extra[] = 'Viber';
	}
	if (isset($_POST['request']['whatsapp']) && $_POST['request']['whatsapp']) {
		$phone_extra[] = 'WhatsApp';
	}

	if (empty($phone) || !preg_match('~\d+~', $phone)) {
		$result['message'][] = "Забыли указать номер телефона";
	} else {
		// Тема письма 
		$mail_subject = 'Заказ c сайта «' . htmlspecialchars($_SERVER['HTTP_HOST']) . '»';
		// Текст письма
		$mail_content =
		'<!DOCTYPE html>' . "\r\n" . '<html>' .
		'<head><title></title><meta charset="UTF-8"></head>' .
		'<body style="padding:0;margin:0;line-height:normal;text-align:left;font:14px Arial,sans-serif;">' .
			(empty($theme) ? '' : 'Тема: ' . htmlspecialchars($theme) . '<br>') .
			(empty($color) ? '' : 'Цвет: ' . htmlspecialchars($color) . '<br>') .
			(empty($size) ? '' : 'Размер: ' . htmlspecialchars($size) . '<br>') .
			(empty($comment) ? '' : 'Комментарий: ' . htmlspecialchars($comment) . '<br>') .
			(empty($phone) ? '' : 'Телефон: ' . htmlspecialchars($phone)) . ($phone_extra ? ' (' . implode(', ', $phone_extra) . ')' : '') . '<br>' .
		'</body>' .
		'</html>';

		// Отправка письма
		include $_SERVER['DOCUMENT_ROOT'] . '/lib/class.SendMailSmtpClass.php';
		$mailSMTP = new SendMailSmtpClass(EMAIL_NOTIFIER, EMAIL_NOTIFIER_PASS, EMAIL_SMTP_URL, EMAIL_SMTP_PORT);
		if (FALSE === $mailSMTP->send(CONTACT_EMAIL, $mail_subject, $mail_content, array($_SERVER['HTTP_HOST'], EMAIL_NOTIFIER))) {
			$result['message'][] = 'Ошибка отправки сообщения. ' . SYSTEM_ERROR_TEXT;
		} else {
			$result['result'] = TRUE;
			$result['message'][] = 'Заявка отправлена. Скоро наш менеджер свяжется с вами.';
			if (empty($_REQUEST['response_type']) || 'json' !== $_REQUEST['response_type']) {
				$_SESSION['request_send_success'] = TRUE;
				redirect($_SERVER['REQUEST_URI']);
			}
		}
	}
}

if (!empty($_REQUEST['response_type']) && 'json' === $_REQUEST['response_type']) {
	exit(json_encode($result));
}