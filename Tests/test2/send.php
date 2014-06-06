<?php

if(isset($_POST['message']) && !empty($_POST['message']))
{
	$socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
	socket_connect($socket, '127.0.0.1', 9818);
	$send = 'SEND?'.sprintf('% 994s', $_POST['message']);
	socket_write($socket, $send, 999);
	socket_shutdown($socket, 2);
	socket_close($socket);
	echo 'send';
}