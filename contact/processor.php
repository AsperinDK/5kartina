<?php

$result = array(
	'result' => FALSE,
	'data' => NULL,
	'message' => array(),
);

if (!empty($_SESSION['message_send_success'])) {
	$result['result'] = TRUE;
	$result['message'][] = 'Сообщение отправлено.';
	unset($_SESSION['message_send_success']);
}

if (isset($_POST['message']) && is_array($_POST['message'])) {
	$text = isset($_POST['message']['text']) && is_string($_POST['message']['text']) ? trim($_POST['message']['text']) : '';
	$name = isset($_POST['message']['name']) && is_string($_POST['message']['name']) ? trim($_POST['message']['name']) : '';
	$email = isset($_POST['message']['email']) && is_string($_POST['message']['email']) ? trim($_POST['message']['email']) : '';

	if (empty($text)) {
		$result['message'][] = "Забыли указать текст сообщения";
	} elseif (empty($email)) {
		$result['message'][] = "Забыли указать e-mail адрес";
	} else {
		// Тема письма 
		$mail_subject = 'Сообщение c сайта «' . htmlspecialchars($_SERVER['HTTP_HOST']) . '»';
		// Текст письма
		$mail_content =
		'<!DOCTYPE html>' . "\r\n" . '<html>' .
		'<head><title></title><meta charset="UTF-8"></head>' .
		'<body style="padding:0;margin:0;line-height:normal;text-align:left;font:14px Arial,sans-serif;">' .
			(empty($text) ? '' : htmlspecialchars($text) . '<br><br>') .
			(empty($name) ? '' : 'Имя: ' . htmlspecialchars($name) . '<br>') .
			(empty($email) ? '' : 'E-mail: ' . htmlspecialchars($email) . '<br>') .
		'</body>' .
		'</html>';

		// Отправка письма
		include $_SERVER['DOCUMENT_ROOT'] . '/lib/class.SendMailSmtpClass.php';
		$mailSMTP = new SendMailSmtpClass(EMAIL_NOTIFIER, EMAIL_NOTIFIER_PASS, EMAIL_SMTP_URL, EMAIL_SMTP_PORT);
		if (FALSE === $mailSMTP->send(CONTACT_EMAIL, $mail_subject, $mail_content, array($_SERVER['HTTP_HOST'], EMAIL_NOTIFIER))) {
			$result['message'][] = 'Ошибка отправки сообщения. ' . SYSTEM_ERROR_TEXT;
		} else {
			$result['result'] = TRUE;
			$result['message'][] = 'Сообщение отправлено.';
			if (empty($_REQUEST['response_type']) || 'json' !== $_REQUEST['response_type']) {
				$_SESSION['message_send_success'] = TRUE;
				redirect($_SERVER['REQUEST_URI']);
			}
		}
	}
}

if (!empty($_REQUEST['response_type']) && 'json' === $_REQUEST['response_type']) {
	exit(json_encode($result));
}