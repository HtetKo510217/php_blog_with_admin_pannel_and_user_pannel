<?php

require('config.php');
session_start();
// unset($_SESSION);
if($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(empty($username) || empty($email) || empty($password)) {
      if(empty($username)) {
        $usernameErr = "Please enter your name";
        if (isset($_SESSION['register'])) {
          unset($_SESSION['register']);
        }
      }else {
        $username = $_POST['username'];
      }

      if(empty($email)) {
        $emailErr = "Please enter your email";
        if (isset($_SESSION['register'])) {
          unset($_SESSION['register']);
        }
      }else {
        $email = $_POST['email'];
      }

      if(empty($password)) {
        $passwordErr = "Please enter your password";
        if (isset($_SESSION['register'])) {
          unset($_SESSION['register']);
        }
      }else {
        $password = $_POST['password'];
      }
    }else {
       $_SESSION['register']['username'] = $_POST['username'];
       $_SESSION['register']['email'] = $_POST['email'];
       $_SESSION['register']['password'] = $_POST['password'];

       $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
       $stmt->bindValue(':email',$email);

       $stmt->execute();
       $checkEmailExit = $stmt->fetch(PDO::FETCH_ASSOC);
       if($checkEmailExit) {
         $emailErr = "Email already exit !!!";
       }else {
         if (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $_POST["email"])) {
           $passwordHash = password_hash($password,PASSWORD_BCRYPT);
           $stmt = $pdo->prepare("INSERT INTO users (name,email,password) VALUES (:name,:email,:password)");
           $stmt->bindValue(':name',$username);
           $stmt->bindValue(':email',$email);
           $stmt->bindValue(':password',$password);
           $result = $stmt->execute();
          //  die(var_dump($result));
           if($result) {
              header('location:login.php');
           }
         }else {
           $emailErr = "Please enter correct email format";
         }       }
    }
}

?>

<?php  require_once('header.php') ?>
<div class="container">
  <div class="row d-flex justify-content-center my-5">
    <div class="login-box w-50 mb-5">
      <div class="login-logo mb-5">
        <a href="login.php"><b>Register</b></a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <form action="register.php" method="post">
            <div class="input-group mb-4">
              <input type="text" name="username" class="form-control" placeholder="User name" value="<?php
              if(isset($_SESSION['register'])){
                echo $_SESSION['register']['username'];
              }else {
                echo @$username;
              }
               ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user-circle"></span>
                </div>
              </div>
            </div>
            <p class="text text-danger"><?php if(isset($usernameErr)){echo $usernameErr;} ?></p>
            <div class="input-group mb-4">
              <input type="email" name="email" class="form-control" placeholder="Email" value="<?php
              if(isset($_SESSION['contact'])){
              echo $_SESSION['contact']['email'];
              } else {
              echo @$email;
              }
               ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <p class="text text-danger"><?php if(isset($emailErr)){echo $emailErr;} ?></p>
            <div class="input-group mb-4">
              <input type="password" name="password" class="form-control" placeholder="Password" value="<?php
              if(isset($_SESSION['register'])){
                echo $_SESSION['register']['password'];
              }
               ?>">
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
                <button type="submit" class="btn form-contr btn-primary btn-block">Register</button>
              </div>
              <div class="col-4">
                <a href="login.php" class="btn btn-outline-secondary">Login In</a>
              </div>
              <!-- /.col -->
            </div>
          </form>
          <!-- /.social-auth-links -->
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
  </div>
</div>
<!-- /.login-box -->

<?php require_once('footer.php') ?>
