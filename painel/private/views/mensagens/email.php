<?php 
$imap = new Imap();
$connection_result = $imap->connect('{imap.gmail.com:993/imap/ssl}INBOX', 'inaciowassir@gmail.com', '05011991');
if($connection_result !== true) {
	echo $connection_result; //Error message!
	exit;
}
$messages = $imap->getMessages('text');
var_dump($messages);
?>