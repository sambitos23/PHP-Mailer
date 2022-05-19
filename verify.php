<?php
session_start();

include 'dbconn.php';

if (isset($_GET['token'])) {
  $token = $_GET['token'];
  $query = "SELECT * FROM users WHERE token = '$token'";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
  if ($count == 1) {
    $query = "UPDATE users SET status = 'active' WHERE token = '$token'";
    $result = mysqli_query($conn, $query);
    if ($result) {
      $_SESSION['message'] = "Your account has been activated";
      header("location: ../PHP-Mailer");
    } else {
      $_SESSION['message'] = "Your account has not registered";
      header("location: ../PHP-Mailer");
    }
  }
}
