<?php

  require_once 'classes/DB.php';
  require_once 'classes/Validation.php';

  class User {

    private $_data = null;
    private $_db = null;

    public function __construct() {
      $this->_db = DB::getInstance();
    }

    public function createUser(array $data): void {

      $this->_data = $data;


      $this->_db->addData("users", array(
        "username" => $this->_data["username"],
        "password" => password_hash($data["password"], PASSWORD_DEFAULT),
        "name" => $this->_data["name"]
      ));

    }

    public function findUser(array $data) {

      $checkUsername = $this->_db->getData("username", "users", array("username", "=", "'{$data["username"]}'"));

      if($checkUsername) {

        $valid_pwd = new Validation();

        $valid_pwd->checkLogin($data);

        if($valid_pwd->passed() === true){

          $userData = $this->_db->getData("id", "users", array("username", "=", "'{$data["username"]}'"));

          return $userData[0][0];

        }

      }else{

        echo '<p class="error">User not exist !</p>';

      }

    }

  }


?>
