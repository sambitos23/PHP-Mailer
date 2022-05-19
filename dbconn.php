<?php
// $server = 'localhost:3307';
// $user = 'root';
// $password = '';
// $db = 'php-mailer';

$server = 'sql6.freemysqlhosting.net';
$user = 'sql6493420';
$password = 'AGNBHumvzd';
$db = 'sql6493420';

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
  echo "No Connection";
}
