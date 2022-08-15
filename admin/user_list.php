<?php
require('../config.php');

session_start();
if($_SESSION['register']['role'] !=1) {
  header('location:login.php');
}
if(isset($_POST['search'])) {
  setcookie('search', $_POST['search'], time() + (86400 * 30), "/");
}else {
  if (empty($_GET['pageno'])) {
     unset($_COOKIE['search']); 
     setcookie('search', null, -1, '/'); 

  }
}

if (!empty($_GET['pageno'])) {
  $pageno = $_GET['pageno'];

}else {
  $pageno =1;

}

$numOfrecs = 4;
// $search = $_GET['search']
$offset = ($pageno - 1) * $numOfrecs;

if(empty($_POST['search']) && empty($_COOKIE['search'])) {
  $stmt = $pdo->prepare("SELECT * FROM users ORDER BY ID DESC");
  $stmt->execute();
  $rawResult = $stmt->fetchAll();
  $total_pages = ceil(count($rawResult) / $numOfrecs);

  $stmt = $pdo->prepare("SELECT * FROM users ORDER BY ID DESC LIMIT $offset,$numOfrecs");
  $stmt->execute();
  $users = $stmt->fetchAll();
}else {
  $search = isset($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
  $stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$search%' ORDER BY ID DESC");
  $stmt->execute();
  $rawResult = $stmt->fetchAll();
  $total_pages = ceil(count($rawResult) / $numOfrecs);

  $stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$search%' ORDER BY ID DESC LIMIT $offset,$numOfrecs");
  $stmt->execute();
  $users = $stmt->fetchAll();
}

?>

<?php require_once('header.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Register User List</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <a href="user_add.php" class="btn btn-success my-4">Create New User</a>
                <table class="table table-bordered my-3">
                  <thead>
                    <tr class="text-center">
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th style="width: 150px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $i =1;
                    foreach($users as $user) { ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $user['name']; ?></td>
                      <td>
                      <?php echo substr($user['email'], 0, 50);?>
                      </td>
                      <td>
                        <a href="user_edit.php?id=<?php echo $user['id']; ?>" class="btn btn-info">Edit</a>
                        <a href="user_delete.php?id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="confirm('Are you sure you want to delete?')">Delete</a>
                      </td>
                    </tr>
                    <?php
                    $i++;
                  }

                    ?>
                  </tbody>
                </table>
                <nav aria-label="Page navigation example">
                  <?php
                    $prev = $pageno <=1 ?  "#":  '?pageno='.($pageno-1);
                    $next = $pageno >= $total_pages ?  "#":  '?pageno='.($pageno+1);
                   ?>
                  <ul class="pagination justify-content-end">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <=1) { echo "disabled";} ?>">
                     <a class="page-link" href="<?php echo $prev ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages) { echo "disabled";} ?>">
                      <a class="page-link" href="<?php echo $next ?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                  </ul>
                </nav>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php require_once('footer.php') ?>
