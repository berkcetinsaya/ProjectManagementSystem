<?php
  include('session.php');
  if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
  }
  $result = $db->query("select * from user");
  while($row = $result->fetch_assoc()){
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
  $sql = "SELECT * FROM user_project";
  if(!$result = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }
  while($row = $result->fetch_assoc()){
      $up_user_id[] = $row['user_id'];
      $up_project_id[] = $row['project_id'];
  }
  $result->free();
  $sql = "SELECT * FROM project";
  if(!$result = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }
  while($row = $result->fetch_assoc()){
      $project_id[] = $row['id'];
      $project_name[] = $row['name'];
      $project_description[] = $row['description'];
      $project_year[] = $row['year'];
      $project_country[] = $row['country'];
      $project_status[] = $row['status'];
  }
  $result->free();
  $sql = "SELECT COUNT(*) as total FROM project";
  if(!$result = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }
  while($row = $result->fetch_assoc()){
      $project_count = $row['total'];
  }
  $result->free();
  $sql = "SELECT * FROM project_request";
  if(!$result = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }
  while($row = $result->fetch_assoc()){
      $pro_id[]   = $row['id'];
      $pro_name[] = $row['name'];
      $pro_des[] = $row['description'];
      $pro_country[] = $row['country'];
      $pro_year[] = $row['year'];
      $pro_status[] = $row['status'];
      $pro_user_id[]  =$row['user_id'];
  }
  $result->free();
  $sql = "SELECT * FROM `project` WHERE id in(select project_id from user_project where user_id in(select id from user where id=$user_id[0]))";
  if(!$result = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }
  while($row = $result->fetch_assoc()){
      $my_id[] = $row['id'];
      $my_name[] = $row['name'];
      $my_description[] = $row['description'];
      $my_year[] = $row['year'];
      $my_country[] = $row['country'];
      $my_status[] = $row['status'];
  }
  $result->free();
  $sql = "SELECT * FROM `project_request` WHERE user_id=$user_id[0]";
  if(!$result = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }
  while($row = $result->fetch_assoc()){
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
    <style>
    th{
      text-align:center;
    }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">Project</a>
        </div>
      </div>
    </nav>
    <div class="container-fluid">
      <div>
      <?php if(!empty($user_id)){  ?>
        <form action="" method="post">
        User table
            <?php      
              echo '<table>
              <tr>
              <th>Select</th>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>School</th>
              <th>Department</th>
              <th>GPA</th>
              <th>Graduation Year</th>
              <th>Country</th>
              <th>Type</th>
              </tr>';
          // output data of each row
          foreach ($user_id as $key => $value) {
             echo "<tr>
                    <td>
                      <label><input type=\"radio\" name=\"radio2\" value=\"$key\" ></label>
                      </td>
                    <td>
                      <input type=\"text\" readonly name=\"qid[]\" value=\"$user_id[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"qfname[]\" value=\"$fname[$key]\"> 
                      </td>
                      <td>
                      <input type=\"text\" name=\"qlname[]\" value=\"$lname[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"qemail[]\" value=\"$email[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"qschool[]\" value=\"$school[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"qdep[]\" value=\"$department[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"qgpa[]\" value=\"$gpa[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"qgrad[]\" value=\"$grad_year[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"qcou[]\" value=\"$country[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"qtype[]\" value=\"$type[$key]\">
                      </td>
                      </tr>";
           } 
            echo "</table>";
          ?>
              <div class="form-group">
              <br>
                <div>
                  <button name="update2" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-plane"></span> Update</button>
                  <button type="reset" class="btn btn-reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                </div>
              </div>
           </form>
           <?php
        if (isset($_POST['update2'])) {
          if(isset($_POST['radio2']))
          {
            $rad2 = $_POST['radio2'];
            echo "You have selected :<b> ".$rad2."</b><br>";
            $rad2 = $rad2 + 1;            

            $qqid = $_POST['qid'];
            $qqfname = $_POST['qfname'];
            $qqlname = $_POST['qlname'];
            $qqemail = $_POST['qemail'];
            $qqschool = $_POST['qschool'];
            $qqdep = $_POST['qdep'];
            $qqgpa = $_POST['qgpa'];
            $qqgrad = $_POST['qgrad'];
            $qqcou = $_POST['qcou'];
            $qqtype = $_POST['qtype'];
            $qqdep = $_POST['qdep'];


      $sql2 = "UPDATE user SET fname='{$qqfname[$rad2-1]}', lname='{$qqlname[$rad2-1]}', email='{$qqemail[$rad2-1]}', school='{$qqschool[$rad2-1]}', department='{$qqdep[$rad2-1]}', gpa='{$qqgpa[$rad2-1]}', grad_year='{$qqgrad[$rad2-1]}', country='{$qqcou[$rad2-1]}', type='{$qqtype[$rad2-1]}' WHERE id='{$qqid[$rad2-1]}'";
      if($db->query($sql2)){
          echo '<script type="text/javascript">'; 
            echo 'alert("Value was changed successfully");'; 
            echo 'window.location.href = "assign.php";';
            echo '</script>';
        }
        }
        else{ echo "Please choose any radio button";}
        }}
        ?>
      </div>





      <div>
      <?php if(!empty($project_id)){  ?>
      Project Table
        <form action="" method="post">
            <?php      
              echo '<table>
              <tr>
              <th>Select</th>
              <th>ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Year</th>
              <th>Country</th>
              <th>Status</th>
              </tr>';
          // output data of each row
          foreach ($project_id as $key => $value) {
             echo "<tr>
                    <td>
                      <label><input type=\"radio\" name=\"radio\" value=\"$key\" ></label>
                      </td>
                    <td>
                      <input type=\"text\" readonly name=\"pid[]\" value=\"$project_id[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"pname[]\" value=\"$project_name[$key]\"> 
                      </td>
                      <td>
                      <input type=\"text\" name=\"pdes[]\" value=\"$project_description[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"pyear[]\" value=\"$project_year[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"pcou[]\" value=\"$project_country[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"pstat[]\" value=\"$project_status[$key]\">
                      </td>
                      </tr>";
           } 
            echo "</table>";
          ?>
              <div class="form-group">
              <br>
                <div>
                  <button name="update" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-plane"></span> Update</button>
                  <button type="reset" class="btn btn-reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                </div>
              </div>
           </form>
           <?php
        if (isset($_POST['update'])) {
          if(isset($_POST['radio']))
          {
            $rad = $_POST['radio'];
            echo "You have selected :<b> ".$rad."</b><br>";
            $rad = $rad + 1;
            echo $project_count;

            $ppid = $_POST['pid'];
            $ppname = $_POST['pname'];
            $ppdes = $_POST['pdes'];
            $ppyear = $_POST['pyear'];
            $ppcou = $_POST['pcou'];
            $ppstat = $_POST['pstat'];

      $sql = "UPDATE project SET name='{$ppname[$rad-1]}', description='{$ppdes[$rad-1]}', year='{$ppyear[$rad-1]}', country='{$ppcou[$rad-1]}', status='{$ppstat[$rad-1]}' WHERE id='{$ppid[$rad-1]}'";
      if($db->query($sql)){
          echo '<script type="text/javascript">'; 
            echo 'alert("Value was changed successfully");'; 
            echo 'window.location.href = "assign.php";';
            echo '</script>';
        }
        }
        else{ echo "Please choose any radio button";}
        }}
        ?>
      </div>

      <div>
      <?php if(!empty($pro_id)){  ?>
      Project Requested
        <form action="" method="post">
            <?php 

              echo '<table>
              <tr>
              <th>Select</th>
              <th>ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Year</th>
              <th>Country</th>
              <th>Status</th>
              <th>User id</th>
              </tr>';
          // output data of each row
              
          foreach ($pro_id as $key => $value) {
             echo "<tr>
                    <td>
                      <label><input type=\"radio\" name=\"radio1\" value=\"$key\" ></label>
                      </td>
                    <td>
                      <input type=\"text\" readonly name=\"bid[]\" value=\"$pro_id[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"bname[]\" value=\"$pro_name[$key]\"> 
                      </td>
                      <td>
                      <input type=\"text\" name=\"bdes[]\" value=\"$pro_des[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"byear[]\" value=\"$pro_year[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"bcou[]\" value=\"$pro_country[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"bstat[]\" value=\"$pro_status[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" readonly name=\"buser[]\" value=\"$pro_user_id[$key]\">
                      </td>
                      </tr>";
           } 
            echo "</table>";
          
          ?>
              <div class="form-group">
              <br>
                <div>
                  <button name="update1" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-plane"></span> Update</button>
                  <button type="reset" class="btn btn-reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                </div>
              </div>
           </form>
           <?php
        if (isset($_POST['update1'])) {
          if(isset($_POST['radio1']))
          {
            $rad1 = $_POST['radio1'];
            echo "You have selected :<b> ".$rad1."</b><br>";
            $rad1=$rad1 + 1;
            $bpid = $_POST['bid'];
            $bpname = $_POST['bname'];
            $bpdes = $_POST['bdes'];
            $bpyear = $_POST['byear'];
            $bpcou = $_POST['bcou'];
            $bpstat = $_POST['bstat'];
            $bpuser = $_POST['buser'];

            if($bpstat[$rad1-1] == 1){
              $sql0 = "INSERT INTO `project`(`name`, `description`, `year`, `country`, `status`) VALUES ('{$bpname[$rad1-1]}', '{$bpdes[$rad1-1]}', '{$bpyear[$rad1-1]}', '{$bpcou[$rad1-1]}', '{$bpstat[$rad1-1]}')";
            if($db->query($sql0)){

            }
            $sql000 = "SELECT id FROM project ORDER BY id DESC LIMIT 1";
            if(!$result = $db->query($sql000)){
                die('There was an error running the query [' . $db->error . ']');
            }
            while($row = $result->fetch_assoc()){
                $last_row[] = $row['id'];
            }
            $result->free();
            
            $sql00 = "INSERT INTO `user_project`(`user_id`, `project_id`) VALUES ('{$bpuser[$rad1-1]}','{$last_row[0]}')";
            if($db->query($sql00)){

            }
            $sql111 = "UPDATE project_request SET name='{$bpname[$rad1-1]}', description='{$bpdes[$rad1-1]}', year='{$bpyear[$rad1-1]}', country='{$bpcou[$rad1-1]}', status='{$bpstat[$rad1-1]}' WHERE id='{$bpid[$rad1-1]}'";
      if($db->query($sql111)){
        }

            $sql40 = "DELETE FROM `project_request` WHERE user_id='{$bpuser[$rad1-1]}' and status=1";
            if($db->query($sql40)){
              echo '<script type="text/javascript">'; 
                echo 'alert("Value was changed successfully");'; 
                echo 'window.location.href = "assign.php";';
                echo '</script>';
            }       
            }
            else{
              $sql1 = "UPDATE project_request SET name='{$bpname[$rad1-1]}', description='{$bpdes[$rad1-1]}', year='{$bpyear[$rad1-1]}', country='{$bpcou[$rad1-1]}', status='{$bpstat[$rad1-1]}' WHERE id='{$bpid[$rad1-1]}'";
      if($db->query($sql1)){
          echo '<script type="text/javascript">'; 
            echo 'alert("Value was changed successfully");'; 
            echo 'window.location.href = "assign.php";';
            echo '</script>';
        }
            }
      
      
        }
        else{ echo "Please choose any radio button";
      }
        }}
        ?>
      </div>

      <div>
      <?php if(!empty($up_user_id)){  ?>
      User ID - Project ID        
            <?php      
              echo '<table>
              <tr>
              <th>User ID</th>
              <th>Project ID</th>
              </tr>';
          // output data of each row
          foreach ($up_user_id as $key => $value) {
             echo "<tr><td>
                      <input type=\"text\" readonly name=\"luserid[]\" value=\"$up_user_id[$key]\">
                      </td>
                      <td>
                      <input type=\"text\" readonly name=\"lproid[]\" value=\"$up_project_id[$key]\"> 
                      </td>
                      </tr>";
           }
            echo '</table>
            <form action="" method="post">';
          
            echo "<br><table>
                <tr>
                  <td>
                      <input type=\"text\" name=\"luseri\" placeholder=\"Adding User ID\" value=\"$up_user_i\">
                      </td>
                      <td>
                      <input type=\"text\" name=\"lproi\" placeholder=\"Adding Project ID\" value=\"$up_project_i\"> 
                      </td>
                      
                      </tr></table>";
              ?>
              <div class="form-group">
              <br>
                <div>
                  <button name="update3" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-plane"></span> Insert</button>
                  <button type="reset" class="btn btn-reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                </div>
              </div>
              <?php echo "<table><tr><td>
                      <input type=\"text\" name=\"luserii\" placeholder=\"Deleting User ID\" value=\"$up_user_ii\"> 
                      </td>
                      <td>
                      <input type=\"text\" name=\"lproii\" placeholder=\"Deleting Project ID\" value=\"$up_project_ii\"> 
                      </td></tr>
                      </table>"; ?>
              <div>

              <div class="form-group">
              <br>
                  <button name="update4" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                  <button type="reset" class="btn btn-reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                
              </div>
           </form>
           <?php
        if (isset($_POST['update3'])) {
          
            $lluseri = $_POST['luseri'];
            $llproi = $_POST['lproi'];

          $sql3 = "INSERT INTO `user_project`(`user_id`, `project_id`) VALUES ($lluseri,$llproi)";
          if($db->query($sql3)){
              echo '<script type="text/javascript">'; 
                echo 'alert("Value was changed successfully");'; 
                echo 'window.location.href = "assign.php";';
                echo '</script>';
            }        
        }
        if (isset($_POST['update4'])) {
          
            $lluserii = $_POST['luserii'];
            $llproii = $_POST['lproii'];

          $sql4 = "DELETE FROM `user_project` WHERE user_id='{$lluserii}' and project_id='{$llproii}'";
          if($db->query($sql4)){
              echo '<script type="text/javascript">'; 
                echo 'alert("Value was changed successfully");'; 
                echo 'window.location.href = "assign.php";';
                echo '</script>';
            }        
        }}
        ?>
      </div>

    </div>


    <footer class="footer">
      <div class="col-sm-offset-2 container1">
        <p>Copyright &copy; Berk Cetinsaya <?php echo date('Y'); ?></p>
      </div>
    </footer>
  </body>
</html>