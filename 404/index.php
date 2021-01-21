<?php
header("HTTP/1.0 404 Not Found");
?><!DOCTYPE html>
<html>
<head>
	<title>404. Страница не найдена</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/css/font-amatic-sc-700.css">
	<link rel="stylesheet" type="text/css" href="/css/main.css">
	<style type="text/css">
		html, body {
		    height: 100%;
		}
		.hero {
		    width: 100%;
		    height: 100%;
		    background-image: url('/img/hero_sad.jpg');
		    background-position: center;
		}
		.hero .caption {
		    padding: 40px 20px;
			box-sizing: border-box;
			background-color: rgba(0, 0, 0, 0.7);
			margin-top: -200px;
		}
	</style>
</head>
<body>
	<section class="hero">
		<section class="caption">
			<h2 style="text-transform: none;">404. Страница не найдена</h2>
			<small>Нам очень жаль, но этой страницы не существует &#9785;</small><br />
			<small>Попробуйте найти нужную Вам информацию <a href="/" style="display: inline-block;">на главной странице</a></small>
		</section>
	</section>
</body>
</html>