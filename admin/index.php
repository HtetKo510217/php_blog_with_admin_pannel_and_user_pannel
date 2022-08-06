<?php 
require('../config.php');

session_start();
// die(var_dump($_SESSION));
if(!isset($_SESSION['isAdmin'])) {
  header('location:login.php');
}

$stmt = $pdo->prepare("SELECT * FROM posts ORDER BY ID DESC");
$stmt->execute();
$posts = $stmt->fetchAll();
?>

<?php require_once('header.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Starter Page</h1>
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
              <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="create.php" class="btn btn-success my-4">New Blog Posts</a>
                <table class="table table-bordered">
                  <thead>
                    <tr class="text-center">
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 150px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $i =1;
                    foreach($posts as $post) { ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $post['title']; ?></td>
                      <td>
                      <?php echo $post['content']; ?>
                      </td>
                      <td>
                        <a href="edit.php?id=<?php echo $post['id']; ?>" class="btn btn-info">Edit</a>
                        <a href="delete.php?id=<?php echo $post['id']; ?>" class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                    <?php
                    $i++;
                  }
                    
                    ?>
                  </tbody>
                </table>
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
