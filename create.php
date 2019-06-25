<?php
include('session.php');
if ($db->connect_errno > 0) {
  die('Unable to connect to database [' . $db->connect_error . ']');
}

$result = $db->query("select * from user where username='$_SESSION[login_user]'");
while ($row = $result->fetch_assoc()) {
  $user_id[]    = $row['id'];
  $username[]   = $row['username'];
  $fname[]      = $row['fname'];
  $lname[]      = $row['lname'];
  $email[]      = $row['email'];
  $school[]     = $row['school'];
  $department[] = $row['department'];
  $gpa[]        = $row['gpa'];
  $grad_year[]  = $row['grad_year'];
  $country[]    = $row['country'];
  $type[]       = $row['type'];
}
$result->free();
if (isset($_POST['create'])) {
  $pro_name   = $_POST['proName'];
  $pro_des   = $_POST['proDes'];
  $pro_country = $_POST['proCountry'];
  $pro_year   = $_POST['proYear'];
  $exists     = 0;
  $error      = '';
  $fields = array('proName', 'proDes', 'proCountry', 'proYear');
  foreach ($fields as $fieldname) { //Loop trough each field
    if (empty($_POST[$fieldname])) {
      $exists = 1;
    }
  }
  if ($db->connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
  }
  $result = $db->query("SELECT name from project_request WHERE name = '{$pro_name}' LIMIT 1");
  if ($result->num_rows == 1)
    $exists = 3;
  if ($exists == 1) {
    $error = "Fields can not be empty!";
  }
  if ($exists == 3) {
    $error = "Project Name already exists!";
  }
  if ($exists == 0) {
    $sql = "INSERT INTO `project_request` (`name`, `description`, `year`, `country`, `user_id`) 
              VALUES ('{$pro_name}', '{$pro_des}', '{$pro_year}', '{$pro_country}', '{$user_id[0]}')";
    if ($db->query($sql)) {
      echo '<script type="text/javascript">';
      echo 'alert("Request was sent successfully");';
      echo 'window.location.href = "profile.php";';
      echo '</script>';
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
        <a class="navbar-brand" href="index.php">Project</a>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="text-center">
      <h1>Create a Project</h1>
    </div>
    <div class="row">
      <form class="form-horizontal" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-group">
          <label class="control-label col-xs-3" for="proName">Project Name:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" name="proName" id="proName" placeholder="Project Name">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="proDes">Project Description:</label>
          <div class="col-xs-9">
            <textarea class="form-control" rows="5" name="proDes" id="proDes" placeholder="Project Description"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="proCountry">Project Country:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" name="proCountry" id="proCountry" placeholder="Project Country">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3">Project Year:</label>
          <div class="col-xs-3">
            <select class="form-control" name="proYear">
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
            <button name="create" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-plane"></span> Create</button>
            <button type="reset" class="btn btn-reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
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