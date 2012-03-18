<?php
/**
 * Конфигурация библиотеки сообщений
 * @author Michail1982
 */
/**
 * Поддерживаемые типы сообщений
 * @var array ( тип сообщения  => шаблон вывода )
 */
$config['message_wrapper'] = array(
		'success' => '<p class="message success">%s</p>',
		'info' => '<p class="message info">%s</p>',
		'error' => '<p class="message error">%s</p>'
);
/**
 * Шаблон вывода блока сообщений
 * @var string
 */
$config['message_block_wrapper'] = '<p id="messages">%s</p>';