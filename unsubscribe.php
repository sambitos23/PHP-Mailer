<?php
session_start();

include 'dbconn.php';

if (isset($_GET['email'])) {
  $email = $_GET['email'];
  $query = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
  if ($count == 1) {
    $query = "UPDATE users SET status = 'inactive' WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if ($result) {
      $_SESSION['message'] = "Your account successfully Deactivated";
      header("location: ../PHP-Mailer");
    } else {
      $_SESSION['message'] = "Your account has not registered";
      header("location: ../PHP-Mailer");
    }
  }
}
