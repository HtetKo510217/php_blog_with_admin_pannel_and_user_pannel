<?php
require('config.php');
session_start();
if(!isset($_SESSION['register'])) {
  header('location:login.php');
}

if($_POST) {
  $id = $_POST['id'];
  $comment = $_POST['comment'];
  $user_id = $_SESSION['register']['id'];

  $stmt = $pdo->prepare("INSERT INTO comments (body,user_id,post_id) VALUES (:body,:user_id,:post_id)");

  $result = $stmt->execute([
    ':body' => $comment,
    ':user_id' => $user_id,
    ':post_id' => $id,
  ]);

  if($result) {
    header('location:blog_detail.php?id='.$id);
  }
}


 ?>
<?php require_once('header.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content pt-5">
      <div class="container">
        <div class="row">
          <?php 

          // post query
          $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
          $stmt->execute();

          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          // user and  comment inner join query
          $user = $pdo->prepare("SELECT * FROM comments INNER JOIN users ON comments.user_id=users.id where comments.post_id=".$_GET['id']) ;    
          $user->execute();
          $users = $user->fetchAll();
     

          ?>
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0"><?php echo $result['title'] ?></h5>
              </div>
              <div class="card-body">
                <img src="admin/images/<?php echo $result['image'] ?>" alt="" class="w-100 d-blok"><br>
                <p class="card-text pt-4"><?php echo $result['content'] ?></p>
              </div>
              <section style="background-color: #eee;">
                  <div class="container py-3">
                    <div class="">
                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-body">
                            <?php
                            

                            if($users) {
                              foreach ($users as $comment_user) {
                              ?>
                              <div class="d-flex flex-start align-items-center">
                                <div>
                                  <h6 class="fw-bold text-primary mb-1"><?php echo $comment_user['name'] ?></h6>
                                  <p class="text-muted small mb-0">
                                    Shared publicly - Jan 2020
                                  </p>
                                </div>
                              </div>
                              <p class="mt-3 mb-4 pb-2">
                                <?php echo $comment_user['body'] ?>
                              </p><hr>
                              <?php
                              }
                            }
                            
                            
                            ?>
                          </div>
                          <form action="" method="POST">
                            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                            <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                              <div class="d-flex flex-start w-100">
                                <div class="form-outline w-100">
                                  <textarea class="form-control" name="comment" id="textAreaExample" rows="4"
                                    style="background: #fff;"></textarea>
                                </div>
                              </div> 
                              <div class="float-end mt-2 pt-1">
                                <button type="submit" class="btn btn-primary btn-sm">Post comment</button>
                                <button type="reset" class="btn btn-outline-primary btn-sm">Cancel</button>
                              </div>
                              <div class="float-left mt-2 pt-1">
                                <a href="index.php" class="btn btn-secondary btn-sm px-5">Back</a>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
            </div>
          </div>
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
