<?php
  session_start();
  include('db_conn.php');
  $error='';
  if (isset($_POST['login'])) {
    if (empty($_POST['un']) || empty($_POST['pwd'])) {
      $error = "Username or Password is required";
    }
    else{
      $username=$_POST['un'];
      $password=md5($_POST['pwd']);
      $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      $username = stripslashes($username);
      $password = stripslashes($password);
      $username = $mysqli->real_escape_string($username);
      $password = $mysqli->real_escape_string($password);
      $query = $mysqli->query("select * from user where password='$password' AND username='$username'");
      $rows = mysqli_num_rows($query);
      while($row = $query->fetch_assoc()){
        $first_name     = $row['fname'];
        $last_name      = $row['lname'];
      }
      if ($rows == 1) {
        $_SESSION['login_user']=$username;
        header("location: profile.php");
      }
      else {
        $error = "Username or Password is invalid";
      }
        mysqli_free_result($query);
        $mysqli->close();
    }
  }
?>