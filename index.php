<?php
  session_start();
  if (isset($_SESSION['ID'])) {
      header("Location:dashboard.php");
      exit();
  }
  // Include database connectivity
    
  include_once('config.php');
  
  if (isset($_POST['submit'])) {

      $errorMsg = "";

      $email = $con->real_escape_string($_POST['email']);
      $password = $con->real_escape_string(md5($_POST['password']));
      
  if (!empty($email) || !empty($password)) {
        $query  = "SELECT * FROM admins WHERE email = '$email' AND password = '$password'";
        $result = $con->query($query);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            $_SESSION["ID"] = $row['id'];
            $_SESSION["ROLE"] = $row['role'];
            $_SESSION["NAME"] = $row['name'];
            $_SESSION["EMAIL"] = $row['email'];
            
            if($password !== $row['password']){
                $errorMsg = "Password is Incorrect";
            }

            elseif($row['role'] == "admin"){
              header("Location:dashboard.php");
            die();  
            }
            elseif($row['role'] == "staff"){
            header("Location:dashboard.php");
            die(); 
          }
            elseif ($row['role'] == "student") {
              header("Location:dashboard.php");
            die(); 
            }
        
            
        }else{
         $errorMsg = "This user does not exist!";
        } 
    }else{
     $errorMsg = "Email Address and Password is required";
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>UITC SUPPORT</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<div class="card text-center" style="padding:20px;">
  <h3>UITC SUPPORT</h3>
</div><br>

<div class="container">
  <div class="row">
    <div class="col-md-3"></div>
      <div class="col-md-6">
        <?php if (isset($errorMsg)) { ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $errorMsg; ?>
          </div>
        <?php } ?>
        <form action="" method="POST">
          <div class="form-group">  
            <label for="email">Email:</label> 
            <input type="text" class="form-control" name="email" placeholder="Enter email address" required>
          </div>
          <div class="form-group">  
            <label for="password">Password:</label> 
            <input type="password" id="myInput" class="form-control" name="password" placeholder="Enter Password" required>
          </div>
          <input type="checkbox" onclick="myFunction()">Show Password
          <div class="form-group">
            <p>Not registered? <a href="register.php">Create Account</a></p>
            <input type="submit" name="submit" class="btn btn-success" value="Login"> 
          </div>
        </form>
      </div>
  </div>
</div>
</body>
</html>

<script>
    function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>