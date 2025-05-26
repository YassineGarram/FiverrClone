<?php

  require_once 'classes/Blog.php';
  require_once 'classes/Input.php';
  require_once 'classes/Validation.php';

  $blogRepository = new Blog();
  $currentState = $blogRepository->getCurrentPost($_REQUEST['id']);

  if(Input::exist()){

    $validation = new Validation();

    $postData = array(
      "title" => $_POST['title'],
      "body" => $_POST['body']
    );

    $validation->checkPost($postData);

    if($validation->passed()){

      try{

        $blogRepository->updatePost($postData, $_REQUEST['id']);
        $currentState['title'] = $_POST['title'];
        $currentState['body'] = $_POST['body'];

        echo '<div class="alert">Data update successfully !' . '<a href="http://localhost:8000/blog.php">Back</a></div>';

      }catch(Exception $e) {

        echo "Something went wrong. Try again...";

      }

    }

  }


?>

<form action="" method="post" class="form-main">

  <h3>
  <label for="post" class="description">editing post nr <?php echo $_REQUEST['post'] ?> during...</label>
  </h3>

  <label for="title" class="text-title">Title</label>
  <input type="text" name="title" class="body-title" value="<?php echo $currentState["title"] ?>">

  <label for="post" class="text-post">Body of your thought</label>
  <textarea name="body" class="body-post"><?php echo $currentState["body"] ?></textarea>

  <input class="submit-button" type="submit" value="add">

</form>

<link rel="stylesheet" href="styles/blog.css">
