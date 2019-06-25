<?php
include('login.php');
if (isset($_SESSION['login_user'])) {
  header("location: profile.php");
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
          <span style="color:white;" class="glyphicon glyphicon-home"></span>
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
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Login</h3>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
              <div class="form-group">
                <div class="">
                  <input type="text" class="form-control" name="un" id="un" placeholder="Enter username" autofocus>
                </div>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Enter password">
              </div>
              <div class="form-group">
                <div class="text-center">
                  <span class="error"><?php if ($_SESSION['message']) {
                                        echo $_SESSION['message'];
                                        $_SESSION['message'] = null;
                                      } else echo $error; ?></span>
                </div>
              </div>
              <div class="form-group">
                <button name="login" type="submit" class="btn btn-lg btn-block"><span class="glyphicon glyphicon-log-in"></span> Login</button>
              </div>
            </form>
          </div>
        </div>
        <div class="text-center">
          <label>
            <small><a href="signup.php"><kbd>sign up</kbd></a></small>
          </label>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer">
    <div class="col-sm-offset-2 container1">
      <p>Copyright &copy; Berk Cetinsaya <?php echo date('Y'); ?></p>
    </div>
  </footer>
</body>

</html>