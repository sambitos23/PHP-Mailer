<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP-Mailer</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <?php
  include 'dbconn.php';

  if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $token = bin2hex(random_bytes(15));

    $emailquery = "SELECT * FROM users WHERE email = '$email'";
    $query = mysqli_query($conn, $emailquery);

    $emailcount = mysqli_num_rows($query);

    if ($emailcount <= 0) {
      $insertquery = "INSERT INTO users (username, email, token, status) VALUES ('$username', '$email', '$token', 'inactive')";
      $iquery = mysqli_query($conn, $insertquery);
      if ($iquery) {
        $to_email = $email;
        $subject = "Email Verification for PHP-Mailer";
        $body = "
                  Hi, $username,
                  Click the link below to verify your email. http://php-mail.unaux.com/PHP-Mailer/verify.php?token=$token.
                  Thank you.



                  Unsubscribe from our newsletter by clicking the link below.
                  http://php-mail.unaux.com/PHP-Mailer/unsubscribe.php?email=$email
                ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers = "From: Sambit Saha <sambit28saha@gmail.com>";

        if (mail($to_email, $subject, $body, $headers)) {
          $_SESSION['message'] = "Check your email to verify your account $to_email";
        } else {
          echo "Email sending failed";
        }
      } else {
        echo "Error: " . mysqli_error($conn);
      }
    } else {
      $_SESSION['message'] = "Email already exists";
    }
  }
  ?>

  <section class="text-gray-600 body-font h-screen flex flex-nowrap items-center">
    <div class="container px-5 mx-auto flex flex-wrap items-center">
      <div class="lg:w-3/5 md:w-1/2 md:pr-16 lg:pr-0 pr-0">
        <h1 class="title-font font-medium text-3xl text-gray-900">Slow-carb next level shoindcgoitch ethical authentic, poko scenester</h1>
        <p class="leading-relaxed mt-4">Poke slow-carb mixtape knausgaard, typewriter street art gentrify hammock starladder roathse. Craies vegan tousled etsy austin.</p>
      </div>
      <form action="../PHP-Mailer/" method="post" class="lg:w-2/6 md:w-1/2 bg-gray-100 rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0">
        <h2 class="text-gray-900 text-lg font-medium title-font mb-5">Sign Up</h2>
        <div class="relative mb-4">
          <label for="username" class="leading-7 text-sm text-gray-600">Full Name</label>
          <input type="text" id="username" name="username" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required />
        </div>
        <div class="relative mb-4">
          <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
          <input type="email" id="email" name="email" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required />
        </div>
        <button type="submit" name="submit" class="text-white bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-600 rounded text-lg">Subscribe</button>
        <p class="text-md text-white mt-3 bg-green-500 p-2 rounded">
          <?php
          if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
          }
          ?>
        </p>
      </form>
    </div>
  </section>
</body>

</html>