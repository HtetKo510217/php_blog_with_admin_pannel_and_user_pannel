<?php
require('config.php');
session_start();
if(!isset($_SESSION['register'])) {
  header('location:login.php');
}

$stmt = $pdo->prepare("SELECT * FROM posts ORDER BY ID DESC");
$stmt->execute();

$result = $stmt->fetchAll();


 ?>
<?php require_once('header.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content pt-5">
      <div class="container">
        <div class="row">
          <?php 
          
          if($result) {
            foreach($result as $post) {
              ?>

              <div class="col-md-4">
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="card-title m-0"><?php echo $post['title'] ?></h5>
                  </div>
                  <div class="card-body">
                    <img src="admin/images/<?php echo $post['image']?>" alt="" class="w-100 d-blok" style="min-height:200px;"><br>
                    <p class="card-text"><?php echo substr($post['content'],0,20) ?></p>
                    <a href="blog_detail.php?id=<?php echo $post['id'] ?>" class="btn btn-primary">Blog Detail</a>
                  </div>
                </div>
              </div>

              <?php
            }
          }
          
          ?>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

<?php require_once('footer.php') ?>
