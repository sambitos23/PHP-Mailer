<?php
session_start();
require_once './function.php';

include 'dbconn.php';

$query = "SELECT * FROM users WHERE status = 'active'";
$result = mysqli_query($conn, $query);

$xkcd_num = rand(1, 999);

$response = @file_get_contents("https://xkcd.com/{$xkcd_num}/info.0.json");

if ($response === false) {
  $error = error_get_last();
  echo json_encode(array(
    'message' => "Failed to fetch xkcd comic with num = {$xkcd_num}: " . $error['message']
  ));
  exit;
}

$comic = json_decode($response, true);

while ($row = $result->fetch_assoc()) {
  $username = $row['username'];
  $mail = $row['email'];
  $title = "xkcd Comic of the day";
  $file         = file_get_contents($comic['img']);
  $encoded_file = chunk_split(base64_encode($file));   //Embed image in base64 to send with email

  $attachments[] = array(
    'name'     => $comic['title'] . '.jpg',
    'data'     => $encoded_file,
    'type'     => 'application/pdf',
    'encoding' => 'base64',
  );
  $Body = '
        <p >Hello <b>' . $username . '<b></p>
        <p> Our favorite Subscriber</p>
        <h3>Here is your Comic for the day</h3>
        <h3>' . $comic['safe_title'] . "</h3>
        <img src='" . $comic['img'] . "' alt='" . $comic['title'] . "'/>
        <br /><br />
        To read the comic head to <a target='_blank' href='https://xkcd.com/" . $comic['num'] . "'>Here</a><br />
        To unsubscribe kindly visit <a href='http://php-mail.unaux.com/PHP-Mailer/unsubscribe.php?email=$mail'>here.</a>
        ";
  sendComic($mail, $title, $Body, $attachments);
}
