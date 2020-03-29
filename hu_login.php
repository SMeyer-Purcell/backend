<?php

//Receive JSON object from webpage and convert to an array
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

$error = []

//Create database connection
$servername = "localhost";
$username = "";
$password = "";
$dbname = "user_login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
}
// Checks to see if the user hit the login button
if (isset($_POST['submit'])) {
  $uemail = mysql_escape_string($_POST['hu_email']);
  $password = mysql_escape_string($_POST['hu_id']);

// Checks to see if user entered in their email and id
if (!$_POST['hu_email'] || !$_POST['hu_id']) {
  echo error('Fill in required fields');
}
else {
  $sql ="SELECT * from users WHERE $uemail = 'hu_email' AND $password = 'hu_id';";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)) {
    echo error();
  }
  else {
    mysqli_stmt_bind_param($stmt, "ss", $uemail, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc()) {
        $pwdCheck = password_verify($password, $row['hu_id']);
        if ($pwdCheck == false)
          echo error('wrong password');
        }
        else if ($pwdCheck == true)
          session_start();
          $_SESSION['uemail'] = $row[hu_email];
          $_SESSION['uid'] = $row[hu_id];

          header("location: mainpage.html");
        }
    }
    }
?>
