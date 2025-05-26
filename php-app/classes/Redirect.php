<?php

  class Redirect {

    public static function go(string $location): void {

      try {

        header("Location: http://localhost:8000/" . $location . ".php");

      }catch(Exception $e) {

        header("Location: http://localhost:8000/includes/errors/404.php");

      }

    }

  }



?>
