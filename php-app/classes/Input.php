<?php

  class Input {
    public static function exist(): bool {

      return (!empty($_POST)) ? true : false;

    }
  }


?>
