<?php

require('config.php');
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
        $validPassword = password_verify($password,$hashed);
        // die(var_dump($hashed));

        $_SESSION['email'] = $realUser['email'];
        if($validPassword) {
            $_SESSION['register']['id'] = $realUser['id'];
            $_SESSION['register']['username'] = $realUser['name'];
            $_SESSION['isAdmin']['logged_in'] = time();
            header('location:index.php');
            exit();
        }else {
            $passwordErr = "You password is incorrect";
        }
    }
}

?>

<?php  require_once('header.php') ?>
<div class="container">
  <div class="row d-flex justify-content-center my-5">
    <div class="login-box w-50 mb-5">
      <div class="login-logo mb-5">
        <a href="login.php"><b>Login</b></a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <form action="login.php" method="post">
            <div class="input-group my-4">
              <input type="email" name="email" class="form-control" placeholder="Email" value="<?php
              if (isset($_SESSION['email'])) {
                echo $_SESSION['email'];
              }else {
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
            <div class="input-group my-4">
              <input type="password" name="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <p class="text text-danger"><?php if(isset($passwordErr)){echo $passwordErr;} ?></p>
            <div class="row mt-5">
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn form-contr btn-primary btn-block">Login</button>
              </div>
              <div class="col-4">
                <a href="register.php" class="btn btn-outline-secondary">Register</a>
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
