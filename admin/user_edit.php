<?php

require('../config.php');
session_start();

if($_SESSION['register']['role'] !=1) {
  header('location:login.php');
}

// unset($_SESSION);
if($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(empty($_POST['role'])) {
        $role = 0;
    }else {
        $role = 1;
    }
   
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
       $id = $_POST['id'];
       $_SESSION['register']['username'] = $_POST['username'];
       $_SESSION['register']['email'] = $_POST['email'];
       $_SESSION['register']['password'] = $_POST['password'];
       $_SESSION['register']['role'] = $role;

       $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
    //    $stmt->bindValue(':email',$email);
    //    $stmt->bindValue(':id',$id);

       $stmt->execute([
        ':email' => $email,
        ':id' => $id
       ]);
       $checkEmailExit = $stmt->fetch(PDO::FETCH_ASSOC);

       if($checkEmailExit) {
         $emailErr = "Email already exit !!!";
       }else {
         if (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $_POST["email"])) {
           $passwordHash = password_hash($password,PASSWORD_BCRYPT);
           $stmt = $pdo->prepare("UPDATE users SET name='$username',email='$email',password='$password',role='$role' WHERE id='$id'");
           $result = $stmt->execute();
          //  die(var_dump($result));
           if($result) {
            echo "<script>alert('User Update is successfuly !!');window.location.href='user_list.php'</script>";
           }
         }else {
           $emailErr = "Please enter correct email format";
         }       }
    }
}


$stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// die(var_dump($result));

?>

<?php  require_once('header.php') ?>
<div class="container">
  <div class="row d-flex justify-content-center my-5">
    <div class="login-box w-50 mb-5">
      <div class="login-logo mb-5">
        <a href="login.php"><b>Edit User</b></a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
            <div class="input-group mb-4">
              <input type="text" name="username" class="form-control" placeholder="User name" value="<?php echo $result['name'] ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user-circle"></span>
                </div>
              </div>
            </div>
            <p class="text text-danger"><?php if(isset($usernameErr)){echo $usernameErr;} ?></p>
            <div class="input-group mb-4">
              <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $result['email'] ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <p class="text text-danger"><?php if(isset($emailErr)){echo $emailErr;} ?></p>
            <div class="input-group mb-4">
              <input type="password" name="password" class="form-control" placeholder="Password" value="">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <p class="text text-danger"><?php if(isset($passwordErr)){echo $passwordErr;} ?></p>
            <div class="input-group mb-4">
              <label for="role">Role</label>
              <input type="checkbox" name="role" <?php echo $result['role'] === 1 ?  'checked' : '' ?> id="role" class="form-control w-25" value="1" style="margin-left: -425px;">
            </div>
            <div class="row">
              <!-- /.col -->
              <div class="col-4">
                <a href="user_list.php" class="btn form-contr btn-secondary btn-block">Back</a>
              </div>
              <div class="col-4">
                <button type="submit" class="btn form-contr btn-primary btn-block">Update</button>
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
