<?php
include('login.php');
if (isset($_SESSION['login_user'])) {
  header("location: profile.php");
}
if (isset($_POST['signup'])) {
  $username   = $_POST['inputUsername'];
  $password   = md5($_POST['inputPassword']);
  $fname      = $_POST['firstName'];
  $lname      = $_POST['lastName'];
  $email      = $_POST['inputEmail'];
  $school     = $_POST['schoolName'];
  $department = $_POST['departmentName'];
  $gpa        = $_POST['GPA'];
  $grad_year   = $_POST['gradYear'];
  $country    = $_POST['country'];
  $exists     = 0;
  $error      = '';
  $fields = array('inputUsername', 'inputPassword', 'firstName', 'lastName', 'schoolName', 'departmentName', 'country');
  foreach ($fields as $fieldname) { //Loop trough each field
    if (empty($_POST[$fieldname])) {
      $exists = 1;
    }
  }
  $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if ($db->connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
  }
  $result = $db->query("SELECT username from user WHERE username = '{$username}' LIMIT 1");
  if ($result->num_rows == 1)
    $exists = 3;
  if ($exists == 1) {
    $error = "Fields can not be empty!";
  }
  if ($exists == 3) {
    $error = "Username already exists!";
  }
  if ($exists == 0) {
    $sql = "INSERT  INTO `user` (`username`, `password`, `fname`, `lname`, `email`, `school`, `department`, `gpa`, `grad_year`, `country`) 
              VALUES ('{$username}', '{$password}', '{$fname}', '{$lname}', '{$email}', '{$school}', '{$department}', '{$gpa}', '{$grad_year}', '{$country}')";
    if ($db->query($sql)) {
      $_SESSION['message'] = 'Registered Successfully!';
      header("location: index.php");
    } else {
      echo "<p>MySQL error no {$db->errno} : {$db->error}</p>";
      exit();
    }
  }
  $db->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>PROJECT</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="my.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Project</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          <li><a href="index.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="text-center">
      <h1>Sign Up</h1>
    </div>
    <div class="row">
      <form class="form-horizontal" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-group">
          <label class="control-label col-xs-3" for="inputUsername">Username:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" name="inputUsername" id="inputUsername" placeholder="Username">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="inputPassword">Password:</label>
          <div class="col-xs-9">
            <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="Password">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="firstName">First Name:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" name="firstName" id="firstName" placeholder="First Name">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="lastName">Last Name:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Last Name">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="inputEmail">Email:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="schoolName">School:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" name="schoolName" id="schoolName" placeholder="School Name">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="departmentName">Department:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" name="departmentName" id="departmentName" placeholder="Department">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="country">Country:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" name="country" id="country" placeholder="Country">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3">GPA:</label>
          <div class="col-xs-3">
            <select class="form-control" name="GPA">
              <?php
              for ($i = 4; $i >= 0.9; $i -= 0.1) {
                echo "<option>$i</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3">Graduation Year:</label>
          <div class="col-xs-3">
            <select class="form-control" name="gradYear">
              <?php
              for ($i = date('Y'); $i <= date('Y') + 10; $i++) {
                echo "<option>$i</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="spa"></label>
          <div class="col-xs-9">
            <span class="error"><?php echo $error; ?></span>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-offset-3 col-xs-9">
            <button name="signup" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-user"></span> Sign Up</button>
            <button type="reset" class="btn btn-reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-offset-3 col-xs-9">
            <label><small> <a href="index.php"><kbd> or sign in</kbd></small></a> </label>
          </div>
        </div>
      </form>
    </div>
  </div>
  <footer class="footer">
    <div class="col-sm-offset-2 container1">
      <p>Copyright &copy; Berk Cetinsaya <?php echo date('Y'); ?></p>
    </div>
  </footer>
</body>

</html>