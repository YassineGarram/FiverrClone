<?php

  require_once 'classes/DB.php';
  require_once 'classes/Cookies.php';


  class Blog {

    private $_db = null;

    public function __construct(){
      $this->_db = DB::getInstance();
    }

    public function getPosts(): array {

      $user = new Cookie();
      $data = $this->_db->getData("*", "blog", array("user_id", "=", $user->getId()));
      return $data;

    }

    public function getCurrentPost(string $idPost): array {

      $data = $this->_db->getData("*", "blog", array("id", "=", $idPost));

      return array(
        "title" => $data[0]["title"],
        "body" => $data[0]["body"]
      );

    }

    public function addPost(array $data): void {

      $user = new Cookie();
      $user->getId();

      $this->_db->addData("blog", array(
        "user_id" => $user->getId(),
        "title" => $data["title"],
        "body" => $data["body"]
      ));

    }

    public function deletePost(string $id): void {
      $data = $this->_db->getInstance()->deleteData("blog", $id);
    }


    public function updatePost(array $data, string $id): void {
      $data = $this->_db->getInstance()->updateData("blog", $data, $id);
    }

  }


?>
