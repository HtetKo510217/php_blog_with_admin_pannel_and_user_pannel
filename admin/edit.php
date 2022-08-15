<?php
require('../config.php');

session_start();
if($_SESSION['register']['role'] !=1) {
  header('location:login.php');
}

if($_POST) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    $id = $_POST['id'];
    if($_FILES['image']['size'] > 0) {
      $path = 'images/'.($_FILES['image']['name']);
      $filetype = pathinfo($path,PATHINFO_EXTENSION);
      $arr = array('png','jpg','jpeg');
      if(in_array($filetype,$arr)) {
        move_uploaded_file($path,$_FILES['image']['tmp_name']);
        $stmt = $pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$image' WHERE id='$id'");
        $result = $stmt->execute();
        echo "<script>alert('Your post is updated successfuly');window.location.href='index.php'</script>";
      }else {
        echo "<script>alert('Your format is incorrect . Please upload image file format !!')</script>";
      }
    }else {
      $stmt = $pdo->prepare("UPDATE posts SET title='$title',content='$content' WHERE id='$id'");
      $result = $stmt->execute();
      echo "<script>alert('Your post is updated successfuly');window.location.href='index.php'</script>";
    }
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
// die(var_dump($result));
?>



<?php require_once('header.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper my-3">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Blog Posts</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Tite</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $result['title']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="content">Content</label><br>
                    <textarea class="form-control" name="content" id="content" cols="20" rows="6"><?php echo $result['content']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <img src="images/<?php echo $result['image']; ?>" class="w-50 d-block my-3 border border-primary">
                    <label for="exampleInputFile">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="index.php" class="btn btn-secondary">Back</a>
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
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
