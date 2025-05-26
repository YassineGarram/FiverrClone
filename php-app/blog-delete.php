<?php

  require_once 'classes/Blog.php';

  $blogRepository = new Blog();

  $blogRepository->deletePost($_REQUEST['id']);

?>

<h1> Post was deleted ! <h1>
<h2> <a href="http://localhost:8000/blog.php">EXIT<a> </h2>

<link rel="stylesheet" href="styles/blog-delete.css">
