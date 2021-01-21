<?php

// Локаль рабочего пространства
setlocale(LC_ALL, 'ru_RU.UTF-8');

// Кодировка скриптов
mb_internal_encoding('utf-8');

// Подключение конфига
include dirname(__FILE__) . '/config.php';

// Инициализируем сессию
session_start();

// Подключаем функции
include dirname(__FILE__) . '/functions.php';