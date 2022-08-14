<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="index.php" class="navbar-brand">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Blog</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="" id="navbarCollapse">
        <div class="row">
          <div class="col-md-6">
          <?php
            if (session_status() === PHP_SESSION_NONE) {
            session_start();
            }
            ?>
            <ul class="navbar-nav">
              <?php if(isset($_SESSION['register'])) { ?>
                <li class="nav-item">
                <a href="#" class="nav-link"><?php echo $_SESSION['register']['username']; ?></a>
              </li>
              <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Account</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                  <li><a href="logout.php" class="dropdown-item">Logout</a></li>
                </ul>
              </li>
            <?php
              }else { ?>
                <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Account</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                  <li><a href="register.php" class="dropdown-item">Register</a></li>
                  <li><a href="login.php" class="dropdown-item">Login</a></li>
                </ul>
              </li>
            <?php  }
              ?>
            </ul>
          </div>
          <div class="col-md-6">
            <!-- SEARCH FORM -->
            <form class="form-inline ml-0 ml-md-3 ml-auto mt-1">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- /.navbar -->
