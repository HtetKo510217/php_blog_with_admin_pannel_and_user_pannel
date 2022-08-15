<?php 

require('../config.php');
session_start();
// unset($_SESSION);
if($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindValue(':email',$email);

    $stmt->execute();
    $realUser = $stmt->fetch(PDO::FETCH_ASSOC);
    if(empty($realUser)) {
        $emailErr = "You email is incorrect";
        if(isset($_SESSION)) {
            unset($_SESSION['email']);
        }
    }else {
        $hashed = password_hash($realUser['password'], PASSWORD_DEFAULT);
        // die(var_dump($hashed));
        $validPassword = password_verify($password,$hashed);
        $_SESSION['email'] = $realUser['email'];
        if($validPassword) {
             $_SESSION['register']['username'] = $realUser['name'];
            $_SESSION['register']['role'] = $realUser['role'];
            $_SESSION['isAdmin']['logged_in'] = time();
            header('location:index.php');
            exit();
        }else {
            $passwordErr = "You password is incorrect";
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blogs | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="container">
  <h4 class="text-center text-danger">Your don't have permission to perform admin pannel !! </h4>
  <h5 class="text-center text-success">If you have admin account permission please !!</h5>
  <div class="login-logo">
    <a href="login.php"><b>Login In </b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card col-md-6 mx-auto">
    <div class="card-body login-card-body">
      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email'];} ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p class="text text-danger"><?php if(isset($emailErr)){echo $emailErr;} ?></p>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <p class="text text-danger"><?php if(isset($passwordErr)){echo $passwordErr;} ?></p>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/../dist/js/adminlte.min.js"></script>
</body>
</html>
