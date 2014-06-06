<?php
$sock = socket_create_listen(0);
socket_getsockname($sock, $addr, $port);
print "Server Listening on $addr:$port\n";
$fp = fopen($port_file, 'w');
fwrite($fp, $port);
fclose($fp);
while($c = socket_accept($sock)) {
   socket_getpeername($c, $raddr, $rport);
   print "Received Connection from $raddr:$rport\n";
}
socket_close($sock);
$fp = fopen($port_file, 'r');
$port = fgets($fp, 1024);
fclose($fp);
$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_connect($sock, '127.0.0.1', $port);
socket_close($sock); 