<?php
  require_once 'classes/Cookies.php';
  require_once 'classes/DB.php';
  require_once 'classes/Input.php';
  require_once 'classes/Validation.php';
  require_once 'classes/Blog.php';

  if(isset($_COOKIE['user'])){

    $blogRepository = new Blog();
    $data = $blogRepository->getPosts();


    if(Input::exist()) {

      $validation = new Validation();

      $inputPost = array(
        "title" => $_POST['title'],
        "body" => $_POST['body']
      );

      $validation->checkPost($inputPost);

      if($validation->passed()){


        try {

          $add = $blogRepository->addPost($inputPost);

          ?><script> window.location.replace("http://localhost:8000/blog.php") </script>;<?php

        }catch(Exception $e) {

          echo "Something went wrong. Try again...";

        }

      }
    }

?>

  <a href="http://localhost:8000/index.php" class="logout">Logout</a>
  <h3> Welcome again in your blog ! </h3>

  <form action="" method="post" class="form-main">

    <h4>
    <label for="post" class="description">Do you want add new post? Here you go:</label>
    </h4>

    <label for="title" class="text-title">Title</label>
    <input type="text" name="title" class="body-title">

    <label for="post" class="text-post">What's new?</label>
    <textarea name="body" class="body-post">Enter your text</textarea>

    <input type="submit" value="add" class="submit-button">

  </form>

  <div class="table-main">
    <table class="table">
      <tbody>
        <?php

          $increment = count($data);

          foreach(array_reverse($data) as $val){

        ?>
        <tr>
          <td class="post-num"><p><?php echo "Post nr. " . $increment; ?></p></td>
        </tr>
        <tr>
          <td class="post-title"><h3><?php echo $val['title']; ?></h3></td>
        </tr>
        <tr>
          <td class="post-body"><h4><?php echo $val['body']; ?><h4></td>
        </tr>
        <tr>
          <td class="post-date"><h5><?php echo $val['date_created']; ?><h5></td>
        </tr>
        <tr>
            <td class="post-update"><a href="blog-update.php?post=<?php echo $increment--; ?>&id=<?php echo $val['id']; ?>" class="edit">Edit</a></td>
            <td class="post-delete"><a href="blog-delete.php?id=<?php echo $val['id']; ?>" class="delete">Delete</a></td>
        </tr>
        <?php

          }

          if(count($data) === 0) {
            echo "no data";
          }

        ?>
      </tbody>
    </table>
  </div>


<?php



}else{

?>

  <p>There is your blog. Go to <a href="http://localhost:8000/login.php">login</a> for browse. </p>
  <p>If you don't have an account <a href="http://localhost:8000/register.php">register</a> now!</p>

<?php

}

?>

<link rel="stylesheet" href="styles/blog.css">
