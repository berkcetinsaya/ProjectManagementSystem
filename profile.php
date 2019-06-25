<?php
error_reporting(0);
include('session.php');
if ($db->connect_errno > 0) {
  die('Unable to connect to database [' . $db->connect_error . ']');
}
$result = $db->query("select * from user where username='$_SESSION[login_user]'");
while ($row = $result->fetch_assoc()) {
  $user_id[]    = $row['id'];
  $username   = $row['username'];
  $fname      = $row['fname'];
  $lname      = $row['lname'];
  $email      = $row['email'];
  $school     = $row['school'];
  $department = $row['department'];
  $gpa        = $row['gpa'];
  $grad_year  = $row['grad_year'];
  $country    = $row['country'];
  $type       = $row['type'];
}
$result->free();
$sql = "SELECT * FROM user_project";
if (!$result = $db->query($sql)) {
  die('There was an error running the query [' . $db->error . ']');
}
while ($row = $result->fetch_assoc()) {
  $up_user_id[] = $row['user_id'];
  $up_project_id[] = $row['project_id'];
}
$result->free();
$sql = "SELECT * FROM project where status=1;";
if (!$result = $db->query($sql)) {
  die('There was an error running the query [' . $db->error . ']');
}
while ($row = $result->fetch_assoc()) {
  $project_id[] = $row['id'];
  $project_name[] = $row['name'];
  $project_description[] = $row['description'];
  $project_year[] = $row['year'];
  $project_country[] = $row['country'];
  $project_status[] = $row['status'];
}
$result->free();
$sql = "SELECT * FROM project_request WHERE status=0";
if (!$result = $db->query($sql)) {
  die('There was an error running the query [' . $db->error . ']');
}
while ($row = $result->fetch_assoc()) {
  $pro_id[]   = $row['id'];
  $pro_name[] = $row['name'];
  $pro_des[] = $row['description'];
  $pro_country[] = $row['country'];
  $pro_year[] = $row['year'];
  $pro_status[] = $row['status'];
  $pro_user_id[]  = $row['user_id'];
}
$result->free();
$sql = "SELECT * FROM `project` WHERE id in(select project_id from user_project where user_id in(select id from user where id=$user_id[0]))";
if (!$result = $db->query($sql)) {
  die('There was an error running the query [' . $db->error . ']');
}
while ($row = $result->fetch_assoc()) {
  $my_id[] = $row['id'];
  $my_name[] = $row['name'];
  $my_description[] = $row['description'];
  $my_year[] = $row['year'];
  $my_country[] = $row['country'];
  $my_status[] = $row['status'];
}
$result->free();
$sql = "SELECT * FROM `project_request` WHERE user_id=$user_id[0]";
if (!$result = $db->query($sql)) {
  die('There was an error running the query [' . $db->error . ']');
}
while ($row = $result->fetch_assoc()) {
  $pmy_id[] = $row['id'];
  $pmy_name[] = $row['name'];
  $pmy_description[] = $row['description'];
  $pmy_year[] = $row['year'];
  $pmy_country[] = $row['country'];
  $pmy_status[] = $row['status'];
}
$result->free();
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
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span style="color:white;" class="glyphicon glyphicon-home"></span>
        </button>
        <a class="navbar-brand" href="index.php">Project</a>
      </div>
      <div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#section1"><?php echo ucfirst($fname) . " " . ucfirst($lname) ?></a></li>
            <?php if ($type == 2) echo '<li><a href="#section2">My Projects</a></li>'; ?>
            <li><a href="#section3">Available Projects</a></li>
            <li><a href="#section4">Project Request</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Sign Out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <div id="section1" class="container-fluid">
    <h1><?php echo ucfirst($fname) . " " . ucfirst($lname) ?></h1>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <tbody>
          <tr>
            <th class="control-label col-xs-3" scope="row">Username:</th>
            <td class="col-xs-9"><?php echo $username ?></td>
          </tr>
          <tr>
            <th class="control-label col-xs-3" scope="row">First Name:</th>
            <td class="col-xs-9"><?php echo ucfirst($fname) ?></td>
          </tr>
          <tr>
            <th class="control-label col-xs-3" scope="row">Last Name:</th>
            <td class="col-xs-9"><?php echo ucfirst($lname) ?></td>
          </tr>
          <tr>
            <th class="control-label col-xs-3" scope="row">Email:</th>
            <td class="col-xs-9"><?php echo $email ?></td>
          </tr>
          <tr>
            <th class="control-label col-xs-3" scope="row">School:</th>
            <td class="col-xs-9"><?php echo ucfirst($school) ?></td>
          </tr>
          <tr>
            <th class="control-label col-xs-3" scope="row">Department:</th>
            <td class="col-xs-9"><?php echo ucfirst($department) ?></td>
          </tr>
          <tr>
            <th class="control-label col-xs-3" scope="row">Country:</th>
            <td class="col-xs-9"><?php echo $country ?></td>
          </tr>
          <?php if ($type == 2) { ?>
            <tr>
              <th class="control-label col-xs-3" scope="row">GPA:</th>
              <td class="col-xs-9"><?php echo $gpa ?></td>
            </tr>
            <tr>
              <th class="control-label col-xs-3" scope="row">Graduation Year:</th>
              <td class="col-xs-9"><?php echo $grad_year ?></td>
            </tr>
            <tr>
              <th class="control-label col-xs-3" scope="row">Account Type:</th>
              <td class="col-xs-9">Student</td>
            </tr>
          <?php } else {
          echo '
              <tr>
                <th class="control-label col-xs-3" scope="row">Account Type:</th>
                <td class="col-xs-9">Professor</td>
              </tr>
              ';
        } ?>
        </tbody>
      </table>
    </div>
  </div>

  <div id="section2" class="container-fluid">
    <h1>My Projects</h1>
    <?php
    echo
      '<div class="panel-group" id="accordion1">';
    foreach ($my_name as $id => $name) {
      $sql = "SELECT * FROM `user` WHERE type=\"2\" and id in(select user_id from user_project where project_id='{$my_id[$id]}')";
      if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
      }
      $stu_fname = array();
      $stu_lname = array();
      while ($row = $result->fetch_assoc()) {
        $stu_fname[]    = $row['fname'];
        $stu_lname[]    = $row['lname'];
      }
      $result->free();
      $sql = "SELECT * FROM `user` WHERE type=\"1\" and id in(select user_id from user_project where project_id='{$my_id[$id]}')";
      if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
      }
      $adv_fname = array();
      $adv_lname = array();
      while ($row = $result->fetch_assoc()) {
        $adv_fname[]    = $row['fname'];
        $adv_lname[]    = $row['lname'];
      }
      $result->free();
      echo '
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion1" href="#mycollapse' . $id . '">' . $name . '</a>
                </h4>
              </div>
              <div id="mycollapse' . $id . '" class="panel-collapse collapse">
                <div class="panel-body">
                  <h5> Project Description: </h5>' . $my_description[$id] . '
                  <h5> Project Year: </h5>' . $my_year[$id] . '
                  <h5> Project Country: </h5>' . $my_country[$id] . '
                  <h5> Students: </h5>';
      foreach ($stu_fname as $key => $value) {
        echo $value . " " . $stu_lname[$key] . "<br>";
      }
      echo '
                  <h5> Advisor: </h5>';
      foreach ($adv_fname as $key => $value) {
        echo $value . " " . $adv_lname[$key] . "<br>";
      }

      echo '
                </div>
              </div>
            </div>
            ';
    }
    echo '</div>';
    ?>
  </div>

  <div id="section3" class="container-fluid">
    <h1>Available Projects</h1>
    <?php
    echo '
    <div class="panel-group" id="accordion2">';
    foreach ($project_name as $id => $name) {
      if (!in_array($name, $my_name)) {
        $sql = "SELECT * FROM `user` WHERE type=\"2\" and id in(select user_id from user_project where project_id='{$project_id[$id]}')";
        if (!$result = $db->query($sql)) {
          die('There was an error running the query [' . $db->error . ']');
        }
        $stu_fname = array();
        $stu_lname = array();

        while ($row = $result->fetch_assoc()) {
          $stu_fname[]    = $row['fname'];
          $stu_lname[]    = $row['lname'];
        }
        $result->free();
        $sql = "SELECT * FROM `user` WHERE type=\"1\" and id in(select user_id from user_project where project_id='{$project_id[$id]}')";
        if (!$result = $db->query($sql)) {
          die('There was an error running the query [' . $db->error . ']');
        }
        $adv_fname = array();
        $adv_lname = array();
        while ($row = $result->fetch_assoc()) {
          $adv_fname[]    = $row['fname'];
          $adv_lname[]    = $row['lname'];
        }
        $result->free();
        if ($project_status[$id] == 1) {
          echo '
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion2" href="#mycollapses' . $id . '">' . $name . '</a>
                </h4>
              </div>
              <div id="mycollapses' . $id . '" class="panel-collapse collapse">
                <div class="panel-body">
                  <h5> Project Description: </h5>' . $project_description[$id] . '
                  <h5> Project Year: </h5>' . $project_year[$id] . '
                  <h5> Project Country: </h5>' . $project_country[$id] . '
                  <h5> Students: </h5>';
          foreach ($stu_fname as $key => $value) {
            echo $value . " " . $stu_lname[$key] . "<br>";
          }
          echo '
                  <h5> Advisor: </h5>';
          foreach ($adv_fname as $key => $value) {
            echo $value . " " . $adv_lname[$key] . "<br>";
          }

          echo '
                  
                </div>
              </div>
            </div>
            ';
        }
      }
    }
    echo '</div>';
    ?>
  </div>

  <div id="section4" class="container-fluid">
    <h1>Project Requests</h1>
    <?php
    if ($type == 2) {
      echo '
    <div class="panel-group" id="accordion3">';
      foreach ($pro_name as $id => $name) {
        $sql = "SELECT * FROM `user` WHERE type=\"2\" and id in(select user_id from project_request where name='{$name}')";
        if (!$result = $db->query($sql)) {
          die('There was an error running the query [' . $db->error . ']');
        }
        $stu_fname = array();
        $stu_lname = array();

        while ($row = $result->fetch_assoc()) {
          $stu_fname[]    = $row['fname'];
          $stu_lname[]    = $row['lname'];
        }
        $result->free();
        echo '
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion3" href="#mycollapsess' . $id . '">' . $name . '</a>
                </h4>
              </div>
              <div id="mycollapsess' . $id . '" class="panel-collapse collapse">
                <div class="panel-body">
                  <h5> Project Description: </h5>' . $pro_des[$id] . '
                  <h5> Project Year: </h5>' . $pro_year[$id] . '
                  <h5> Project Country: </h5>' . $pro_country[$id] . '
                  <h5> Students: </h5>';
        foreach ($stu_fname as $key => $value) {
          echo $value . " " . $stu_lname[$key] . "<br>";
        }

        echo '
                </div>
              </div>
            </div>
            ';
      }
      echo '</div>';

      ?>

      <p>
        If you have a project idea, click this button
      </p>
      <a href="create.php" class="btn btn-default btn-block"><span class="glyphicon glyphicon-send"></span> Create a project</a>
    <?php } else {
    echo '
    <div class="panel-group" id="accordion4">';
    foreach ($pro_name as $id => $name) {
      $sql = "SELECT * FROM `user` WHERE type=\"2\" and id in(select user_id from project_request where name='{$name}')";
      if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
      }
      $stu_fname = array();
      $stu_lname = array();

      while ($row = $result->fetch_assoc()) {
        $stu_fname[]    = $row['fname'];
        $stu_lname[]    = $row['lname'];
      }
      $result->free();
      echo '
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion4" href="#collapsesss' . $id . '">' . $name . '</a>
          </h4>
        </div>
        <div id="collapsesss' . $id . '" class="panel-collapse collapse">
          <div class="panel-body">
                  <h5> Project Description: </h5>' . $pro_des[$id] . '
                  <h5> Project Year: </h5>' . $pro_year[$id] . '
                  <h5> Project Country: </h5>' . $pro_country[$id] . '
                  <h5> Students: </h5>';
      foreach ($stu_fname as $key => $value) {
        echo $value . " " . $stu_lname[$key] . "<br>";
      }

      echo '

                </div>
        </div>
      </div>';
    }
    echo '</div><a href="assign.php" class="btn btn-default btn-block"><span class="glyphicon glyphicon-user"></span> Assign</a>';
  }
  ?>

  </div>
  <footer class="footer">
    <div class="col-sm-offset-2 container1">
      <p>Copyright &copy; Berk Cetinsaya <?php echo date('Y'); ?></p>
    </div>
  </footer>

  <script>
    $(document).ready(function() {
      $('body').scrollspy({
        target: ".navbar",
        offset: 50
      });
      $("#myNavbar a").on('click', function(event) {
        if (this.hash !== "") {
          event.preventDefault();
          var hash = this.hash;
          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 800, function() {
            window.location.hash = hash;
          });
        }
      });
    });
  </script>
</body>

</html>