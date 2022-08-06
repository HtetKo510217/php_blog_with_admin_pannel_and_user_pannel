<?php 
require('../config.php');

session_start();
if(!isset($_SESSION['isAdmin'])) {
  header('location:login.php');
}

if($_POST) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    // die(var_dump($_FILES));
    $image = 'images/'.($_FILES['image']['name']);

    $imageType = pathinfo($image,PATHINFO_EXTENSION);

   if($imageType !='png' && $imageType !='jpg' && $imageType != 'jpeg') {
        echo "<script>alert('Image file is not png jpg or jpeg');</script>";
   }else {
        $mov = move_uploaded_file($_FILES['image']['tmp_name'],$image);
        
        $stmt = $pdo->prepare("INSERT INTO posts(title,content,image) VALUES (:title,:content,:image)");
        $result = $stmt->execute(
            array(
                ':title' => $title,
                ':content' => $content,
                ':image' => $_FILES['image']['name'],
            )
        );
        // die(var_dump($result));
        if($result) {
            echo "<script>alert('Your post upload successfuly !!');window.location.href='index.php';</script>";
        }
   }
}

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
                <h3 class="card-title">Creeate Blog Posts</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="create.php" enctype="multipart/form-data" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Tite</label>
                    <input type="text" class="form-control" id="title" name="title">
                  </div>
                  <div class="form-group">
                    <label for="content">Content</label><br>
                    <textarea class="form-control" name="content" id="content" cols="20" rows="6"></textarea>
                  </div>
                  <div class="form-group">
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
                  <button type="submit" class="btn btn-primary">Add</button>
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
