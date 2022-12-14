<?php
require('config.php');
session_start();
if(!isset($_SESSION['register'])) {
  header('location:login.php');
}

if (!empty($_GET['pageno'])) {
  $pageno = $_GET['pageno'];

}else {
  $pageno =1;

}

$numOfrecs = 6;
$offset = ($pageno - 1) * $numOfrecs;

$stmt = $pdo->prepare("SELECT * FROM posts ORDER BY ID DESC");
$stmt->execute();

$rawResult = $stmt->fetchAll();
$total_pages = ceil(count($rawResult) / $numOfrecs);
 
$stmt = $pdo->prepare("SELECT * FROM posts ORDER BY ID DESC LIMIT $offset,$numOfrecs");
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
                    <img src="admin/images/<?php echo $post['image']?>" alt="" class="w-100 d-blok" style="min-height:200px; max-height:200px;"><br>
                    <p class="card-text"><?php echo substr($post['content'],0,20) ?></p>
                    <a href="blog_detail.php?id=<?php echo $post['id'] ?>" class="btn btn-outline-primary col-md-12">Blog Detail</a>
                  </div>
                </div>
              </div>

              <?php
            }
          }
          
          ?>
          
        </div>
        <!-- /.row -->
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
